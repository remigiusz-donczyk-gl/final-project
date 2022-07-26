pipeline {
  agent any
  options {
    skipDefaultCheckout(true)
  }
  environment {
    VERSION = "1.1.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 85')}"
  }
  stages {
    stage('cleanup') {
      steps {
        cleanWs()
        checkout scm
      }
    }
    stage('dockerize') {
      when {
        allOf {
          branch 'dev';
          changeset 'website/*'
        }
      }
      tools {
        dockerTool '19.3'
      }
      steps {
        dir('website') {
          withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
            sh 'echo $PASS | docker login -u $USER --password-stdin'
          }
          sh '''
            docker build --no-cache --tag remigiuszdonczyk/final-project .
            docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:$VERSION
            docker push remigiuszdonczyk/final-project:$VERSION
            docker push remigiuszdonczyk/final-project
            docker image rm remigiuszdonczyk/final-project:$VERSION
            docker image rm remigiuszdonczyk/final-project
            docker logout
          '''
        }
      }
    }
    stage('terraform') {
      when { branch 'dev' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        sh '''
          cp tf-conditional/testenv.tf .
          terraform init
          terraform plan -out .plan
        '''
        retry(1) {
          sh 'terraform apply .plan'
        }
        sh 'cat .endpoint'
      }
    }
    stage('test') {
      when { branch 'dev' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        sleep 60
        sh 'test $(echo $(curl -sLo /dev/null -w "%{http_code}" $(cat .endpoint)) | cut -c 1) -eq 2 || exit 1'
        input message: 'Smoke test passed, awaiting manual approval', ok: 'Confirm'
        sh '''
          terraform init
          terraform destroy -target kubernetes_pod.testenv -target kubernetes_service.testenv_deploy -target local_file.test_endpoint -auto-approve
          mv terraform.tfstate /var/jenkins_home/tf/
        '''
      }
    }
    stage('merge-prod') {
      when { branch 'dev' }
      tools {
        dockerTool '19.3'
        git 'Default'
      }
      steps {
        withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
          sh 'echo $PASS | docker login -u $USER --password-stdin'
        }
        sh '''
          docker pull remigiuszdonczyk/final-project
          docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:stable
          docker push remigiuszdonczyk/final-project:stable
          docker image rm remigiuszdonczyk/final-project:stable
          docker image rm remigiuszdonczyk/final-project
          docker logout
        '''
        git branch: 'prod', credentialsId: 'github-account', url: 'https://github.com/remigiusz-donczyk/final-project'
        withCredentials([string(credentialsId: 'github-token', variable: 'TOKEN')]) {
          sh """
            git merge origin/dev
            git push https://$TOKEN@github.com/remigiusz-donczyk/final-project.git prod
          """
        }
      }
    }
    stage('undeploy') {
      when { branch 'prod' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        sh '''
          mv /var/jenkins_home/tf/terraform.tfstate .
          terraform init
          terraform plan -destroy -out .plan
          terraform apply .plan
        '''
      }
    }
  }
}

