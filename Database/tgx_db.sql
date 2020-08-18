-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2020 at 05:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tgx_db`
--
CREATE DATABASE IF NOT EXISTS `tgx_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tgx_db`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `bookingID` int(11) NOT NULL AUTO_INCREMENT,
  `bookingDate` date NOT NULL,
  `noOfAdults` int(11) NOT NULL,
  `noOfKids` int(11) NOT NULL,
  `paymentMethod` varchar(100) NOT NULL,
  `credentials` varchar(255) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`bookingID`),
  KEY `booking_user` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `bookingDate`, `noOfAdults`, `noOfKids`, `paymentMethod`, `credentials`, `totalPrice`, `userID`) VALUES
(1, '2020-08-15', 1, 0, 'Credit Card', 'Zahiriddin Rustamov', '15.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cinema`
--

DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `cinemaID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  PRIMARY KEY (`cinemaID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cinema`
--

INSERT INTO `cinema` (`cinemaID`, `name`, `location`) VALUES
(1, 'TGX Wangsa Walk', '2-01, Level 2 Wangsa Walk Mall, Wangsa Avenue, 9, Jalan Wangsa Perdana 1, Bandar Wangsa Maju, 53300 Kuala Lumpur, Wilayah Persekutuan, Malaysia'),
(2, 'TGX Suria KLCC', 'Level 3, Suria KLCC, Kuala Lumpur City Centre, 50088 Kuala Lumpur, Wilayah Persekutuan, Malaysia'),
(3, 'TGX 1 Utama', 'Level 3, Old Wing, 1 Utama Shopping Centre, 1, Lebuh Bandar Utama, Bandar Utama, 47800 Petaling Jaya, Selangor, Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

DROP TABLE IF EXISTS `hall`;
CREATE TABLE IF NOT EXISTS `hall` (
  `hallID` int(11) NOT NULL AUTO_INCREMENT,
  `experience` varchar(100) NOT NULL,
  `basePrice` decimal(10,2) NOT NULL,
  `cinemaID` int(11) NOT NULL,
  PRIMARY KEY (`hallID`),
  KEY `cinemaID` (`cinemaID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`hallID`, `experience`, `basePrice`, `cinemaID`) VALUES
