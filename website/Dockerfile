# begin with a slim linux
FROM debian:stable-slim
# fix internet connectivity and install packages
RUN echo 'nameserver 192.168.0.1' > /etc/resolv.conf && apt update && apt install -y mariadb-server nginx php7.4-fpm php7.4-mysql supervisor
# copy files
ADD supervisord.conf /etc/supervisord.conf
ADD php-fpm.conf /etc/php/7.4/fpm/
ADD nginx.conf /etc/nginx/
ADD setup.sql /tmp/
ADD website.db /tmp/
ADD data /var/www/html/data
# start the database and setup
RUN service php7.4-fpm start && service nginx start && service mariadb start && mysql </tmp/setup.sql
ADD index.php /var/www/html/

# inform users of preferred values
EXPOSE 80
VOLUME ["/var/lib/mysql"]
CMD ["/usr/bin/supervisord"]

