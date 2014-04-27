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
end_time timestamp, -- should not default not null
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

insert into user_mobile (user_id,mobile_id, start_time, end_time) values 
(1,1,'2014-03-19 00:00:01', '2014-03-19 10:00:01'),
(1,1,'2014-03-20 10:00:01', '2014-03-20 22:00:01'),
(1,2,'2014-03-19  00:05:01', '2014-03-20 20:30:01'),
(1,3,'2014-03-19 00:01:01', '2014-03-19 17:40:01'),
(2,5,'2014-03-19 00:00:01', '2014-03-19 10:00:01');


DROP TABLE IF EXISTS paymentinfo;
CREATE TABLE paymentinfo (
	id int NOT NULL AUTO_INCREMENT,
	user_id int NOT NULL,
	card_number varchar(50) NOT NULL,
	name_on_card varchar(50) NOT NULL,
	expire varchar(20) NOT NULL,
	street varchar(50),
	city varchar(20),
	state varchar(20),
	postcode varchar(20),
	country varchar(20),
	phone varchar(20),
	FOREIGN KEY (user_id) REFERENCES users(id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (id)
	);

insert into paymentinfo (user_id, card_number,name_on_card,expire,street,city,state,postcode,country,phone)	values
	(1,'123456789012','ling zhang','12/2018','100 1st Street','San Jose','CA','12345','USA','408-123-4567');


DROP TABLE IF EXISTS bills;
CREATE TABLE bills (
	id int NOT NULL AUTO_INCREMENT,
	user_id int NOT NULL,
	bill_start timestamp NOT NULL,
	bill_end timestamp NOT NULL,
	bill_due timestamp,
	amount decimal(10,2) NOT NULL,
	paid_flag bit default 0,  -- 0, not paid; 1, alread paid
	FOREIGN KEY (user_id) REFERENCES users(id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (id)
	);

insert into bills (user_id,bill_start,bill_end,bill_due,amount,paid_flag)	values
	(1,'2013-06-01 00:00:01','2013-07-01 00:00:00','2013-08-01 00:00:00', 19.30, 1),
	(1,'2013-07-01 00:00:01','2013-08-01 00:00:00','2013-09-01 00:00:00', 29.10, 1),
	(1,'2013-08-01 00:00:01','2013-09-01 00:00:00','2013-10-01 00:00:00', 5.67, 1),
	(1,'2013-09-01 00:00:01','2013-10-01 00:00:00','2013-11-01 00:00:00', 38.10, 1),
	(1,'2013-10-01 00:00:01','2013-11-01 00:00:00','2013-12-01 00:00:00', 21.50, 1),
	(1,'2013-11-01 00:00:01','2013-12-01 00:00:00','2014-01-01 00:00:00', 15.80, 1),
	(1,'2013-12-01 00:00:01','2014-01-01 00:00:00','2014-02-01 00:00:00', 27.35, 1),
	(1,'2014-01-01 00:00:01','2014-02-01 00:00:00','2014-03-01 00:00:00', 20.00, 1),
	(1,'2014-02-01 00:00:01','2014-03-01 00:00:00','2014-04-01 00:00:00', 10.27, 1),
	(1,'2014-03-01 00:00:01','2014-04-01 00:00:00','2014-05-01 00:00:00', 25.00, 0);

DROP TABLE IF EXISTS pay_history;
CREATE TABLE pay_history (	
	id int NOT NULL AUTO_INCREMENT,
	user_id int NOT NULL,
	bill_id int NOT NULL,
	payinfo_id int NOT NULL,
	paid_time timestamp NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (bill_id) REFERENCES bills(id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (payinfo_id) REFERENCES paymentinfo(id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (id)
	);	

insert into pay_history(user_id,bill_id,payinfo_id,paid_time)values
	(1,1,1,'2013-07-15 00:00:00'),
	(1,2,1,'2013-08-15 00:00:00'),
	(1,3,1,'2013-09-15 00:00:00'),
	(1,4,1,'2013-10-15 00:00:00'),
	(1,5,1,'2013-11-15 00:00:00'),
	(1,6,1,'2013-12-15 00:00:00'),
	(1,7,1,'2014-01-15 00:00:00'),
	(1,8,1,'2014-02-14 00:00:00'),
	(1,9,1,'2014-03-27 00:00:00');

	
-- SELECT h.user_id, h.paid_time, b.amount, p.card_number
-- FROM pay_history h, bills b, paymentinfo p 
-- WHERE h.user_id =1 AND h.bill_id=b.id AND h.payinfo_id=p.id;
-- test success

-- select * from user_mobile
-- where user_id = 1 and start_time > '2014-04-19 00:00:00' and end_time < '2014-04-20 00:00:01';
-- test success

-- select um.id, um.user_id, um.mobile_id, um.start_time, um.end_time, m.emulator_flag from user_mobile um, mobiles m
-- where um.mobile_id=m.id and um.user_id = 1 and um.start_time > '2014-04-19 00:00:00' and um.end_time < '2014-04-20 00:00:01'
-- and m.emulator_flag=0;
-- test sucess

-- select um.id, um.user_id, um.mobile_id, m.emulator_flag, m.brand, m.api from user_mobile um, mobiles m
-- where um.mobile_id=m.id and um.user_id = 1 um.mobile_id ;
-- test sucess


-- select id, emulator_flag, brand, api from mobiles
-- where id in (select distinct mobile_id from user_mobile where user_id=1);
-- test sucess
