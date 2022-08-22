#!/bin/sh
sleep 30
if [ ! -d /var/lib/mysql ] || [ "$(find /var/lib/mysql -type d -empty -exec echo yes \;)" = 'yes' ]; then
  [ ! -d /var/lib/mysql ] && mkdir /var/lib/mysql
  cp -r /var/tmp/mysql-initial/** /var/lib/mysql/
  chown mysql:mysql /var/lib/mysql -R
fi
exec /usr/bin/supervisord -c /etc/supervisord.conf

