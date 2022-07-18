terraform {
  required_providers {
    aws = {
      version = "4.22.0"
    }
  }
}

provider "aws" {
  region = "us-east-1"
}
