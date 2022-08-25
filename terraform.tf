//  specify required versions explicitly, update this every so often
terraform {
  required_version = "1.2.7"
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "4.27.0"
    }
    cloudinit = {
      source  = "hashicorp/cloudinit"
      version = "2.2.0"
    }
    kubernetes = {
      source  = "hashicorp/kubernetes"
      version = "2.12.1"
    }
    helm = {
      source  = "hashicorp/helm"
      version = "2.6.0"
    }
    null = {
      source  = "hashicorp/null"
      version = "3.1.1"
    }
    tls = {
      source  = "hashicorp/tls"
      version = "3.4.0"
    }
  }
  //  use s3 to store the tfstate, requires setup to run first
  backend "s3" {
    bucket         = "remigiuszdonczyk-tfstate-bucket"
    key            = "terraform.tfstate"
    region         = "us-east-1"
    encrypt        = true
    kms_key_id     = "alias/tfstate-bucket-key"
    dynamodb_table = "tfstate-lock"
  }
}

//  set the environment type, dev by default
variable "production" {
  type    = bool
  default = false
}

//  get the required data values as they're needed
data "aws_availability_zones" "az" {
  state = "available"
}

data "aws_eks_cluster" "eks" {
  name = module.eks.cluster_id
}

data "aws_eks_cluster_auth" "eks" {
  name = module.eks.cluster_id
}

data "aws_ecr_authorization_token" "token" {}

//  set up providers
provider "aws" {
  region = "us-east-1"
}

provider "kubernetes" {
  host                   = data.aws_eks_cluster.eks.endpoint
  cluster_ca_certificate = base64decode(data.aws_eks_cluster.eks.certificate_authority[0].data)
  token                  = data.aws_eks_cluster_auth.eks.token
}

provider "helm" {
  kubernetes {
    host                   = data.aws_eks_cluster.eks.endpoint
    cluster_ca_certificate = base64decode(data.aws_eks_cluster.eks.certificate_authority[0].data)
    token                  = data.aws_eks_cluster_auth.eks.token
  }
}

//  build docker and push into ECR
resource "null_resource" "docker" {
  provisioner "local-exec" {
    working_dir = "${path.root}/website"
    command     = <<-EOC
      echo ${data.aws_ecr_authorization_token.token.password} | docker login -u ${data.aws_ecr_authorization_token.token.user_name} --password-stdin ${data.aws_ecr_authorization_token.token.proxy_endpoint}
      docker build --no-cache -t ${replace(data.aws_ecr_authorization_token.token.proxy_endpoint, "https://", "")}/final-project .
      docker push ${replace(data.aws_ecr_authorization_token.token.proxy_endpoint, "https://", "")}/final-project
      docker image rm ${replace(data.aws_ecr_authorization_token.token.proxy_endpoint, "https://", "")}/final-project
      docker logout
    EOC
  }
}

//  create VPC, subnets, route tables, gateways & EIP
module "vpc" {
  source               = "terraform-aws-modules/vpc/aws"
  version              = "3.14.2"
  name                 = "vpc"
  cidr                 = "10.0.0.0/16"
  azs                  = data.aws_availability_zones.az.names
  private_subnets      = ["10.0.1.0/24", "10.0.2.0/24", "10.0.3.0/24"]
  public_subnets       = ["10.0.4.0/24", "10.0.5.0/24", "10.0.6.0/24"]
  enable_nat_gateway   = true
  single_nat_gateway   = true
  enable_dns_hostnames = true
  public_subnet_tags = {
    "kubernetes.io/role/elb" = "1"
  }
  private_subnet_tags = {
    "kubernetes.io/role/internal-elb" = "1"
  }
}

//  create node groups, iam roles, openid provider, cluster & cloudwatch log
module "eks" {
  source                          = "terraform-aws-modules/eks/aws"
  version                         = "18.28.0"
  cluster_name                    = "cluster"
  cluster_version                 = "1.22"
  cluster_endpoint_private_access = true
  subnet_ids                      = module.vpc.private_subnets
  vpc_id                          = module.vpc.vpc_id
  eks_managed_node_groups = {
    default = {
      name          = "default"
      instance_type = "t3.small"
      desired_size  = 1
    }
  }
}

resource "kubernetes_secret" "docker" {
  metadata {
    name = "docker-login"
  }
  data = {
    ".dockerconfigjson" = jsonencode({
      auths = {
        "${data.aws_ecr_authorization_token.token.proxy_endpoint}" = {
          auth = "${data.aws_ecr_authorization_token.token.authorization_token}"
        }
      }
    })
  }
  type = "kubernetes.io/dockerconfigjson"
}

