pipeline {
  agent any
  stages {
    stage('dev-hello') {
      when { branch 'dev' }
      steps {
        echo 'Hello World'
      }
    }
    stage('prod-hello') {
      when { branch 'prod' }
      steps {
        echo 'Hello World'
      }
    }
  }
}
