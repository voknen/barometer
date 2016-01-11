-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2016 at 03:32 PM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `financial_barometer`
--

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE IF NOT EXISTS `earnings` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_earning` date NOT NULL,
  `type` enum('salary','scholarship','inheritance','other') NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `user_id`, `date_of_earning`, `type`, `value`) VALUES
(1, 5, '2015-12-27', 'salary', 1234),
(3, 5, '2015-12-28', 'scholarship', 60),
(4, 5, '2015-12-28', 'inheritance', 1059),
(7, 5, '2015-12-28', 'salary', 2000),
(8, 5, '2015-12-28', 'inheritance', 1059),
(9, 5, '2016-01-03', 'scholarship', 230),
(10, 5, '2016-01-05', 'scholarship', 200);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_expense` date NOT NULL,
  `type` enum('food','fuel','entertainment','education','other') NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `date_of_expense`, `type`, `value`) VALUES
(1, 5, '2015-12-27', 'fuel', 900),
(3, 5, '2015-12-28', 'food', 3123),
(4, 5, '2015-12-28', 'education', 900),
(5, 5, '2016-01-01', 'food', 1000),
(6, 5, '2016-01-03', 'education', 200),
(7, 5, '2016-01-03', 'entertainment', 500),
(8, 5, '2016-01-03', 'other', 200);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `age`, `username`, `password`) VALUES
(2, 'dasa', 'dasa', 11, 'Ivan1', '$2y$10$E2Bb.xi5rpwIlv9Mvo2ArOAlaOk7eLbWFzLaHCsHR33Bf1o4gG25O'),
(5, 'гошо', 'гошо', 20, 'gosho2', '$2y$10$0RzW8iaAZ4cDktjz20GA1.otDnQlKy2zxFjl5.kPY/pxIYxbuCMvC'),
(6, 'Моника', 'Спасова', 21, 'Monika', '$2y$10$NvFNXBC.IBmcu6sMuJcNZ.ajKk1eiOYzy8MyCzDGOQgd7w8UTvh1O'),
(7, 'dadads', 'dasd', 31, 'Ivan', '$2y$10$PYhJcQSaTpDR1QcCHhntAeC4Gmo5OAtgxbrFaHzOL8KgAG85uvA2C'),
(8, 'Катя', 'Иванова', 35, 'katia_35', '$2y$10$lMxTg.gTNwf4P/31bxsR7.yTRR/ROmJMf6x1lKjvp2Zgs7JjaZc1e'),
(9, 'Катя', 'Иванова', 35, 'katia_34', '$2y$10$pPZSG68oTfskj5o.j9kVhuu1eXgc2S6dktH3IiqstjlSxVrj0dby6'),
(10, 'dadads', 'dasa', 15, 'pesho8', '$2y$10$2HPcXFtYtYaebgMRMgvGbediEW7RrE7dcOkLa1IVbIoYpsEqmLDiy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
