# Setup

Files to set up the required environment for builds will be stored here. To install the project, make sure you have Docker and Docker Compose (plugin) and run [./install.sh](install.sh) after cloning the repo. The installer will ask for your HOME environment variable, and will install into HOME/.docker/final_project (it will assume bash's HOME by default but you can change it as you wish). It will also ask for DOCKER_SOCK and DOCKER_GROUP, which will be used to set up Jenkins (it uses docker internally). Those will also autodetect the correct values but ask you for approval. The container volume files will be deleted from this folder, so if you need a second install, you'll need to copy them prior to installation, or clone a second time.

# Uninstall

The installer will create a file called app.env in this folder, which will store your selected values for the lifetime of your installation. Run [./uninstall.sh](uninstall.sh) to delete the entire project cleanly. HOME/.docker/final_project will be fully purged, so make sure to back up anything you want to keep after you uninstall.
