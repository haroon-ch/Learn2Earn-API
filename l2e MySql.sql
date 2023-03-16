-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2022 at 12:55 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `l2e`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `a_id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `description` int(255) NOT NULL,
  `credit` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `debit` varchar(255) NOT NULL,
  `netbalance` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`a_id`, `c_id`, `type`, `source`, `description`, `credit`, `debit`, `netbalance`, `date`, `other`) VALUES
(31, 1, 'rent', 'bank account', 4000, '2022-10-30', '', '', '', ''),
(32, 2, 'rent', 'easypasa', 3000, '2022-10-20', '', '', '', ''),
(33, 2, 'rent', 'jazzcash', 3000, '2022-10-30', '', '', '', ''),
(34, 2, 'rent', 'jazzcash', 5000, '2022-10-30', '', '', '', ''),
(35, 1, 'rent', 'jazzcash', 5000, '2022-11-01', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `a_student`
--

CREATE TABLE `a_student` (
  `id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `st_gender` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `cnic` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `c_duration` varchar(255) NOT NULL,
  `a_month` varchar(255) NOT NULL,
  `ad_date` date NOT NULL DEFAULT current_timestamp(),
  `total_fee` int(255) NOT NULL,
  `installment_no` int(255) NOT NULL,
  `first_installment_no` int(255) NOT NULL,
  `advance` int(255) NOT NULL,
  `remaning_amount` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `st_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_student`
--

INSERT INTO `a_student` (`id`, `c_id`, `name`, `f_name`, `st_gender`, `contact_no`, `address`, `reference`, `cnic`, `course`, `c_duration`, `a_month`, `ad_date`, `total_fee`, `installment_no`, `first_installment_no`, `advance`, `remaning_amount`, `status`, `st_status`) VALUES
(123, 1, 'sumama ', 'hanif', 'Male', '317193092', 'pakppatan', 'localhoast', '28399832', 'Full Stack Development', '2', '0', '2022-11-04', 2000, 0, 0, 1000, 0, 'pending', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `c_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`c_id`, `name`) VALUES
(1, 'pakpattan'),
(2, 'arifwala');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `e_id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `from_account` varchar(255) NOT NULL,
  `e_amount` int(255) NOT NULL,
  `to_account` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `other` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `i_id` int(255) NOT NULL,
  `id` int(255) NOT NULL,
  `a_id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `i_amount` int(255) NOT NULL,
  `remaning_payment` int(255) NOT NULL,
  `date` date NOT NULL,
  `installmentNo` int(255) NOT NULL,
  `month` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `installments`
--

INSERT INTO `installments` (`i_id`, `id`, `a_id`, `c_id`, `i_amount`, `remaning_payment`, `date`, `installmentNo`, `month`) VALUES
(172, 154, 0, 1, 1000, 3000, '2022-11-08', 1, 'may');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `u_id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`u_id`, `c_id`, `username`, `password`, `role`, `other`) VALUES
(1, 1, 'l2e', '12', 'admin', ''),
(2, 2, 'athar', '120', 'employ', ''),
(3, 3, 'shahzaib', '130', 'ceo', '');

-- --------------------------------------------------------

--
-- Table structure for table `main_account`
--

CREATE TABLE `main_account` (
  `a_id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `netbalance` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_account`
--

INSERT INTO `main_account` (`a_id`, `c_id`, `name`, `netbalance`) VALUES
(1, 1, 'Learn2Earn Pakpattan', 26300),
(2, 2, 'Learn2Earn Arifwala', 4000),
(5, 1, 'Shahzaib Malik', 25000),
(6, 1, 'Bilal Raza', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `t_id` int(255) NOT NULL,
  `a_id` int(255) NOT NULL,
  `c_id` int(255) NOT NULL,
  `from` int(255) NOT NULL,
  `to` int(255) NOT NULL,
  `debit` int(255) NOT NULL,
  `credit` int(255) NOT NULL,
  `netbalance` int(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `t_date` date NOT NULL,
  `other` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`t_id`, `a_id`, `c_id`, `from`, `to`, `debit`, `credit`, `netbalance`, `type`, `description`, `t_date`, `other`) VALUES
(46, 1, 1, 1, 1, 0, 1000, 25300, 'addmission', 'student addmission', '2022-11-08', 0),
(47, 1, 1, 1, 1, 0, 1000, 26300, 'Addmission', 'Student Addmission', '2022-11-08', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `a_student`
--
ALTER TABLE `a_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `main_account`
--
ALTER TABLE `main_account`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `a_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `a_student`
--
ALTER TABLE `a_student`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `c_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `e_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `i_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `u_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `main_account`
--
ALTER TABLE `main_account`
  MODIFY `a_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `t_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
