/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.7-MariaDB : Database - simplebank_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `simplebank_db`;

/*Table structure for table `account` */

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `username` char(16) NOT NULL,
  `token` char(40) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `account` */

insert  into `account`(`username`,`token`,`full_name`,`balance`,`address`,`phone`,`email`) values 
('jaksem','aflBEUbZ3CBVhPNJmb3Gkbg3QUU7Fu2j8jFGlg2p','Jaka Sembung',1030.30,'Jl. Pendekar No. 4','085262211000','jaka@sigurita.com'),
('milkyman','G9Cd7g1xw4P58EO9CRUZZareRwO5kLEt24Pq5N0Q','Milkyman',1000.00,'Jl. Najagoan No. 11','085211223344','milky@sigurita.com'),
('wirosableng','Q7YHVDU5BQUkAfax1fcTEEGtu1O4L4hM1idBKKtF','Wiro Sableng',969.70,'Jl. Dunia Persilatan No. 9','085262211212','wiro@sigurita.com');

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` char(40) NOT NULL,
  `sender` char(16) NOT NULL,
  `recipient` char(16) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` varchar(40) DEFAULT NULL,
  `status` char(20) NOT NULL DEFAULT 'success',
  `issued_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `from` (`sender`),
  KEY `recipient` (`recipient`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `account` (`username`),
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `account` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `transaction` */

insert  into `transaction`(`id`,`sender`,`recipient`,`amount`,`notes`,`status`,`issued_at`) values 
('DIWpNziY7Uo9Tp66EGJ8PF7wQzW4wFiyHTv0L1wI','jaksem','wirosableng',22.50,'Jajan di Lbn. Silintong','success','2019-12-21 03:40:09'),
('DxBXUgEazIUdzlVjMyptRhfUJo96Gm925RvNnU11','wirosableng','jaksem',10.10,'Beli Kembang Layang','success','2020-01-04 11:05:11'),
('Fdqwe4xW7vDxDOJmt2rtNo0t7ArQ1ur0M2fLJp2w','wirosableng','jaksem',10.10,'Beli Kembang Layang','success','2020-01-05 08:45:22'),
('KvNdWBT3BI79NfqTwxmVR2k4GonhZBpzHDlkZbru','wirosableng','milkyman',24.63,'Beli Durian','success','2020-01-05 08:25:46'),
('Ua9xm6mW50UDFTxZfP8swwAldHKgwki3oeOyK3wv','milkyman','jaksem',16.30,'Durung-durung Desember','success','2020-01-04 10:43:56');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
