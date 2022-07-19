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
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access-key')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret-key')
      }
      steps {
        dir('terraform') {
          sh '''
            terraform init
            terraform plan -out=.plan.lock
            terraform apply ".plan.lock"
            kubectl get pods -A --kubeconfig .kubeconfig
            terraform destroy --auto-approve
          '''
        }
      }
    }
  }
}

