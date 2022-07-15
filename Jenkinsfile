pipeline {
  agent any
  environment {
    VERSION = "1.0.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 2')}"
  }
  stages {
    stage('test-version-env') {
      steps {
        sh 'echo $VERSION'
      }
    }
    /*
    stage('dev-dockerize') {
      tools {
        dockerTool '19.3'
      }
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
    TODO
    stage('dev-terraform') {
      when { branch 'dev' }
      tools {
        terraform '1.2.5'
      }
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
    */
  }
}
