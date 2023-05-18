DROP TABLE IF EXISTS `client_events`;
DROP TABLE IF EXISTS `employees`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `clients`;
DROP TABLE IF EXISTS `operations_log`;

-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2021 at 03:02 PM
-- Server version: 5.7.36
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f1278278_assignment4_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--


CREATE TABLE `clients` (
  `client_id` int(10) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `business_number` varchar(10) NOT NULL,
  `client_first_name` varchar(20) NOT NULL,
  `client_last_name` varchar(30) NOT NULL,
  `client_phone_number` varchar(11) NOT NULL,
  `client_cell_number` varchar(11) NOT NULL,
  `carrier` varchar(20) NOT NULL,
  `hst_number` varchar(20) NOT NULL,
  `website` varchar(100) NOT NULL,
  `client_status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `company_name`, `business_number`, `client_first_name`, `client_last_name`, `client_phone_number`, `client_cell_number`, `carrier`, `hst_number`, `website`, `client_status`) VALUES
(1, 'apple', '12345', 'tim', 'cook', '18006424496', '82247757463', 'verizon', '123456789 RT 001', 'www.apple.com', 'Active'),
(2, 'amazon', '4321', 'jeff', 'bezos', '18003543564', '32534563454', 'at&t', '3534535435 RT 001', 'www.amazon.com', 'Active'),
(3, 'tesla', '9999', 'elon', 'musk', '18005436789', '5439871234', 'virgin', '1234567TRE', 'www.tesla.com', 'Active'),
(4, 'google', '1111', 'larry', 'page', '1888008800', '2585-google', 'rogers', '159357GOG', 'www.google.com', 'Active'),
(5, 'facebook', '666', 'mark', 'zuckerberg', '18006669990', '15935746824', 't-mobile', '666 9991 FBE', 'www.facebook.com', 'Active'),
(6, 'samsung', '00002', 'lee', 'byung-chul', '19381987234', '1966196800', 'telus', '1084005 SSE', 'www.samsung.com', 'Active'),
(7, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `client_events`
--

CREATE TABLE `client_events` (
  `event_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `notification_id` int(10) NOT NULL,
  `event_time_date` datetime(6) NOT NULL,
  `event_frequency` int(4) NOT NULL,
  `event_status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_events`
--

INSERT INTO `client_events` (`event_id`, `client_id`, `notification_id`, `event_time_date`, `event_frequency`, `event_status`) VALUES
(1, 2, 1, '2021-12-09 13:12:12.000000', 30, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(10) NOT NULL,
  `employee_first_name` varchar(255) NOT NULL,
  `employee_last_name` varchar(255) NOT NULL,
  `employee_email` varchar(255) NOT NULL,
  `employee_cell_number` varchar(12) NOT NULL,
  `employee_position` varchar(20) NOT NULL,
  `employee_password` varchar(40) NOT NULL,
  `employee_status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `employee_first_name`, `employee_last_name`, `employee_email`, `employee_cell_number`, `employee_position`, `employee_password`, `employee_status`) VALUES
(1, 'admin', 'admin', 'admin', '4166789018', 'sysadmin', '123456', 'Active');

INSERT INTO `employees` (`employee_id`, `employee_first_name`, `employee_last_name`, `employee_email`, `employee_cell_number`, `employee_position`, `employee_password`, `employee_status`) VALUES
(2, 'Phuong', 'Hoang', 'diemphuong1291@gmail.com', '4166789018', 'PM', '$2y$10$vVi/pxoZByyJhyjmEHJjo.84SW0mZy1.Pisinq4uvN6h83CaboSiW
', 'Active');


-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(10) NOT NULL,
  `notification_name` varchar(20) NOT NULL,
  `notification_type` varchar(20) NOT NULL,
  `notification_description` varchar(255) NULL,
  `notification_status` varchar(10) NOT NULL DEFAULT 'Disabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--
INSERT INTO `notifications` (`notification_id`, `notification_name`, `notification_type`, `notification_description`, `notification_status`) VALUES
(1, 'test', 'Email', 'test', 'Disabled');

-- --------------------------------------------------------

--
-- Table structure for table `operations_log`
--

CREATE TABLE `operations_log` (
  `employee_id` int(10) NOT NULL,
  `module_name` varchar(10) NOT NULL,
  `action` varchar(10) NOT NULL,
  `date_time` datetime(6) NOT NULL,
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
-- Indexes for table `client_events`
--
ALTER TABLE `client_events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `notification_id` (`notification_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

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
  MODIFY `client_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client_events`
--
ALTER TABLE `client_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_events`
--
ALTER TABLE `client_events`
  ADD CONSTRAINT `client_events_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`),
  ADD CONSTRAINT `client_events_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--phuong updates 
ALTER TABLE `operations_log` CHANGE `date_time` `date_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `operations_log` CHANGE `action` `action` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `operations_log` CHANGE `module_name` `module_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `employees` CHANGE `employee_password` `employee_password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;