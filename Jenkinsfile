pipeline {
  agent any
  environment {
    //  set up the current version <major>.<minor>.<build-number-in-current-version>
    VERSIONDEV = "2.4.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 59 || [ $? -eq 1 ] && true').trim()}"
    VERSIONPROD = "2.4.${sh(returnStdout: true, script: 'expr $BUILD_NUMBER - 23 || [ $? -eq 1 ] && true').trim()}"
  }
  stages {
    ////  ANY BRANCH / PULL REQUEST
    stage('cleanup') {
      steps {
        //  clean up previous builds and Jenkins' detached checkout and checkout entire repo manually
        //  Jenkins needs to
        cleanWs()
        sh 'git clone https://github.com/remigiusz-donczyk/final-project .'
      }
    }
    stage('phpunit-tests') {
      when {
        //  test all pull requests and any branch that changed website files
        anyOf {
          changeRequest();
          allOf {
            not { branch 'prod' }
            changeset 'website/*'
          }
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
        changeRequest target: 'dev'
      }
      steps {
        withCredentials([string(credentialsId: 'github-token', variable: 'TOKEN')]) {
          sh 'curl -X PUT -H "Authorization: token $TOKEN" -H "Accept: application/vnd.github+json" -d \'{"merge_method": "squash"}\' https://api.github.com/repos/remigiusz-donczyk/final-project/pulls/$CHANGE_ID/merge'
        }
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
    stage('terraform') {
      when {
        branch 'dev'
      }
      tools {
        terraform 'tf1.2.7'
        dockerTool 'docker19.3'
      }
      environment {
        AWS_ACCESS_KEY_ID = credentials('aws-access')
        AWS_SECRET_ACCESS_KEY = credentials('aws-secret')
      }
      steps {
        //  create terraform infrastructure with the testing environment
        //  apply sometimes times out but will finish correctly if given the chance
        sh 'terraform init'
        retry(1) {
          sh 'terraform apply -auto-approve'
        }
      }
    }
    stage('test') {
      when {
        branch 'dev'
      }
      steps {
        sleep 30
        //  test if the request response status is in the 2** range - smoke test
        sh 'test $(echo $(curl -sLo /dev/null -w "%{http_code}" $(cat .dev-endpoint)) | cut -c 1) -eq 2 || exit 1'
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
            git config user.email "remigiusz.donczyk@globallogic.com"
            git config user.name "Remigiusz Dończyk"
            git clean -ffd
            git merge --ff-only $(git commit-tree -m "AUTO: Rewritten with dev" -p HEAD -p dev dev^{tree})
            git tag -a v$VERSIONDEV -m "AUTO: Merged production to version $VERSIONDEV"
            for i in prod v$VERSIONDEV; do
              git push https://$TOKEN@github.com/remigiusz-donczyk/final-project.git $i
            done
          '''
        }
      }
    }
    ////  THE PROD BRANCH
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
            (cat Doxyfile ; echo PROJECT_NUMBER=$VERSIONPROD) | doxygen -
            mkdir docs-branch
          '''
        }
        dir('website/docs-branch') {
          //  get into the docs branch and replace documentation if it has changed
          git branch: 'docs', credentialsId: 'github-account', url: 'https://github.com/remigiusz-donczyk/final-project'
          withCredentials([string(credentialsId: 'github-token', variable: 'TOKEN')]) {
            sh '''
              git config user.email "remigiusz.donczyk@globallogic.com"
              git config user.name "Remigiusz Dończyk"
              cp -r ../docs/** .
              git add -A
              if ! git diff-index --quiet HEAD; then
                git commit -m "AUTO: Updated Documentation"
                git tag -a v$VERSIONPROD-doc -m "AUTO: Documentation for version $VERSIONPROD"
                git push --atomic https://$TOKEN@github.com/remigiusz-donczyk/final-project.git docs v$VERSIONPROD-doc
              fi
            '''
          }
        }
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
        sh 'terraform init'
        retry(1) {
          sh 'terraform apply -auto-approve'
        }
        //  print the endpoints to easily access them
        sh 'echo "Production Environment: $(cat .prod-endpoint)\nGrafana: $(cat .grafana-endpoint)"'
      }
    }
    //  purge Terraform to empty playground for the next build, would not happen in a real environment
    //  delete this stage in the case of a real environment, tfstate will be preserved between builds
    //  this is only for testing purposes when changing Terraform's code
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
          terraform init
          terraform destroy -auto-approve
        '''
      }
    }
  }
}

