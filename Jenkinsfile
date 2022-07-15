pipeline {
  agent any
  tools {
    docker '20.10'
  }
  environment {
    DOCKER_CERT_PATH = credentials('')
  }
  stages {
    stage('dev-build') {
      when { branch 'dev' }
      steps {
        sh 'docker version'
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
