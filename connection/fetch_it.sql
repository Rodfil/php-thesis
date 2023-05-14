/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.14-MariaDB : Database - fetch_it
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fetch_it` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `fetch_it`;

/*Table structure for table `document_list` */

DROP TABLE IF EXISTS `document_list`;

CREATE TABLE `document_list` (
  `ID` int(1) NOT NULL AUTO_INCREMENT,
  `DocumentName` varchar(255) DEFAULT NULL,
  `Price` double(10,2) DEFAULT 0.00,
  `IsVoter` tinyint(1) DEFAULT 0,
  `IsNonVoter` tinyint(1) DEFAULT 0,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `document_list` */

insert  into `document_list`(`ID`,`DocumentName`,`Price`,`IsVoter`,`IsNonVoter`,`DateAdded`) values 
(1,'Barangay Clearance',45.00,1,1,'2023-03-11 14:52:06'),
(2,'Certificate of Indigency',100.00,1,1,'2023-03-11 14:52:28'),
(9,'Marriage Certificate',900.00,1,1,'2023-03-11 15:22:44'),
(8,'PSA / Birth Certification',150.00,1,1,'2023-03-11 15:22:10'),
(5,'Death Certificate',350.00,1,1,'2023-03-11 14:53:01'),
(6,'Business Permit',900.00,1,1,'2023-03-11 14:53:11'),
(7,'Building Permit',1500.00,1,1,'2023-03-11 14:53:21');

/*Table structure for table `feedback` */

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `Emoticon` tinyint(1) DEFAULT 0,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

/*Data for the table `feedback` */

insert  into `feedback`(`ID`,`UserID`,`Remarks`,`Emoticon`,`DateAdded`) values 
(1,1,'Fusce condimentum cursus mauris et ornare. Mauris fermentum mi id sollicitudin viverra. Aenean dignissim sed ante eget dapibus. Sed dapibus nulla elementum, rutrum neque eu, gravida neque.',3,'2023-03-12 11:18:13'),
(2,1,'Fusce condimentum cursus mauris et ornare. Mauris fermentum mi id sollicitudin viverra. Aenean dignissim sed ante eget dapibus. Sed dapibus nulla elementum, rutrum neque eu, gravida neque.',4,'2023-03-12 11:18:45'),
(3,1,'TEST',5,'2023-03-12 11:26:51'),
(4,1,'TEST 2',1,'2023-03-12 11:26:55'),
(5,1,'TEST 3',2,'2023-03-12 11:26:58'),
(6,1,'TEST 4',3,'2023-03-12 11:27:02'),
(7,1,'TEST 5',4,'2023-03-12 11:27:11'),
(8,1,'TEST 6',5,'2023-03-12 11:27:16'),
(9,1,'TEST 7',1,'2023-03-12 11:27:20'),
(10,1,'TEST 8',2,'2023-03-12 11:27:24'),
(11,1,'TEST 9',3,'2023-03-12 11:27:29'),
(12,1,'qweqweqwe',4,'2023-03-12 11:45:07'),
(13,1,'qweqw561231251',5,'2023-03-12 11:45:10'),
(14,1,'6123125123123',3,'2023-03-12 11:45:13'),
(15,1,'123',1,'2023-03-12 11:45:34'),
(16,1,'123125123',2,'2023-03-12 11:45:36'),
(17,1,'25123216123123',2,'2023-03-12 11:45:38'),
(18,1,'68679678678',3,'2023-03-12 11:45:41'),
(19,1,'17696067678',4,'2023-03-12 11:45:43'),
(20,1,'werwefwerw er',5,'2023-03-12 11:45:46'),
(21,1,'rweuwerwerwe',1,'2023-03-12 11:45:49'),
(22,1,'qweqweqwe',2,'2023-03-12 11:45:54'),
(23,1,'qwe',2,'2023-03-12 11:45:56'),
(24,1,'qwe',4,'2023-03-12 11:45:57'),
(25,1,'qwe',3,'2023-03-12 11:45:57'),
(26,1,'e',4,'2023-03-12 11:45:58'),
(27,1,'qwe',5,'2023-03-12 11:45:59'),
(28,1,'eq',1,'2023-03-12 11:46:00'),
(29,1,'qwe',2,'2023-03-12 11:46:00'),
(30,1,'qwe',5,'2023-03-12 11:46:01'),
(31,1,'qwe',1,'2023-03-12 11:46:02'),
(32,1,'qwe',2,'2023-03-12 11:46:03'),
(33,1,'we',3,'2023-03-12 11:46:03'),
(34,1,'weq',5,'2023-03-12 11:46:04'),
(35,1,'eq',1,'2023-03-12 11:46:04'),
(36,1,'qw',1,'2023-03-12 11:46:05'),
(37,1,'we',2,'2023-03-12 11:46:06'),
(38,1,'eq',3,'2023-03-12 11:46:06'),
(39,1,'qw',1,'2023-03-12 11:46:07'),
(40,1,'qwe',1,'2023-03-12 11:46:07'),
(41,1,'qwe',1,'2023-03-12 11:46:08'),
(42,1,'qwe',1,'2023-03-12 11:46:08'),
(43,1,'qwe',1,'2023-03-12 11:46:09'),
(44,1,'23',1,'2023-03-12 11:46:09'),
(45,1,'31',1,'2023-03-12 11:46:10'),
(46,1,'12',1,'2023-03-12 11:46:11'),
(47,1,'23',1,'2023-03-12 11:46:11'),
(48,1,'31',2,'2023-03-12 11:46:12'),
(49,1,'qwe',2,'2023-03-12 11:46:12'),
(50,1,'123',2,'2023-03-12 11:46:13'),
(51,1,'123',2,'2023-03-12 11:46:13'),
(52,1,'123',2,'2023-03-12 11:46:14'),
(53,4,'Test 3-18-2023 ',3,'2023-03-18 16:41:49');

/*Table structure for table `notification` */

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(30) DEFAULT NULL,
  `Description` varchar(60) DEFAULT NULL,
  `Status` varchar(30) DEFAULT NULL,
  `Date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Data for the table `notification` */

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `RequestFormID` int(11) DEFAULT NULL,
  `Amount` double(10,2) DEFAULT 0.00,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `ReferenceNo` varchar(30) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT 0,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `payment` */

