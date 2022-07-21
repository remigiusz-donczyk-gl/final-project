pipeline {
  agent any
  environment {
    VERSION = "0.9.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 0')}"
  }
  stages {
    stage('dev-dockerize') {
      when { branch 'dev' }
      tools {
        dockerTool '19.3'
      }
      steps {
        dir('website') {
          sh 'docker build --no-cache --tag remigiuszdonczyk/final-project .'
        }
        withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
          sh 'echo $PASS | docker login -u $USER --password-stdin'
        }
        sh '''
          docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:$VERSION
          docker push remigiuszdonczyk/final-project:$VERSION
          docker push remigiuszdonczyk/final-project
          docker logout
          docker image rm remigiuszdonczyk/final-project:$VERSION
          docker image rm remigiuszdonczyk/final-project
        '''
      }
    }
    stage('terraform') {
      when { branch 'dev' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access-key')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret-key')
      }
      steps {
        dir('terraform') {
          // cp -p /var/tf/terraform.tfstate . || true
          sh '''
            terraform init
            terraform plan -out .plan
            terraform apply .plan
          '''
          // cp -p terraform.tfstate /var/tf/
        }
        sh '''
          kubectl apply -f kube.yml --kubeconfig .kube
          kubectl get service testenv-deploy --kubeconfig .kube
        '''
      }
    }
    stage('extinction') {
      when { branch 'dev' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access-key')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret-key')
      }
      steps {
        input message: 'Do you wish to perform extinction?', ok: 'Approve'
        sh 'kubectl delete -f kube.yml --kubeconfig .kube'
        dir('terraform') {
          // cp -p /var/tf/terraform.tfstate . || true
          sh '''
            terraform init
            terraform plan -destroy -out .plan
            terraform apply .plan
          '''
          // cp -p terraform.tfstate /var/tf/
        }
      }
    }
  }
}

