terraform {
  required_version = "1.2.5"
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "4.23.0"
    }
    cloudinit = {
      source  = "hashicorp/cloudinit"
      version = "2.2.0"
    }
    kubernetes = {
      source  = "hashicorp/kubernetes"
      version = "2.12.1"
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
}

locals {
  region = "us-east-1"
}

data "aws_availability_zones" "available" {}

data "aws_eks_cluster" "eks" {
  name = module.eks.cluster_id
}

data "aws_eks_cluster_auth" "eks" {
  name = module.eks.cluster_id
}

provider "aws" {
  region = local.region
}

provider "kubernetes" {
  host                   = data.aws_eks_cluster.eks.endpoint
  cluster_ca_certificate = base64decode(data.aws_eks_cluster.eks.certificate_authority[0].data)
  token                  = data.aws_eks_cluster_auth.eks.token
}

module "vpc" {
  source               = "terraform-aws-modules/vpc/aws"
  version              = "3.14.2"
  name                 = "vpc"
  cidr                 = "10.0.0.0/16"
  azs                  = data.aws_availability_zones.available.names
  private_subnets      = ["10.0.1.0/24", "10.0.2.0/24", "10.0.3.0/24"]
  public_subnets       = ["10.0.4.0/24", "10.0.5.0/24", "10.0.6.0/24"]
  enable_nat_gateway   = true
  single_nat_gateway   = true
  enable_dns_hostnames = true
  public_subnet_tags = {
    "kubernetes.io/cluster/cluster" = "shared"
    "kubernetes.io/role/elb"        = "1"
  }
  private_subnet_tags = {
    "kubernetes.io/cluster/cluster"   = "shared"
    "kubernetes.io/role/internal-elb" = "1"
  }
}

module "eks" {
  source                          = "terraform-aws-modules/eks/aws"
  version                         = "18.26.5"
  cluster_name                    = "cluster"
  cluster_version                 = "1.22"
  cluster_endpoint_private_access = true
  cluster_endpoint_public_access  = true
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

resource "kubernetes_pod" "testenv" {
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

resource "kubernetes_service" "testenv_deploy" {
  metadata {
    name = "testenv-deploy"
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

resource "local_file" "endpoint" {
  content  = kubernetes_service.testenv_deploy.status[0].load_balancer[0].ingress[0].hostname
  filename = ".endpoint"
}

