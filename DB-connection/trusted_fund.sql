-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.ezyro.com
-- Generation Time: Feb 26, 2024 at 04:11 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezyro_35434748_trusted_fund`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(225) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `fund_amount` int(11) NOT NULL,
  `customer_date` date NOT NULL,
  `return_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `phone_no`, `fund_amount`, `customer_date`, `return_amount`) VALUES
(7, 'upendo mganga', 683635634, 600000, '2023-10-04', 30000),
(11, 'jacklin mganga', 789032495, 700000, '2023-10-01', 100000),
(12, 'mchunguzi mganga', 716358896, 400000, '2023-10-03', 50000),
(17, 'exaud mganga', 672507875, 300000, '2023-10-04', 20000),
(23, 'mama bonge', 676890745, 1000000, '2023-10-06', 100000),
(27, 'Johnson Kimbila', 789890977, 400000, '2023-12-01', 120000),
(28, 'Mariam Ramadhani', 674507845, 50000, '2023-12-07', 15000),
(29, 'Allfred Kindundu', 682508875, 300000, '2023-11-30', 90000);

-- --------------------------------------------------------

--
-- Table structure for table `customer_amount`
--

CREATE TABLE `customer_amount` (
  `amount_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `amount_date` date DEFAULT NULL,
  `loan_amount` int(11) DEFAULT NULL,
  `added_loan` int(11) DEFAULT NULL,
  `total_interest` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_amount`
--

INSERT INTO `customer_amount` (`amount_id`, `customer_id`, `amount_date`, `loan_amount`, `added_loan`, `total_interest`, `rate`) VALUES
(3, 17, '2023-12-06', 300000, 50000, 170000, 90000);

-- --------------------------------------------------------

--
-- Table structure for table `date_cush`
--

CREATE TABLE `date_cush` (
  `dc_id` int(11) NOT NULL,
  `dc_date` date NOT NULL,
  `dc_return_amount` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `date_cush`
--

INSERT INTO `date_cush` (`dc_id`, `dc_date`, `dc_return_amount`, `customer_id`) VALUES
(1, '2023-10-07', 30000, 7),
(2, '2023-10-09', 30000, 7),
(4, '2023-10-08', 20000, 17),
(18, '2023-10-09', 20000, 17),
(21, '2023-10-12', 50000, 12),
(23, '2023-10-19', 50000, 12),
(25, '2023-10-10', 30000, 17),
(26, '2023-10-09', 50000, 11),
(27, '2023-10-10', 100000, 11),
(28, '2023-10-11', 100000, 11),
(31, '2023-10-10', 30000, 7),
(33, '2023-10-11', 20000, 17),
(34, '2023-10-12', 30000, 17),
(35, '2023-10-12', 30000, 11),
(36, '2023-10-13', 30000, 17),
(37, '2023-10-14', 20000, 17),
(45, '2023-12-06', 100000, 23);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `user_email` varchar(225) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(4, 'mama bonge', 'mamabonge700@gmail.com', '$2y$10$Jg6SgTrDTK/EczMMUo9irO9PObHjf/xI8ayaUVD1Pjjk2A51D.Dre'),
(5, 'upendo mganga', 'mgangau@gmail.com', '$2y$10$47axhCs3FGKcFuP1681ZSuBjDwxIGKcUDNOTccYErniAbwiBJguiG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_amount`
--
ALTER TABLE `customer_amount`
  ADD PRIMARY KEY (`amount_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `date_cush`
--
ALTER TABLE `date_cush`
  ADD PRIMARY KEY (`dc_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `customer_amount`
--
ALTER TABLE `customer_amount`
  MODIFY `amount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `date_cush`
--
ALTER TABLE `date_cush`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_amount`
--
ALTER TABLE `customer_amount`
  ADD CONSTRAINT `customer_amount_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `date_cush`
--
ALTER TABLE `date_cush`
  ADD CONSTRAINT `date_cush_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
