#!/bin/bash
sleep 3
if ! mysql -p$(cat /pw.conf) -u dbuser -h appdb -e "show databases;" | grep website; then
  mysql -p$(cat /pw.conf) -u dbuser -h appdb </tmp/setup.sql
fi
exec /usr/bin/supervisord -c /etc/supervisord.conf