insert  into `payment`(`ID`,`RequestFormID`,`Amount`,`PaymentMethod`,`ReferenceNo`,`Status`,`DateAdded`) values 
(24,15,900.00,'GCASH','TEST125123123123',1,'2023-04-13 19:01:59'),
(23,14,45.00,'Over the counter','OTC1342023185336',1,'2023-04-13 18:53:36');

/*Table structure for table `request_form` */

DROP TABLE IF EXISTS `request_form`;

CREATE TABLE `request_form` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `DocumentID` int(11) DEFAULT NULL,
  `Purpose` varchar(255) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT 0,
  `ReferenceNo` varchar(30) DEFAULT NULL,
  `ReceiveDate` date DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  `ReleasedBy` int(11) DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `request_form` */

insert  into `request_form`(`ID`,`UserID`,`DocumentID`,`Purpose`,`Status`,`ReferenceNo`,`ReceiveDate`,`Reason`,`DateAdded`,`ReleasedBy`) values 
(17,4,6,'Applying for business permit',0,'REF20230413011741',NULL,NULL,'2023-04-13 19:17:41',0),
(16,4,8,'TEST only',0,'REF20230413010435',NULL,'TEST','2023-04-13 19:04:35',0),
(15,1,6,'TEST',3,'REF20230413125737','2023-04-14','For testing purpose only','2023-04-13 18:57:37',2),
(14,1,1,'TEST',3,'REF20230413124144','2023-04-13',NULL,'2023-04-13 18:41:44',2);

/*Table structure for table `requirements` */

DROP TABLE IF EXISTS `requirements`;

