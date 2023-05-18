-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2021 at 04:44 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment4_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `business_number` varchar(10) NOT NULL,
  `client_first_name` varchar(20) NOT NULL,
  `client_last_name` varchar(30) NOT NULL,
  `client_phone_number` varchar(11) NOT NULL,
  `client_cell_number` varchar(11) NOT NULL,
  `carrier` varchar(20) NOT NULL,
  `hst_number` varchar(20) NOT NULL,
  `website` varchar(100) NOT NULL,
  `client_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `company_name`, `business_number`, `client_first_name`, `client_last_name`, `client_phone_number`, `client_cell_number`, `carrier`, `hst_number`, `website`, `client_status`) VALUES
(1, 'apple', '1234', 'tim', 'cook', '18006424496', '82247757463', 'verizon', '123456789 RT 001', 'www.apple.com', 'Active'),
(2, 'amazon', '4321', 'jeff', 'bezos', '18003543564', '32534563454', 'at&t', '3534535435 RT 001', 'www.amazon.com', 'Active'),
(3, 'tesla', '9999', 'elon', 'musk', '18005436789', '5439871234', 'virgin', '1234567TRE', 'www.tesla.com', 'Active'),
(4, 'google', '1111', 'larry', 'page', '18880088', '2585-google', 'rogers', '159357GOG', 'www.google.com', 'Active'),
(5, 'facebook', '666', 'mark', 'zuckerberg', '180066699', '15935746824', 't-mobile', '666 9991 FBE', 'www.facebook.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `employee_first_name` varchar(20) NOT NULL,
  `employee_last_name` varchar(30) NOT NULL,
  `employee_email` varchar(50) NOT NULL,
  `employee_cell_number` varchar(12) NOT NULL,
  `employee_position` varchar(20) NOT NULL,
  `employee_password` varchar(40) NOT NULL,
  `employee_status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_first_name`, `employee_last_name`, `employee_email`, `employee_cell_number`, `employee_position`, `employee_password`, `employee_status`) VALUES
(1, 'Gustavo', 'Mendes', 'gustavo.mendespinto@georgebrown.ca', '4166789018', 'CEO', '123456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `event_time_date` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `event_frequency` int(11) NOT NULL,
  `event_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `client_id`, `notification_id`, `event_time_date`, `event_frequency`, `event_status`) VALUES
(1, 1, 1, 'current_timestamp()', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_name` varchar(20) NOT NULL,
  `notification_type` int(11) NOT NULL,
  `notification_description` varchar(100) NOT NULL,
  `notification_status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_name`, `notification_type`, `notification_description`, `notification_status`) VALUES
(1, 'test', 1, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operations_log`
--

CREATE TABLE `operations_log` (
  `employee_id` int(11) NOT NULL,
  `module_name` varchar(10) NOT NULL,
  `action` varchar(10) NOT NULL,
  `date_time` varchar(20) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `notification_id` (`notification_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
