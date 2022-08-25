FROM debian:stable-slim

# fix internet connectivity and install packages + files
RUN echo 'nameserver 192.168.0.1' > /etc/resolv.conf && \
    apt update && \
    apt install -y mariadb-client nginx php7.4-fpm php7.4-mysql supervisor
ADD supervisord.conf /etc/
ADD php-fpm.conf php.ini /etc/php/7.4/fpm/
ADD nginx.conf /etc/nginx/
ADD entrypoint.sh pw.conf /
ADD setup.sql /tmp/
ADD data /var/www/html/data
ADD Website.php index.php script.js style.css /var/www/html/

# bootstrap services
RUN service php7.4-fpm start && \
    service nginx start

ENTRYPOINT ["/entrypoint.sh"]

# inform users of preferred values
EXPOSE 80

