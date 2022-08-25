terraform {
  required_version = "1.2.7"
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "4.25.0"
    }
  }
}

provider "aws" {
  region = "us-east-1"
}

resource "aws_kms_key" "tfstate-bucket-key" {
  description             = "This key is used to secure the tfstate file"
  enable_key_rotation     = true
  deletion_window_in_days = 30
}

resource "aws_kms_alias" "tfstate-key-alias" {
  name          = "alias/tfstate-bucket-key"
  target_key_id = aws_kms_key.tfstate-bucket-key.key_id
}

resource "aws_s3_bucket" "tfstate" {
  bucket = "remigiuszdonczyk-tfstate-bucket"
}

resource "aws_s3_bucket_acl" "tfstate-acl" {
  bucket = aws_s3_bucket.tfstate.id
  acl    = "private"
}

resource "aws_s3_bucket_versioning" "tfstate-ver" {
  bucket = aws_s3_bucket.tfstate.id
  versioning_configuration {
    status = "Enabled"
  }
}

resource "aws_s3_bucket_server_side_encryption_configuration" "tfstate-enc" {
  bucket = aws_s3_bucket.tfstate.id
  rule {
    apply_server_side_encryption_by_default {
      kms_master_key_id = aws_kms_key.tfstate-bucket-key.arn
      sse_algorithm     = "aws:kms"
    }
  }
}

resource "aws_s3_bucket_public_access_block" "tfstate-security" {
  bucket                  = aws_s3_bucket.tfstate.id
  block_public_acls       = true
  block_public_policy     = true
  ignore_public_acls      = true
  restrict_public_buckets = true
}

resource "aws_dynamodb_table" "tfstate-lock" {
  name           = "tfstate-lock"
  read_capacity  = 1
  write_capacity = 1
  hash_key       = "LockID"
  attribute {
    name = "LockID"
    type = "S"
  }
}

resource "aws_ecr_repository" "docker_repo" {
  name = "docker-repo"
}

