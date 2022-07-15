pipeline {
  agent any
  tools {
    dockerTool '19.3'
    terraform '1.2.5'
  }
  stages {
    stage('dev-build') {
      when { branch 'dev' }
      environment {
        DOCKER_CONTENT_TRUST_SERVER="https://notary.docker.io"
      }
      steps {
        dir('website') {
          sh 'docker build --no-cache --tag remigiuszdonczyk/final-project:latest .'
          withCredentials([string(credentialsId: 'docker-trust-password', variable: 'DOCKER_CONTENT_TRUST_REPOSITORY_PASSPHRASE'), file(credentialsId: 'docker-trust-keyfile', variable: 'DOCKER_KEYFILE')]) {
            sh 'docker trust sign remigiuszdonczyk/final-project:latest'
          }
        }
      }
    }
    stage('prod-placeholder') {
      when { branch 'prod' }
      steps {
        echo 'Do something'
      }
    }
  }
}
