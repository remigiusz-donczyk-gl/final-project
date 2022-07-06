# A CI/CD pipeline

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.

[nginx + mariadb : some kind of simple web app with a database]
github push to dev > jenkins
jenkins (branch dev)
  build : terraform > dockerhub (signing)
  deploy canary : kubernetes
    auto tests > notify github
    manual approval, mark release as stable
    allow github merge
    remove canary
github merge to main
jenkins (branch main)
  deploy production : kubernetes
  monitor health : grafana ???
