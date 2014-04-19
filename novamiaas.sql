DROP DATABASE IF EXISTS nova_miaas;
CREATE DATABASE nova_miaas ;
USE nova_miaas;

GRANT ALL PRIVILEGES ON nova_miaas.*
TO 'group6'@'localhost'
IDENTIFIED BY 'sjsugroup6';

DROP TABLE IF EXISTS users;
CREATE TABLE users (
id int NOT NULL AUTO_INCREMENT,
first_name varchar(100) NOT NULL,
last_name varchar(100) NOT NULL,
email varchar(100) NOT NULL, -- may need to set uique later
password MEDIUMTEXT not NULL,
admin_authority bit default 0,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS hosts;
CREATE TABLE hosts ( 
id int NOT NULL AUTO_INCREMENT,
host_ip varchar(100) NOT NULL,
status varchar(100) NOT NULL,  --power on , power off
used_device_no int default 0,
used_emulator_no int default 0,
PRIMARY KEY (id)

DROP TABLE IF EXISTS mobiles;
CREATE TABLE mobiles ( 
id int NOT NULL AUTO_INCREMENT,
emulator_flag bit default 0,  -- whether it is emulator (0) or device (1)
brand varchar(100) NOT NULL, 
api varchar(100) NOT NULL, 
name varchar(100) NOT NULL, 
status varchar(100) NOT NULL, --power on , power off, free
ip varchar(100) NOT NULL, 
host_id int NOT NULL,
FOREIGN KEY (host_id) REFERENCES hosts(id)
 ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (id)


DROP TABLE IF EXISTS user_mobile;
CREATE TABLE user_mobile ( 
id int NOT NULL AUTO_INCREMENT,
user_id int NOT NULL,
mobile_id int NOT NULL,
start_time timestamp NOT NULL,
end_time timestamp NOT NULL,
FOREIGN KEY (user_id) REFERENCES users(id)
 ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (mobile_id) REFERENCES mobiles(id)
 ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (id)
