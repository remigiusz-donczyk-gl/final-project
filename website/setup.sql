create database website;
create user dbuser@localhost identified by '123';
grant all on website.* to dbuser@localhost;
use website;
source /tmp/website.db;

