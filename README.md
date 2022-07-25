# A CI/CD pipeline
![Build Status](https://jenkins-gl.bluecom.dev/buildStatus/icon?job=final-project%2Fdev)

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.

- [x] simple webapp with database
- [ ] jenkins (branch dev)
  - [x] build
    - [x] make docker image > dockerhub
    - [x] terraform aws kubernetes
    - [x] deploy test env
  - [x] test
    - [x] auto tests
    - [x] remove test env
    - [x] dockerhub (:stable)
    - [ ] github merge to prod
- [ ] jenkins (branch prod)
  - [ ] deploy prod env
  - [ ] monitor health

