## Overview

This is a project that intends to show my familiarity with DevOps tools. It showcases many technologies used commonly in functional products.

The main purpose is its focus on combining multiple tools into a coherent pipeline; the website being deployed (a stateful database of DevOps & IT memes) is only for showcase purposes, and thus of secondary importance.

## Jenkins

The core of the entire project. It contains the entire workflow as code in the Jenkinsfile. Everything that the pipeline does is defined in said file, and happens as a result of a GitHub Hook that notifies Jenkins of changes to the repository. It is split into the *dev* and *prod* branches, and the entire pipeline is only done when both parts complete. The *dev* branch will automatically call the *prod* branch when it finishes successfully, so the entire process will happen automatically, assuming no errors occur.

#### The *dev* branch

This is the first part that starts whenever changes are pushed to the *dev* branch of the repository. It first creates a Docker image out of the current version of the website, assuming any changes were made since the last time it did so, the Docker image is then pushed into Dockerhub with a SEMVER-compliant version number as well as *latest* tag.
After that is done, terraform is used to create the required architecture on the AWS cloud, the website is deployed into the test environment and tests (currently only a smoke test) are performed. If they pass, the Docker image is tagged as *stable*, and the *dev* branch is merged into *prod*. The test environment is kept online for no-downtime purposes.

#### The *prod* branch

This is the second part that runs when changes are made to the *prod* branch of the repository. It deploys a stable version of the website to AWS, then undeploys the test version. For showcase purposes, it also deletes the entire architecture after manual approval is given.

## Docker

The first tool used by Jenkins to complete the entire process. It depends on the Dockerfile and other files present in the website folder to create an image based on Debian, containing supervisord, nginx, php and mariadb. It places all the files in the correct folders, and initializes the database. The completed image is then tagged and pushed into Dockerhub.

## Terraform

The second, and the most important, tool that Jenkins uses. It uses the AWS tokens specified securely in Jenkins credentials to access AWS and set up all of the architecture needed to deploy a Docker image inside EKS. It creates a total of \~50 resources within the cloud, including such highlights as the VPC, gateways, security rules, EKS and a kubernetes service that allows the website to be accessed publicly.

## Git

Honorable mentions for git, which is used within the pipeline to merge the *dev* branch into *prod* automatically. This is also the only way for the prod branch can be updated, ensuring that it can never contain an environment which is faulty.

## Planned

- Monitoring

- A bit more documentation

- Static code analysis

