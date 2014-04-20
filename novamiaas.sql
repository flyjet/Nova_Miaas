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
admin_authority bit default 0, -- 0, normal user; 1, admin
PRIMARY KEY (id)
);

insert into users (first_name,last_name,email,password, admin_authority) values
('ling', 'zhang','ling@gmail.com','1234', 0),
('qi', 'cao','qi@gmail.com','1234', 0),
('yang', 'song','yang@gmail.com','1234', 0),
('kai', 'yao','kai@gmail.com','1234', 0),
('admin', 'admin','admin@gmail.com','1234', 1);

DROP TABLE IF EXISTS hosts;
CREATE TABLE hosts ( 
id int NOT NULL AUTO_INCREMENT,
host_ip varchar(100) default NULL, -- maybe not necessary, host will monitor SQS by itself
status bit default 0,  -- 0, power off; 1, power on
used_device_no int default 0,
used_emulator_no int default 0,
PRIMARY KEY (id)
);

insert into hosts (status) values (1),(1);


DROP TABLE IF EXISTS mobiles;
CREATE TABLE mobiles ( 
id int NOT NULL AUTO_INCREMENT,
emulator_flag bit default 0,  -- 0, emulator; 1, device 
brand varchar(100) NOT NULL, -- may be not necessary
api varchar(100) NOT NULL, -- may be not necessary
name varchar(100) NOT NULL, -- could include all info
status int default 0, -- 0, free;  1, power on;  2, power off
ip varchar(100) default NULL, -- when power on, assign dynamically by genymotion
host_id int NOT NULL,
FOREIGN KEY (host_id) REFERENCES hosts(id)
ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (id)
);

insert into mobiles (emulator_flag,brand, api, name, host_id) values 
(0,'Google Galaxy Nexus - 4.3', 'API 18','Google Galaxy Nexus - 4.3 - API 18 - 720x1280', 1),
(0,'Samsung Galaxy S3 - 4.1.1', 'API 16','Samsung Galaxy S3 - 4.1.1 - API 16 - 720x1280', 1),
(1,'Google Galaxy Nexus - 4.3', 'API 18','Google Galaxy Nexus - 4.3 - API 18 - 720x1280', 1),
(1,'Samsung Galaxy S3 - 4.1.1', 'API 16','Samsung Galaxy S3 - 4.1.1 - API 16 - 720x1280', 1),
(0,'Google Galaxy Nexus - 4.3', 'API 18','Google Galaxy Nexus - 4.3 - API 18 - 720x1280', 2),
(0,'Samsung Galaxy S3 - 4.1.1', 'API 16','Samsung Galaxy S3 - 4.1.1 - API 16 - 720x1280', 2);


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
);

insert into user_mobile (user_id,mobile_id, start_time, end_time) values 
(1,1,'2014-04-19 00:00:01', '2014-04-19 10:00:01'),
(1,1,'2014-04-20 12:00:01', '2014-04-20 22:00:01'),
(1,2,'2014-04-19  00:00:01', '2014-04-20 20:00:01'),
(1,3,'2014-04-19 00:00:01', '2014-04-19 15:00:01'),
(2,5,'2014-04-19 00:00:01', '2014-04-19 10:00:01');

