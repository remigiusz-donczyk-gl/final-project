pipeline {
           //  allow any worker to run
  agent any
           //  don't checkout scm declaratively
  options {
    skipDefaultCheckout(true)
  }
  environment {
           //  set up the current SEMVER <major>.<minor>.<build-number-in-current-version>
    VERSION = "1.1.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 85')}"
  }
  stages {
    stage('cleanup') {
      steps {
           //  clean up previous build and checkout manually
        cleanWs()
        checkout scm
      }
    }
    stage('dockerize') {
      when {
        allOf {
           //  only build on the dev branch if the website files changed
          branch 'dev';
          changeset 'website/*'
        }
      }
      tools {
        dockerTool '19.3'
      }
      steps {
        dir('website') {
           //  login into docker to be able to push
          withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
            sh 'echo $PASS | docker login -u $USER --password-stdin'
          }
           //  build the website and push it to $VERSION and latest tags
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
         //  create terraform infrastructure as well as the testing environment
        sh '''
          cp tf-conditional/testenv.tf .
          terraform init
          terraform plan -out .plan
        '''
        retry(1) {
          sh 'terraform apply .plan'
        }
         //  write the endpoint to console for showcase purposes
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
           //  send a request to the generated endpoint and fail if unreachable
        sh 'test $(echo $(curl -sLo /dev/null -w "%{http_code}" $(cat .endpoint)) | cut -c 1) -eq 2 || exit 1'
           //  wait for approval for showcase purposes
        input message: 'Smoke test passed, awaiting manual approval', ok: 'Confirm'
           //  remove testing environment, keep the general infrastructure, backup the tfstate for later
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
           //  login to docker to be able to push
        withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
          sh 'echo $PASS | docker login -u $USER --password-stdin'
        }
           //  mark the latest tag as stable since it passed tests
        sh '''
          docker pull remigiuszdonczyk/final-project
          docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:stable
          docker push remigiuszdonczyk/final-project:stable
          docker image rm remigiuszdonczyk/final-project:stable
          docker image rm remigiuszdonczyk/final-project
          docker logout
        '''
           //  get into the prod branch and merge dev since it's stable
        git branch: 'prod', credentialsId: 'github-account', url: 'https://github.com/remigiusz-donczyk/final-project'
        withCredentials([string(credentialsId: 'github-token', variable: 'TOKEN')]) {
          sh """
            git merge origin/dev
            git push https://$TOKEN@github.com/remigiusz-donczyk/final-project.git prod
          """
        }
      }
    }
    stage('deploy') {
      when { branch 'prod' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
           //  get the tfstate from earlier and deploy the prod env, also updates dependencies as necesssary
        sh '''
          mv /var/jenkins_home/tf/terraform.tfstate .
          cp tf-conditional/prodenv.tf .
          terraform init
          terraform plan -out .plan
          terraform apply .plan
        '''
      }
    }
           //  purge terraform to empty playground for the next build, would not happen in a real environment
    stage('extinction') {
      when { branch 'prod' }
      tools {
        terraform '1.2.5'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        input message: 'Confirm extinction?', ok: 'Send a meteor'
             //  destroy everything
        sh '''
          terraform init
          terraform plan -destroy -out .plan
          terraform apply .plan
        '''
      }
    }
  }
}

