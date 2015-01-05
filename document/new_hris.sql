-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.24-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema new_hris
--

CREATE DATABASE IF NOT EXISTS ccs_hris;
USE ccs_hris;

--
-- Definition of table `tbl_daily_attendance`
--

DROP TABLE IF EXISTS `tbl_daily_attendance`;
CREATE TABLE `tbl_daily_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `emp_code` varchar(10) NOT NULL,
  `date_filed` int(11) NOT NULL COMMENT 'timestamp',
  `type` varchar(20) DEFAULT NULL COMMENT 'late = 2, absent = 1, awol = 0',
  `reason` text COMMENT 'reason of late/absent/awol',
  `status` tinyint(4) DEFAULT NULL COMMENT 'arrived = 1, not yet arrived = 0',
  `remark` text COMMENT 'remarks of head',
  `created_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  `updated_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_daily_attendance`
--

/*!40000 ALTER TABLE `tbl_daily_attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_daily_attendance` ENABLE KEYS */;


--
-- Definition of table `tbl_employee_beneficiaries`
--

DROP TABLE IF EXISTS `tbl_employee_beneficiaries`;
CREATE TABLE `tbl_employee_beneficiaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `spouse` varchar(100) DEFAULT NULL,
  `child1` varchar(100) DEFAULT NULL,
  `child2` varchar(100) DEFAULT NULL,
  `child3` varchar(100) DEFAULT NULL,
  `child4` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_beneficiaries`
--

/*!40000 ALTER TABLE `tbl_employee_beneficiaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_employee_beneficiaries` ENABLE KEYS */;


--
-- Definition of table `tbl_employee_emergency_info`
--

DROP TABLE IF EXISTS `tbl_employee_emergency_info`;
CREATE TABLE `tbl_employee_emergency_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `home_phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_emergency_info`
--

/*!40000 ALTER TABLE `tbl_employee_emergency_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_employee_emergency_info` ENABLE KEYS */;


--
-- Definition of table `tbl_employee_info`
--

DROP TABLE IF EXISTS `tbl_employee_info`;
CREATE TABLE `tbl_employee_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `emp_code` varchar(10) NOT NULL,
  `employer` varchar(100) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `date_hired` int(11) DEFAULT NULL COMMENT 'timestamp',
  `date_regularization` int(11) DEFAULT NULL COMMENT 'timestamp',
  `created_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  `updated_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_employee_info`
--

/*!40000 ALTER TABLE `tbl_employee_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_employee_info` ENABLE KEYS */;


--
-- Definition of table `tbl_leaves`
--

DROP TABLE IF EXISTS `tbl_leaves`;
CREATE TABLE `tbl_leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `emp_code` varchar(10) NOT NULL,
  `date_filed` int(11) NOT NULL COMMENT 'timestamp',
  `date_from` int(11) NOT NULL COMMENT 'timestamp START date of effectiveness',
  `date_to` int(11) NOT NULL COMMENT 'timestamp END date of effectiveness',
  `reason` text COMMENT 'reason of leave',
  `type` varchar(20) DEFAULT NULL COMMENT 'type of leave( VACATION, SICK... )',
  `remark` text COMMENT 'remarks of head',
  `status` tinyint(4) DEFAULT NULL COMMENT 'approved = 1,denied = 0,pending = 2',
  `created_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  `updated_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_leaves`
--

/*!40000 ALTER TABLE `tbl_leaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_leaves` ENABLE KEYS */;


--
-- Definition of table `tbl_logins`
--

DROP TABLE IF EXISTS `tbl_logins`;
CREATE TABLE `tbl_logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `emp_code` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` tinyint(4) NOT NULL COMMENT 'role id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_logins`
--

/*!40000 ALTER TABLE `tbl_logins` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_logins` ENABLE KEYS */;


--
-- Definition of table `tbl_person_info`
--

DROP TABLE IF EXISTS `tbl_person_info`;
CREATE TABLE `tbl_person_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `street_address` text,
  `city` varchar(50) DEFAULT NULL,
  `province` text,
  `zipcode` int(11) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `home_phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  `date_of_birth` int(11) DEFAULT NULL,
  `place_of_birth` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `tax_tin` varchar(50) DEFAULT NULL,
  `sss` varchar(50) DEFAULT NULL,
  `philhealth` varchar(50) DEFAULT NULL,
  `pagibig` varchar(50) DEFAULT NULL,
  `person_pic` varchar(150) DEFAULT NULL COMMENT 'URL of image from base',
  `created_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  `updated_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_person_info`
--

/*!40000 ALTER TABLE `tbl_person_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_person_info` ENABLE KEYS */;


--
-- Definition of table `tbl_request`
--

DROP TABLE IF EXISTS `tbl_request`;
CREATE TABLE `tbl_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL COMMENT 'id field in person_data table',
  `emp_code` varchar(10) NOT NULL,
  `date_filed` int(11) NOT NULL COMMENT 'timestamp',
  `purpose` tinyint(4) DEFAULT NULL COMMENT 'tardiness = 1, Undertime = 0, non pouching (IN/OUT) = 2',
  `reason` text COMMENT 'reason of request',
  `status` tinyint(4) DEFAULT NULL COMMENT 'approved = 1, disapproved = 0',
  `remark` text COMMENT 'remarks of head',
  `created_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  `updated_at` int(11) DEFAULT NULL COMMENT 'timestamp ( auto generate of system )',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_request`
--

/*!40000 ALTER TABLE `tbl_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_request` ENABLE KEYS */;


--
-- Definition of table `tbl_roles`
--

DROP TABLE IF EXISTS `tbl_roles`;
CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) DEFAULT NULL COMMENT 'role name ex. admin, employee',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

/*!40000 ALTER TABLE `tbl_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_roles` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
