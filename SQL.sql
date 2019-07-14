-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2019 at 12:13 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsw`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) NOT NULL,
  `organisation_id` bigint(20) DEFAULT NULL COMMENT 'ompanies is like branches',
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `office_email` varchar(255) NOT NULL,
  `office_phone` varchar(255) DEFAULT NULL,
  `approval_status` enum('approved','declined','verifying') DEFAULT NULL,
  `documents` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `company_description` text,
  `pefcom_id` varchar(255) DEFAULT NULL COMMENT 'pension administrato number',
  `rc_number` varchar(255) DEFAULT NULL COMMENT 'cac rc number',
  `bn_number` varchar(255) DEFAULT NULL COMMENT 'cac bn number',
  `logo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `organisation_id`, `user_id`, `name`, `address`, `office_email`, `office_phone`, `approval_status`, `documents`, `created_at`, `updated_at`, `company_description`, `pefcom_id`, `rc_number`, `bn_number`, `logo`) VALUES
(5, NULL, 1, 'Machinery Ltd', '', '', '', 'verifying', '{\"1\":{\"files\":\"uploads\\/companies\\/documents\\/Screenshot-8.png\",\"label\":\"ten\"}}', '2019-07-12 23:29:32', '2019-07-14 09:52:10', NULL, '', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
