<?php

// Clients table
$clientsQry = "CREATE TABLE IF NOT EXISTS `a_clients` (
	`client_id` int(11) NOT NULL AUTO_INCREMENT,
	`last_name` varchar(25) NOT NULL,
	`first_name` varchar(25) NOT NULL,
	`father_name` varchar(25) NOT NULL,
	`address` varchar(35) NOT NULL,
	`phone1` int(11) NOT NULL,
	`phone2` int(11) NOT NULL,
	`creation_date` date NOT NULL,
	`last_edit_date` date NOT NULL,
	PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


// Books table
$booksQry = "CREATE TABLE IF NOT EXISTS `b_books` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// Orders table
$ordersQry = "CREATE TABLE IF NOT EXISTS `c_orders` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// orders_books table
$orders_booksQry = "CREATE TABLE IF NOT EXISTS `d_orders_books` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// Users table
$usersQry = "CREATE TABLE IF NOT EXISTS `users` (
	`username` varchar(25) NOT NULL,
	`password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// insert admins
$pwd = md5('2020');
$insUsersQry = "INSERT INTO users VALUES('maktaba','$pwd')";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (
	mysqli_query($conn, $clientsQry) and
	mysqli_query($conn, $booksQry) and
	mysqli_query($conn, $ordersQry) and
	mysqli_query($conn, $orders_booksQry) and
	mysqli_query($conn, $usersQry) and
	mysqli_query($conn, $insUsersQry)
) {
	echo "Tables Created Successfully";
} else {
	echo "ERROR! can not create tables!";
}