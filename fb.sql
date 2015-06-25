-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2015 at 12:56 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `fb_firends_insert`(IN `user_first_name` VARCHAR(32), IN `fb_user_id` VARCHAR(100))
    MODIFIES SQL DATA
BEGIN
    INSERT INTO tbl_friends (user_first_name, fb_user_id) VALUES (user_first_name, fb_user_id);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friends`
--

CREATE TABLE IF NOT EXISTS `fb_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(32) DEFAULT NULL,
  `fb_user_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
