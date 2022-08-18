## Overview

This is a project that intends to show my familiarity with DevOps tools. It showcases many technologies used commonly in functional products.

The main purpose is its focus on combining multiple tools into a coherent pipeline; the website being deployed (a stateful database of DevOps and IT memes) is only for showcase purposes, and thus of secondary importance.

## Jenkins

The core of the entire project. It contains the entire workflow as code in the Jenkinsfile. Everything that the pipeline does is defined in said file, and happens as a result of a GitHub Hook that notifies Jenkins of changes to the repository. It is split into the *dev* and *prod* branches, and the entire pipeline is only done when both parts complete. The *dev* branch will automatically call the *prod* branch when it finishes successfully, so the entire process will happen automatically, assuming no errors occur.

#### The *dev* branch

This is the first part that starts whenever changes are pushed to the *dev* branch of the repository. It first performs tests, a coverage report and then uses SonarQube to perform static analysis and make a report of the results. Immediately after, it creates a Docker image out of the current version of the website, assuming any changes were made since the last time it did so; the Docker image is then pushed into Docker Hub with a SEMVER-compliant version number as well as the *latest* tag.
After that is done, Terraform is used to create the required architecture on the AWS cloud, the website is deployed into the test environment and a smoke test is performed. If it passes, the *dev* branch is merged into *prod*. The test environment is kept online for no-downtime purposes.

#### The *prod* branch

This is the second part that runs when changes are made to the *prod* branch of the repository. It tags the Docker image as *stable*, deploys a stable version of the website to AWS as well as monitoring tools, then removes the test version. It creates documentation for the stable version of the site and deploys it to GitHub Pages. For showcase purposes, it also deletes the entire architecture after manual approval is given.

## PHPUnit

The tool of choice for executing tests. It runs all the unit tests and analyzes code coverage, which is later used by SonarQube.

## SonarQube

A static code analysis tool also used for quality measurement and reports. It notifies of any bugs, vulnerabilities, security risks and bad choices encountered in code. It also displays the collected coverage reports in a simple-to-visualize manner.

## Docker

Depends on the Dockerfile and other files present in the website folder to create an image based on Debian, containing supervisord, nginx, PHP and mariadb. It places all the configuration and website files in the correct folders and initializes the database. The completed image is then tagged appropriately and pushed into Docker Hub.

## Terraform

The most important tool specified in the pipeline. It uses the AWS tokens contained securely as Jenkins credentials to access AWS and set up all the architecture needed to deploy a Docker image inside EKS. It creates 50+ resources within the cloud, including such highlights as the VPC, gateways, security rules, EKS and a Kubernetes service that allows the website to be accessed publicly.

## Doxygen

Generates the documentation by reading annotated code. In addition to this manually-written documentation, it provides a basis for understanding the project's design.

## Prometheus and Grafana

Tools used to monitor the state of the services deployed to EKS. Implemented with the use of kube-prometheus-stack, a ready-to-use Helm chart.

## Git

Honorable mentions for git, which is used within the pipeline to merge the *dev* branch into *prod* automatically and update documentation. This is also the only expected way for the protected branches to be updated, to ensure that it always contains the latest working version of the repository.

