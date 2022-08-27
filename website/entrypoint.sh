#!/bin/sh
if ! mysql -h appdb -e "show databases;" | grep website; then
  mysql -h appdb </tmp/setup.sql
fi
exec /usr/bin/supervisord -c /etc/supervisord.conf
