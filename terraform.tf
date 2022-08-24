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
  //backend "s3" {
  //  bucket         = "remigiuszdonczyk-tfstate-bucket"
  //  key            = "terraform.tfstate"
  //  region         = "us-east-1"
  //  encrypt        = true
  //  kms_key_id     = "alias/tfstate-bucket-key"
  //  dynamodb_table = "tfstate-lock"
  //}
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

//  create VPC, subnets, route tables, gateways & EIP
module "vpc" {
  source               = "terraform-aws-modules/vpc/aws"
  version              = "3.14.2"
  name                 = "vpc"
  cidr                 = "10.0.0.0/16"
  //azs                  = data.aws_availability_zones.az.names
  azs                  = ["us-east-1a", "us-east-1b", "us-east-1c", "us-east-1d", "us-east-1f"]
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

//  create public endpoint for website
resource "kubernetes_service" "app" {
  metadata {
    name = "app"
  }
  spec {
    type = "LoadBalancer"
    selector = {
      app = "website"
    }
    port {
      port        = 80
      target_port = 80
    }
  }
}

resource "local_file" "app_endpoint" {
  content  = kubernetes_service.app.status[0].load_balancer[0].ingress[0].hostname
  filename = ".endpoint"
}

////  DEVELOPMENT ENVIRONMENT
//  create development pod from latest image
resource "kubernetes_pod" "testenv" {
  count = var.production ? 0 : 1
  metadata {
    name = "testenv"
    labels = {
      app = "website"
    }
  }
  spec {
    container {
      name  = "website"
      image = "remigiuszdonczyk/final-project:latest"
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

//  create production pod from stable image
resource "kubernetes_pod" "prodenv" {
  count = var.production ? 1 : 0
  depends_on = [
    helm_release.prometheus
  ]
  metadata {
    name = "prodenv"
    labels = {
      app = "website"
    }
  }
  spec {
    container {
      name  = "website"
      image = "remigiuszdonczyk/final-project:stable"
    }
  }
}

