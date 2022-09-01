FROM jenkins/jenkins:2.346.2-lts-jdk11
USER root
ADD https://phar.phpunit.de/phpunit-9.5.21.phar /var/jenkins_home/bin/phpunit
RUN chown jenkins:jenkins /var/jenkins_home/bin/phpunit && \
    chmod 555 /var/jenkins_home/bin/phpunit && \
    apt update && \
    apt install -y php7.4-cli php7.4-json php7.4-mbstring php7.4-xml php7.4-mysql php-xdebug nodejs doxygen && \
    echo "xdebug.mode=coverage" >> /etc/php/7.4/mods-available/xdebug.ini
USER jenkins

