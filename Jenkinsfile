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
      tools {
        terraform '1.2.5'
      }
      steps {
        sh 'terraform init'
        sh 'terraform plan'
      }
    }
    /* TODO
    stage('prod-placeholder') {
      when { branch 'prod' }
      steps {
        echo 'Hello, World!'
      }
    }
    */
  }
}
