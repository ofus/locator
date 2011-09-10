SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE `location` (
  `id` varchar(8) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `street_1` varchar(32) DEFAULT NULL,
  `street_2` varchar(32) DEFAULT NULL,
  `street_3` varchar(32) DEFAULT NULL,
  `street_4` varchar(15) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(9) DEFAULT NULL,
  `phone` varchar(22) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `zip_codes` (
  `zip` varchar(5) NOT NULL DEFAULT '',
  `state` char(2) NOT NULL DEFAULT '',
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `full_state` varchar(50) DEFAULT NULL,
  UNIQUE KEY `zip` (`zip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
