pipeline {
  agent any
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
