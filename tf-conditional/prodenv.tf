//  create pod from stable image
resource "kubernetes_pod" "prodenv" {
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

//  deploy pod on public endpoint
resource "kubernetes_service" "prodenv_deploy" {
  metadata {
    name = "prodenv-deploy"
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

//  testing - output the endpoint
output "prod_endpoint" {
  value = kubernetes_service.prodenv_deploy.status[0].load_balancer[0].ingress[0].hostname
}

