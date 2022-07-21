pipeline {
  agent any
  options {
    skipDefaultCheckout(true)
  }
  environment {
    VERSION = "0.9.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 0')}"
  }
  stages {
    stage('cleanup') {
      steps {
        cleanWs()
        checkout scm
      }
    }
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
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        sh '''
          [ -f /var/tf/terraform.tfstate ] && cp -p /var/tf/terraform.tfstate .
          terraform init
          terraform plan -out .plan
          terraform apply .plan
          kubectl apply -f kube.yml --kubeconfig .kube
          cp -p terraform.tfstate /var/tf/
          sleep 5
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
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        input message: 'Do you wish to perform extinction?', ok: 'Approve'
        sh '''
          [ -f /var/tf/terraform.tfstate ] && cp -p /var/tf/terraform.tfstate .
          kubectl delete -f kube.yml --kubeconfig .kube
          terraform init
          terraform plan -destroy -out .plan
          terraform apply .plan
          cp -p terraform.tfstate /var/tf/
        '''
      }
    }
  }
}

