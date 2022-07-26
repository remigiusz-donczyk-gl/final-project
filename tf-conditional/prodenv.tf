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

output "prod_endpoint" {
  value = kubernetes_service.prodenv_deploy.status[0].load_balancer[0].ingress[0].hostname
}
