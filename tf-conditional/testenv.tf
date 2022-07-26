//  create pod from latest image
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

//  deploy pod on a public endpoint
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

//  push the endpoint to a file to be available for tests
resource "local_file" "test_endpoint" {
  content  = kubernetes_service.testenv_deploy.status[0].load_balancer[0].ingress[0].hostname
  filename = ".endpoint"
}

