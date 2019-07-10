-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2019 at 09:57 PM
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
-- Database: `mle`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `username`, `firstname`, `lastname`, `email`, `phone`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 'Super', 'admin@admin.com', '08123353738', '$2y$10$OepumDQQsOJw/kZBnXAf7.48lf5sP9IibKoMdubhuxTle8XNQ5HWS', '2018-02-22 23:00:00', '2019-03-26 22:51:35'),
(2, NULL, 'Jigloa', 'James ', 'tee02bn@gmail.com', '08123351819', '$2y$10$Tt8Xj8ZAqk7sMAu1cbqWtOZS6rgL8wG.w.OOiU74hRmpTZdCaSLQ6', '2018-02-28 10:26:56', '2018-03-16 16:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast`
--

CREATE TABLE `broadcast` (
  `id` bigint(20) NOT NULL,
  `broadcast_message` varchar(255) NOT NULL,
  `admin_id` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1=published, 0=paused',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `note`, `created_at`, `updated_at`) VALUES
(3, 'Partys', '', NULL, '2019-02-16 10:13:21'),
(5, 'Training', '', NULL, '2017-07-05 01:03:10'),
(6, 'Kinos', '', '2019-02-16 07:48:47', '2019-02-16 07:48:47'),
(7, 'men', '', '2019-02-16 07:49:42', '2019-02-16 07:49:42');

-- --------------------------------------------------------

--
-- Table structure for table `customers_support`
--

CREATE TABLE `customers_support` (
  `id` bigint(20) NOT NULL,
  `ticket_id` bigint(20) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ebooks`
--

CREATE TABLE `ebooks` (
  `id` bigint(20) NOT NULL,
  `subscription_access` varchar(255) DEFAULT NULL COMMENT 'free = it is free',
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `cover_image` longtext,
  `file_path` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ebooks`
--

INSERT INTO `ebooks` (`id`, `subscription_access`, `title`, `description`, `cover_image`, `file_path`, `created_at`, `updated_at`) VALUES
(1, '', 'Books feature added', 'juyy', NULL, 'uploads/ebooks/Dove-Investment-Whitepaper-v2.1.pdf', '2019-04-01 00:00:00', '2019-04-18 10:11:30'),
(2, '', 'Human Nature Revisedrev', 'revised Ge to know the human nature and get all you need', NULL, 'uploads/ebooks/Screenshot-3.png', '2019-04-01 00:00:00', '2019-04-18 10:27:26'),
(3, '1', 'Books feature added', 'Just a little description', 'uploads/ebooks/cover_images/Screenshot-1.png', 'uploads/ebooks/Credentials.docx', '2019-04-18 01:45:46', '2019-04-18 10:01:22'),
(4, NULL, NULL, NULL, NULL, NULL, '2019-04-18 01:46:52', '2019-04-18 01:46:52'),
(5, '', 'sql file added', '', NULL, NULL, '2019-04-18 01:46:58', '2019-04-18 01:47:05'),
(6, NULL, NULL, NULL, NULL, NULL, '2019-04-18 10:25:46', '2019-04-18 10:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `level_income_report`
--

CREATE TABLE `level_income_report` (
  `id` bigint(20) NOT NULL,
  `owner_user_id` bigint(20) NOT NULL,
  `downline_id` bigint(20) DEFAULT NULL,
  `amount_earned` float NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `availability` int(11) DEFAULT NULL COMMENT '1= available, 0=not available',
  `commission_type` varchar(255) DEFAULT NULL,
  `extra_detail` text,
  `proof` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level_income_report`
--

INSERT INTO `level_income_report` (`id`, `owner_user_id`, `downline_id`, `amount_earned`, `status`, `availability`, `commission_type`, `extra_detail`, `proof`, `created_at`, `updated_at`) VALUES
(30, 1, 15, 11300, 'Credit', NULL, 'Referral Bonus', NULL, NULL, '2019-04-03 04:52:48', '2019-03-14 05:52:48'),
(37, 1, 17, 900, 'Credit', NULL, 'Referral Bonus', NULL, NULL, '2019-04-10 14:45:45', '2019-03-26 15:45:45'),
(38, 1, 1, 100, 'Debit', NULL, 'Withdrawal Request', NULL, NULL, '2019-04-11 22:13:15', '2019-04-11 22:13:15'),
(62, 16, 1, 10, 'Credit', NULL, 'April Commission', NULL, NULL, '2019-04-14 16:36:09', '2019-04-14 16:36:09'),
(64, 1, NULL, 500, 'Debit', NULL, 'Withdrawal Paid', 'For May, 2019 Subscription', NULL, '2019-04-15 23:49:20', '2019-04-15 23:49:20'),
(65, 1, NULL, 11600, 'Debit', NULL, 'Withdrawal Request', 'April, 2019 Payout', NULL, '2019-04-16 00:15:33', '2019-04-16 00:15:33'),
(66, 16, NULL, 10, 'Debit', NULL, 'Withdrawal Request', 'April, 2019 Payout', NULL, '2019-04-16 00:15:33', '2019-04-16 00:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `url` text,
  `message` text,
  `short_message` text,
  `seen_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `type` enum('system_generated','admin_generated') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `heading`, `url`, `message`, `short_message`, `seen_at`, `created_at`, `updated_at`, `admin_id`, `type`) VALUES
(7, 1, '3 Rupees Scheme Upgrade', 'user/scheme', '1', 'Click here to See Details of current Scheme.', '2019-05-29 20:56:43', '2019-05-29 20:56:05', '2019-05-29 20:56:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `amount_payable` float DEFAULT NULL,
  `percent_off` float DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_response` longtext,
  `billing_firstname` varchar(255) DEFAULT NULL,
  `billing_lastname` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(255) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_company` varchar(255) DEFAULT NULL,
  `billing_street_address` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_apartment` varchar(255) DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `additional_note` mediumtext,
  `buyer_order` longtext,
  `user_id` bigint(20) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'whether order is shipped, payed, pending, cancelled etc',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `shipping_firstname` varchar(255) DEFAULT NULL,
  `shipping_lastname` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `shipping_company` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_street_address` varchar(255) DEFAULT NULL,
  `shipping_apartment` varchar(255) DEFAULT NULL,
  `shipping_fee` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `amount_payable`, `percent_off`, `paid_at`, `razorpay_order_id`, `razorpay_response`, `billing_firstname`, `billing_lastname`, `billing_phone`, `billing_email`, `billing_country`, `billing_company`, `billing_street_address`, `billing_city`, `billing_state`, `billing_apartment`, `buyer_name`, `email`, `phone`, `address`, `additional_note`, `buyer_order`, `user_id`, `status`, `created_at`, `updated_at`, `shipping_firstname`, `shipping_lastname`, `shipping_email`, `shipping_phone`, `shipping_company`, `shipping_country`, `shipping_city`, `shipping_state`, `shipping_street_address`, `shipping_apartment`, `shipping_fee`) VALUES
(18, 465, 7, NULL, 'order_CVbXdlCa8NzS09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:29:35', '2019-05-15 01:29:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 465, 7, NULL, 'order_CVbYvMgrXNF7tW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:30:51', '2019-05-15 01:30:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 465, 7, NULL, 'order_CVbZZZFEIgHueV', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:31:27', '2019-05-15 01:31:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 465, 7, NULL, 'order_CVbhjw59Y0IQhX', '{\"razorpay_payment_id\":\"pay_CVbhrtORycFwaz\",\"razorpay_order_id\":\"order_CVbhjw59Y0IQhX\",\"razorpay_signature\":\"a3f14cf3a306c92bd3d8008180614ee7de727504e4d4d7320a07c759706cb0e7\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:39:12', '2019-05-15 01:39:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 465, 7, NULL, 'order_CVbo7ooOTotCVD', '{\"razorpay_payment_id\":\"pay_CVboRYcz64jill\",\"razorpay_order_id\":\"order_CVbo7ooOTotCVD\",\"razorpay_signature\":\"e8ee054fbcdb6e45ee0c8ee8e8be4eab8dcd584ae86859800a425c4317e32d36\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:45:15', '2019-05-15 01:45:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 465, 7, NULL, 'order_CVbpExILWb9hTt', '{\"razorpay_payment_id\":\"pay_CVbpLFES6h1DEh\",\"razorpay_order_id\":\"order_CVbpExILWb9hTt\",\"razorpay_signature\":\"baaca59e56eac8080e5bb0c36a6f2f40c668c026d94caa5f49470fa181613be7\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:46:19', '2019-05-15 01:46:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 465, 7, NULL, 'order_CVbpsHlLvNCKrg', '{\"razorpay_payment_id\":\"pay_CVbq7OBTG0zRJd\",\"razorpay_order_id\":\"order_CVbpsHlLvNCKrg\",\"razorpay_signature\":\"0c0334c2c143af732074737b59b248f440c910d9d6c7cc6bce1f0cf8f10e6e70\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:46:55', '2019-05-15 01:47:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 465, 7, NULL, 'order_CVbqs3LUNYZo5B', '{\"razorpay_payment_id\":\"pay_CVbqxlspXvtTt6\",\"razorpay_order_id\":\"order_CVbqs3LUNYZo5B\",\"razorpay_signature\":\"83cd347b7ff7a44ac5ac8bea891cd0f1991c6dd6dfd0297e640f5a039e7fc532\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:47:51', '2019-05-15 01:48:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 465, 7, NULL, 'order_CVbtiKFJ6B4r2p', '{\"razorpay_payment_id\":\"pay_CVbtoQjIfG3aIz\",\"razorpay_order_id\":\"order_CVbtiKFJ6B4r2p\",\"razorpay_signature\":\"d1215cb2409991e8e916212816c243120ae28db5a99889d5c05c6095f80815bb\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:50:32', '2019-05-15 01:50:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 465, 7, NULL, 'order_CVbuJsiVRmbX9v', '{\"razorpay_payment_id\":\"pay_CVbuR22Qkbj8fW\",\"razorpay_order_id\":\"order_CVbuJsiVRmbX9v\",\"razorpay_signature\":\"ffb4f232cec3d7a414a5c1bc6616337a03dd561878571d8c4a7e3688d6e2528e\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:51:06', '2019-05-15 01:51:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 465, 7, NULL, 'order_CVbwfAiWmnBsaH', '{\"razorpay_payment_id\":\"pay_CVbwpbvtG9JBC9\",\"razorpay_order_id\":\"order_CVbwfAiWmnBsaH\",\"razorpay_signature\":\"15cee49b5573fd09a42d48c636484764aa7a6ca97f154c7f428abcb9a156fa94\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:53:20', '2019-05-15 01:53:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 465, 7, NULL, 'order_CVc0sgBlqW8tW4', '{\"razorpay_payment_id\":\"pay_CVc10AFvQQCZiY\",\"razorpay_order_id\":\"order_CVc0sgBlqW8tW4\",\"razorpay_signature\":\"d06b8902a6bcd79cd948ca4bbae187f23a969375b99fc5e283acec75d6766012\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugia...\",\"qty\":1}]', 1, 'pending', '2019-05-15 01:57:19', '2019-05-15 01:57:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 465, 7, NULL, 'order_CVc4cufpSkhcnp', '{\"razorpay_payment_id\":\"pay_CVc4j0e3zIZ7FQ\",\"razorpay_order_id\":\"order_CVc4cufpSkhcnp\",\"razorpay_signature\":\"a2bbc741cc7795cd40db0f1eab7ac08b1a3f7bc3252c535f9961a8ab9eee7393\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n...\",\"qty\":1}]', 1, 'pending', '2019-05-15 02:00:52', '2019-05-15 02:01:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 465, 7, NULL, 'order_CVc67qlTKNzkaZ', '{\"razorpay_payment_id\":\"pay_CVc6HQl5akvRkS\",\"razorpay_order_id\":\"order_CVc67qlTKNzkaZ\",\"razorpay_signature\":\"4e3c8c81d45d491daae8b1647c8e292c54939b47ac54575a6d53dbc394be0460\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arc...\",\"qty\":1}]', 1, 'pending', '2019-05-15 02:02:17', '2019-05-15 02:02:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 465, 7, '2019-05-15 02:04:11', 'order_CVc7tfrIFpmAnC', '{\"razorpay_payment_id\":\"pay_CVc81wLsIPyTOb\",\"razorpay_order_id\":\"order_CVc7tfrIFpmAnC\",\"razorpay_signature\":\"7b70ff8f7412b645c8cf8502350caa14bb53e6c1c41fb3e43d0ac9a0683048eb\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arc...\",\"qty\":1}]', 1, 'pending', '2019-05-15 02:03:58', '2019-05-15 02:04:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 37.83, 3, '2019-05-15 21:40:54', 'order_CVwAyNFRZQnJBm', '{\"razorpay_payment_id\":\"pay_CVwB3QarI1qhaN\",\"razorpay_order_id\":\"order_CVwAyNFRZQnJBm\",\"razorpay_signature\":\"c73dee4cdca2ac4e9e6cd17677aa09545902cd7c7152f291e10b81f22af0919f\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":43,\"name\":\"Machinery\",\"scheme\":1,\"price\":\"39\",\"category_id\":null,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-21.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-21_1.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-05-05 14:52:00\",\"updated_at\":\"2019-05-05 15:36:22\",\"by\":\" \",\"category\":null,\"short_title\":\"\",\"last_updated\":\"1 week ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/43\\/Machinery\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-21.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-21_1.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-21.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-21.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fu...\",\"qty\":1}]', 1, 'pending', '2019-05-15 21:40:44', '2019-05-15 21:40:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 697.5, 7, NULL, 'order_CbRgmNik0CQzd1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nu...\",\"qty\":1},{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tel...\",\"qty\":1}]', 1, 'pending', '2019-05-29 19:45:15', '2019-05-29 19:45:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `orders` (`id`, `amount_payable`, `percent_off`, `paid_at`, `razorpay_order_id`, `razorpay_response`, `billing_firstname`, `billing_lastname`, `billing_phone`, `billing_email`, `billing_country`, `billing_company`, `billing_street_address`, `billing_city`, `billing_state`, `billing_apartment`, `buyer_name`, `email`, `phone`, `address`, `additional_note`, `buyer_order`, `user_id`, `status`, `created_at`, `updated_at`, `shipping_firstname`, `shipping_lastname`, `shipping_email`, `shipping_phone`, `shipping_company`, `shipping_country`, `shipping_city`, `shipping_state`, `shipping_street_address`, `shipping_apartment`, `shipping_fee`) VALUES
(35, 697.5, 7, NULL, 'order_CbRgx6V96MpsG9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nu...\",\"qty\":1},{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tel...\",\"qty\":1}]', 1, 'pending', '2019-05-29 19:45:25', '2019-05-29 19:45:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 697.5, 7, NULL, 'order_CbRh5vkhzNSZPd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":40,\"name\":\"Peplum Hem \",\"scheme\":2,\"price\":\"250\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>&nbsp;<\\/li>\\r\\n<\\/ul>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_2.png\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/Screenshot-1_3.png\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2018-12-01 17:17:45\",\"updated_at\":\"2019-05-05 16:07:41\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/40\\/Peplum-Hem\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]},\"mainimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"secondaryimage\":\"http:\\/\\/localhost\\/mle\\/uploads\\/images\\/products\\/Screenshot-1_2.png\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\\r\\n<p>Nu...\",\"qty\":1},{\"id\":41,\"name\":\"tbou\",\"scheme\":2,\"price\":\"500\",\"category_id\":3,\"ribbon\":null,\"old_price\":null,\"description\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.<\\/p>\\r\\n\",\"front_image\":\"{\\\"images\\\":[{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-4-2_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-5-4-568x653_1.jpg\\\"},{\\\"main_image\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1.jpg\\\",\\\"thumbnail\\\":\\\"uploads\\\\\\/images\\\\\\/products\\\\\\/prod-6-1-1_1.jpg\\\"}]}\",\"back_image\":null,\"on_sale\":1,\"created_at\":\"2019-02-26 06:21:19\",\"updated_at\":\"2019-05-03 23:38:47\",\"by\":\" \",\"category\":{\"id\":3,\"category\":\"Partys\",\"note\":\"\",\"created_at\":null,\"updated_at\":\"2019-02-16 10:13:21\"},\"short_title\":\"\",\"last_updated\":\"3 weeks ago\",\"thumbnail\":null,\"url_link\":\"http:\\/\\/localhost\\/mle\\/shop\\/product_detail\\/41\\/tbou\",\"images\":{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]},\"mainimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"secondaryimage\":\"https:\\/\\/wrappixel.com\\/demos\\/admin-templates\\/monster-admin\\/assets\\/images\\/big\\/img1.jpg\",\"percentdiscount\":0,\"quickdescription\":\"<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tel...\",\"qty\":1}]', 1, 'pending', '2019-05-29 19:45:32', '2019-05-29 19:45:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(1, 'tee02bn@gmail.com ', '5c9d5a2c96e96', '2019-03-28 19:35:08', '2019-03-28 19:35:08'),
(2, 'nationel83@gmail.com', '5c9e8f9b698ad', '2019-03-29 17:35:23', '2019-03-29 17:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheme` bigint(20) DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint(191) DEFAULT NULL,
  `ribbon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `front_image` longtext COLLATE utf8mb4_unicode_ci,
  `back_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `downloadable_files` longtext COLLATE utf8mb4_unicode_ci,
  `on_sale` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `scheme`, `price`, `category_id`, `ribbon`, `old_price`, `description`, `front_image`, `back_image`, `downloadable_files`, `on_sale`, `created_at`, `updated_at`) VALUES
(40, 'Peplum Hem ', 2, '250', 3, NULL, NULL, '<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.</p>\r\n\r\n<p>Nunc lacus elit, faucibus ac laoreet sed, dapibus ac mi. Maecenas eu ante a elit tempus fermentum. Aliquam commodo tincidunt semper. Phasellus accumsan, justo ac mollis pharetra, ex dui pharetra nisl, a scelerisque ipsum nulla ac sem. Cras eu risus urna. Duis lorem sapien, congue eget nisl sit amet, rutrum faucibus elit.</p>\r\n\r\n<ul>\r\n <li>&nbsp;</li>\r\n</ul>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-1_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-1_3.png\"}]}', NULL, 'uploads/images/downloadable_files/Screenshot-21_1.zip', 1, '2018-12-01 17:17:45', '2019-05-05 15:07:41'),
(41, 'tbou', 2, '500', 3, NULL, NULL, '<p>Donec accumsan auctor iaculis. Sed suscipit arcu ligula, at egestas magna molestie a. Proin ac ex maximus, ultrices justo eget, sodales orci. Aliquam egestas libero ac turpis pharetra, in vehicula lacus scelerisque. Vestibulum ut sem laoreet, feugiat tellus at, hendrerit arcu.</p>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/prod-4-2.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-4-2_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-5-4-568x653.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-5-4-568x653_1.jpg\"},{\"main_image\":\"uploads\\/images\\/products\\/prod-6-1-1.jpg\",\"thumbnail\":\"uploads\\/images\\/products\\/prod-6-1-1_1.jpg\"}]}', NULL, NULL, 1, '2019-02-26 06:21:19', '2019-05-03 22:38:47'),
(43, 'Machinery', 1, '39', NULL, NULL, NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-21.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-21_1.png\"}]}', NULL, 'uploads/images/downloadable_files/', 1, '2019-05-05 13:52:00', '2019-05-21 18:50:30'),
(46, 'Machiner', 1, '39', NULL, NULL, NULL, '<p>vs n bse&nbsp;</p>\r\n', '{\"images\":[{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_16.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_17.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_14.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_15.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_12.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_13.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_10.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_11.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_8.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_9.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_6.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_7.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_4.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_5.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15_2.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_3.png\"},{\"main_image\":\"uploads\\/images\\/products\\/Screenshot-15.png\",\"thumbnail\":\"uploads\\/images\\/products\\/Screenshot-15_1.png\"}]}', NULL, 'uploads/images/downloadable_files/Screenshot-21_11.zip', 1, '2019-05-21 19:02:15', '2019-05-21 19:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `criteria` varchar(255) DEFAULT NULL,
  `settings` longtext,
  `default_setting` longtext NOT NULL COMMENT 'backup',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `criteria`, `settings`, `default_setting`, `created_at`, `updated_at`) VALUES
(25, 'admin_bank_details', '{\"bank\":\"Access Banll\",\"account_number\":\"987567878\",\"account_name\":\"Alien Fashion\"}', '', NULL, NULL),
(26, 'paystack_keys', '{\"public_key\":\"pk_test_117354fdfdd854df97e8f2451be553d3cf529d9c34fc\",\"secret_key\":\"sk_test_httr54544ff7a1002b56b25e7f3a5dbc57b6ab3974\"}', '', NULL, NULL),
(27, 'sms_api_keys', '{\"username\":\"ncs\",\"password\":\"65f130\",\"link\":\"http://www.estoresms.com/smsapi.php\",\"sender\":\"Attendance\"}', '', NULL, '2019-03-21 13:58:02'),
(28, 'site_settings', '{\"paypal_public_key\":\"AdWnLF5gb5swcNtu3B4ccPEL1fFvnOGuG_uR4IuRELl3w0hw5QKU_Uyi6xcexrbBjAdjssM-fm6FDeRc\",\"paypal_secret_key\":\"EB8yHHRYuwtQWLio5QRFnn1Z0ojb7vX1MmOsqkiCNEKMXY4IRv1HOGEbX0fZ63ebrsLDS4lq4JwSLfoh\",\"email_verification\":1,\"razorpay_public_key\":\"rzp_test_ZS6LJ68zhbjxSb\",\"razorpay_secret_key\":\"tDyrcCJYyubGBp69eHDcKiyK\",\"google_re_captcha_site_key\":\"6Ldwap8UAAAAAHPfcf47YobB_Je-TUVZjJCbPwfG\",\"google_re_captcha_secret_key\":\"6Ldwap8UAAAAAO2pamsGRVEePsVqDH9GY5QhWGM-\"}', '', NULL, '2019-05-13 21:45:47');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_payment_orders`
--

CREATE TABLE `subscription_payment_orders` (
  `id` bigint(20) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_response` longtext,
  `user_id` bigint(20) NOT NULL,
  `sent_email` tinyint(1) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `price` float NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `details` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_payment_orders`
--

INSERT INTO `subscription_payment_orders` (`id`, `plan_id`, `razorpay_order_id`, `razorpay_response`, `user_id`, `sent_email`, `payment_proof`, `price`, `paid_at`, `details`, `created_at`, `updated_at`) VALUES
(6, 1, 'order_CbStIqGGBfE0tv', '{\"razorpay_payment_id\":\"pay_CbStVcwcDyP9t8\",\"razorpay_order_id\":\"order_CbStIqGGBfE0tv\",\"razorpay_signature\":\"d5ebb8ffadff0ea118e76dafee8096be560793dcc272bda6d9607445cb037621\"}', 1, NULL, NULL, 3, '2019-05-29 20:56:05', '{\"id\":1,\"price\":3,\"hierarchy\":2,\"features\":\"access, read, write, view\",\"percent_off\":3,\"package_type\":\"3 Rupees Scheme\",\"availability\":\"on\",\"confirmation_message\":\"<p>Dear project_name;?&gt; member thank you for paying the signup fee for 3 inr (Indian rupees) only<\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.<\\/li>\\r\\n\\t<li>The new multi level earning scheme developed by our very creative minds<\\/li>\\r\\n\\t<li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.<\\/li>\\r\\n\\t<li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p>Here are the details for this particular scheme:<\\/p>\\r\\n\\r\\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.<\\/p>\\r\\n\\r\\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.<\\/p>\\r\\n\\r\\n<p>Here are the product details: link: -https\\/\\/:LOREMIPSUM.CODQSUCJCB<\\/p>\\r\\n\",\"created_at\":null,\"updated_at\":\"2019-05-21 20:05:27\"}', '2019-05-29 20:55:46', '2019-05-29 20:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `price` float NOT NULL,
  `hierarchy` int(11) DEFAULT NULL,
  `features` longtext NOT NULL,
  `percent_off` float DEFAULT NULL,
  `package_type` varchar(255) NOT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `confirmation_message` longtext,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `price`, `hierarchy`, `features`, `percent_off`, `package_type`, `availability`, `confirmation_message`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 'access, read, write, view', 3, '3 Rupees Scheme', 'on', '<p>Dear project_name;?&gt; member thank you for paying the signup fee for 3 inr (Indian rupees) only</p>\r\n\r\n<ul>\r\n  <li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.</li>\r\n <li>The new multi level earning scheme developed by our very creative minds</li>\r\n  <li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.</li>\r\n <li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme</li>\r\n</ul>\r\n\r\n<p>Here are the details for this particular scheme:</p>\r\n\r\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.</p>\r\n\r\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.</p>\r\n\r\n<p>Here are the product details: link: -https//:LOREMIPSUM.CODQSUCJCB</p>\r\n', NULL, '2019-05-21 20:05:27'),
(2, 7, 1, 'access, read, write, view', 7, '7 Rupees Scheme', 'on', '<p>Dear <!--?=project_name;?--> member thank you for paying the signup fee for 7&nbsp;inr (Indian rupees) only</p>\r\n\r\n<ul>\r\n  <li>Now you are a privilege member of 1 out of more than 101 earning acts and schemes.</li>\r\n <li>The new multi level earning scheme developed by our very creative minds</li>\r\n  <li>This signup fee for 3 inr is for 1 case project I.e its not a monthly or yearly subscription but its a signup fee for 1 earning act.</li>\r\n <li>This is the basic earning scheme where you will get a return of more than 100 times per successful task and you can do unlimited number of tasks in this scheme</li>\r\n</ul>\r\n\r\n<p>Here are the details for this particular scheme:</p>\r\n\r\n<p>In this scheme we will teach you to harness your hidden potential within your social circle. We will give you a product which will cost 3% of the actual product value which will be resold in the social circle for the double price what you pay for, making everybody win in all the aspects.</p>\r\n\r\n<p>So you can order as much quantity you want but there is no need to buy in bulk initially, you can buy it again as you sell the previous one with minimum quantity 1 at a time. This way we will win trust and make everyone win.</p>\r\n\r\n<p>Here are the product details: link: -https//:LOREMIPSUM.CODQSUCJCB</p>\r\n', NULL, '2019-05-21 20:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) NOT NULL,
  `subject_of_ticket` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` smallint(1) NOT NULL COMMENT '0=open, 1=clsed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `subject_of_ticket`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'huujklj E g4RH 7YWJ', 5, 1, '2018-03-06 14:05:02', '2018-03-15 15:44:34'),
(2, 'hhhh', 5, 1, '2018-03-06 14:05:29', '2018-03-06 15:26:26'),
(3, 'hhhh orag', 5, 1, '2018-03-06 14:17:46', '2018-03-06 15:15:52'),
(4, 'My first complaint', 1, 1, '2018-03-07 09:53:15', '2018-03-15 13:47:31'),
(5, 'jiji it', 20, 1, '2018-03-15 13:42:52', '2018-03-15 13:43:13'),
(6, 'jiji itv  jytyet im 4u4j i 4ol', 20, 0, '2018-03-15 13:43:28', '2018-03-15 13:43:28'),
(7, 'hey', 21, 0, '2018-03-15 16:13:28', '2018-03-15 16:13:28');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `attester` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `approval_status` int(11) NOT NULL DEFAULT '0' COMMENT '1= approved, 0=not approved',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `user_id`, `attester`, `content`, `approval_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Linda Jmon', 'I Love DOve Investment I dk', 0, '2019-04-07 00:00:00', '2019-05-21 19:41:25'),
(2, NULL, ' ', 'We are good people', 1, '2019-04-05 07:50:46', '2019-04-05 07:51:55'),
(3, NULL, 'Ibukun Ibk', 'GReat jobs', 1, '2019-04-05 07:56:48', '2019-04-05 08:03:23'),
(4, 1, 'Linda Jmon', '', 0, '2019-05-21 19:35:07', '2019-05-21 19:35:07'),
(5, 1, 'Linda Jmon', 'fr th yh ', 0, '2019-05-21 19:35:13', '2019-05-21 19:35:13'),
(6, 1, 'Linda Jmon', '', 0, '2019-05-21 19:35:29', '2019-05-21 19:35:29'),
(7, 1, 'Linda Jmon', '', 0, '2019-05-21 19:35:47', '2019-05-21 19:35:47'),
(8, 1, 'Linda Jmon', '', 0, '2019-05-21 19:35:47', '2019-05-21 19:35:47'),
(9, 1, 'Linda Jmon', 'yh4 76j74 65 ', 0, '2019-05-21 19:35:51', '2019-05-21 19:35:51'),
(10, 1, 'Linda Jmon', 'fvio jtorw yehtrte r', 0, '2019-05-21 19:36:36', '2019-05-21 19:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `mlm_id` varchar(255) DEFAULT NULL,
  `referred_by` bigint(20) DEFAULT NULL COMMENT 'placment_sponsor',
  `introduced_by` bigint(20) DEFAULT NULL COMMENT 'enrolment sponsor',
  `placement_cut_off` longtext,
  `rejoin_id` varchar(255) DEFAULT NULL,
  `rejoin_email` varchar(255) DEFAULT NULL,
  `placed` int(11) DEFAULT NULL COMMENT '0=not placed, 1= placed (by enroler)',
  `username` varchar(255) DEFAULT NULL,
  `account_plan` varchar(255) DEFAULT NULL COMMENT 'Demo receiver user',
  `rank` int(11) NOT NULL DEFAULT '0',
  `locked_to_receive` datetime DEFAULT NULL,
  `rank_history` longtext,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email_verification` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone_verification` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `worthy_cause_for_donation` longtext,
  `age` varchar(255) DEFAULT NULL,
  `profile_pix` varchar(255) DEFAULT NULL,
  `resized_profile_pix` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `blocked_on` datetime DEFAULT NULL,
  `lastseen_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastlogin_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mlm_id`, `referred_by`, `introduced_by`, `placement_cut_off`, `rejoin_id`, `rejoin_email`, `placed`, `username`, `account_plan`, `rank`, `locked_to_receive`, `rank_history`, `firstname`, `lastname`, `email`, `state`, `country`, `email_verification`, `phone`, `phone_verification`, `bank_name`, `bank_account_number`, `bank_account_name`, `worthy_cause_for_donation`, `age`, `profile_pix`, `resized_profile_pix`, `password`, `created_at`, `updated_at`, `blocked_on`, `lastseen_at`, `lastlogin_ip`) VALUES
(1, '1', 16, NULL, NULL, NULL, NULL, NULL, 'company', '1', 2, NULL, '{\"2018-11-27 12:20:17\":\"8\",\"2018-11-27 12:31:10\":\"5\"}', 'Jmon', 'Lindas', 'ozih@rocketmail.comm', NULL, ' Antigua & Barbuda', '1', '9678908690', '1', 'capitec', '097567890', 'jacqueline', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover ', '23', 'uploads/images/users/profile_pictures/download.jpg', 'uploads/images/users/profile_pictures/download_2.jpg', '$2y$10$Tt8Xj8ZAqk7sMAu1cbqWtOZS6rgL8wG.w.OOiU74hRmpTZdCaSLQ6', '2018-11-07 12:05:14', '2019-05-29 20:56:05', NULL, '2019-05-29 19:56:05', ''),
(15, '15', 1, 1, NULL, NULL, NULL, NULL, 'teeboy', NULL, 0, NULL, NULL, 'Taiwo', 'Ope-ifa', 'tee02bn@gmail.com', NULL, NULL, 'da4d81442eb4ee489d6a0fa06f3a9f37', '8123351819', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$ZDRYb/VZJuO51zjTc9m0TOTHoMtSx54f9XPi9y8KzAq79Ll/wfOCK', '2019-03-28 18:19:08', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(16, '16', 1, 1, NULL, NULL, NULL, NULL, 'nationel', '1', 0, NULL, NULL, 'Nelson', 'Johnson', 'nationel83@gmail.com', NULL, NULL, '1', '08079117724', NULL, 'Access Bank', '0019670753', 'Johnson Nelson ', NULL, NULL, NULL, NULL, '$2y$10$sQGscDaEhtbdgTf7GZLps.UPdnJkRZpJN0NySg5lA4lL2HIqELAj2', '2019-03-28 18:58:50', '2019-04-15 22:39:41', NULL, '2019-04-15 22:24:04', ''),
(17, '17', 1, 1, NULL, NULL, NULL, NULL, 'Teeboz', NULL, 0, NULL, NULL, 'Taiwo', 'Ope-ifa ', 'tee01bn@gmail.com', NULL, NULL, 'f1a76a313d9bda262a849d7763c31def', '08123351819', NULL, 'Access', '', '', NULL, NULL, NULL, NULL, '$2y$10$EYJLkTM2ubUiZs6hv6KSeeScU2WWOQqCy0BJOmDORDUOVFxShLNFO', '2019-03-28 19:36:42', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(18, '18', 16, 16, NULL, NULL, NULL, NULL, 'usylvia', NULL, 0, NULL, NULL, 'Sylvia ', 'Oparaekocha ', 'oparaekochaus@gmail.com', NULL, NULL, '1', '08025401179', NULL, 'Diamond ', '0092755227', 'OPARAEKOCHA U. SYLVIA ', NULL, NULL, NULL, NULL, '$2y$10$PGSHfwJsXiQe0eg1d8kdS.7ccE6BdqBjcl.9rz4ZXZMKAoljc1faW', '2019-03-29 04:50:54', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(19, '19', 1, NULL, NULL, NULL, NULL, NULL, 'china', NULL, 0, NULL, NULL, 'Chinaemerem', 'Assumpta', 'caladimma@yahoo.com ', NULL, NULL, '1', '09087517666', NULL, 'Gtb', '0107470554', 'Aladimma chinaemerem', NULL, NULL, NULL, NULL, '$2y$10$xBjgrSuQ1ZY0eylRsaoaM.mvmvEql6uD4wOTSgyRymBRwfHJcJDby', '2019-03-29 05:07:11', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(20, '20', 16, 16, NULL, NULL, NULL, NULL, 'Research', NULL, 0, NULL, NULL, 'Abiso', 'Jacob', 'abisodq@gmail.com', NULL, NULL, '1', '08033871468', NULL, 'Zenith', '2081648254', 'Abinokhauno oshiogwe Solomon ', NULL, NULL, NULL, NULL, '$2y$10$Kr2sgHmXBlLNtsFp3HtUCOLK12LiYrSUq6RwPw77yH42bzMjamxfW', '2019-03-29 06:20:12', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(21, '21', 16, 16, NULL, NULL, NULL, NULL, 'Boss 1', NULL, 0, NULL, NULL, 'Presley ', 'Ebibomoh ', 'pepeeboy946@gmail.com', NULL, NULL, '1', '09076338872', NULL, 'Guarantee Trust Bank', '0013039955', 'Presley Ebiabode Ebibomoh ', NULL, NULL, 'uploads/images/users/profile_pictures/IMG_20181223_211606.jpg', 'uploads/images/users/profile_pictures/IMG_20181223_211606_1.jpg', '$2y$10$ShUDXd2zdbtAZlxG.Nbze.MytaE5.0u.v7qgAJ2VlXuGxz4QAUtLW', '2019-03-29 06:23:20', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(22, '22', 16, 16, NULL, NULL, NULL, NULL, 'Chinnel', NULL, 0, NULL, NULL, 'Magdalene', 'Abinokhauno', 'omoh_real@yahoo.com', NULL, NULL, '1', '8034305099', NULL, 'GUARANTY TRUST BANK', '0019783802', 'MAGDALENE,ABINOKHAUNO', NULL, NULL, NULL, NULL, '$2y$10$ywA/upvaU4nFg1uGgXuTUOF5vQgolMIUyO2/CmDjlDaU/Q.fjwMo.', '2019-03-29 06:23:26', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(23, '23', 16, 16, NULL, NULL, NULL, NULL, 'Efreda4real', NULL, 0, NULL, NULL, 'Theodora', 'Egburedi', 'theodoraefreda2016@gmail.com', NULL, NULL, '1', '08063387640', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$kRs9fcV2b6vWXsEHc6besOs6Ud0JtezPZvNwOEADU7enLXkwnVjgG', '2019-03-29 06:58:53', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(24, '24', 16, 16, NULL, NULL, NULL, NULL, 'Therian', NULL, 0, NULL, NULL, 'Ijeoma', 'Oparaekocha', 'oparaekochat@gmail.com', NULL, NULL, '1f66c8ec22693be625a96ab7710acd5a', '08068473529', NULL, 'GTB', '0235506165', 'Oparaekocha Ijeoma', NULL, NULL, NULL, NULL, '$2y$10$l50JEA14LYvMyY6lEwlPI.QkK5nSQzGQvxXCEKFNzqorrBeHCJRfy', '2019-03-29 07:31:12', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(25, '25', 16, 16, NULL, NULL, NULL, NULL, 'mountain', NULL, 0, NULL, NULL, 'Ugwu', 'Edith', 'ugwuchinenye.e@gmail.com', NULL, NULL, '1', '07061894818', NULL, 'First Bank', '3024779666', 'Ugwu Chinenye Edith', NULL, NULL, NULL, NULL, '$2y$10$KBhjTvQYir0ojI.fQFmKL.c.n/v3PQbjfmglTo8uERAcvY2T.GQA6', '2019-03-29 08:14:36', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(26, '26', 16, 16, NULL, NULL, NULL, NULL, 'Chimus', NULL, 0, NULL, NULL, 'Nwosu', 'Anthonia', 'chimua12@gmail.com', NULL, NULL, '1', '08065839410', NULL, 'Access Bank ', '0049839432', 'Nwosu Anthonia', NULL, NULL, NULL, NULL, '$2y$10$y76f.s5gylXuvWvJwC1xMeR2VLMmhWLxFJM1IPP6/x8QluxI.67p6', '2019-03-29 08:16:32', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(27, '27', 16, 16, NULL, NULL, NULL, NULL, 'LACHOICE', NULL, 0, NULL, NULL, 'MIRIAM', 'CHUKWU', 'ADAEZEM980@GMAIL.COM', NULL, NULL, '1', '09099766534', NULL, 'Access bank', '0042683193', 'Miriam chukwu', NULL, NULL, NULL, NULL, '$2y$10$.gEdhnzmWxd.Dfy.af2NmOolFDw4gWOtdoRdSkWMVzKfBLjEyL/6u', '2019-03-29 08:42:09', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(28, '28', 16, 16, NULL, NULL, NULL, NULL, 'Henry ', NULL, 0, NULL, NULL, 'Henry ', 'Agbugba ', 'agbugbahenry@yahoo.com', NULL, NULL, '1', '08025401179', NULL, 'UBA PLC ', '2090559622', 'Agbugba Henry C. ', NULL, NULL, NULL, NULL, '$2y$10$0sfmAlwz3xmz5kmBkLdluef8IWvP026.OQFBWQwCFsbIKXTePk3bS', '2019-03-29 08:53:55', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(29, '29', 16, 16, NULL, NULL, NULL, NULL, 'Michellemarcus', NULL, 0, NULL, NULL, 'Michelle', 'Marcus', 'michellemarcus410@gmail.com', NULL, NULL, '1', '08036739668', NULL, 'Access Bank', '0019786803', 'Michelle Marcus', NULL, NULL, NULL, NULL, '$2y$10$ogmwLVkkpbPLUE9dH7B8J.Lt4PRPwL5qREYbUQ7IgHV.A.AvaNPnu', '2019-03-29 13:40:48', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(30, '30', 18, 18, NULL, NULL, NULL, NULL, 'Happiness', NULL, 0, NULL, NULL, 'Happiness', 'Okiaze', 'okiazehappiness@gmail.com', NULL, NULL, '1', '08037843243', NULL, 'Diamond', '0032802851', 'Okiaze Happiness U.', NULL, NULL, NULL, NULL, '$2y$10$W3gAW7vYv/EKC6PfDrk0l.ODhongQWVTPUFCSdtJj0lMCPBlH2hWG', '2019-04-01 12:26:16', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(31, '31', 18, 18, NULL, NULL, NULL, NULL, 'Uigho ', NULL, 0, NULL, NULL, 'Igho', 'Etinne ', 'igho.umukoro@yahoo.com', NULL, NULL, '1', '08055930852', NULL, 'Access', '0690885257', 'Igho Etinne', NULL, NULL, NULL, NULL, '$2y$10$Bc/TYAtCbXQykxSxet4NWe3WzbNqNmvDXPDPNCoC/lyzXE7i8nlFe', '2019-04-01 17:33:29', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(32, '32', 26, 26, NULL, NULL, NULL, NULL, 'eai', NULL, 0, NULL, NULL, 'Taiwo', 'Opeifa', 'tee04b@gmail.com', NULL, NULL, 'e077224e496b10d4f0322e3160c90f2f', '909389232333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$lKnbqPSCkEnWOMd43EFpSOgr6RA.y8h7WPhMijPUN0GkrUWS2J1c6', '2019-04-11 22:29:03', '2019-04-15 22:39:41', NULL, '2019-04-15 20:39:41', ''),
(33, '33', 1, 1, NULL, NULL, NULL, NULL, 'tee04bn', '1', 0, NULL, NULL, 'Taiwo', 'Opeifa', 'taiwo@sevenbridgesoluts.com', NULL, NULL, '1', '08133347383', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$/PNLA4IO9zPI9Y30mI4nVuiGAaLgnhHTSskqQQMLL8fBIBFJVTAAC', '2019-04-30 20:47:23', '2019-04-30 21:23:33', NULL, '2019-05-01 10:14:48', ''),
(34, '34', 1, NULL, NULL, NULL, NULL, NULL, 'taiwo', NULL, 0, NULL, NULL, 'Taiwo', 'Opeifa', 'taiwo@sevenbridgesolutions.c', NULL, NULL, 'p9nk6y', '08123351819', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$VywtVl66A6iFwWWAcSF4ROpsreziJBiwC7zQDmtRk4Gvf15Cx8UPG', '2019-05-15 21:56:58', '2019-05-15 21:56:58', NULL, '2019-05-15 20:56:58', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `broadcast`
--
ALTER TABLE `broadcast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers_support`
--
ALTER TABLE `customers_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ebooks`
--
ALTER TABLE `ebooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_income_report`
--
ALTER TABLE `level_income_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commission_type` (`commission_type`,`owner_user_id`,`downline_id`) USING BTREE;

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product` (`name`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_payment_orders`
--
ALTER TABLE `subscription_payment_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `Unique` (`mlm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `broadcast`
--
ALTER TABLE `broadcast`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers_support`
--
ALTER TABLE `customers_support`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ebooks`
--
ALTER TABLE `ebooks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `level_income_report`
--
ALTER TABLE `level_income_report`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `subscription_payment_orders`
--
ALTER TABLE `subscription_payment_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
