# A CI/CD pipeline
![Build Status](https://jenkins-gl.bluecom.dev/buildStatus/icon?job=final-project%2Fdev)

This is part of a DevOps academy I am taking part in. A simple project with a pipeline to go with it.

[simple webapp with db]
- [x] github push to dev > jenkins hook
- [ ] jenkins (branch dev)
  - [ ] build
    - [ ] make docker image > dockerhub (signing)
    - [ ] terraform azure kubernetes
    - [ ] deploy test env
  - [ ] test
    - [ ] auto tests
    - [ ] allow github merge
    - [ ] remove test env
- [ ] github merge to prod > jenkins hook
- [ ] jenkins (branch prod)
  - [ ] deploy prod env
  - [ ] monitor health
asdf