resource "kubernetes_pod" "db" {
  metadata {
    name = "appdb"
    labels = {
      app = "db"
    }
  }
  spec {
    container {
      name  = "db"
      image = "mariadb:10.9.2-jammy"
      env {
        name = "MYSQL_USER"
        value = "dbuser"
      }
      env {
        name = "MYSQL_HOST"
        value = "%"
      }
      env {
        name = "MYSQL_PASSWORD"
        value = file("${path.root}/website/pw.conf")
      }
      env {
        name = "MYSQL_RANDOM_ROOT_PASSWORD"
        value = true
      }
    }
  }
}

resource "kubernetes_service" "app_db" {
  count = var.production ? 0 : 1
  metadata {
    name = "appdb"
  }
  spec {
    type = "NodePort"
    selector = {
      app = "db"
    }
    port {
      port = 3306
    }
  }
}


////  FOR MANUAL TESTS
resource "null_resource" "kubectl" {
  depends_on = [
    module.eks
  ]
  provisioner "local-exec" {
    command = "aws eks --region us-east-1 update-kubeconfig --kubeconfig .kube --name ${module.eks.cluster_id}"
  }
}
////  DEVELOPMENT ENVIRONMENT
//  create public endpoint for development environment
resource "kubernetes_service" "dev_app" {
  count = var.production ? 0 : 1
  metadata {
    name = "devapp"
  }
  spec {
    type = "LoadBalancer"
    selector = {
      app = "website"
      env = "dev"
    }
    port {
      port        = 80
      target_port = 80
    }
  }
}

resource "local_file" "dev_endpoint" {
  count    = var.production ? 0 : 1
  content  = one(kubernetes_service.dev_app[*].status[0].load_balancer[0].ingress[0].hostname)
  filename = ".dev-endpoint"
}

//  create development pod from latest image
resource "kubernetes_pod" "devenv" {
  count = var.production ? 0 : 1
  depends_on = [
    null_resource.docker
  ]
  metadata {
    name = "devenv"
    labels = {
      app = "website"
      env = "dev"
    }
  }
  spec {
    image_pull_secrets {
      name = "docker-login"
    }
    container {
      name  = "website"
      image = "${replace(data.aws_ecr_authorization_token.token.proxy_endpoint, "https://", "")}/final-project"
    }
  }
}

////  PRODUCTION ENVIRONMENT
//  install prometheus and grafana
resource "helm_release" "prometheus" {
  count      = var.production ? 1 : 0
  name       = "kube-prometheus-stack"
  repository = "https://prometheus-community.github.io/helm-charts"
  chart      = "kube-prometheus-stack"
  version    = "39.6.0"
}

//  create public endpoint for grafana
resource "kubernetes_service" "grafana" {
  count = var.production ? 1 : 0
  metadata {
    name = "grafana"
  }
  spec {
    type = "LoadBalancer"
    selector = {
      "app.kubernetes.io/instance" = "kube-prometheus-stack"
      "app.kubernetes.io/name"     = "grafana"
    }
    port {
      port        = 80
      target_port = 3000
    }
  }
}

resource "local_file" "grafana_endpoint" {
  count    = var.production ? 1 : 0
  content  = one(kubernetes_service.grafana[*].status[0].load_balancer[0].ingress[0].hostname)
  filename = ".grafana-endpoint"
}

//  create public endpoint for production environment
resource "kubernetes_service" "prod_app" {
  count = var.production ? 1 : 0
  metadata {
    name = "prodapp"
  }
  spec {
    type = "LoadBalancer"
    selector = {
      app = "website"
      env = "prod"
    }
    port {
      port        = 80
      target_port = 80
    }
  }
}

resource "local_file" "prod_endpoint" {
  count    = var.production ? 1 : 0
  content  = one(kubernetes_service.prod_app[*].status[0].load_balancer[0].ingress[0].hostname)
  filename = ".prod-endpoint"
}

//  create production pod from stable image
resource "kubernetes_pod" "prodenv" {
  count = var.production ? 1 : 0
  depends_on = [
    helm_release.prometheus,
    null_resource.docker
  ]
  metadata {
    name = "prodenv"
    labels = {
      app = "website"
      env = "prod"
    }
  }
  spec {
    image_pull_secrets {
      name = "docker-login"
    }
    container {
      name  = "website"
      image = "${replace(data.aws_ecr_authorization_token.token.proxy_endpoint, "https://", "")}/final-project"
    }
  }
}

