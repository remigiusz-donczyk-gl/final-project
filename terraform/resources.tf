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
    "kubernetes.io/role/elb" = "1"
  }
  private_subnet_tags = {
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
  cluster_addons = {
    coredns = {
      resolve_conflicts = "OVERWRITE"
    }
    kube-proxy = {}
    vpc-cni = {
      resolve_conflicts = "OVERWRITE"
    }
  }
  eks_managed_node_groups = {
    coredns = {
      name          = "coredns"
      instance_type = "t3.small"
      desired_size  = 1
    }
  }
  fargate_profiles = {
    default = {
      name = "default"
      selectors = [
        {
          namespace = "default"
          labels = {
            WorkerType = "fargate"
          }
        }
      ]
      tags = {
        Owner = "default"
      }
      timeouts = {
        create = "20m"
        delete = "20m"
      }
    }
  }
}

resource "null_resource" "noname" {
  depends_on = [module.eks]
  provisioner "local-exec" {
    command = "aws eks --region ${local.region} update-kubeconfig --kubeconfig ../.kube --name ${module.eks.cluster_id}"
  }
}