(1, 'Regular', '5.00', 1),
(2, 'Regular', '5.00', 1),
(3, 'LUXE', '10.00', 2),
(4, 'LUXE', '10.00', 3),
(5, 'Deluxe', '10.00', 1),
(6, 'Deluxe', '15.00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

DROP TABLE IF EXISTS `movie`;
CREATE TABLE IF NOT EXISTS `movie` (
  `movieID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `poster` varchar(150) NOT NULL,
  `length` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `genre` varchar(200) NOT NULL,
  `language` varchar(50) NOT NULL,
  `subtitle` varchar(150) NOT NULL,
  `ageRestriction` varchar(20) NOT NULL,
  `releaseDate` date NOT NULL,
  `cast` varchar(300) NOT NULL,
  `director` varchar(100) NOT NULL,
  `distributor` varchar(50) NOT NULL,
  `synopsis` text NOT NULL,
  PRIMARY KEY (`movieID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movieID`, `name`, `poster`, `length`, `status`, `genre`, `language`, `subtitle`, `ageRestriction`, `releaseDate`, `cast`, `director`, `distributor`, `synopsis`) VALUES
(1, 'Avengers: Infinity War', 'img/avengers.jpg', 120, 'Showing', 'Action,Drama', 'English', 'English,Chinese', '13', '2020-08-05', 'Thor,Captain America', 'Tony Start', 'Fox Movies', 'The Avengers must stop Thanos, an intergalactic warlord, from getting his hands on all the infinity stones. However, Thanos is prepared to go to any lengths to carry out his insane plan.'),
(4, 'Joker', 'img/joker.jpg', 122, '', 'Drama,Crime', 'English', 'English,Chinese', '18', '2020-08-22', 'Joaquin Phoenix, Robert De Niro', 'Todd Phillips', 'Warner Bros. Pictures', 'Forever alone in a crowd, failed comedian Arthur Fleck seeks connection as he walks the streets of Gotham City. Arthur wears two masks -- the one he paints for his day job as a clown, and the guise he projects in a futile attempt to feel like he\'s part of the world around him. Isolated, bullied and disregarded by society, Fleck begins a slow descent into madness as he transforms into the criminal mastermind known as the Joker.');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `promotionID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `rate` decimal(3,2) NOT NULL,
  `date` date NOT NULL,
  `photo` varchar(200) NOT NULL,
  PRIMARY KEY (`promotionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `showtime`
--

DROP TABLE IF EXISTS `showtime`;
CREATE TABLE IF NOT EXISTS `showtime` (
  `showtimeID` int(11) NOT NULL AUTO_INCREMENT,
  `showDate` date NOT NULL,
  `showTime` int(11) NOT NULL,
  `hallID` int(11) NOT NULL,
  `movieID` int(11) NOT NULL,
  PRIMARY KEY (`showtimeID`),
  KEY `hall_showtime` (`hallID`),
  KEY `movie_showtime` (`movieID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `showtime`
--

INSERT INTO `showtime` (`showtimeID`, `showDate`, `showTime`, `hallID`, `movieID`) VALUES
(1, '2020-08-20', 720, 1, 1),
(2, '2020-08-20', 750, 3, 1),
(4, '2020-08-22', 780, 5, 1),
(5, '2020-08-20', 840, 2, 1),
(6, '2020-08-24', 840, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ticketID` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) NOT NULL,
  `seat` varchar(50) NOT NULL,
  `type` varchar(100) NOT NULL,
  `showtimeID` int(11) NOT NULL,
  `bookingID` int(11) NOT NULL,
  PRIMARY KEY (`ticketID`),
  KEY `ticket_showtime` (`showtimeID`),
  KEY `ticket_booking` (`bookingID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketID`, `price`, `seat`, `type`, `showtimeID`, `bookingID`) VALUES
(4, '12.00', 'A1', 'Regular', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `address` varchar(250) NOT NULL,
  `state` varchar(100) NOT NULL,
  `creationDate` date NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastLoginDate` date NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `name`, `email`, `number`, `dob`, `gender`, `photo`, `address`, `state`, `creationDate`, `username`, `password`, `lastLoginDate`) VALUES
(1, 'Zahir Sher', 'zakisher@gmail.com', '010-8003610', '2000-01-24', 'Male', '', 'Idaman Putera Condo', 'KL', '2020-08-15', 'zahir', '123', '2020-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `useraccountreset`
--

DROP TABLE IF EXISTS `useraccountreset`;
CREATE TABLE IF NOT EXISTS `useraccountreset` (
  `resetDate` date NOT NULL,
  `resetExpiryDate` date NOT NULL,
  `resetUsed` tinyint(1) NOT NULL,
  `resetToken` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  KEY `useracc_user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `hall`
--
ALTER TABLE `hall`
  ADD CONSTRAINT `hall_ibfk_1` FOREIGN KEY (`cinemaID`) REFERENCES `cinema` (`cinemaID`);

--
-- Constraints for table `showtime`
--
ALTER TABLE `showtime`
  ADD CONSTRAINT `hall_showtime` FOREIGN KEY (`hallID`) REFERENCES `hall` (`hallID`),
  ADD CONSTRAINT `movie_showtime` FOREIGN KEY (`movieID`) REFERENCES `movie` (`movieID`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_booking` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`bookingID`),
  ADD CONSTRAINT `ticket_showtime` FOREIGN KEY (`showtimeID`) REFERENCES `showtime` (`showtimeID`);

--
-- Constraints for table `useraccountreset`
--
ALTER TABLE `useraccountreset`
  ADD CONSTRAINT `useracc_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