CREATE TABLE `requirements` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DocumentID` int(11) DEFAULT NULL,
  `Description` longtext DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `requirements` */

insert  into `requirements`(`ID`,`DocumentID`,`Description`,`DateAdded`) values 
(1,1,'Valid ID (Latest)','2023-03-18 12:50:27'),
(2,1,'Zone Clearance.','2023-03-18 12:50:27'),
(3,1,'Community Tax Certificate or CEDULA.','2023-03-18 12:50:27'),
(4,1,'Completed Application Form.','2023-03-18 12:50:27'),
(5,1,'Barangay Clearance Fee - 100 PHP','2023-03-18 12:52:43'),
(6,7,'Five (5) copies of Bill of Materials and Specification – signed and sealed by an engineer or an architect on every page.','2023-03-18 12:53:19'),
(7,7,'Locational Clearance.','2023-03-18 12:53:19'),
(8,7,'Photocopy of PTR # and PRC license of all concerned engineers and architects.','2023-03-18 12:53:19'),
(9,7,'Clearance from the DPWH if the construction is located along National Highway.','2023-03-18 12:53:19'),
(10,7,'DOLE Clearance.','2023-03-18 12:53:19'),
(11,6,'DTI or SEC registration certificate.','2023-03-18 12:53:52'),
(12,6,'Barangay Clearance.','2023-03-18 12:53:52'),
(13,6,'Community Tax Certificate.','2023-03-18 12:53:52'),
(14,6,'Lease contract (for rented property) or tax declaration (for owned properties)','2023-03-18 12:53:52'),
(15,6,'Building or occupancy permit for newly-constructed buildings or offices.','2023-03-18 12:53:52'),
(16,2,'Barangay Certification / Barangay Certificate of Residency.','2023-03-18 12:54:24'),
(17,2,'Certificate of No Business from the Municipal Treasury Office.','2023-03-18 12:54:24'),
(18,5,'Complete name of the deceased person.','2023-03-18 12:55:25'),
(19,5,'Date of death.','2023-03-18 12:55:25'),
(20,5,'Place of death.','2023-03-18 12:55:25'),
(21,5,'Place of marriage.','2023-03-18 12:55:25'),
(22,5,'Complete name and address of the requesting party.','2023-03-18 12:55:25'),
(23,5,'Number of copies needed.','2023-03-18 12:55:25'),
(24,5,'Purpose of the certification.','2023-03-18 12:55:25'),
(25,9,'Marriage License Application Form.','2023-03-18 12:56:00'),
(26,9,'Birth or Baptismal Certificates of both applicants.','2023-03-18 12:56:00'),
(27,9,'Community Tax Certificate (Cedula)','2023-03-18 12:56:00'),
(28,9,'One (1) ID photo of both applicants.','2023-03-18 12:56:00'),
(29,9,'If Applicable: Municipal Form No. 92 (Consent of Marriage of a Person Under Age)','2023-03-18 12:56:00'),
(30,8,'Complete name of the child (first, middle, last)','2023-03-18 12:56:41'),
(31,8,'Complete name of the father.','2023-03-18 12:56:41'),
(32,8,'Complete maiden name of the mother.','2023-03-18 12:56:41'),
(33,8,'Date of birth (month, day, year)','2023-03-18 12:56:41'),
(34,8,'Place of birth (city/municipality, province)','2023-03-18 12:56:41'),
(35,8,'Whether or not registered late.','2023-03-18 12:56:41');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(50) DEFAULT NULL,
  `Lastname` varchar(50) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `RegistrationStatus` varchar(50) DEFAULT NULL,
  `Address` longtext DEFAULT NULL,
  `ContactNo` varchar(25) DEFAULT NULL,
  `EmailAddress` varchar(60) DEFAULT NULL,
  `Password` longtext DEFAULT NULL,
  `UserType` varchar(10) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT 0,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`ID`,`Firstname`,`Lastname`,`Gender`,`Birthdate`,`RegistrationStatus`,`Address`,`ContactNo`,`EmailAddress`,`Password`,`UserType`,`Status`,`DateAdded`) values 
(1,'Angelo','Fernandez','Male','1996-12-19','Registered Voter','18A J.M. Basa Street Cebu City 1','09956143191','la.gelo.fernandez@gmail.com','e10adc3949ba59abbe56e057f20f883e','Client',1,'2023-03-10 18:46:00'),
(2,'Admin 1','Fernandez','Male','1997-12-19','Registered Voter','',NULL,'angelo.roccatech@gmail.com','e10adc3949ba59abbe56e057f20f883e','Admin',0,'2023-03-11 15:24:44'),
(3,'Ricardo','Navaja','Male','2007-02-28','Registered Voter','','09956143191','angelo.toyntoys@gmail.com','e10adc3949ba59abbe56e057f20f883e','Client',1,'2023-03-18 11:57:36'),
(4,'John','Doe','Male','1993-03-16','Registered Voter','','09335601231','john.doe@gmail.com','e10adc3949ba59abbe56e057f20f883e','Client',1,'2023-03-18 16:33:01'),
(5,'Admin','Super','Male','1993-03-16','Registered Voter',NULL,'000000','superadmin@gmail.com','e10adc3949ba59abbe56e057f20f883e','SuperAdmin',1,'2023-03-18 18:40:40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
