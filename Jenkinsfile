pipeline {
  agent any
  tools {
    dockerTool '19.3'
    terraform '1.2.5'
  }
  stages {
    stage('dev-build') {
      when { branch 'dev' }
      steps {
        dir('website') {
          sh 'docker build --no-cache --tag remigiuszdonczyk/final-project:latest .'
        }
        sh 'docker push remigiuszdonczyk/final-project'
        sh 'docker image rm remigiuszdonczyk/final-project'
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
