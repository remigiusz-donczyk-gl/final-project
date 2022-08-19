pipeline {
  agent any
  //  don't checkout scm declaratively
  options {
    skipDefaultCheckout(true)
  }
  environment {
    //  set up the current version with SEMVER <major>.<minor>.<build-number-in-current-version>
    VERSION = "2.3.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 38 || [ $? -eq 1 ] && true')}"
  }
  stages {
    ////  ANY BRANCH / PULL REQUEST
    stage('cleanup') {
      steps {
        //  clean up previous build and checkout manually
        cleanWs()
        checkout scm
      }
    }
    stage('phpunit-tests') {
      when {
        allOf {
          not { branch 'prod' }
          changeset 'website/*'
        }
      }
      steps {
        dir('website') {
          sh '''
            phpunit --configuration tests/phpunit.xml
            chmod a+r tests/coverage.xml
            chmod a+r tests/report.xml
          '''
        }
      }
    }
    stage('merge-dev') {
      when {
        script {
          if (env.CHANGE_ID && pullRequest.base == 'dev') {
              return true
          }
          return false
        }
      }
      steps {
        echo 'Hello, World!'
      }
    }
    ////  THE DEV BRANCH
    stage('static-analysis') {
      when {
        allOf {
          branch 'dev';
          changeset 'website/*'
        }
      }
      steps {
        withSonarQubeEnv('sonarqube') {
          script {
            def scannerHome = tool name: 'sonar4.7'
            sh "${scannerHome}/bin/sonar-scanner"
          }
        }
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
        dockerTool 'docker19.3'
      }
      steps {
        dir('website') {
          //  login into docker to be allowed to push
          withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
            sh 'echo $PASS | docker login -u $USER --password-stdin'
          }
          //  build the website and push it to dockerhub
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
      when {
        branch 'dev'
      }
      tools {
        terraform 'tf1.2.7'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        //  create terraform infrastructure as well as the testing environment
        //  if a tfstate file exists, copy it to update the infrastructure instead of creating from scratch
        sh '''
          [ -f /var/jenkins_home/tf/terraform.tfstate ] && mv /var/jenkins_home/tf/terraform.tfstate .
          terraform init
        '''
        //  apply sometimes times out, which causes an error but will finish correctly if given the chance
        retry(1) {
          sh 'terraform apply -auto-approve'
        }
        sh 'mv terraform.tfstate /var/jenkins_home/tf/'
      }
    }
    stage('test') {
      when {
        branch 'dev'
      }
      steps {
        sleep 30
        //  smoke test - fail if endpoint is unreachable
        sh 'test $(echo $(curl -sLo /dev/null -w "%{http_code}" $(cat .endpoint)) | cut -c 1) -eq 2 || exit 1'
      }
    }
    stage('merge-prod') {
      when {
        branch 'dev'
      }
      tools {
        git 'gitDefault'
      }
      steps {
        //  get into the prod branch and merge dev since it is stable
        git branch: 'prod', credentialsId: 'github-account', url: 'https://github.com/remigiusz-donczyk/final-project'
        withCredentials([string(credentialsId: 'github-token', variable: 'TOKEN')]) {
          sh '''
            git merge origin/dev
            git push https://$TOKEN@github.com/remigiusz-donczyk/final-project.git prod
          '''
        }
      }
    }
    ////  THE PROD BRANCH
    stage('mark-stable') {
      when {
        branch 'prod'
      }
      tools {
        dockerTool 'docker19.3'
      }
      steps {
        //  login to docker to be allowed to push
        withCredentials([usernamePassword(credentialsId: 'docker-account', passwordVariable: 'PASS', usernameVariable: 'USER')]) {
          sh 'echo $PASS | docker login -u $USER --password-stdin'
        }
        //  mark the latest tag as stable since it is deployed to production
        sh '''
          docker pull remigiuszdonczyk/final-project
          docker tag remigiuszdonczyk/final-project remigiuszdonczyk/final-project:stable
          docker push remigiuszdonczyk/final-project:stable
          docker image rm remigiuszdonczyk/final-project:stable
          docker image rm remigiuszdonczyk/final-project
          docker logout
        '''
      }
    }
    stage('deploy') {
      when {
        branch 'prod'
      }
      tools {
        terraform 'tf1.2.7'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
        TF_VAR_prod = true
      }
      steps {
        //  deploy the prod env, if a tfstate exists only update
        sh '''
          [ -f /var/jenkins_home/tf/terraform.tfstate ] && mv /var/jenkins_home/tf/terraform.tfstate .
          terraform init
          terraform apply -auto-approve
          mv terraform.tfstate /var/jenkins_home/tf/
        '''
        //  print the endpoints to easily access them
        sh 'echo "Website: $(cat .endpoint)\nGrafana: $(cat .grafana-endpoint)"'
      }
    }
    stage('doxygen') {
      when {
        branch 'prod'
      }
      tools {
        git 'gitDefault'
      }
      steps {
        dir('website') {
          sh '''
            doxygen
            mkdir docs-branch
          '''
        }
        dir('website/docs-branch') {
          //  get into the docs branch and replace documentation
          git branch: 'docs', credentialsId: 'github-account', url: 'https://github.com/remigiusz-donczyk/final-project'
          withCredentials([string(credentialsId: 'github-token', variable: 'TOKEN')]) {
            sh '''
              cp -r ../docs/** .
              git config user.email "remigiusz.donczyk@globallogic.com"
              git config user.name "Remigiusz Dończyk"
              git add -A
              if ! git diff-index --quiet HEAD; then
                git commit -m "AUTO: Updated Documentation"
                git push https://$TOKEN@github.com/remigiusz-donczyk/final-project.git docs
              fi
            '''
          }
        }
      }
    }
    //  purge terraform to empty playground for the next build, would not happen in a real environment
    //  delete this stage in the case of a real environment, terraform will be preserved between builds
    //  this is necessary because cloudguru playground is deleted every 5 hours, which invalidates the tfstate
    stage('extinction') {
      when {
        branch 'prod'
      }
      tools {
        terraform 'tf1.2.7'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
        TF_VAR_prod = true
      }
      steps {
        input message: 'Confirm extinction?', ok: 'Send a meteor'
        sh '''
          [ -f /var/jenkins_home/tf/terraform.tfstate ] && mv /var/jenkins_home/tf/terraform.tfstate .
          terraform init
          terraform destroy -auto-approve
        '''
      }
    }
  }
}

