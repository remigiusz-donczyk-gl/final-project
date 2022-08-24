## Overview

This is a project that intends to show my familiarity with DevOps tools. It showcases many technologies used commonly in functional products. Its main purpose is its focus on combining multiple tools into a coherent pipeline; the website being deployed (a stateful database of DevOps and IT memes) is only for showcase purposes, and thus of secondary importance.

## Jenkins

The core of the project. It contains the entire workflow as code in the [Jenkinsfile](Jenkinsfile). Everything that the pipeline does is defined in said file, and happens as a result of a GitHub Hook that notifies Jenkins of changes to the repository. It is split into parts running on all branches as well as the *dev* and *prod* branches in particular, and the entire pipeline is only complete when all parts run in tandem. The entire process will happen automatically, assuming no errors occur.

#### *Any* branch

Any code change to the repository will prompt Jenkins to test the code with a series of unit tests and the commit will be marked in GitHub with their results. Due to limitations with the static analysis tool used, it is not run for all branches, only for the *dev branch*.

#### Pull requests

Pull requests initialized from any branch to the *dev branch* will be squashed and merged automatically, assuming tests have passed on the source branch.

#### The *dev* branch

As with any branch, it first performs tests; unlike other branches however, it also performs a coverage report and then uses SonarQube to perform static analysis and makes a report of the results. It then creates a Docker image out of the current version of the website, assuming any changes were made since the last time it did so; the resulting Docker image is pushed into Docker Hub with a version number based on SEMVER as well as the *latest* tag. After that is done, Terraform is used to create all the architecture on the AWS cloud, the website is deployed into the test environment and a smoke test is performed. If it passes, the *dev* branch is merged into *prod*. The test environment is kept online for no-downtime purposes.

#### The *prod* branch

It tags the Docker image as *stable*, deploys the stable version of the website to AWS as well as monitoring tools, then removes the test environment. It creates documentation for the stable version of the site and deploys it to GitHub Pages. For showcase purposes, after manual approval is given, it also deletes the entire architecture to allow an immediate clean rerun of the pipeline.

## PHPUnit

The tool of choice for executing tests. It runs all the unit tests and analyzes code coverage, which on the dev branch is also later used by SonarQube.

## SonarQube

A static code analysis tool also used for quality measurement and reports. It notifies of any bugs, vulnerabilities, security risks and bad choices encountered in code. It also displays the collected coverage reports in an easily visualized manner.

## Docker

Depends on the Dockerfile and other files present in the website folder to create an image based on Debian, containing supervisord, nginx, PHP and mariadb. It places all the configuration and website files in the correct folders and initializes the database. The completed image is then tagged appropriately and pushed into Docker Hub for use by Terraform.

## Terraform

The most important tool specified in the pipeline. It uses the AWS tokens contained securely as Jenkins credentials to access AWS and set up all the architecture needed to deploy a Docker image inside EKS. It creates 50+ resources within the cloud, including the VPC, gateways, security rules, EKS, a Kubernetes service (and more) that allow the website to be accessed publicly.

## Doxygen

Generates documentation by reading annotated code. In addition to this manually-written documentation, it provides a basis for understanding the project's design.

## Prometheus and Grafana

Tools used to monitor the state of the services deployed to EKS. Implemented with the use of kube-prometheus-stack, a Helm chart provided by the Prometheus developers.

## Git

Used within the pipeline to perform any merges to *prod* and documentation. This is also the only expected way for the protected branches to be updated, to ensure that they always contain a working version of the repository.

