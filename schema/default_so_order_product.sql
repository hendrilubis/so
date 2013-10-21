-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2013 at 04:55 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tryoutstan`
--

-- --------------------------------------------------------

--
-- Table structure for table `default_so_order_product`
--

CREATE TABLE IF NOT EXISTS `default_so_order_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `row_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `current_price` int(11) DEFAULT '0',
  `qty` int(20) NOT NULL DEFAULT '1',
  `sub_total` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `default_so_order_product`
--

INSERT INTO `default_so_order_product` (`id`, `row_id`, `order_id`, `product_id`, `current_price`, `qty`, `sub_total`) VALUES
(3, 2, 8, 2, 0, 0, 0),
(9, 1, 8, 1, 0, 0, 0),
(10, 1, 8, 2, 0, 0, 0),
(17, 4, 8, 2, 0, 0, 0),
(18, 3, 8, 3, 0, 0, 0),
(27, 6, 8, 3, 0, 1, 0),
(28, 6, 8, 7, 0, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
