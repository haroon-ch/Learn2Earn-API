-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 15, 2020 at 10:15 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id12883790_serviceprovider`
--

-- --------------------------------------------------------

--
-- Table structure for table `place_order`
--

CREATE TABLE `place_order` (
  `o_id` varchar(255) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `s_id` varchar(255) NOT NULL,
  `ss_id` varchar(255) NOT NULL,
  `w_id` varchar(255) NOT NULL,
  `worker_mobile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `place_order`
--

INSERT INTO `place_order` (`o_id`, `user_id`, `s_id`, `ss_id`, `w_id`, `worker_mobile`, `address`, `city`, `date`, `status`) VALUES
('331134ju2020-03-14', '33', '1', '1', '34', '2147483647', 'pakpattan', 'ju', '2020-03-14', 'pending'),
('331134ju2020-03-17', '33', '1', '1', '34', '2147483647', 'pakpattan', 'ju', '2020-03-17', 'pending'),
('331134juahhli', '33', '1', '1', '34', '2147483647', 'pakpattan', 'ju', 'ahhli', 'confrm'),
('331134juali', '33', '1', '1', '34', '2147483647', 'pakpattan', 'ju', 'ali', 'confrm'),
('331135juali', '33', '1', '1', '35', '2147483647', 'pakpattan', 'ju', 'ali', 'pending'),
('331236juali', '33', '1', '2', '36', '2147483647', 'pakpattan', 'ju', 'ali', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `userid` int(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`userid`, `name`, `address`, `city`, `category`, `mobile`, `profile_image`) VALUES
(12, 'shahzaib', 'pakpattan', 'pakpattan', 'worker', '2223', 'images/12.jpg'),
(13, 'shahzaib', 'pakpattan', 'pakpattan', 'worker', '123', 'images/13.jpg'),
(14, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'shan', NULL, NULL, 'couste', '123', NULL),
(23, 'ahmad', NULL, NULL, 'customer', '123', NULL),
(33, 'ali', 'Sfgvgh', 'Aadf', 'customer', '2147483647', 'images/33_200312_1584001348.8557.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `s_id` int(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `service_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`s_id`, `s_name`, `service_image`) VALUES
(1, 'House Hold', 'images/home.svg'),
(2, 'Cars', 'images/car.svg'),
(5, 'Electronics', 'images/electronics.svg');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`id`, `name`, `email`, `password`, `category`, `mobile`) VALUES
(32, 'ss', 's@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'worker', '2147483647'),
(33, 'ali', 'a@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'customer', '2147483647'),
(34, 'shahzaib', 'shah@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'worker', '2147483647'),
(35, 'ali', 'ali@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'worker', '2147483647'),
(36, 'umair', 'umair@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'worker', '2147483647'),
(37, 'asif', 'asif@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'worker', '2147483647'),
(38, 'Shehryar ', 'a@aa.com', 'c4ca4238a0b923820dcc509a6f75849b', 'worker', '12345'),
(39, 'Muhammad afzal', 'afa', '123', 'cutomer', '300'),
(40, 'muhammmad afzal', 'aaa1@gmail.com', 'e769119fcdab182494f03f947e89a26b', 'worker', '03066972739');

-- --------------------------------------------------------

--
-- Table structure for table `sub-services`
--

CREATE TABLE `sub-services` (
  `ss_id` int(255) NOT NULL,
  `s_id` int(255) NOT NULL,
  `ss_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sub_services`
--

CREATE TABLE `sub_services` (
  `ss_id` int(255) NOT NULL,
  `s_id` int(255) NOT NULL,
  `ss_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_services`
--

INSERT INTO `sub_services` (`ss_id`, `s_id`, `ss_name`) VALUES
(1, 1, 'plumber'),
(2, 1, 'mistri'),
(3, 1, 'Labour');

-- --------------------------------------------------------

--
-- Table structure for table `worker_profile`
--

CREATE TABLE `worker_profile` (
  `w_id` int(255) NOT NULL,
  `w_name` varchar(255) NOT NULL,
  `w_address` varchar(255) NOT NULL,
  `w_category` varchar(255) NOT NULL,
  `w_mobile` varchar(255) NOT NULL,
  `w_services` int(255) NOT NULL,
  `profile-image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `worker_profile`
--

INSERT INTO `worker_profile` (`w_id`, `w_name`, `w_address`, `w_category`, `w_mobile`, `w_services`, `profile-image`) VALUES
(31, 'ss', '', 'worker', '2147483647', 0, ''),
(32, 'ss', '', 'worker', '2147483647', 0, ''),
(34, 'shahzaib', 'pakpattan', 'worker', '2147483647', 11, ''),
(35, 'ali', 'pakpattan', 'worker', '2147483647', 11, ''),
(36, 'umair', 'pakpattan', 'worker', '2147483647', 12, ''),
(37, 'asif', 'pakpattan', 'worker', '2147483647', 21, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `place_order`
--
ALTER TABLE `place_order`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub-services`
--
ALTER TABLE `sub-services`
  ADD PRIMARY KEY (`ss_id`);

--
-- Indexes for table `sub_services`
--
ALTER TABLE `sub_services`
  ADD PRIMARY KEY (`ss_id`);

--
-- Indexes for table `worker_profile`
--
ALTER TABLE `worker_profile`
  ADD PRIMARY KEY (`w_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `s_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sub-services`
--
ALTER TABLE `sub-services`
  MODIFY `ss_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_services`
--
ALTER TABLE `sub_services`
  MODIFY `ss_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `worker_profile`
--
ALTER TABLE `worker_profile`
  MODIFY `w_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
