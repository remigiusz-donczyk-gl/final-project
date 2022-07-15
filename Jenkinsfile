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
