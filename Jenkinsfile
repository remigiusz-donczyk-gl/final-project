pipeline {
  agent any
  tools {
    dockerTool '19.3'
    terraform '1.2.5'
  }
  environment {
    VERSION="1.0.$BUILD_NUMBER"
  }
  stages {
    stage('dev-dockerize') {
      when { branch 'dev' }
      steps {
        dir('website') {
          sh 'docker build --no-cache --tag remigiuszdonczyk/final-project .'
        }
        sh 'docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:$VERSION'
        withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
          sh 'echo $PASS | docker login -u $USER --password-stdin'
        }
        sh 'docker push remigiuszdonczyk/final-project:$VERSION'
        sh 'docker push remigiuszdonczyk/final-project'
        sh 'docker logout'
        sh 'docker image rm remigiuszdonczyk/final-project:$VERSION'
        sh 'docker image rm remigiuszdonczyk/final-project'
      }
    }
    stage('dev-terraform') {
      when { branch 'dev' }
      steps {
        echo 'Let there be light!'
      }
    }
    stage('prod-placeholder') {
      when { branch 'prod' }
      steps {
        echo 'Hello, World!'
      }
    }
  }
}
