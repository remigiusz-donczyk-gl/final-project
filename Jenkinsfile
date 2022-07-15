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
    stage('dev-build') {
      when { branch 'dev' }
      steps {
        dir('website') {
          sh 'docker build --no-cache --tag remigiuszdonczyk/final-project .'
        }
        sh 'docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:$VERSION'
        withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
          sh 'echo $PASS | docker login -u $USER --password-stdin'
        }
        sh 'docker push remigiuszdonczyk/final-project'
        sh 'docker push remigiuszdonczyk/final-project:$VERSION'
        sh 'docker logout'
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
