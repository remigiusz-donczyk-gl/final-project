# A CI/CD pipeline
![Build Status](https://jenkins-gl.bluecom.dev/buildStatus/icon?job=final-project%2Fdev)

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.
[Docker image](https://hub.docker.com/repository/docker/remigiuszdonczyk/final-project/tags)

Check out the documentation [here](DOCS.md)!

- [x] webapp
  - [x] database
  - [x] frontend
  - [x] stateful
- [x] jenkins (branch dev)
  - [x] make docker image > dockerhub
  - [x] terraform EKS
  - [x] deploy test env
  - [x] smoke test
  - [ ] static code analysis
  - [ ] auto docs
  - [x] dockerhub (:stable)
  - [x] github merge to prod
- [x] jenkins (branch prod)
  - [x] deploy prod env
  - [x] undeploy test env
  - [ ] monitor health

