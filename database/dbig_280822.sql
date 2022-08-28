-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 27, 2022 at 01:14 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbig`
--

-- --------------------------------------------------------

--
-- Table structure for table `dt_log_queries`
--

CREATE TABLE `dt_log_queries` (
  `detail_id` bigint(20) UNSIGNED NOT NULL,
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `query_text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hd_log_queries`
--

CREATE TABLE `hd_log_queries` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(100) NOT NULL,
  `ref_id` int(11) UNSIGNED NOT NULL,
  `log_remark` varchar(250) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2022-08-25-163151', 'App\\Database\\Migrations\\LogQueries', 'logs', 'App', 1661450116, 1),
(2, '2022-08-25-163228', 'App\\Database\\Migrations\\Auth', 'default', 'App', 1661450117, 1),
(3, '2022-08-25-180919', 'App\\Database\\Migrations\\InitDatabase', 'default', 'App', 1661515236, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ms_category`
--

CREATE TABLE `ms_category` (
  `category_id` int(5) UNSIGNED NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_description` text NOT NULL,
  `deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_store`
--

CREATE TABLE `ms_store` (
  `store_id` int(5) UNSIGNED NOT NULL,
  `store_code` varchar(10) NOT NULL,
  `store_name` varchar(200) NOT NULL,
  `store_phone` varchar(15) NOT NULL,
  `store_address` text NOT NULL,
  `store_api_key` varchar(200) NOT NULL,
  `deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ms_store`
--

INSERT INTO `ms_store` (`store_id`, `store_code`, `store_name`, `store_phone`, `store_address`, `store_api_key`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'UTM', 'DBIG', '6281268880819', 'Jl. Serdam No A2-A3-A4(Arah RS Soedarso)', '123456789012345678', 'N', '2022-08-26 00:58:39', '2022-08-26 00:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `store_id` int(5) UNSIGNED NOT NULL,
  `user_code` varchar(4) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `user_realname` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_group` varchar(3) NOT NULL,
  `user_fingerprint` blob,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `store_id`, `user_code`, `user_name`, `user_realname`, `user_password`, `user_group`, `user_fingerprint`, `active`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'U000', 'dbig22', 'Owner', '$2y$10$Zhiyzp.Cv9m7Pe3klwuSJeTCWiMhX.1UZEPibJYuDtpqcmLgIHhHi', 'L00', NULL, 'Y', 'N', '2022-08-26 01:08:06', '2022-08-27 00:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `group_code` varchar(3) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`group_code`, `group_name`, `deleted`, `created_at`, `updated_at`) VALUES
('L00', 'OWNER', 'N', '2022-08-26 01:04:58', '2022-08-26 01:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `group_code` varchar(3) NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `role_value` varchar(1) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dt_log_queries`
--
ALTER TABLE `dt_log_queries`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `dt_log_queries_log_id_foreign` (`log_id`);

--
-- Indexes for table `hd_log_queries`
--
ALTER TABLE `hd_log_queries`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `module` (`module`),
  ADD KEY `ref_id` (`ref_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ms_category`
--
ALTER TABLE `ms_category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `ms_store`
--
ALTER TABLE `ms_store`
  ADD PRIMARY KEY (`store_id`),
  ADD UNIQUE KEY `store_code` (`store_code`),
  ADD UNIQUE KEY `store_name` (`store_name`),
  ADD UNIQUE KEY `store_api_key` (`store_api_key`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_code` (`user_code`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD KEY `user_account_user_group_foreign` (`user_group`),
  ADD KEY `user_account_store_id_foreign` (`store_id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`group_code`),
  ADD UNIQUE KEY `group_name` (`group_name`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD UNIQUE KEY `group_code_module_name_role_name` (`group_code`,`module_name`,`role_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dt_log_queries`
--
ALTER TABLE `dt_log_queries`
  MODIFY `detail_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hd_log_queries`
--
ALTER TABLE `hd_log_queries`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ms_category`
--
ALTER TABLE `ms_category`
  MODIFY `category_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_store`
--
ALTER TABLE `ms_store`
  MODIFY `store_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dt_log_queries`
--
ALTER TABLE `dt_log_queries`
  ADD CONSTRAINT `dt_log_queries_log_id_foreign` FOREIGN KEY (`log_id`) REFERENCES `hd_log_queries` (`log_id`);

--
-- Constraints for table `user_account`
--
ALTER TABLE `user_account`
  ADD CONSTRAINT `user_account_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `ms_store` (`store_id`),
  ADD CONSTRAINT `user_account_user_group_foreign` FOREIGN KEY (`user_group`) REFERENCES `user_group` (`group_code`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_group_code_foreign` FOREIGN KEY (`group_code`) REFERENCES `user_group` (`group_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
