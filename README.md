# A CI/CD pipeline
![Build Status](https://jenkins-gl.bluecom.dev/buildStatus/icon?job=FinalProject%2Fdev)
![SonarCloud Coverage](https://sonarqube-gl.bluecom.dev/api/project_badges/measure?project=remigiusz-donczyk_final-project&metric=alert_status)

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.

[Dockerhub repository](https://hub.docker.com/repository/docker/remigiuszdonczyk/final-project/tags)

Check out a more detailed description [here](DOCS.md)!

- [x] webapp
  - [x] database
  - [x] frontend
  - [x] stateful
- [x] jenkins (branch dev)
  - [x] static code analysis
  - [x] php unit tests (+ coverage)
  - [x] make docker image > dockerhub
  - [x] terraform EKS
  - [x] deploy test env
  - [x] smoke test
  - [x] dockerhub (:stable)
  - [x] github merge to prod
- [x] jenkins (branch prod)
  - [x] deploy prod env
  - [x] undeploy test env
  - [ ] auto docs
  - [ ] monitor health

