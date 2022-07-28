# A CI/CD pipeline
![Build Status](https://jenkins-gl.bluecom.dev/buildStatus/icon?job=final-project%2Fdev)

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.
[Docker image](https://hub.docker.com/repository/docker/remigiuszdonczyk/final-project/tags)

Check out the documentation [here](DOCS.md)!
- [x] simple webapp with database
- [x] jenkins (branch dev)
  - [x] build
    - [x] make docker image > dockerhub
    - [x] terraform aws kubernetes
    - [x] deploy test env
  - [x] test
    - [x] auto tests
    - [x] remove test env
    - [x] dockerhub (:stable)
    - [x] github merge to prod
- [x] jenkins (branch prod)
  - [x] deploy prod env
- [ ] Cloudflare Integration
- [ ] monitor health
- [ ] documentation

