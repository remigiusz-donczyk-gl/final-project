provider "aws" {
  region = local.region
}

data "aws_availability_zones" "available" {}

provider "kubernetes" {
  config_path = ".kubeconfig"
}

