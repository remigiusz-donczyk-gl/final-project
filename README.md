# A CI/CD pipeline
![Build Status](https://jenkins-gl.bluecom.dev/buildStatus/icon?job=final-project%2Fdev)

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.

- [x] placeholder app
- [ ] simple webapp with db
- [x] github push to dev
  - [x] jenkins (branch dev)
    - [x] build
      - [x] make docker image > dockerhub
      - [ ] terraform aws kubernetes
      - [ ] deploy test env
    - [ ] test
      - [ ] auto tests
      - [ ] remove test env
      - [ ] dockerhub (:stable) (signing?)
      - [ ] github merge to prod
- [ ] jenkins (branch prod)
  - [ ] deploy prod env
  - [ ] monitor health?

