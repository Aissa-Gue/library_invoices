-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for library_invoices_db
CREATE DATABASE IF NOT EXISTS `library_invoices_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `library_invoices_db`;

-- Dumping structure for table library_invoices_db.a_clients
CREATE TABLE IF NOT EXISTS `a_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `father_name` varchar(25) NOT NULL,
  `address` varchar(35) NOT NULL,
  `phone` varchar(25) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table library_invoices_db.b_books
CREATE TABLE IF NOT EXISTS `b_books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `auther` varchar(50) NOT NULL,
  `investigator` varchar(50) NOT NULL,
  `translator` varchar(50) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `publication_year` year(4) NOT NULL,
  `edition` varchar(15) NOT NULL,
  `quantity` int(5) NOT NULL,
  `purchase_price` int(5) NOT NULL,
  `sale_price` int(5) NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `creation_date` date NOT NULL,
  `last_edit_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table library_invoices_db.c_orders
CREATE TABLE IF NOT EXISTS `c_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `discount_percentage` int(3) NOT NULL,
  `paid_price` int(11) NOT NULL,
  `creation_date` date NOT NULL,
  `last_edit_date` date NOT NULL,
  PRIMARY KEY (`order_id`,`client_id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `e_orders_clients_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `a_clients` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table library_invoices_db.d_orders_books
CREATE TABLE IF NOT EXISTS `d_orders_books` (
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL,
  `remaining` INT(4) NOT NULL DEFAULT '0',
  `purchase_price` int(5) NOT NULL,
  `sale_price` int(5) NOT NULL,
  PRIMARY KEY (`order_id`,`book_id`),
  KEY `order_id` (`order_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `d_orders_books_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `c_orders` (`order_id`),
  CONSTRAINT `d_orders_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `b_books` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table library_invoices_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
