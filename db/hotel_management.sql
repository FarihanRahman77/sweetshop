-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 12:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `calender_tbl`
--

CREATE TABLE `calender_tbl` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `day_name` varchar(50) NOT NULL,
  `day_type` varchar(50) NOT NULL,
  `offday_cause` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `calender_tbl`
--

INSERT INTO `calender_tbl` (`id`, `date`, `day_name`, `day_type`, `offday_cause`, `created_at`, `updated_at`) VALUES
(1, '2023-01-01', 'Sun', 'Offday', 'weekend', '2024-12-12 11:52:41', '2024-12-12 05:52:41'),
(2, '2023-01-02', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(3, '2023-01-03', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(4, '2023-01-04', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(5, '2023-01-05', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(6, '2023-01-06', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(7, '2023-01-07', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(8, '2023-01-08', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(9, '2023-01-09', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(10, '2023-01-10', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(11, '2023-01-11', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(12, '2023-01-12', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(13, '2023-01-13', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(14, '2023-01-14', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(15, '2023-01-15', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(16, '2023-01-16', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(17, '2023-01-17', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(18, '2023-01-18', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(19, '2023-01-19', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(20, '2023-01-20', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(21, '2023-01-21', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(22, '2023-01-22', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(23, '2023-01-23', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(24, '2023-01-24', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(25, '2023-01-25', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(26, '2023-01-26', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(27, '2023-01-27', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(28, '2023-01-28', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(29, '2023-01-29', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(30, '2023-01-30', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(31, '2023-01-31', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(32, '2023-02-01', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(33, '2023-02-02', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(34, '2023-02-03', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(35, '2023-02-04', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(36, '2023-02-05', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(37, '2023-02-06', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(38, '2023-02-07', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(39, '2023-02-08', 'Wed', 'Holiday', 'hkjh', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(40, '2023-02-09', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(41, '2023-02-10', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(42, '2023-02-11', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(43, '2023-02-12', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(44, '2023-02-13', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(45, '2023-02-14', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(46, '2023-02-15', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(47, '2023-02-16', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(48, '2023-02-17', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(49, '2023-02-18', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(50, '2023-02-19', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(51, '2023-02-20', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(52, '2023-02-21', 'Tue', 'Holiday', 'Shaheed Day', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(53, '2023-02-22', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(54, '2023-02-23', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(55, '2023-02-24', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(56, '2023-02-25', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(57, '2023-02-26', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(58, '2023-02-27', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(59, '2023-02-28', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(60, '2023-03-01', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(61, '2023-03-02', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(62, '2023-03-03', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(63, '2023-03-04', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(64, '2023-03-05', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(65, '2023-03-06', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(66, '2023-03-07', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(67, '2023-03-08', 'Wed', 'Holiday', 'Shab e-Barat', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(68, '2023-03-09', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(69, '2023-03-10', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(70, '2023-03-11', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(71, '2023-03-12', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(72, '2023-03-13', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(73, '2023-03-14', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(74, '2023-03-15', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(75, '2023-03-16', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(76, '2023-03-17', 'Fri', 'Offday', '	Sheikh Mujibur Rahmans Birthday', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(77, '2023-03-18', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(78, '2023-03-19', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(79, '2023-03-20', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(80, '2023-03-21', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(81, '2023-03-22', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(82, '2023-03-23', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(83, '2023-03-24', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(84, '2023-03-25', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(85, '2023-03-26', 'Sun', 'Holiday', 'Independence Day', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(86, '2023-03-27', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(87, '2023-03-28', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(88, '2023-03-29', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(89, '2023-03-30', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(90, '2023-03-31', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(91, '2023-04-01', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(92, '2023-04-02', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(93, '2023-04-03', 'Mon', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(94, '2023-04-04', 'Tue', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(95, '2023-04-05', 'Wed', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(96, '2023-04-06', 'Thu', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(97, '2023-04-07', 'Fri', 'Offday', '', '2024-12-12 11:49:01', '2024-12-12 05:49:01'),
(98, '2023-04-08', 'Sat', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00'),
(99, '2023-04-09', 'Sun', 'Onday', '', '2023-07-23 07:40:04', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dues`
--

CREATE TABLE `dues` (
  `id` int(11) NOT NULL,
  `party_id` bigint(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `current_due` decimal(10,2) DEFAULT NULL,
  `type` enum('purchase','purchase_return','sale','sale_return','payment_receive','payment','discount','purchase_delete','purchase_return_delete','sale_delete','sale_return_delete','payment_receive_delete','payment_delete','discount_delete') DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `purchase_delete_id` bigint(20) DEFAULT NULL,
  `purchase_return_id` bigint(20) DEFAULT NULL,
  `purchase_return_delete_id` bigint(20) DEFAULT NULL,
  `sale_id` bigint(20) DEFAULT NULL,
  `sale_delete_id` bigint(20) DEFAULT NULL,
  `sale_return_id` bigint(20) DEFAULT NULL,
  `sale_return_delete_id` bigint(20) DEFAULT NULL,
  `voucher_id` bigint(20) DEFAULT NULL,
  `voucher_delete_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `min_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `remarks` longtext DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sort_code` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `code`, `name`, `slug`, `min_price`, `max_price`, `discount_percentage`, `category_id`, `sister_concern_id`, `remarks`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`, `sort_code`) VALUES
(1, '000001', 'Kacchi Biriyani', 'Kacchi_Biriyani', 235.00, 250.00, 6, 5, 2, '1:2', 'No', 'Active', 1, '2024-09-10 09:41:27', 1, '2024-10-20 06:26:22', NULL, NULL, '2024-09-10 03:41:27', '2024-10-20 00:26:22', 0),
(2, '000002', 'Mutton Korma', 'Mutton_Korma', 218.00, 230.00, 5, 4, 2, '1:2', 'No', 'Active', 1, '2024-09-10 09:49:12', 1, '2024-10-20 04:50:43', NULL, NULL, '2024-09-10 03:49:12', '2024-10-19 22:50:43', 0),
(21, '000003', 'Butter Fried Prawn', 'Butter_Fried_Prawn', 627.00, 660.00, 5, 24, 2, '1:2', 'No', 'Active', 1, '2024-09-26 09:48:24', NULL, NULL, NULL, NULL, '2024-09-26 03:48:24', '2024-09-26 03:48:24', 1001),
(22, '000004', 'Thai Soup - Clear', 'Thai_Soup_-_Clear', 617.50, 650.00, 5, 25, 2, '1:1', 'No', 'Active', 1, '2024-09-26 09:50:43', NULL, NULL, NULL, NULL, '2024-09-26 03:50:43', '2024-09-26 03:50:43', 1002),
(23, '000005', 'Thai Soup - Thick', 'Thai_Soup_-_Thick', 617.50, 650.00, 5, 25, 2, '1:2', 'No', 'Active', 1, '2024-09-26 09:54:23', NULL, NULL, NULL, NULL, '2024-09-26 03:54:23', '2024-09-26 03:54:23', 1003),
(24, '000006', 'Chicken Corn Soup', 'Chicken_Corn_Soup', 598.50, 630.00, 5, 25, 2, '1:2', 'No', 'Active', 1, '2024-09-26 09:55:21', NULL, NULL, NULL, NULL, '2024-09-26 03:55:21', '2024-09-26 03:55:21', 1005),
(25, '000007', 'Prawn Salad', 'Prawn_Salad', 494.00, 520.00, 5, 26, 2, NULL, 'No', 'Active', 1, '2024-09-26 10:00:04', NULL, NULL, NULL, NULL, '2024-09-26 04:00:04', '2024-09-26 04:00:04', 1007),
(26, '000008', 'Chicken Cashewnut Salad', 'Chicken_Cashewnut_Salad', 617.50, 650.00, 5, 26, 2, '1:3', 'No', 'Active', 1, '2024-09-26 10:09:48', NULL, NULL, NULL, NULL, '2024-09-26 04:09:48', '2024-09-26 04:09:48', 1008),
(27, '000009', 'Doi Fuchka', 'Doi_Fuchka', 522.50, 550.00, 5, 27, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:13:44', NULL, NULL, NULL, NULL, '2024-09-26 04:13:44', '2024-09-26 04:13:44', 1009),
(28, '000010', 'Papri Chaat', 'Papri_Chaat', 199.50, 210.00, 5, 27, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:15:11', NULL, NULL, NULL, NULL, '2024-09-26 04:15:11', '2024-09-26 04:15:11', 1010),
(29, '000011', 'Pani Puri', 'Pani_Puri', 199.50, 210.00, 5, 27, 2, '1:3', 'No', 'Active', 1, '2024-09-26 10:17:30', NULL, NULL, NULL, NULL, '2024-09-26 04:17:30', '2024-09-26 04:17:30', 1011),
(30, '000012', 'Chotpoti', 'Chotpoti', 180.50, 190.00, 5, 27, 2, '1:3', 'No', 'Active', 1, '2024-09-26 10:18:31', NULL, NULL, NULL, NULL, '2024-09-26 04:18:31', '2024-09-26 04:18:31', 1012),
(31, '000013', 'Chicken Roll', 'Chicken_Roll', 266.00, 280.00, 5, 28, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:20:56', NULL, NULL, NULL, NULL, '2024-09-26 04:20:56', '2024-09-26 04:20:56', 1013),
(32, '000014', 'Chicken Egg Roll', 'Chicken_Egg_Roll', 304.00, 320.00, 5, 28, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:23:33', NULL, NULL, NULL, NULL, '2024-09-26 04:23:33', '2024-09-26 04:23:33', 1014),
(33, '000015', 'Beef Egg Roll', 'Beef_Egg_Roll', 427.50, 450.00, 5, 28, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:24:59', NULL, NULL, NULL, NULL, '2024-09-26 04:24:59', '2024-09-26 04:24:59', 1015),
(34, '000016', 'Beef Roll', 'Beef_Roll', 558.00, 620.00, 10, 28, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:25:49', NULL, NULL, NULL, NULL, '2024-09-26 04:25:49', '2024-09-26 04:25:49', 1016),
(35, '000017', 'Vegetable Roll', 'Vegetable_Roll', 332.50, 350.00, 5, 28, 2, '1:3', 'No', 'Active', 1, '2024-09-26 10:41:32', NULL, NULL, NULL, NULL, '2024-09-26 04:41:32', '2024-09-26 04:41:32', 1017),
(36, '000018', 'Egg Roll', 'Egg_Roll', 332.50, 350.00, 5, 28, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:42:41', NULL, NULL, NULL, NULL, '2024-09-26 04:42:41', '2024-09-26 04:42:41', 1018),
(37, '000019', 'Pad Thai Noodles with Hot Sauce', 'Pad_Thai_Noodles_with_Hot_Sauce', 494.00, 520.00, 5, 13, 2, '1:1', 'No', 'Active', 1, '2024-09-26 10:46:59', NULL, NULL, NULL, NULL, '2024-09-26 04:46:59', '2024-09-26 04:46:59', 1019),
(38, '000020', 'Special Fried Noodles', 'Special_Fried_Noodles', 342.00, 360.00, 5, 13, 2, '1:1', 'No', 'Active', 1, '2024-09-26 10:48:27', NULL, NULL, NULL, NULL, '2024-09-26 04:48:27', '2024-09-26 04:48:27', 1020),
(39, '000021', 'American Chopsuey', 'American_Chopsuey', 494.00, 520.00, 5, 13, 2, '1:1', 'No', 'Active', 1, '2024-09-26 10:49:31', NULL, NULL, NULL, NULL, '2024-09-26 04:49:31', '2024-09-26 04:49:31', 1021),
(40, '000022', 'Special Dosa', 'Special_Dosa', 520.00, 520.00, 0, 14, 2, '1:3', 'No', 'Active', 1, '2024-09-26 10:51:10', 1, '2024-09-26 11:22:32', NULL, NULL, '2024-09-26 04:51:10', '2024-09-26 05:22:32', 1022),
(41, '000023', 'Butter Naan', 'Butter_Naan', 114.00, 120.00, 5, 15, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:52:38', NULL, NULL, NULL, NULL, '2024-09-26 04:52:38', '2024-09-26 04:52:38', 1023),
(42, '000024', 'Plain Naan', 'Plain_Naan', 95.00, 100.00, 5, 15, 2, '1:1', 'No', 'Active', 1, '2024-09-26 10:53:38', NULL, NULL, NULL, NULL, '2024-09-26 04:53:38', '2024-09-26 04:53:38', 1024),
(43, '000025', 'Garlic Naan', 'Garlic_Naan', 95.00, 100.00, 5, 15, 2, '1:2', 'No', 'Active', 1, '2024-09-26 10:56:15', 1, '2024-10-20 06:26:55', NULL, NULL, '2024-09-26 04:56:15', '2024-10-20 00:26:55', 1025),
(44, '000026', 'Tandoori Chicken', 'Tandoori_Chicken', 266.00, 280.00, 5, 16, 2, 'Quarter', 'No', 'Active', 1, '2024-09-26 10:57:17', NULL, NULL, NULL, NULL, '2024-09-26 04:57:17', '2024-09-26 04:57:17', 1029),
(45, '000027', 'Chicken Reshmi Kebab', 'Chicken_Reshmi_Kebab', 560.50, 590.00, 5, 16, 2, '1:3', 'No', 'Active', 1, '2024-09-26 11:01:27', NULL, NULL, NULL, NULL, '2024-09-26 05:01:27', '2024-09-26 05:01:27', 1030),
(46, '000028', 'Paneer Tikka Kebab', 'Paneer_Tikka_Kebab', 617.50, 650.00, 5, 16, 2, '1:1', 'No', 'Active', 1, '2024-09-26 11:02:27', NULL, NULL, NULL, NULL, '2024-09-26 05:02:27', '2024-09-26 05:02:27', 1031),
(47, '000029', 'Beef Tawa Kebab', 'Beef_Tawa_Kebab', 627.00, 660.00, 5, 16, 2, NULL, 'No', 'Active', 1, '2024-09-26 11:04:24', NULL, NULL, NULL, NULL, '2024-09-26 05:04:24', '2024-09-26 05:04:24', 1032),
(48, '000030', 'Chicken Reshmi Tawa Kebab', 'Chicken_Reshmi_Tawa_Kebab', 551.00, 580.00, 5, 16, 2, '1:3', 'No', 'Active', 1, '2024-09-26 11:06:15', NULL, NULL, NULL, NULL, '2024-09-26 05:06:15', '2024-09-26 05:06:15', 1035),
(49, '000031', 'Paneer Butter Masala', 'Paneer_Butter_Masala', 551.00, 580.00, 5, 17, 2, '1:3', 'No', 'Active', 1, '2024-09-26 11:07:45', NULL, NULL, NULL, NULL, '2024-09-26 05:07:45', '2024-09-26 05:07:45', 1036),
(50, '000032', 'Mixed Vegetable', 'Mixed_Vegetable', 450.00, 450.00, 0, 17, 2, '1:3', 'No', 'Active', 1, '2024-09-26 11:08:59', NULL, NULL, NULL, NULL, '2024-09-26 05:08:59', '2024-09-26 05:08:59', 1037),
(51, '000033', 'Chicken Red Curry', 'Chicken_Red_Curry', 522.50, 550.00, 5, 18, 2, '1:3', 'No', 'Active', 1, '2024-09-26 11:10:06', NULL, NULL, NULL, NULL, '2024-09-26 05:10:06', '2024-09-26 05:10:06', 1037),
(52, '000034', 'Deep Fried Chicken', 'Deep_Fried_Chicken', 712.50, 750.00, 5, 18, 2, '1:2', 'No', 'Active', 1, '2024-09-26 11:11:11', NULL, NULL, NULL, NULL, '2024-09-26 05:11:11', '2024-09-26 05:11:11', 1038),
(53, '000035', 'Sweet & Sour Chicken', 'Sweet_Sour_Chicken', 627.00, 660.00, 5, 18, 2, '1:1', 'No', 'Active', 1, '2024-09-26 11:12:15', 1, '2024-10-20 06:27:24', NULL, NULL, '2024-09-26 05:12:15', '2024-10-20 00:27:24', 1039),
(54, '000036', 'Faluda', 'Faluda', 237.50, 250.00, 5, 6, 2, '1:1', 'No', 'Active', 1, '2024-09-26 11:47:59', NULL, NULL, NULL, NULL, '2024-09-26 05:47:59', '2024-09-26 05:47:59', 1049),
(55, '000037', 'Fruity Faluda', 'Fruity_Faluda', 275.50, 290.00, 5, 6, 2, 'Delicious dessert, full of flavors', 'No', 'Active', 1, '2024-09-26 11:49:10', NULL, NULL, NULL, NULL, '2024-09-26 05:49:10', '2024-09-26 05:49:10', 1050),
(56, '000038', 'Beef Red Curry', 'Beef_Red_Curry', 617.50, 650.00, 5, 19, 2, '1:3', 'No', 'Active', 1, '2024-09-26 11:59:38', NULL, NULL, NULL, NULL, '2024-09-26 05:59:38', '2024-09-26 05:59:38', 1059),
(57, '000039', 'Beef with Oyster Sauce', 'Beef_with_Oyster_Sauce', 684.00, 720.00, 5, 19, 2, '1:3', 'No', 'Active', 1, '2024-09-26 12:00:33', NULL, NULL, NULL, NULL, '2024-09-26 06:00:33', '2024-09-26 06:00:33', 1059),
(58, '000040', 'Sweet & Sour Slice Fish', 'Sweet_Sour_Slice_Fish', 494.00, 520.00, 5, 20, 2, '1:2', 'No', 'Active', 1, '2024-09-26 12:01:35', 1, '2024-10-20 06:25:58', NULL, NULL, '2024-09-26 06:01:35', '2024-10-20 00:25:58', 1060),
(59, '000041', 'Prawn Masala', 'Prawn_Masala', 456.00, 480.00, 5, 21, 2, 'Flavorful dish made with fresh prawns & spices', 'No', 'Active', 1, '2024-09-26 12:02:27', NULL, NULL, NULL, NULL, '2024-09-26 06:02:27', '2024-09-26 06:02:27', 1061),
(60, '000042', 'Sweet & Sour Prawn', 'Sweet_Sour_Prawn', 750.00, 750.00, 0, 21, 2, NULL, 'No', 'Active', 1, '2024-09-26 12:03:11', NULL, NULL, NULL, NULL, '2024-09-26 06:03:11', '2024-09-26 06:03:11', 1062),
(61, '000043', 'Chicken Sizzlers', 'Chicken_Sizzlers', 712.50, 750.00, 5, 22, 2, '1:3', 'No', 'Active', 1, '2024-09-26 12:11:36', NULL, NULL, NULL, NULL, '2024-09-26 06:11:36', '2024-09-26 06:11:36', 1065),
(62, '000044', 'Prawn Sizzlers', 'Prawn_Sizzlers', 712.50, 750.00, 5, 22, 2, '1:3', 'No', 'Active', 1, '2024-09-26 12:13:28', NULL, NULL, NULL, NULL, '2024-09-26 06:13:28', '2024-09-26 06:13:28', 1065),
(63, '000045', 'Vegetable Sizzlers', 'Vegetable_Sizzlers', 712.50, 750.00, 5, 22, 2, '1:3', 'No', 'Active', 1, '2024-09-26 12:16:21', NULL, NULL, NULL, NULL, '2024-09-26 06:16:21', '2024-09-26 06:16:21', 1067),
(64, '000046', 'Chicken Fried Rice', 'Chicken_Fried_Rice', 427.50, 450.00, 5, 23, 2, '1:3', 'No', 'Active', 1, '2024-10-07 11:48:50', NULL, NULL, NULL, NULL, '2024-10-07 05:48:50', '2024-10-07 05:48:50', 1001),
(65, '000047', 'Beef Fried Rice', 'Beef_Fried_Rice', 427.50, 450.00, 5, 23, 2, '1:2', 'No', 'Active', 1, '2024-10-07 11:49:29', NULL, NULL, NULL, NULL, '2024-10-07 05:49:29', '2024-10-07 05:49:29', 1006),
(66, '000048', 'Strawberry Drink', 'Strawberry_Drink', 332.50, 350.00, 5, 7, 2, '1:1', 'No', 'Active', 1, '2024-10-07 12:13:33', NULL, NULL, NULL, NULL, '2024-10-07 06:13:33', '2024-10-07 06:13:33', 10054),
(67, '000049', 'Cocacola', 'Cocacola', 114.00, 120.00, 5, 7, 2, '1:2', 'No', 'Active', 1, '2024-10-07 12:15:47', NULL, NULL, NULL, NULL, '2024-10-07 06:15:47', '2024-10-07 06:15:47', 10541),
(68, '000050', 'Pizza', 'Pizza', 532.00, 560.00, 5, 2, 2, '1:3', 'No', 'Active', 1, '2024-10-07 12:44:44', NULL, NULL, NULL, NULL, '2024-10-07 06:44:44', '2024-10-07 06:44:44', 1056),
(69, '000051', 'special Egg Burger', 'special_Egg_Burger', 375.00, 750.00, 50, 2, 2, '1:2', 'No', 'Active', 1, '2024-10-07 13:04:26', 1, '2024-12-17 12:55:15', NULL, NULL, '2024-10-07 07:04:26', '2024-12-17 06:55:15', 10257);

-- --------------------------------------------------------

--
-- Table structure for table `menu_images`
--

CREATE TABLE `menu_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_images`
--

INSERT INTO `menu_images` (`id`, `menu_id`, `image`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 1, '1725961287kolkataStyleChikenBiriyani.webp', 'Yes', 'Inactive', NULL, NULL, NULL, NULL, 1, '2024-09-26 12:29:57', '2024-09-10 03:41:28', '2024-09-26 06:29:57'),
(2, 1, '1725961288kozhikode-chicken-biriyani-500x500.jpg', 'Yes', 'Inactive', NULL, NULL, NULL, NULL, 1, '2024-09-26 12:25:35', '2024-09-10 03:41:28', '2024-09-26 06:25:35'),
(3, 1, '1725961288kozhikodan-biriyani-recipe.1024x1024-2.webp', 'Yes', 'Inactive', NULL, NULL, NULL, NULL, 1, '2024-09-26 12:25:32', '2024-09-10 03:41:28', '2024-09-26 06:25:32'),
(4, 2, '1725961752khashi-gnta.webp', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-10 03:49:13', '2024-09-10 03:49:13'),
(5, 21, '1727344104istockphoto-1168757137-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 03:48:24', '2024-09-26 03:48:24'),
(6, 22, '1727344243istockphoto-1252817533-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 03:50:43', '2024-09-26 03:50:43'),
(7, 23, '1727344463istockphoto-1209399006-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 03:54:24', '2024-09-26 03:54:24'),
(8, 24, '1727344521istockphoto-1442171151-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 03:55:21', '2024-09-26 03:55:21'),
(9, 25, '1727344804istockphoto-1070938206-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:00:04', '2024-09-26 04:00:04'),
(10, 26, '1727345388istockphoto-1142610514-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:09:48', '2024-09-26 04:09:48'),
(11, 27, '1727345624istockphoto-1498747452-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:13:44', '2024-09-26 04:13:44'),
(12, 28, '1727345711istockphoto-1490357284-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:15:11', '2024-09-26 04:15:11'),
(13, 29, '1727345850istockphoto-1314329942-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:17:30', '2024-09-26 04:17:30'),
(14, 30, '1727345911istockphoto-1323098892-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:18:31', '2024-09-26 04:18:31'),
(15, 31, '1727346056istockphoto-475712608-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:20:56', '2024-09-26 04:20:56'),
(16, 32, '1727346213istockphoto-952113608-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:23:33', '2024-09-26 04:23:33'),
(17, 33, '1727346299istockphoto-1223807121-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:24:59', '2024-09-26 04:24:59'),
(18, 34, '1727346349istockphoto-888366454-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:25:49', '2024-09-26 04:25:49'),
(19, 35, '1727347292istockphoto-499742048-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:41:32', '2024-09-26 04:41:32'),
(20, 36, '1727347361istockphoto-623301114-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:42:41', '2024-09-26 04:42:41'),
(21, 37, '1727347619istockphoto-1336787701-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:47:00', '2024-09-26 04:47:00'),
(22, 38, '1727347707istockphoto-1371009161-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:48:27', '2024-09-26 04:48:27'),
(23, 39, '1727347771istockphoto-1430638312-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:49:32', '2024-09-26 04:49:32'),
(24, 40, '1727347870istockphoto-1156896083-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:51:10', '2024-09-26 04:51:10'),
(25, 41, '1727347958istockphoto-1425200827-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:52:39', '2024-09-26 04:52:39'),
(26, 42, '1727348018istockphoto-1150376593-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:53:38', '2024-09-26 04:53:38'),
(27, 43, '1727348176istockphoto-1140752821-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:56:16', '2024-09-26 04:56:16'),
(28, 44, '1727348237istockphoto-953514746-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 04:57:17', '2024-09-26 04:57:17'),
(29, 45, '1727348487istockphoto-1447752296-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:01:27', '2024-09-26 05:01:27'),
(30, 46, '1727348547istockphoto-1186759792-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:02:27', '2024-09-26 05:02:27'),
(31, 47, '1727348664istockphoto-1081826742-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:04:24', '2024-09-26 05:04:24'),
(32, 48, '1727348775istockphoto-1254011998-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:06:15', '2024-09-26 05:06:15'),
(33, 49, '1727348865istockphoto-1327746667-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:07:45', '2024-09-26 05:07:45'),
(34, 50, '1727348939istockphoto-588595864-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:08:59', '2024-09-26 05:08:59'),
(35, 51, '1727349006istockphoto-153953887-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:10:06', '2024-09-26 05:10:06'),
(36, 52, '1727349071istockphoto-1408338331-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:11:11', '2024-09-26 05:11:11'),
(37, 53, '1727349135istockphoto-1251156449-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:12:15', '2024-09-26 05:12:15'),
(38, 54, '1727351279istockphoto-1152132428-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:47:59', '2024-09-26 05:47:59'),
(39, 55, '1727351350istockphoto-503680624-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:49:10', '2024-09-26 05:49:10'),
(40, 56, '1727351978istockphoto-1086053800-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 05:59:38', '2024-09-26 05:59:38'),
(41, 57, '1727352033istockphoto-1436674598-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:00:33', '2024-09-26 06:00:33'),
(42, 58, '1727352095istockphoto-1363269707-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:01:35', '2024-09-26 06:01:35'),
(43, 59, '1727352147istockphoto-2043767125-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:02:27', '2024-09-26 06:02:27'),
(44, 60, '1727352191istockphoto-1425381962-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:03:11', '2024-09-26 06:03:11'),
(45, 61, '1727352696istockphoto-1429338797-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:11:36', '2024-09-26 06:11:36'),
(46, 62, '1727352808istockphoto-1145939510-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:13:28', '2024-09-26 06:13:28'),
(47, 63, '1727352981istockphoto-1429338813-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:16:21', '2024-09-26 06:16:21'),
(48, 1, '1727353801istockphoto-1716976168-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-26 06:30:01', '2024-09-26 06:30:01'),
(49, 64, '1728301730istockphoto-483676117-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 05:48:50', '2024-10-07 05:48:50'),
(50, 65, '1728301769istockphoto-960867816-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 05:49:29', '2024-10-07 05:49:29'),
(51, 66, '1728303213istockphoto-1395736637-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 06:13:33', '2024-10-07 06:13:33'),
(52, 67, '1728303347istockphoto-936008054-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 06:15:47', '2024-10-07 06:15:47'),
(53, 68, '1728305084istockphoto-943449226-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 06:44:45', '2024-10-07 06:44:45'),
(54, 69, '1728306266istockphoto-1223816195-612x612.jpg', 'No', 'Active', NULL, NULL, NULL, NULL, NULL, NULL, '2024-10-07 07:04:26', '2024-10-07 07:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `menu_specifications`
--

CREATE TABLE `menu_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) DEFAULT NULL,
  `text` longtext DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_specifications`
--

INSERT INTO `menu_specifications` (`id`, `menu_id`, `text`, `value`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'a', '1', 'Yes', 'Inactive', 1, '2024-09-10 09:41:27', NULL, NULL, 1, '2024-09-26 12:25:45', '2024-09-10 03:41:27', '2024-09-26 06:25:45'),
(2, 1, 'b', '2', 'Yes', 'Inactive', 1, '2024-09-10 09:41:27', NULL, NULL, 1, '2024-09-26 12:25:39', '2024-09-10 03:41:27', '2024-09-26 06:25:39'),
(3, 1, 'c', '3', 'Yes', 'Inactive', 1, '2024-09-10 09:41:27', NULL, NULL, 1, '2024-09-26 12:25:42', '2024-09-10 03:41:27', '2024-09-26 06:25:42'),
(4, 2, '', '', 'No', 'Active', 1, '2024-09-10 09:49:12', NULL, NULL, NULL, NULL, '2024-09-10 03:49:12', '2024-09-10 03:49:12'),
(23, 21, '', '', 'No', 'Active', 1, '2024-09-26 09:48:24', NULL, NULL, NULL, NULL, '2024-09-26 03:48:24', '2024-09-26 03:48:24'),
(24, 22, '', '', 'No', 'Active', 1, '2024-09-26 09:50:43', NULL, NULL, NULL, NULL, '2024-09-26 03:50:43', '2024-09-26 03:50:43'),
(25, 23, '', '', 'No', 'Active', 1, '2024-09-26 09:54:23', NULL, NULL, NULL, NULL, '2024-09-26 03:54:23', '2024-09-26 03:54:23'),
(26, 24, '', '', 'No', 'Active', 1, '2024-09-26 09:55:21', NULL, NULL, NULL, NULL, '2024-09-26 03:55:21', '2024-09-26 03:55:21'),
(27, 25, '', '', 'No', 'Active', 1, '2024-09-26 10:00:04', NULL, NULL, NULL, NULL, '2024-09-26 04:00:04', '2024-09-26 04:00:04'),
(28, 26, '', '', 'No', 'Active', 1, '2024-09-26 10:09:48', NULL, NULL, NULL, NULL, '2024-09-26 04:09:48', '2024-09-26 04:09:48'),
(29, 27, '', '', 'No', 'Active', 1, '2024-09-26 10:13:44', NULL, NULL, NULL, NULL, '2024-09-26 04:13:44', '2024-09-26 04:13:44'),
(30, 28, '', '', 'No', 'Active', 1, '2024-09-26 10:15:11', NULL, NULL, NULL, NULL, '2024-09-26 04:15:11', '2024-09-26 04:15:11'),
(31, 29, '', '', 'No', 'Active', 1, '2024-09-26 10:17:30', NULL, NULL, NULL, NULL, '2024-09-26 04:17:30', '2024-09-26 04:17:30'),
(32, 30, '', '', 'No', 'Active', 1, '2024-09-26 10:18:31', NULL, NULL, NULL, NULL, '2024-09-26 04:18:31', '2024-09-26 04:18:31'),
(33, 31, '', '', 'No', 'Active', 1, '2024-09-26 10:20:56', NULL, NULL, NULL, NULL, '2024-09-26 04:20:56', '2024-09-26 04:20:56'),
(34, 32, '', '', 'No', 'Active', 1, '2024-09-26 10:23:33', NULL, NULL, NULL, NULL, '2024-09-26 04:23:33', '2024-09-26 04:23:33'),
(35, 33, '', '', 'No', 'Active', 1, '2024-09-26 10:24:59', NULL, NULL, NULL, NULL, '2024-09-26 04:24:59', '2024-09-26 04:24:59'),
(36, 34, '', '', 'No', 'Active', 1, '2024-09-26 10:25:49', NULL, NULL, NULL, NULL, '2024-09-26 04:25:49', '2024-09-26 04:25:49'),
(37, 35, '', '', 'No', 'Active', 1, '2024-09-26 10:41:32', NULL, NULL, NULL, NULL, '2024-09-26 04:41:32', '2024-09-26 04:41:32'),
(38, 36, '', '', 'No', 'Active', 1, '2024-09-26 10:42:41', NULL, NULL, NULL, NULL, '2024-09-26 04:42:41', '2024-09-26 04:42:41'),
(39, 37, '', '', 'No', 'Active', 1, '2024-09-26 10:46:59', NULL, NULL, NULL, NULL, '2024-09-26 04:46:59', '2024-09-26 04:46:59'),
(40, 38, '', '', 'No', 'Active', 1, '2024-09-26 10:48:27', NULL, NULL, NULL, NULL, '2024-09-26 04:48:27', '2024-09-26 04:48:27'),
(41, 39, '', '', 'No', 'Active', 1, '2024-09-26 10:49:31', NULL, NULL, NULL, NULL, '2024-09-26 04:49:31', '2024-09-26 04:49:31'),
(42, 40, '', '', 'No', 'Active', 1, '2024-09-26 10:51:10', NULL, NULL, NULL, NULL, '2024-09-26 04:51:10', '2024-09-26 04:51:10'),
(43, 41, '', '', 'No', 'Active', 1, '2024-09-26 10:52:38', NULL, NULL, NULL, NULL, '2024-09-26 04:52:38', '2024-09-26 04:52:38'),
(44, 42, '', '', 'No', 'Active', 1, '2024-09-26 10:53:38', NULL, NULL, NULL, NULL, '2024-09-26 04:53:38', '2024-09-26 04:53:38'),
(45, 43, '', '', 'No', 'Active', 1, '2024-09-26 10:56:15', NULL, NULL, NULL, NULL, '2024-09-26 04:56:15', '2024-09-26 04:56:15'),
(46, 44, '', '', 'No', 'Active', 1, '2024-09-26 10:57:17', NULL, NULL, NULL, NULL, '2024-09-26 04:57:17', '2024-09-26 04:57:17'),
(47, 45, '', '', 'No', 'Active', 1, '2024-09-26 11:01:27', NULL, NULL, NULL, NULL, '2024-09-26 05:01:27', '2024-09-26 05:01:27'),
(48, 46, '', '', 'No', 'Active', 1, '2024-09-26 11:02:27', NULL, NULL, NULL, NULL, '2024-09-26 05:02:27', '2024-09-26 05:02:27'),
(49, 47, '', '', 'No', 'Active', 1, '2024-09-26 11:04:24', NULL, NULL, NULL, NULL, '2024-09-26 05:04:24', '2024-09-26 05:04:24'),
(50, 48, '', '', 'No', 'Active', 1, '2024-09-26 11:06:15', NULL, NULL, NULL, NULL, '2024-09-26 05:06:15', '2024-09-26 05:06:15'),
(51, 49, '', '', 'No', 'Active', 1, '2024-09-26 11:07:45', NULL, NULL, NULL, NULL, '2024-09-26 05:07:45', '2024-09-26 05:07:45'),
(52, 50, '', '', 'No', 'Active', 1, '2024-09-26 11:08:59', NULL, NULL, NULL, NULL, '2024-09-26 05:08:59', '2024-09-26 05:08:59'),
(53, 51, '', '', 'No', 'Active', 1, '2024-09-26 11:10:06', NULL, NULL, NULL, NULL, '2024-09-26 05:10:06', '2024-09-26 05:10:06'),
(54, 52, '', '', 'No', 'Active', 1, '2024-09-26 11:11:11', NULL, NULL, NULL, NULL, '2024-09-26 05:11:11', '2024-09-26 05:11:11'),
(55, 53, '', '', 'No', 'Active', 1, '2024-09-26 11:12:15', NULL, NULL, NULL, NULL, '2024-09-26 05:12:15', '2024-09-26 05:12:15'),
(56, 54, '', '', 'No', 'Active', 1, '2024-09-26 11:47:59', NULL, NULL, NULL, NULL, '2024-09-26 05:47:59', '2024-09-26 05:47:59'),
(57, 55, '', '', 'No', 'Active', 1, '2024-09-26 11:49:10', NULL, NULL, NULL, NULL, '2024-09-26 05:49:10', '2024-09-26 05:49:10'),
(58, 56, '', '', 'No', 'Active', 1, '2024-09-26 11:59:38', NULL, NULL, NULL, NULL, '2024-09-26 05:59:38', '2024-09-26 05:59:38'),
(59, 57, '', '', 'No', 'Active', 1, '2024-09-26 12:00:33', NULL, NULL, NULL, NULL, '2024-09-26 06:00:33', '2024-09-26 06:00:33'),
(60, 58, '', '', 'No', 'Active', 1, '2024-09-26 12:01:35', NULL, NULL, NULL, NULL, '2024-09-26 06:01:35', '2024-09-26 06:01:35'),
(61, 59, '', '', 'No', 'Active', 1, '2024-09-26 12:02:27', NULL, NULL, NULL, NULL, '2024-09-26 06:02:27', '2024-09-26 06:02:27'),
(62, 60, '', '', 'No', 'Active', 1, '2024-09-26 12:03:11', NULL, NULL, NULL, NULL, '2024-09-26 06:03:11', '2024-09-26 06:03:11'),
(63, 61, '', '', 'No', 'Active', 1, '2024-09-26 12:11:36', NULL, NULL, NULL, NULL, '2024-09-26 06:11:36', '2024-09-26 06:11:36'),
(64, 62, '', '', 'No', 'Active', 1, '2024-09-26 12:13:28', NULL, NULL, NULL, NULL, '2024-09-26 06:13:28', '2024-09-26 06:13:28'),
(65, 63, '', '', 'No', 'Active', 1, '2024-09-26 12:16:21', NULL, NULL, NULL, NULL, '2024-09-26 06:16:21', '2024-09-26 06:16:21'),
(66, 64, '', '', 'No', 'Active', 1, '2024-10-07 11:48:50', NULL, NULL, NULL, NULL, '2024-10-07 05:48:50', '2024-10-07 05:48:50'),
(67, 65, '', '', 'No', 'Active', 1, '2024-10-07 11:49:29', NULL, NULL, NULL, NULL, '2024-10-07 05:49:29', '2024-10-07 05:49:29'),
(68, 66, '', '', 'No', 'Active', 1, '2024-10-07 12:13:33', NULL, NULL, NULL, NULL, '2024-10-07 06:13:33', '2024-10-07 06:13:33'),
(69, 67, '', '', 'No', 'Active', 1, '2024-10-07 12:15:47', NULL, NULL, NULL, NULL, '2024-10-07 06:15:47', '2024-10-07 06:15:47'),
(70, 68, '', '', 'No', 'Active', 1, '2024-10-07 12:44:44', NULL, NULL, NULL, NULL, '2024-10-07 06:44:44', '2024-10-07 06:44:44'),
(71, 69, '', '', 'No', 'Active', 1, '2024-10-07 13:04:26', NULL, NULL, NULL, NULL, '2024-10-07 07:04:26', '2024-10-07 07:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_04_12_154957_create_permission_tables', 1),
(6, '2023_10_26_111819_tbl_crm_parties', 1),
(7, '2023_10_26_112841_tbl_inventory_products', 1),
(8, '2023_10_26_120000_tbl_inventory_damage_products', 1),
(9, '2023_10_26_121213_tbl_inventory_sale_orders', 1),
(10, '2023_10_28_103035_tbl_settings_company_settings', 1),
(11, '2023_10_30_112651_tbl_voucher_payment_voucher', 1),
(12, '2023_10_30_131837_tbl_purchases', 1),
(13, '2023_11_01_094159_tbl_setups_categories', 1),
(14, '2023_11_01_103238_tbl_setups_brands', 1),
(15, '2023_11_01_103244_tbl_setups_units', 1),
(16, '2023_11_01_103309_tbl_setups_damage_products', 1),
(17, '2023_11_01_105759_tbl_inventory_product_specification', 1),
(18, '2023_11_01_110044_tbl_inventory_serialize_products', 1),
(19, '2023_11_01_110229_tbl_setups_warehouses', 1),
(20, '2023_11_05_111342_tbl_accounts_coas', 1),
(21, '2023_11_05_130754_tbl_purchase_products', 1),
(22, '2023_11_05_132021_tbl_accounts_vouchers', 1),
(23, '2023_11_05_132042_tbl_accounts_voucher_details', 1),
(24, '2023_11_06_065255_tbl_floor', 1),
(25, '2023_11_09_071029_tbl_facilities', 1),
(26, '2023_11_09_071236_tbl_images', 1),
(27, '2023_11_09_122626_tbl_setups_sister_concern_to_warehouses', 1),
(28, '2023_11_09_122846_tbl_hotel_management_room_floor_and_warehouse', 1),
(29, '2023_11_11_125932_tbl_room_facilities', 1),
(30, '2023_11_12_081233_tbl_setups_sisterconcern_categories', 1),
(31, '2023_11_13_102531_create_tbl_booking_table', 1),
(32, '2023_11_14_114617_create_tbl_booking_details_table', 1),
(33, '2023_11_20_052712_create_tbl_building_table', 1),
(34, '2023_12_14_075438_create_tbl_asset_assign_table', 1),
(35, '2023_12_17_112700_create_tbl_asset_shift_table', 1),
(36, '2024_02_06_055031_create_tbl_boy_assign_table', 2),
(37, '2024_02_06_072255_create_our_teams_table', 3),
(38, '2024_02_06_072255_create_tbl_employee_table', 4),
(39, '2024_08_25_063908_create_menus_table', 4),
(40, '2024_08_25_063922_create_tables_table', 4),
(41, '2024_08_25_063950_create_menu_specifications_table', 4),
(42, '2024_09_05_103032_create_menu_images_table', 5),
(43, '2024_09_10_095134_create_orders_table', 6),
(44, '2024_09_10_095145_create_order_details_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_id` bigint(20) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `order_token` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `room_id` bigint(20) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `waiter_id` bigint(20) DEFAULT NULL,
  `present_status` enum('Running','Desposed','Pending','Concelled') DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `alternate_contact` varchar(255) DEFAULT NULL,
  `credit_limit` decimal(10,2) NOT NULL,
  `party_type` enum('Supplier','Customer','Walkin_Customer','Both') NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `country_name` varchar(20) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `customer_type` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `current_due` decimal(10,2) DEFAULT 0.00,
  `opening_due` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `code`, `address`, `contact`, `alternate_contact`, `credit_limit`, `party_type`, `contact_person`, `email`, `country_name`, `district`, `customer_type`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`, `current_due`, `opening_due`) VALUES
(1, 'SALMAN FARSI', '000001', 'LALALAL', '0171111111111', NULL, 1000000.00, 'Customer', 'Salman Farsi', 'ssj@kjjjakjk.com', 'Bangladesh', 'Chittagong', 'Customer', 'Active', 'No', 1, '2024-03-06', 1, '2024-03-06 17:12:05', NULL, NULL, '2024-03-06 23:10:08', '2024-03-06 23:12:40', 0.00, 0.00),
(2, 'BSRM WIRES LTD.', '000001', 'Sadarghat', '01730784826', NULL, 0.00, 'Supplier', 'Afzal Hussain', 'afzal.hossain@bsrmwires.com', 'Bangladesh', 'Chittagong', 'Cash', 'Active', 'No', 8, '2024-03-06', NULL, NULL, NULL, NULL, '2024-03-07 01:04:42', '2024-03-13 15:37:18', -63850.10, 0.00),
(3, 'Mr. Shoaib', '000001', 'ctg', '01823835334', '01823835334', 0.00, 'Walkin_Customer', NULL, NULL, NULL, NULL, NULL, 'Active', 'No', 1, '2024-03-09', NULL, NULL, NULL, NULL, '2024-03-09 21:57:40', '2024-03-09 21:57:40', 0.00, 0.00),
(4, 'Quality Belt House', '000002', '104/106, Nawabpur Road, Imperial Super Market, Shop No. D14, Dhaka-1100', '01766240252', '029511558, 01973-171218', 300000.00, 'Supplier', 'No Name', 'proprietorqsc@gmail.com', 'Bangladesh', 'Chittagong', 'Regular', 'Active', 'No', 8, '2024-03-10', NULL, NULL, NULL, NULL, '2024-03-10 16:39:58', '2024-03-10 16:41:44', -10174.50, 0.00),
(5, 'BSRM KEW Nasirabad', '000002', 'Nasirabad', '01234567891', NULL, 500000.00, 'Customer', 'No Name', 'noemail@gmail.com', 'Bangladesh', 'Chittagong', 'Regular', 'Active', 'No', 8, '2024-03-10', NULL, NULL, NULL, NULL, '2024-03-10 16:44:13', '2024-03-10 19:31:54', 15435.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `status`, `deleted`, `deleted_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'dashboard', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:49', NULL, '2024-02-10 05:04:49'),
(2, 'dashboard.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:49', NULL, '2024-02-10 05:04:49'),
(3, 'user', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:49', NULL, '2024-02-10 05:04:49'),
(4, 'user.create', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:49', NULL, '2024-02-10 05:04:49'),
(5, 'user.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:49', NULL, '2024-02-10 05:04:49'),
(6, 'user.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(7, 'user.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(8, 'user.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(9, 'user.changePassword', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(10, 'role', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(11, 'role.create', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(12, 'role.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(13, 'role.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(14, 'role.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(15, 'role.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(16, 'permission', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(17, 'permission.create', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(18, 'permission.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(19, 'permission.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(20, 'permission.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(21, 'permission.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(22, 'permission.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(23, 'permissionToRole', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(24, 'permissionToRole.create', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(25, 'permissionToRole.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(26, 'permissionToRole.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(27, 'permissionToRole.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(28, 'Setting', 'web', 'Setting', 'Active', 'No', NULL, '2024-02-10 05:04:50', 1, '2024-02-10 05:39:30'),
(29, 'companySetting', 'web', 'Setting', 'Active', 'No', NULL, '2024-02-10 05:04:50', 1, '2024-02-10 05:39:44'),
(30, 'companySetting.view', 'web', 'Setting', 'Active', 'No', NULL, '2024-02-10 05:04:50', 1, '2024-02-10 05:40:23'),
(31, 'companySetting.edit', 'web', 'Setting', 'Active', 'No', NULL, '2024-02-10 05:04:50', 1, '2024-02-10 05:40:44'),
(32, 'companySetting.update', 'web', 'Setting', 'Active', 'No', NULL, '2024-02-10 05:04:50', 1, '2024-02-10 05:40:58'),
(33, 'categories', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(34, 'categories.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(35, 'categories.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(36, 'categories.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(37, 'categories.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(38, 'categories.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(39, 'brands', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(40, 'brands.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(41, 'brands.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(42, 'brands.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(43, 'brands.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(44, 'brands.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(45, 'units', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(46, 'units.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(47, 'units.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(48, 'units.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(49, 'units.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(50, 'units.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(51, 'warehouse', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(52, 'warehouse.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(53, 'warehouse.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(54, 'warehouse.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(55, 'warehouse.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(56, 'warehouse.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(57, 'products', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(58, 'products.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:50', NULL, '2024-02-10 05:04:50'),
(59, 'products.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(60, 'products.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(61, 'products.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(62, 'products.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(63, 'purchase', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(64, 'purchase.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(65, 'purchase.add', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(66, 'purchase.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(67, 'sale', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(68, 'sale.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(69, 'sale.add', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(70, 'sale.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(71, 'damage', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(72, 'damage.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(73, 'damage.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(74, 'damage.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(75, 'transport', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(76, 'transport.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(77, 'transport.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(78, 'transport.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(79, 'transport.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(80, 'transport.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(81, 'PaymentVoucher', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(82, 'PaymentVoucher.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(83, 'PaymentVoucher.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(84, 'PaymentVoucher.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(85, 'PaymentVoucher.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(86, 'PaymentVoucher.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(87, 'PaymentReceiveVoucher', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(88, 'PaymentReceiveVoucher.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(89, 'PaymentReceiveVoucher.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(90, 'PaymentReceiveVoucher.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(91, 'PaymentReceiveVoucher.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:51', NULL, '2024-02-10 05:04:51'),
(92, 'PaymentReceiveVoucher.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(93, 'DiscountVoucher', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(94, 'DiscountVoucher.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(95, 'DiscountVoucher.store', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(96, 'DiscountVoucher.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(97, 'DiscountVoucher.update', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(98, 'DiscountVoucher.delete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(99, 'saleService', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(100, 'saleService.view', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(101, 'saleService.add', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(102, 'saleService.edit', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(103, 'saleService.statusComplete', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52'),
(104, 'saleService.createOrderToWalkinSale', 'web', NULL, 'Active', 'No', NULL, '2024-02-10 05:04:52', NULL, '2024-02-10 05:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product_returns`
--

CREATE TABLE `purchase_product_returns` (
  `id` bigint(20) NOT NULL,
  `purchase_product_id` bigint(20) DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `purchase_return_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `return_qty` int(11) DEFAULT NULL,
  `remaining_qty` bigint(20) DEFAULT NULL,
  `unit_price` bigint(20) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `sisterConcern_id` bigint(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(11) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL,
  `deleted_date` date DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_product_returns`
--

INSERT INTO `purchase_product_returns` (`id`, `purchase_product_id`, `purchase_id`, `purchase_return_id`, `product_id`, `warehouse_id`, `return_qty`, `remaining_qty`, `unit_price`, `total_price`, `sisterConcern_id`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted`, `deleted_date`, `created_date`, `deleted_by`) VALUES
(11, 8, 8, 11, 13, 10, 5, 5, 10, 50.00, NULL, '2024-11-27 04:59:07', '2024-11-27 04:59:07', 1, NULL, 'No', NULL, '2024-11-27 10:59:07', NULL),
(12, 8, 8, 12, 13, 9, 1, 4, 10, 10.00, NULL, '2024-11-27 05:09:28', '2024-11-27 05:09:28', 1, NULL, 'No', NULL, '2024-11-27 11:09:28', NULL),
(13, 8, 8, 13, 13, 8, 1, 3, 10, 10.00, NULL, '2024-11-28 06:01:49', '2024-11-28 00:01:49', 1, NULL, 'Yes', '2024-11-28', '2024-11-27 11:23:54', 1),
(14, 7, 7, 14, 13, 6, 2, 8, 10, 20.00, NULL, '2024-11-27 12:34:46', '2024-11-27 06:34:46', 1, NULL, 'Yes', '2024-11-27', '2024-11-27 12:22:57', 1),
(15, 7, 7, 15, 13, 5, 5, 5, 10, 50.00, NULL, '2024-11-27 12:38:07', '2024-11-27 06:38:07', 1, NULL, 'Yes', '2024-11-27', '2024-11-27 12:37:42', 1),
(16, 9, 9, 16, 14, 2, 5, 5, 10, 50.00, NULL, '2024-11-27 13:11:14', '2024-11-27 07:11:14', 1, NULL, 'Yes', '2024-11-27', '2024-11-27 13:10:47', 1),
(18, 10, 10, 20, 15, NULL, 5, 5, 370, 1850.00, NULL, '2024-11-28 06:08:51', '2024-11-28 00:08:51', 1, NULL, 'Yes', '2024-11-28', '2024-11-28 06:07:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) NOT NULL,
  `purchase_return_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_no` varchar(255) DEFAULT NULL,
  `purchase_return_date` date DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `coa_id` bigint(20) NOT NULL,
  `supplier_id` varchar(255) DEFAULT NULL,
  `discount` bigint(20) DEFAULT NULL,
  `grand_total` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `update_by` bigint(20) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` date DEFAULT NULL,
  `from_warehouse` bigint(20) DEFAULT 0,
  `sisterConcern_id` bigint(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `purchase_return_no`, `purchase_no`, `purchase_return_date`, `purchase_date`, `purchase_id`, `coa_id`, `supplier_id`, `discount`, `grand_total`, `status`, `created_at`, `updated_at`, `created_by`, `update_by`, `deleted`, `deleted_by`, `deleted_date`, `from_warehouse`, `sisterConcern_id`) VALUES
(11, '000001', '000007', '2024-11-27', '2024-11-27', 8, 12, '1', NULL, 50, 'Active', '2024-11-27 04:59:07', '2024-11-27 04:59:07', 1, NULL, 'No', NULL, NULL, 10, NULL),
(12, '000002', '000007', '2024-11-27', '2024-11-27', 8, 12, '1', NULL, 10, 'Active', '2024-11-27 05:09:28', '2024-11-27 05:09:28', 1, NULL, 'No', NULL, NULL, 9, NULL),
(13, '000003', '000007', '2024-11-27', '2024-11-27', 8, 12, '1', NULL, 10, 'Active', '2024-11-27 05:23:54', '2024-11-28 00:01:49', 1, NULL, 'Yes', 1, '2024-11-28', 8, 2),
(14, '000004', '000006', '2024-11-27', '2024-11-27', 7, 12, '1', NULL, 20, 'Active', '2024-11-27 06:22:57', '2024-11-27 06:34:46', 1, NULL, 'Yes', 1, '2024-11-27', 6, 2),
(15, '000005', '000006', '2024-11-27', '2024-11-27', 7, 12, '1', NULL, 50, 'Active', '2024-11-27 06:37:42', '2024-11-27 06:38:07', 1, NULL, 'Yes', 1, '2024-11-27', 5, 2),
(16, '000006', '000008', '2024-11-27', '2024-11-27', 9, 12, '1', NULL, 50, 'Active', '2024-11-27 07:10:47', '2024-11-27 07:11:14', 1, NULL, 'Yes', 1, '2024-11-27', 2, 2),
(20, '000007', '000009', '2024-11-28', '2024-11-28', 10, 12, '1', NULL, 1850, 'Active', '2024-11-28 00:07:53', '2024-11-28 00:08:51', 1, NULL, 'Yes', 1, '2024-11-28', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `status`, `deleted`, `created_at`, `updated_at`) VALUES
(2, 'Super Admin', 'web', 'Active', 'No', '2024-02-10 05:04:49', '2024-02-10 05:04:49'),
(3, 'Manager', 'web', 'Active', 'No', '2024-02-10 05:04:49', '2024-02-10 05:04:49'),
(4, 'Sales Man', 'web', 'Active', 'No', '2024-02-10 05:04:49', '2024-02-10 05:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `building_id` bigint(20) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `asset_product_category_id` bigint(20) DEFAULT NULL,
  `asset_product_id` bigint(20) DEFAULT NULL,
  `capacity` bigint(20) DEFAULT NULL,
  `present_status` enum('Occupied','Available','Out Of Order') DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `code`, `name`, `slug`, `image`, `building_id`, `warehouse_id`, `sister_concern_id`, `asset_product_category_id`, `asset_product_id`, `capacity`, `present_status`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '000001', 'Table 1', 'Table_1', '1734609080table img2.jpg', 1, 1, 2, 28, 1, 6, 'Available', 'No', 'Active', 1, '2024-09-10 09:13:42', 1, '2024-12-19 11:51:20', NULL, NULL, '2024-09-10 03:13:42', '2024-12-19 05:51:20'),
(2, '000002', 'Table 2', 'Table_2', '1734609151tableimg2.jpg', 1, 1, 2, 28, 2, 6, 'Available', 'No', 'Active', 1, '2024-09-10 09:14:15', 1, '2024-12-19 11:52:31', NULL, NULL, '2024-09-10 03:14:15', '2024-12-19 05:52:31'),
(3, '000003', 'Table 3', 'Table_3', '1734609159imggg3.jpg', 1, 1, 2, 28, 3, 6, 'Available', 'No', 'Active', 1, '2024-09-10 09:14:35', 1, '2024-12-19 11:52:39', NULL, NULL, '2024-09-10 03:14:35', '2024-12-19 05:52:39'),
(4, '000004', 'Table 4', 'Table_4', '1738235178asdkj.jpg', 1, 1, 2, 28, 4, 7, 'Occupied', 'No', 'Active', 1, '2024-09-10 09:39:42', 1, '2025-01-30 11:06:19', NULL, NULL, '2024-09-10 03:39:42', '2025-01-30 05:06:19'),
(5, '000005', 'Table 5', 'Table_5', '1734010082specialtable.jpg', 1, 1, 2, 28, 5, 7, 'Available', 'No', 'Active', 1, '2024-09-10 09:40:02', 1, '2024-12-12 13:28:02', NULL, NULL, '2024-09-10 03:40:02', '2024-12-12 07:28:02'),
(6, '000006', 'Table 6', 'Table_6', '1726053142img.png', 1, 1, 2, 28, 6, 6, 'Available', 'Yes', 'Inactive', 1, '2024-09-10 09:40:21', 1, '2024-09-11 11:12:23', 1, '2024-12-12 13:26:06', '2024-09-10 03:40:21', '2024-12-12 07:26:06'),
(7, '000007', 'Table 7', 'Table_7', '1726043787pngtree-realistic-transparent-six-chair-big-dinning-table-top-view-for-3d-png-image_6570816.png', 1, 1, 2, 28, 7, 6, 'Out Of Order', 'Yes', 'Inactive', 1, '2024-09-11 08:36:27', 1, '2024-09-11 11:10:21', 1, '2024-12-12 13:25:58', '2024-09-11 02:36:27', '2024-12-12 07:25:58'),
(8, '000008', 'special Table', 'special_Table', '1734009949specialtable.jpg', 2, 3, 2, 28, 1, 12, NULL, 'No', 'Active', 1, '2024-12-12 13:16:54', 1, '2024-12-12 13:25:49', NULL, NULL, '2024-12-12 07:16:54', '2024-12-12 07:25:49'),
(9, '000009', 'Delux', 'Delux', '1734609290img4444.jpg', 2, 4, 2, 28, 1, 6, NULL, 'No', 'Active', 1, '2024-12-19 11:54:50', NULL, NULL, NULL, NULL, '2024-12-19 05:54:50', '2024-12-19 05:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts_coas`
--

CREATE TABLE `tbl_accounts_coas` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `code` bigint(20) DEFAULT NULL,
  `our_code` bigint(20) DEFAULT NULL,
  `limit_from` bigint(20) DEFAULT NULL,
  `limit_to` bigint(20) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `unused` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_accounts_coas`
--

INSERT INTO `tbl_accounts_coas` (`id`, `name`, `slug`, `amount`, `code`, `our_code`, `limit_from`, `limit_to`, `parent_id`, `unused`, `status`, `deleted`, `created_by`, `last_updated_by`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'Asset', 'Asset', 0.00, 100000000, 100000000, 100000000, 199999999, 0, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(2, 'Liability', 'Liability', 0.00, 200000000, 200000000, 200000000, 299999999, 0, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(3, 'Income', 'Income', 0.00, 300000000, 300000000, 300000000, 399999999, 0, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(4, 'Expense', 'Expense', 0.00, 400000000, 400000000, 400000000, 499999999, 0, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(5, 'Bank', 'Bank', 0.00, 500000000, 500000000, 500000000, 599999999, 0, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(6, 'Sales', 'Sales', 0.00, 301000000, 301000000, 301000000, 309900000, 3, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(7, 'Purchase', 'Purchase', 0.00, 401000000, 401000000, 401000000, 409900000, 4, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(8, 'Cash', 'cash', 144763.00, 501000000, 501000000, 501000000, 509900000, 5, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2025-01-09 01:30:43'),
(9, 'Cash Amount', 'cash-amount', 0.00, 501010000, 501010000, 501010000, 501099000, 8, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16'),
(10, 'Discount', 'Discount', 0.00, 502000000, 502000000, 502000000, 509900000, 5, 'No', 'Active', 'No', 0, NULL, NULL, NULL, '2024-02-03 23:37:16', '2024-02-03 23:37:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts_vouchers`
--

CREATE TABLE `tbl_accounts_vouchers` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) DEFAULT NULL,
  `tbl_booking_id` bigint(30) DEFAULT NULL,
  `tbl_resturantOrder_id` bigint(100) DEFAULT NULL,
  `voucher_no` bigint(20) DEFAULT NULL,
  `type_no` bigint(20) DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `payment_voucher_id` bigint(20) NOT NULL DEFAULT 0,
  `from_tbl_id` bigint(20) NOT NULL DEFAULT 0,
  `sister_concern_id` bigint(20) NOT NULL DEFAULT 0,
  `amount` decimal(10,2) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `transaction_date` varchar(255) DEFAULT NULL,
  `voucher_title` varchar(255) DEFAULT NULL,
  `particulars` longtext DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `from_warehouse` bigint(100) DEFAULT 0,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_accounts_vouchers`
--

INSERT INTO `tbl_accounts_vouchers` (`id`, `vendor_id`, `tbl_booking_id`, `tbl_resturantOrder_id`, `voucher_no`, `type_no`, `purchase_id`, `sales_id`, `payment_voucher_id`, `from_tbl_id`, `sister_concern_id`, `amount`, `type`, `transaction_date`, `voucher_title`, `particulars`, `payment_method`, `status`, `from_warehouse`, `deleted`, `created_by`, `created_date`, `last_updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 8, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 3090.00, NULL, '2025-02-01 11:32:30', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-01 11:30:00', NULL, NULL, NULL, NULL, '2025-02-01 05:32:30', '2025-02-01 05:32:30'),
(2, 4, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 280.00, NULL, '2025-02-01 12:41:27', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-01 12:27:00', NULL, NULL, NULL, NULL, '2025-02-01 06:41:27', '2025-02-01 06:41:27'),
(3, 4, NULL, 3, NULL, NULL, NULL, NULL, 0, 0, 0, 6245.00, NULL, '2025-02-01 12:46:57', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-01 12:57:00', NULL, NULL, NULL, NULL, '2025-02-01 06:46:57', '2025-02-01 06:46:57'),
(4, 4, NULL, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 714.00, NULL, '2025-02-01 12:49:38', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-01 12:38:00', NULL, NULL, NULL, NULL, '2025-02-01 06:49:38', '2025-02-01 06:49:38'),
(5, 4, NULL, 5, NULL, NULL, NULL, NULL, 0, 0, 0, 760.00, NULL, '2025-02-01 13:46:39', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-01 01:39:00', NULL, NULL, NULL, NULL, '2025-02-01 07:46:39', '2025-02-01 07:46:39'),
(6, 9, NULL, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 3080.00, NULL, '2025-02-02 07:22:03', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-02 07:03:00', NULL, NULL, NULL, NULL, '2025-02-02 01:22:03', '2025-02-02 01:22:03'),
(7, 10, NULL, 7, NULL, NULL, NULL, NULL, 0, 0, 0, 750.00, NULL, '2025-02-04 08:51:23', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-04 08:23:00', NULL, NULL, NULL, NULL, '2025-02-04 02:51:23', '2025-02-04 02:51:23'),
(8, 11, NULL, 8, NULL, NULL, NULL, NULL, 0, 0, 0, 750.00, NULL, '2025-02-04 08:52:51', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-04 08:51:00', NULL, NULL, NULL, NULL, '2025-02-04 02:52:51', '2025-02-04 02:52:51'),
(9, 12, NULL, 9, NULL, NULL, NULL, NULL, 0, 0, 0, 865.00, NULL, '2025-02-04 10:41:03', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-04 10:03:00', NULL, NULL, NULL, NULL, '2025-02-04 04:41:03', '2025-02-04 04:41:03'),
(10, 13, NULL, 10, NULL, NULL, NULL, NULL, 0, 0, 0, 1400.00, NULL, '2025-02-04 12:00:29', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-04 12:29:00', NULL, NULL, NULL, NULL, '2025-02-04 06:00:29', '2025-02-04 06:00:29'),
(11, 14, NULL, 11, NULL, NULL, NULL, NULL, 0, 0, 0, 280.00, NULL, '2025-02-05 07:01:24', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 07:24:00', NULL, NULL, NULL, NULL, '2025-02-05 01:01:24', '2025-02-05 01:01:24'),
(12, 4, NULL, 12, NULL, NULL, NULL, NULL, 0, 0, 0, 1800.00, NULL, '2025-02-05 07:12:24', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 07:24:00', NULL, NULL, NULL, NULL, '2025-02-05 01:12:24', '2025-02-05 01:12:24'),
(13, 15, NULL, 13, NULL, NULL, NULL, NULL, 0, 0, 0, 1800.00, NULL, '2025-02-05 08:52:41', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 08:41:00', NULL, NULL, NULL, NULL, '2025-02-05 02:52:41', '2025-02-05 02:52:41'),
(14, 16, NULL, 14, NULL, NULL, NULL, NULL, 0, 0, 0, 1800.00, NULL, '2025-02-05 09:02:49', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 09:49:00', NULL, NULL, NULL, NULL, '2025-02-05 03:02:49', '2025-02-05 03:02:49'),
(15, 27, NULL, 25, NULL, NULL, NULL, NULL, 0, 0, 0, 200.00, NULL, '2025-02-05 10:53:12', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 10:12:00', NULL, NULL, NULL, NULL, '2025-02-05 04:53:12', '2025-02-05 04:53:12'),
(16, 28, NULL, 26, NULL, NULL, NULL, NULL, 0, 0, 0, 200.00, NULL, '2025-02-05 10:59:19', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 10:19:00', NULL, NULL, NULL, NULL, '2025-02-05 04:59:19', '2025-02-05 04:59:19'),
(17, 29, NULL, 27, NULL, NULL, NULL, NULL, 0, 0, 0, 420.00, NULL, '2025-02-05 11:09:19', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-05 11:19:00', NULL, NULL, NULL, NULL, '2025-02-05 05:09:19', '2025-02-05 05:09:19'),
(18, 31, NULL, 28, NULL, NULL, NULL, NULL, 0, 0, 0, 2145.00, NULL, '2025-02-06 06:02:55', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 06:55:00', NULL, NULL, NULL, NULL, '2025-02-06 00:02:55', '2025-02-06 00:02:55'),
(19, 36, NULL, 29, NULL, NULL, NULL, NULL, 0, 0, 0, 273.00, NULL, '2025-02-06 09:08:55', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 09:55:00', NULL, NULL, NULL, NULL, '2025-02-06 03:08:55', '2025-02-06 03:08:55'),
(20, 38, NULL, 31, NULL, NULL, NULL, NULL, 0, 0, 0, 290.00, NULL, '2025-02-06 09:14:00', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 09:00:00', NULL, NULL, NULL, NULL, '2025-02-06 03:14:00', '2025-02-06 03:14:00'),
(21, 39, NULL, 32, NULL, NULL, NULL, NULL, 0, 0, 0, 280.00, NULL, '2025-02-06 09:17:25', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 09:25:00', NULL, NULL, NULL, NULL, '2025-02-06 03:17:25', '2025-02-06 03:17:25'),
(22, 40, NULL, 33, NULL, NULL, NULL, NULL, 0, 0, 0, 280.00, NULL, '2025-02-06 09:20:05', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 09:05:00', NULL, NULL, NULL, NULL, '2025-02-06 03:20:05', '2025-02-06 03:20:05'),
(23, 41, NULL, 34, NULL, NULL, NULL, NULL, 0, 0, 0, 930.00, NULL, '2025-02-06 09:36:33', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 09:33:00', NULL, NULL, NULL, NULL, '2025-02-06 03:36:33', '2025-02-06 03:36:33'),
(24, 42, NULL, 35, NULL, NULL, NULL, NULL, 0, 0, 0, 280.00, NULL, '2025-02-06 09:50:32', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 09:32:00', NULL, NULL, NULL, NULL, '2025-02-06 03:50:32', '2025-02-06 03:50:32'),
(25, 3, NULL, 36, NULL, NULL, NULL, NULL, 0, 0, 0, 2220.00, NULL, '2025-02-06 10:20:35', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 10:35:00', NULL, NULL, NULL, NULL, '2025-02-06 04:20:35', '2025-02-06 04:20:35'),
(26, 43, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 280.00, NULL, '2025-02-06 10:59:25', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 10:25:00', NULL, NULL, NULL, NULL, '2025-02-06 04:59:25', '2025-02-06 04:59:25'),
(27, 44, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 1900.00, NULL, '2025-02-06 11:01:22', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 11:22:00', NULL, NULL, NULL, NULL, '2025-02-06 05:01:22', '2025-02-06 05:01:22'),
(28, 45, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 0, 713.00, NULL, '2025-02-06 11:03:53', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 11:53:00', NULL, NULL, NULL, NULL, '2025-02-06 05:03:53', '2025-02-06 05:03:53'),
(29, 46, NULL, 3, NULL, NULL, NULL, NULL, 0, 0, 0, 1062.00, NULL, '2025-02-06 11:32:00', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 11:00:00', NULL, NULL, NULL, NULL, '2025-02-06 05:32:00', '2025-02-06 05:32:00'),
(30, 47, NULL, 4, NULL, NULL, NULL, NULL, 0, 0, 0, 580.00, NULL, '2025-02-06 11:36:42', NULL, NULL, 'Cash', 'Active', 0, 'No', 1, '2025-02-06 11:42:00', NULL, NULL, NULL, NULL, '2025-02-06 05:36:42', '2025-02-06 05:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acc_voucher_details`
--

CREATE TABLE `tbl_acc_voucher_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `tbl_acc_coa_id` bigint(20) DEFAULT NULL,
  `tbl_acc_voucher_id` bigint(20) DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `voucher_id` bigint(20) NOT NULL DEFAULT 0,
  `particulars` longtext DEFAULT NULL,
  `debit` decimal(10,2) DEFAULT NULL,
  `credit` decimal(10,2) DEFAULT NULL,
  `voucher_title` varchar(255) DEFAULT NULL,
  `tbl_booking_id` bigint(20) DEFAULT NULL,
  `tbl_resturantOrder_id` bigint(100) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `from_warehouse` int(100) NOT NULL DEFAULT 0,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_acc_voucher_details`
--

INSERT INTO `tbl_acc_voucher_details` (`id`, `tbl_acc_coa_id`, `tbl_acc_voucher_id`, `purchase_id`, `sales_id`, `voucher_id`, `particulars`, `debit`, `credit`, `voucher_title`, `tbl_booking_id`, `tbl_resturantOrder_id`, `transaction_date`, `status`, `from_warehouse`, `deleted`, `created_by`, `created_date`, `last_updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 6, 1, NULL, NULL, 0, NULL, NULL, 3090.00, 'Order amount paid 3090 Tk , Date:  2025-02-01 11:32:30', NULL, NULL, '2025-02-01', 'Active', 0, 'No', 1, '2025-02-01 11:30:00', NULL, NULL, NULL, NULL, '2025-02-01 05:32:30', '2025-02-01 05:32:30'),
(2, 6, 2, NULL, NULL, 0, NULL, NULL, 280.00, 'Order amount paid 280 Tk , Date:  2025-02-01 12:41:27', NULL, NULL, '2025-02-01', 'Active', 0, 'No', 1, '2025-02-01 12:27:00', NULL, NULL, NULL, NULL, '2025-02-01 06:41:27', '2025-02-01 06:41:27'),
(3, 6, 3, NULL, NULL, 0, NULL, NULL, 6245.00, 'Order amount paid 6245 Tk , Date:  2025-02-01 12:46:57', NULL, NULL, '2025-02-01', 'Active', 0, 'No', 1, '2025-02-01 12:57:00', NULL, NULL, NULL, NULL, '2025-02-01 06:46:57', '2025-02-01 06:46:57'),
(4, 6, 4, NULL, NULL, 0, NULL, NULL, 714.00, 'Order amount paid 714 Tk , Date:  2025-02-01 12:49:38', NULL, NULL, '2025-02-01', 'Active', 0, 'No', 1, '2025-02-01 12:38:00', NULL, NULL, NULL, NULL, '2025-02-01 06:49:38', '2025-02-01 06:49:38'),
(5, 6, 5, NULL, NULL, 0, NULL, NULL, 760.00, 'Order amount paid 760 Tk , Date:  2025-02-01 13:46:39', NULL, NULL, '2025-02-01', 'Active', 0, 'No', 1, '2025-02-01 01:39:00', NULL, NULL, NULL, NULL, '2025-02-01 07:46:39', '2025-02-01 07:46:39'),
(6, 6, 6, NULL, NULL, 0, NULL, NULL, 3080.00, 'Order amount paid 3080 Tk , Date:  2025-02-02 07:22:03', NULL, NULL, '2025-02-02', 'Active', 0, 'No', 1, '2025-02-02 07:03:00', NULL, NULL, NULL, NULL, '2025-02-02 01:22:03', '2025-02-02 01:22:03'),
(7, 6, 7, NULL, NULL, 0, NULL, NULL, 750.00, 'Order amount paid 750 Tk , Date:  2025-02-04 08:51:23', NULL, NULL, '2025-02-04', 'Active', 0, 'No', 1, '2025-02-04 08:23:00', NULL, NULL, NULL, NULL, '2025-02-04 02:51:23', '2025-02-04 02:51:23'),
(8, 6, 8, NULL, NULL, 0, NULL, NULL, 750.00, 'Order amount paid 750 Tk , Date:  2025-02-04 08:52:51', NULL, NULL, '2025-02-04', 'Active', 0, 'No', 1, '2025-02-04 08:51:00', NULL, NULL, NULL, NULL, '2025-02-04 02:52:51', '2025-02-04 02:52:51'),
(9, 6, 9, NULL, NULL, 0, NULL, NULL, 865.00, 'Order amount paid 865 Tk , Date:  2025-02-04 10:41:03', NULL, NULL, '2025-02-04', 'Active', 0, 'No', 1, '2025-02-04 10:03:00', NULL, NULL, NULL, NULL, '2025-02-04 04:41:03', '2025-02-04 04:41:03'),
(10, 6, 10, NULL, NULL, 0, NULL, NULL, 1400.00, 'Order amount paid 1400 Tk , Date:  2025-02-04 12:00:29', NULL, NULL, '2025-02-04', 'Active', 0, 'No', 1, '2025-02-04 12:29:00', NULL, NULL, NULL, NULL, '2025-02-04 06:00:29', '2025-02-04 06:00:29'),
(11, 6, 11, NULL, NULL, 0, NULL, NULL, 280.00, 'Order amount paid 280 Tk , Date:  2025-02-05 07:01:24', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 07:24:00', NULL, NULL, NULL, NULL, '2025-02-05 01:01:24', '2025-02-05 01:01:24'),
(12, 6, 12, NULL, NULL, 0, NULL, NULL, 1800.00, 'Order amount paid 1800 Tk , Date:  2025-02-05 07:12:24', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 07:24:00', NULL, NULL, NULL, NULL, '2025-02-05 01:12:24', '2025-02-05 01:12:24'),
(13, 6, 13, NULL, NULL, 0, NULL, NULL, 1800.00, 'Order amount paid 1800 Tk , Date:  2025-02-05 08:52:41', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 08:41:00', NULL, NULL, NULL, NULL, '2025-02-05 02:52:41', '2025-02-05 02:52:41'),
(14, 6, 14, NULL, NULL, 0, NULL, NULL, 1800.00, 'Order amount paid 1800 Tk , Date:  2025-02-05 09:02:49', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 09:49:00', NULL, NULL, NULL, NULL, '2025-02-05 03:02:49', '2025-02-05 03:02:49'),
(15, 6, 15, NULL, NULL, 0, NULL, NULL, 200.00, 'Order amount paid 200 Tk , Date:  2025-02-05 10:53:12', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 10:12:00', NULL, NULL, NULL, NULL, '2025-02-05 04:53:12', '2025-02-05 04:53:12'),
(16, 6, 16, NULL, NULL, 0, NULL, NULL, 200.00, 'Order amount paid 200 Tk , Date:  2025-02-05 10:59:19', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 10:19:00', NULL, NULL, NULL, NULL, '2025-02-05 04:59:19', '2025-02-05 04:59:19'),
(17, 6, 17, NULL, NULL, 0, NULL, NULL, 420.00, 'Order amount paid 420 Tk , Date:  2025-02-05 11:09:19', NULL, NULL, '2025-02-05', 'Active', 0, 'No', 1, '2025-02-05 11:19:00', NULL, NULL, NULL, NULL, '2025-02-05 05:09:19', '2025-02-05 05:09:19'),
(18, 6, 18, NULL, NULL, 0, NULL, NULL, 2145.00, 'Order amount paid 2145 Tk , Date:  2025-02-06 06:02:55', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 06:55:00', NULL, NULL, NULL, NULL, '2025-02-06 00:02:55', '2025-02-06 00:02:55'),
(19, 6, 19, NULL, NULL, 0, NULL, NULL, 273.00, 'Order amount paid 273 Tk , Date:  2025-02-06 09:08:55', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 09:55:00', NULL, NULL, NULL, NULL, '2025-02-06 03:08:55', '2025-02-06 03:08:55'),
(20, 6, 20, NULL, NULL, 0, NULL, NULL, 290.00, 'Order amount paid 290 Tk , Date:  2025-02-06 09:14:00', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 09:00:00', NULL, NULL, NULL, NULL, '2025-02-06 03:14:00', '2025-02-06 03:14:00'),
(21, 6, 21, NULL, NULL, 0, NULL, NULL, 280.00, 'Order amount paid 280 Tk , Date:  2025-02-06 09:17:25', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 09:25:00', NULL, NULL, NULL, NULL, '2025-02-06 03:17:25', '2025-02-06 03:17:25'),
(22, 6, 22, NULL, NULL, 0, NULL, NULL, 280.00, 'Order amount paid 280 Tk , Date:  2025-02-06 09:20:05', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 09:05:00', NULL, NULL, NULL, NULL, '2025-02-06 03:20:05', '2025-02-06 03:20:05'),
(23, 6, 23, NULL, NULL, 0, NULL, NULL, 930.00, 'Order amount paid 930 Tk , Date:  2025-02-06 09:36:33', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 09:33:00', NULL, NULL, NULL, NULL, '2025-02-06 03:36:33', '2025-02-06 03:36:33'),
(24, 6, 24, NULL, NULL, 0, NULL, NULL, 280.00, 'Order amount paid 280 Tk , Date:  2025-02-06 09:50:32', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 09:32:00', NULL, NULL, NULL, NULL, '2025-02-06 03:50:32', '2025-02-06 03:50:32'),
(25, 6, 25, NULL, NULL, 0, NULL, NULL, 2220.00, 'Order amount paid 2220 Tk , Date:  2025-02-06 10:20:35', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 10:35:00', NULL, NULL, NULL, NULL, '2025-02-06 04:20:35', '2025-02-06 04:20:35'),
(26, 6, 26, NULL, NULL, 0, NULL, NULL, 280.00, 'Order amount paid 280 Tk , Date:  2025-02-06 10:59:25', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 10:25:00', NULL, NULL, NULL, NULL, '2025-02-06 04:59:25', '2025-02-06 04:59:25'),
(27, 6, 27, NULL, NULL, 0, NULL, NULL, 1900.00, 'Order amount paid 1900 Tk , Date:  2025-02-06 11:01:22', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 11:22:00', NULL, NULL, NULL, NULL, '2025-02-06 05:01:22', '2025-02-06 05:01:22'),
(28, 6, 28, NULL, NULL, 0, NULL, NULL, 713.00, 'Order amount paid 713 Tk , Date:  2025-02-06 11:03:53', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 11:53:00', NULL, NULL, NULL, NULL, '2025-02-06 05:03:53', '2025-02-06 05:03:53'),
(29, 6, 29, NULL, NULL, 0, NULL, NULL, 1062.00, 'Order amount paid 1062 Tk , Date:  2025-02-06 11:32:00', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 11:00:00', NULL, NULL, NULL, NULL, '2025-02-06 05:32:00', '2025-02-06 05:32:00'),
(30, 6, 30, NULL, NULL, 0, NULL, NULL, 580.00, 'Order amount paid 580 Tk , Date:  2025-02-06 11:36:42', NULL, NULL, '2025-02-06', 'Active', 0, 'No', 1, '2025-02-06 11:42:00', NULL, NULL, NULL, NULL, '2025-02-06 05:36:42', '2025-02-06 05:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_assign`
--

CREATE TABLE `tbl_asset_assign` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_asset_id` bigint(20) DEFAULT NULL,
  `tbl_building_id` bigint(20) DEFAULT NULL,
  `room_id` bigint(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_assign`
--

INSERT INTO `tbl_asset_assign` (`id`, `tbl_asset_id`, `tbl_building_id`, `room_id`, `remarks`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 9, NULL, 'No', 'Active', 1, '2024-07-02 13:28:28', NULL, NULL, NULL, NULL, '2024-07-02 07:28:28', '2024-07-02 07:28:28'),
(2, 28, 2, 3, NULL, 'No', 'Active', 1, '2024-11-12 13:28:51', NULL, NULL, NULL, NULL, '2024-11-12 07:28:51', '2024-11-12 07:28:51'),
(3, 28, 1, 1, NULL, 'No', 'Active', 1, '2024-12-12 05:40:59', NULL, NULL, NULL, NULL, '2024-12-11 23:40:59', '2024-12-11 23:40:59'),
(4, 28, 2, 3, NULL, 'No', 'Active', 1, '2024-12-12 05:41:51', NULL, NULL, NULL, NULL, '2024-12-11 23:41:51', '2024-12-11 23:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_depreciation_details`
--

CREATE TABLE `tbl_asset_depreciation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_serializeId` bigint(20) NOT NULL DEFAULT 0,
  `tbl_assetProductId` bigint(20) NOT NULL DEFAULT 0,
  `tbl_assetPurchaseProductId` bigint(20) DEFAULT NULL,
  `deducted_date` datetime DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deducted_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_month_year` varchar(250) DEFAULT NULL,
  `status` enum('Paid','Pending') NOT NULL DEFAULT 'Pending',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_depreciation_details`
--

INSERT INTO `tbl_asset_depreciation_details` (`id`, `tbl_serializeId`, `tbl_assetProductId`, `tbl_assetPurchaseProductId`, `deducted_date`, `amount`, `deducted_amount`, `paid_month_year`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2023-06-05 00:00:00', 25000.00, 695.00, '2023-06', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:37:33'),
(2, 1, 1, 1, '2023-07-05 00:00:00', 25000.00, 695.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:30:50'),
(3, 1, 1, 1, '2023-08-05 00:00:00', 25000.00, 695.00, '2023-08', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:37:33'),
(4, 1, 1, 1, '2023-09-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(5, 1, 1, 1, '2023-10-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(6, 1, 1, 1, '2023-11-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(7, 1, 1, 1, '2023-12-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(8, 1, 1, 1, '2024-01-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(9, 1, 1, 1, '2024-02-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(10, 1, 1, 1, '2024-03-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(11, 1, 1, 1, '2024-04-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(12, 1, 1, 1, '2024-05-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(13, 1, 1, 1, '2024-06-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(14, 1, 1, 1, '2024-07-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(15, 1, 1, 1, '2024-08-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(16, 1, 1, 1, '2024-09-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(17, 1, 1, 1, '2024-10-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(18, 1, 1, 1, '2024-11-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(19, 1, 1, 1, '2024-12-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(20, 1, 1, 1, '2025-01-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(21, 1, 1, 1, '2025-02-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(22, 1, 1, 1, '2025-03-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(23, 1, 1, 1, '2025-04-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(24, 1, 1, 1, '2025-05-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(25, 1, 1, 1, '2025-06-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(26, 1, 1, 1, '2025-07-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(27, 1, 1, 1, '2025-08-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(28, 1, 1, 1, '2025-09-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(29, 1, 1, 1, '2025-10-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(30, 1, 1, 1, '2025-11-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(31, 1, 1, 1, '2025-12-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(32, 1, 1, 1, '2026-01-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(33, 1, 1, 1, '2026-02-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(34, 1, 1, 1, '2026-03-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(35, 1, 1, 1, '2026-04-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(36, 1, 1, 1, '2026-05-05 00:00:00', 25000.00, 695.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(37, 2, 2, 2, '2023-06-05 00:00:00', 8000.00, 223.00, '2023-06', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:37:45'),
(38, 2, 2, 2, '2023-07-05 00:00:00', 8000.00, 223.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:30:50'),
(39, 2, 2, 2, '2023-08-05 00:00:00', 8000.00, 223.00, '2023-08', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:37:45'),
(40, 2, 2, 2, '2023-09-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(41, 2, 2, 2, '2023-10-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(42, 2, 2, 2, '2023-11-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(43, 2, 2, 2, '2023-12-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(44, 2, 2, 2, '2024-01-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(45, 2, 2, 2, '2024-02-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(46, 2, 2, 2, '2024-03-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(47, 2, 2, 2, '2024-04-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(48, 2, 2, 2, '2024-05-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(49, 2, 2, 2, '2024-06-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(50, 2, 2, 2, '2024-07-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(51, 2, 2, 2, '2024-08-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(52, 2, 2, 2, '2024-09-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(53, 2, 2, 2, '2024-10-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(54, 2, 2, 2, '2024-11-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(55, 2, 2, 2, '2024-12-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(56, 2, 2, 2, '2025-01-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(57, 2, 2, 2, '2025-02-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(58, 2, 2, 2, '2025-03-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(59, 2, 2, 2, '2025-04-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(60, 2, 2, 2, '2025-05-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(61, 2, 2, 2, '2025-06-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(62, 2, 2, 2, '2025-07-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(63, 2, 2, 2, '2025-08-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(64, 2, 2, 2, '2025-09-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(65, 2, 2, 2, '2025-10-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(66, 2, 2, 2, '2025-11-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(67, 2, 2, 2, '2025-12-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(68, 2, 2, 2, '2026-01-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(69, 2, 2, 2, '2026-02-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(70, 2, 2, 2, '2026-03-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(71, 2, 2, 2, '2026-04-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(72, 2, 2, 2, '2026-05-05 00:00:00', 8000.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(73, 3, 3, 3, '2023-06-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(74, 3, 3, 3, '2023-07-05 00:00:00', 3050.00, 128.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:30:50'),
(75, 3, 3, 3, '2023-08-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(76, 3, 3, 3, '2023-09-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(77, 3, 3, 3, '2023-10-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(78, 3, 3, 3, '2023-11-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(79, 3, 3, 3, '2023-12-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(80, 3, 3, 3, '2024-01-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(81, 3, 3, 3, '2024-02-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(82, 3, 3, 3, '2024-03-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(83, 3, 3, 3, '2024-04-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(84, 3, 3, 3, '2024-05-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(85, 3, 3, 3, '2024-06-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(86, 3, 3, 3, '2024-07-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(87, 3, 3, 3, '2024-08-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(88, 3, 3, 3, '2024-09-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(89, 3, 3, 3, '2024-10-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(90, 3, 3, 3, '2024-11-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(91, 3, 3, 3, '2024-12-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(92, 3, 3, 3, '2025-01-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(93, 3, 3, 3, '2025-02-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(94, 3, 3, 3, '2025-03-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(95, 3, 3, 3, '2025-04-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(96, 3, 3, 3, '2025-05-05 00:00:00', 3050.00, 128.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(97, 4, 4, 4, '2023-06-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(98, 4, 4, 4, '2023-07-05 00:00:00', 12500.00, 521.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:30:50'),
(99, 4, 4, 4, '2023-08-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(100, 4, 4, 4, '2023-09-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(101, 4, 4, 4, '2023-10-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(102, 4, 4, 4, '2023-11-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(103, 4, 4, 4, '2023-12-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(104, 4, 4, 4, '2024-01-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(105, 4, 4, 4, '2024-02-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(106, 4, 4, 4, '2024-03-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(107, 4, 4, 4, '2024-04-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(108, 4, 4, 4, '2024-05-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(109, 4, 4, 4, '2024-06-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(110, 4, 4, 4, '2024-07-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(111, 4, 4, 4, '2024-08-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(112, 4, 4, 4, '2024-09-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(113, 4, 4, 4, '2024-10-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(114, 4, 4, 4, '2024-11-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(115, 4, 4, 4, '2024-12-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(116, 4, 4, 4, '2025-01-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(117, 4, 4, 4, '2025-02-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(118, 4, 4, 4, '2025-03-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(119, 4, 4, 4, '2025-04-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(120, 4, 4, 4, '2025-05-05 00:00:00', 12500.00, 521.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(121, 5, 5, 5, '2023-06-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(122, 5, 5, 5, '2023-07-05 00:00:00', 20000.00, 556.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:30:50'),
(123, 5, 5, 5, '2023-08-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(124, 5, 5, 5, '2023-09-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(125, 5, 5, 5, '2023-10-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(126, 5, 5, 5, '2023-11-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(127, 5, 5, 5, '2023-12-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(128, 5, 5, 5, '2024-01-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(129, 5, 5, 5, '2024-02-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(130, 5, 5, 5, '2024-03-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(131, 5, 5, 5, '2024-04-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(132, 5, 5, 5, '2024-05-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(133, 5, 5, 5, '2024-06-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(134, 5, 5, 5, '2024-07-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(135, 5, 5, 5, '2024-08-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(136, 5, 5, 5, '2024-09-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(137, 5, 5, 5, '2024-10-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(138, 5, 5, 5, '2024-11-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(139, 5, 5, 5, '2024-12-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(140, 5, 5, 5, '2025-01-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(141, 5, 5, 5, '2025-02-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(142, 5, 5, 5, '2025-03-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(143, 5, 5, 5, '2025-04-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(144, 5, 5, 5, '2025-05-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(145, 5, 5, 5, '2025-06-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(146, 5, 5, 5, '2025-07-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(147, 5, 5, 5, '2025-08-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(148, 5, 5, 5, '2025-09-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(149, 5, 5, 5, '2025-10-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(150, 5, 5, 5, '2025-11-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(151, 5, 5, 5, '2025-12-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(152, 5, 5, 5, '2026-01-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(153, 5, 5, 5, '2026-02-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(154, 5, 5, 5, '2026-03-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(155, 5, 5, 5, '2026-04-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(156, 5, 5, 5, '2026-05-05 00:00:00', 20000.00, 556.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(157, 6, 6, 6, '2023-06-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(158, 6, 6, 6, '2023-07-05 00:00:00', 1000.00, 28.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-08-20 23:30:50'),
(159, 6, 6, 6, '2023-08-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(160, 6, 6, 6, '2023-09-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(161, 6, 6, 6, '2023-10-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(162, 6, 6, 6, '2023-11-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(163, 6, 6, 6, '2023-12-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(164, 6, 6, 6, '2024-01-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(165, 6, 6, 6, '2024-02-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(166, 6, 6, 6, '2024-03-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(167, 6, 6, 6, '2024-04-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(168, 6, 6, 6, '2024-05-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(169, 6, 6, 6, '2024-06-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(170, 6, 6, 6, '2024-07-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(171, 6, 6, 6, '2024-08-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(172, 6, 6, 6, '2024-09-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(173, 6, 6, 6, '2024-10-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(174, 6, 6, 6, '2024-11-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(175, 6, 6, 6, '2024-12-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(176, 6, 6, 6, '2025-01-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(177, 6, 6, 6, '2025-02-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(178, 6, 6, 6, '2025-03-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(179, 6, 6, 6, '2025-04-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(180, 6, 6, 6, '2025-05-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(181, 6, 6, 6, '2025-06-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(182, 6, 6, 6, '2025-07-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(183, 6, 6, 6, '2025-08-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(184, 6, 6, 6, '2025-09-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(185, 6, 6, 6, '2025-10-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(186, 6, 6, 6, '2025-11-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(187, 6, 6, 6, '2025-12-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(188, 6, 6, 6, '2026-01-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(189, 6, 6, 6, '2026-02-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(190, 6, 6, 6, '2026-03-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(191, 6, 6, 6, '2026-04-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(192, 6, 6, 6, '2026-05-05 00:00:00', 1000.00, 28.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:27:43', NULL, NULL, NULL, NULL, '2023-06-06 00:27:43', '2023-06-06 00:27:43'),
(193, 7, 7, 7, '2023-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(194, 7, 7, 7, '2023-07-05 00:00:00', 5000.00, 105.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(195, 7, 7, 7, '2023-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(196, 7, 7, 7, '2023-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(197, 7, 7, 7, '2023-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(198, 7, 7, 7, '2023-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(199, 7, 7, 7, '2023-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(200, 7, 7, 7, '2024-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(201, 7, 7, 7, '2024-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(202, 7, 7, 7, '2024-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(203, 7, 7, 7, '2024-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(204, 7, 7, 7, '2024-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(205, 7, 7, 7, '2024-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(206, 7, 7, 7, '2024-07-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(207, 7, 7, 7, '2024-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(208, 7, 7, 7, '2024-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(209, 7, 7, 7, '2024-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(210, 7, 7, 7, '2024-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(211, 7, 7, 7, '2024-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(212, 7, 7, 7, '2025-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(213, 7, 7, 7, '2025-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(214, 7, 7, 7, '2025-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(215, 7, 7, 7, '2025-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(216, 7, 7, 7, '2025-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(217, 7, 7, 7, '2025-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(218, 7, 7, 7, '2025-07-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(219, 7, 7, 7, '2025-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(220, 7, 7, 7, '2025-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(221, 7, 7, 7, '2025-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(222, 7, 7, 7, '2025-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(223, 7, 7, 7, '2025-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(224, 7, 7, 7, '2026-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(225, 7, 7, 7, '2026-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(226, 7, 7, 7, '2026-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(227, 7, 7, 7, '2026-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(228, 7, 7, 7, '2026-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(229, 7, 7, 7, '2026-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(230, 7, 7, 7, '2026-07-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(231, 7, 7, 7, '2026-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(232, 7, 7, 7, '2026-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(233, 7, 7, 7, '2026-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(234, 7, 7, 7, '2026-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(235, 7, 7, 7, '2026-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(236, 7, 7, 7, '2027-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(237, 7, 7, 7, '2027-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(238, 7, 7, 7, '2027-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(239, 7, 7, 7, '2027-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(240, 7, 7, 7, '2027-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(241, 8, 7, 7, '2023-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(242, 8, 7, 7, '2023-07-05 00:00:00', 5000.00, 105.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(243, 8, 7, 7, '2023-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(244, 8, 7, 7, '2023-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(245, 8, 7, 7, '2023-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(246, 8, 7, 7, '2023-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(247, 8, 7, 7, '2023-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(248, 8, 7, 7, '2024-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(249, 8, 7, 7, '2024-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(250, 8, 7, 7, '2024-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(251, 8, 7, 7, '2024-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(252, 8, 7, 7, '2024-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(253, 8, 7, 7, '2024-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(254, 8, 7, 7, '2024-07-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(255, 8, 7, 7, '2024-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(256, 8, 7, 7, '2024-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(257, 8, 7, 7, '2024-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(258, 8, 7, 7, '2024-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(259, 8, 7, 7, '2024-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(260, 8, 7, 7, '2025-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(261, 8, 7, 7, '2025-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(262, 8, 7, 7, '2025-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(263, 8, 7, 7, '2025-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(264, 8, 7, 7, '2025-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(265, 8, 7, 7, '2025-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(266, 8, 7, 7, '2025-07-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(267, 8, 7, 7, '2025-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(268, 8, 7, 7, '2025-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(269, 8, 7, 7, '2025-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(270, 8, 7, 7, '2025-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(271, 8, 7, 7, '2025-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(272, 8, 7, 7, '2026-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(273, 8, 7, 7, '2026-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(274, 8, 7, 7, '2026-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(275, 8, 7, 7, '2026-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(276, 8, 7, 7, '2026-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(277, 8, 7, 7, '2026-06-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(278, 8, 7, 7, '2026-07-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(279, 8, 7, 7, '2026-08-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(280, 8, 7, 7, '2026-09-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(281, 8, 7, 7, '2026-10-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(282, 8, 7, 7, '2026-11-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(283, 8, 7, 7, '2026-12-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(284, 8, 7, 7, '2027-01-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(285, 8, 7, 7, '2027-02-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(286, 8, 7, 7, '2027-03-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(287, 8, 7, 7, '2027-04-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09');
INSERT INTO `tbl_asset_depreciation_details` (`id`, `tbl_serializeId`, `tbl_assetProductId`, `tbl_assetPurchaseProductId`, `deducted_date`, `amount`, `deducted_amount`, `paid_month_year`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(288, 8, 7, 7, '2027-05-05 00:00:00', 5000.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(289, 9, 8, 8, '2023-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(290, 9, 8, 8, '2023-07-05 00:00:00', 13334.00, 223.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(291, 9, 8, 8, '2023-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(292, 9, 8, 8, '2023-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(293, 9, 8, 8, '2023-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(294, 9, 8, 8, '2023-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(295, 9, 8, 8, '2023-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(296, 9, 8, 8, '2024-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(297, 9, 8, 8, '2024-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(298, 9, 8, 8, '2024-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(299, 9, 8, 8, '2024-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(300, 9, 8, 8, '2024-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(301, 9, 8, 8, '2024-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(302, 9, 8, 8, '2024-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(303, 9, 8, 8, '2024-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(304, 9, 8, 8, '2024-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(305, 9, 8, 8, '2024-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(306, 9, 8, 8, '2024-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(307, 9, 8, 8, '2024-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(308, 9, 8, 8, '2025-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(309, 9, 8, 8, '2025-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(310, 9, 8, 8, '2025-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(311, 9, 8, 8, '2025-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(312, 9, 8, 8, '2025-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(313, 9, 8, 8, '2025-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(314, 9, 8, 8, '2025-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(315, 9, 8, 8, '2025-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(316, 9, 8, 8, '2025-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(317, 9, 8, 8, '2025-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(318, 9, 8, 8, '2025-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(319, 9, 8, 8, '2025-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(320, 9, 8, 8, '2026-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(321, 9, 8, 8, '2026-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(322, 9, 8, 8, '2026-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(323, 9, 8, 8, '2026-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(324, 9, 8, 8, '2026-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(325, 9, 8, 8, '2026-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(326, 9, 8, 8, '2026-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(327, 9, 8, 8, '2026-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(328, 9, 8, 8, '2026-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(329, 9, 8, 8, '2026-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(330, 9, 8, 8, '2026-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(331, 9, 8, 8, '2026-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(332, 9, 8, 8, '2027-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(333, 9, 8, 8, '2027-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(334, 9, 8, 8, '2027-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(335, 9, 8, 8, '2027-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(336, 9, 8, 8, '2027-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(337, 9, 8, 8, '2027-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(338, 9, 8, 8, '2027-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(339, 9, 8, 8, '2027-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(340, 9, 8, 8, '2027-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(341, 9, 8, 8, '2027-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(342, 9, 8, 8, '2027-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(343, 9, 8, 8, '2027-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(344, 9, 8, 8, '2028-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(345, 9, 8, 8, '2028-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(346, 9, 8, 8, '2028-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(347, 9, 8, 8, '2028-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(348, 9, 8, 8, '2028-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(349, 10, 8, 8, '2023-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(350, 10, 8, 8, '2023-07-05 00:00:00', 13334.00, 223.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(351, 10, 8, 8, '2023-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(352, 10, 8, 8, '2023-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(353, 10, 8, 8, '2023-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(354, 10, 8, 8, '2023-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(355, 10, 8, 8, '2023-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(356, 10, 8, 8, '2024-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(357, 10, 8, 8, '2024-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(358, 10, 8, 8, '2024-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(359, 10, 8, 8, '2024-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(360, 10, 8, 8, '2024-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(361, 10, 8, 8, '2024-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(362, 10, 8, 8, '2024-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(363, 10, 8, 8, '2024-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(364, 10, 8, 8, '2024-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(365, 10, 8, 8, '2024-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(366, 10, 8, 8, '2024-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(367, 10, 8, 8, '2024-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(368, 10, 8, 8, '2025-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(369, 10, 8, 8, '2025-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(370, 10, 8, 8, '2025-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(371, 10, 8, 8, '2025-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(372, 10, 8, 8, '2025-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(373, 10, 8, 8, '2025-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(374, 10, 8, 8, '2025-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(375, 10, 8, 8, '2025-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(376, 10, 8, 8, '2025-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(377, 10, 8, 8, '2025-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(378, 10, 8, 8, '2025-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(379, 10, 8, 8, '2025-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(380, 10, 8, 8, '2026-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(381, 10, 8, 8, '2026-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(382, 10, 8, 8, '2026-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(383, 10, 8, 8, '2026-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(384, 10, 8, 8, '2026-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(385, 10, 8, 8, '2026-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(386, 10, 8, 8, '2026-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(387, 10, 8, 8, '2026-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(388, 10, 8, 8, '2026-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(389, 10, 8, 8, '2026-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(390, 10, 8, 8, '2026-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(391, 10, 8, 8, '2026-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(392, 10, 8, 8, '2027-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(393, 10, 8, 8, '2027-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(394, 10, 8, 8, '2027-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(395, 10, 8, 8, '2027-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(396, 10, 8, 8, '2027-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(397, 10, 8, 8, '2027-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(398, 10, 8, 8, '2027-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(399, 10, 8, 8, '2027-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(400, 10, 8, 8, '2027-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(401, 10, 8, 8, '2027-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(402, 10, 8, 8, '2027-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(403, 10, 8, 8, '2027-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(404, 10, 8, 8, '2028-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(405, 10, 8, 8, '2028-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(406, 10, 8, 8, '2028-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(407, 10, 8, 8, '2028-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(408, 10, 8, 8, '2028-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(409, 11, 8, 8, '2023-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(410, 11, 8, 8, '2023-07-05 00:00:00', 13334.00, 223.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(411, 11, 8, 8, '2023-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(412, 11, 8, 8, '2023-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(413, 11, 8, 8, '2023-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(414, 11, 8, 8, '2023-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(415, 11, 8, 8, '2023-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(416, 11, 8, 8, '2024-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(417, 11, 8, 8, '2024-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(418, 11, 8, 8, '2024-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(419, 11, 8, 8, '2024-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(420, 11, 8, 8, '2024-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(421, 11, 8, 8, '2024-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(422, 11, 8, 8, '2024-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(423, 11, 8, 8, '2024-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(424, 11, 8, 8, '2024-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(425, 11, 8, 8, '2024-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(426, 11, 8, 8, '2024-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(427, 11, 8, 8, '2024-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(428, 11, 8, 8, '2025-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(429, 11, 8, 8, '2025-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(430, 11, 8, 8, '2025-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(431, 11, 8, 8, '2025-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(432, 11, 8, 8, '2025-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(433, 11, 8, 8, '2025-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(434, 11, 8, 8, '2025-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(435, 11, 8, 8, '2025-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(436, 11, 8, 8, '2025-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(437, 11, 8, 8, '2025-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(438, 11, 8, 8, '2025-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(439, 11, 8, 8, '2025-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(440, 11, 8, 8, '2026-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(441, 11, 8, 8, '2026-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(442, 11, 8, 8, '2026-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(443, 11, 8, 8, '2026-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(444, 11, 8, 8, '2026-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(445, 11, 8, 8, '2026-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(446, 11, 8, 8, '2026-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(447, 11, 8, 8, '2026-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(448, 11, 8, 8, '2026-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(449, 11, 8, 8, '2026-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(450, 11, 8, 8, '2026-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(451, 11, 8, 8, '2026-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(452, 11, 8, 8, '2027-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(453, 11, 8, 8, '2027-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(454, 11, 8, 8, '2027-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(455, 11, 8, 8, '2027-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(456, 11, 8, 8, '2027-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(457, 11, 8, 8, '2027-06-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(458, 11, 8, 8, '2027-07-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(459, 11, 8, 8, '2027-08-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(460, 11, 8, 8, '2027-09-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(461, 11, 8, 8, '2027-10-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(462, 11, 8, 8, '2027-11-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(463, 11, 8, 8, '2027-12-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(464, 11, 8, 8, '2028-01-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(465, 11, 8, 8, '2028-02-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(466, 11, 8, 8, '2028-03-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(467, 11, 8, 8, '2028-04-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(468, 11, 8, 8, '2028-05-05 00:00:00', 13334.00, 223.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(469, 12, 10, 9, '2023-06-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(470, 12, 10, 9, '2023-07-05 00:00:00', 22500.00, 469.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(471, 12, 10, 9, '2023-08-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(472, 12, 10, 9, '2023-09-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(473, 12, 10, 9, '2023-10-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(474, 12, 10, 9, '2023-11-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(475, 12, 10, 9, '2023-12-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(476, 12, 10, 9, '2024-01-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(477, 12, 10, 9, '2024-02-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(478, 12, 10, 9, '2024-03-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(479, 12, 10, 9, '2024-04-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(480, 12, 10, 9, '2024-05-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(481, 12, 10, 9, '2024-06-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(482, 12, 10, 9, '2024-07-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(483, 12, 10, 9, '2024-08-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(484, 12, 10, 9, '2024-09-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(485, 12, 10, 9, '2024-10-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(486, 12, 10, 9, '2024-11-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(487, 12, 10, 9, '2024-12-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(488, 12, 10, 9, '2025-01-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(489, 12, 10, 9, '2025-02-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(490, 12, 10, 9, '2025-03-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(491, 12, 10, 9, '2025-04-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(492, 12, 10, 9, '2025-05-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(493, 12, 10, 9, '2025-06-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(494, 12, 10, 9, '2025-07-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(495, 12, 10, 9, '2025-08-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(496, 12, 10, 9, '2025-09-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(497, 12, 10, 9, '2025-10-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(498, 12, 10, 9, '2025-11-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(499, 12, 10, 9, '2025-12-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(500, 12, 10, 9, '2026-01-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(501, 12, 10, 9, '2026-02-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(502, 12, 10, 9, '2026-03-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(503, 12, 10, 9, '2026-04-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(504, 12, 10, 9, '2026-05-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(505, 12, 10, 9, '2026-06-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(506, 12, 10, 9, '2026-07-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(507, 12, 10, 9, '2026-08-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(508, 12, 10, 9, '2026-09-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(509, 12, 10, 9, '2026-10-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(510, 12, 10, 9, '2026-11-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(511, 12, 10, 9, '2026-12-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(512, 12, 10, 9, '2027-01-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(513, 12, 10, 9, '2027-02-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(514, 12, 10, 9, '2027-03-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(515, 12, 10, 9, '2027-04-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(516, 12, 10, 9, '2027-05-05 00:00:00', 22500.00, 469.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(517, 13, 11, 10, '2023-06-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(518, 13, 11, 10, '2023-07-05 00:00:00', 2000.00, 112.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(519, 13, 11, 10, '2023-08-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(520, 13, 11, 10, '2023-09-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(521, 13, 11, 10, '2023-10-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(522, 13, 11, 10, '2023-11-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(523, 13, 11, 10, '2023-12-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(524, 13, 11, 10, '2024-01-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(525, 13, 11, 10, '2024-02-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(526, 13, 11, 10, '2024-03-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(527, 13, 11, 10, '2024-04-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(528, 13, 11, 10, '2024-05-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(529, 13, 11, 10, '2024-06-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(530, 13, 11, 10, '2024-07-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(531, 13, 11, 10, '2024-08-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(532, 13, 11, 10, '2024-09-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(533, 13, 11, 10, '2024-10-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(534, 13, 11, 10, '2024-11-05 00:00:00', 2000.00, 112.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(535, 14, 12, 11, '2023-06-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(536, 14, 12, 11, '2023-07-05 00:00:00', 17000.00, 709.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(537, 14, 12, 11, '2023-08-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(538, 14, 12, 11, '2023-09-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(539, 14, 12, 11, '2023-10-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(540, 14, 12, 11, '2023-11-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(541, 14, 12, 11, '2023-12-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(542, 14, 12, 11, '2024-01-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(543, 14, 12, 11, '2024-02-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(544, 14, 12, 11, '2024-03-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(545, 14, 12, 11, '2024-04-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(546, 14, 12, 11, '2024-05-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(547, 14, 12, 11, '2024-06-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(548, 14, 12, 11, '2024-07-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(549, 14, 12, 11, '2024-08-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(550, 14, 12, 11, '2024-09-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(551, 14, 12, 11, '2024-10-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(552, 14, 12, 11, '2024-11-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(553, 14, 12, 11, '2024-12-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(554, 14, 12, 11, '2025-01-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(555, 14, 12, 11, '2025-02-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(556, 14, 12, 11, '2025-03-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(557, 14, 12, 11, '2025-04-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(558, 14, 12, 11, '2025-05-05 00:00:00', 17000.00, 709.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(559, 15, 13, 12, '2023-06-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(560, 15, 13, 12, '2023-07-05 00:00:00', 4000.00, 84.00, '2023-07', 'Paid', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-08-20 23:30:50'),
(561, 15, 13, 12, '2023-08-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(562, 15, 13, 12, '2023-09-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(563, 15, 13, 12, '2023-10-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(564, 15, 13, 12, '2023-11-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(565, 15, 13, 12, '2023-12-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(566, 15, 13, 12, '2024-01-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(567, 15, 13, 12, '2024-02-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(568, 15, 13, 12, '2024-03-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(569, 15, 13, 12, '2024-04-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(570, 15, 13, 12, '2024-05-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09');
INSERT INTO `tbl_asset_depreciation_details` (`id`, `tbl_serializeId`, `tbl_assetProductId`, `tbl_assetPurchaseProductId`, `deducted_date`, `amount`, `deducted_amount`, `paid_month_year`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(571, 15, 13, 12, '2024-06-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(572, 15, 13, 12, '2024-07-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(573, 15, 13, 12, '2024-08-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(574, 15, 13, 12, '2024-09-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(575, 15, 13, 12, '2024-10-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(576, 15, 13, 12, '2024-11-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(577, 15, 13, 12, '2024-12-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(578, 15, 13, 12, '2025-01-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(579, 15, 13, 12, '2025-02-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(580, 15, 13, 12, '2025-03-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(581, 15, 13, 12, '2025-04-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(582, 15, 13, 12, '2025-05-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(583, 15, 13, 12, '2025-06-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(584, 15, 13, 12, '2025-07-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(585, 15, 13, 12, '2025-08-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(586, 15, 13, 12, '2025-09-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(587, 15, 13, 12, '2025-10-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(588, 15, 13, 12, '2025-11-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(589, 15, 13, 12, '2025-12-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(590, 15, 13, 12, '2026-01-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(591, 15, 13, 12, '2026-02-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(592, 15, 13, 12, '2026-03-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(593, 15, 13, 12, '2026-04-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(594, 15, 13, 12, '2026-05-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(595, 15, 13, 12, '2026-06-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(596, 15, 13, 12, '2026-07-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(597, 15, 13, 12, '2026-08-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(598, 15, 13, 12, '2026-09-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(599, 15, 13, 12, '2026-10-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(600, 15, 13, 12, '2026-11-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(601, 15, 13, 12, '2026-12-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(602, 15, 13, 12, '2027-01-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(603, 15, 13, 12, '2027-02-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(604, 15, 13, 12, '2027-03-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(605, 15, 13, 12, '2027-04-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(606, 15, 13, 12, '2027-05-05 00:00:00', 4000.00, 84.00, NULL, 'Pending', 'No', 1, '2023-06-05 19:49:09', NULL, NULL, NULL, NULL, '2023-06-06 00:49:09', '2023-06-06 00:49:09'),
(607, 16, 15, 13, '2023-06-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(608, 16, 15, 13, '2023-07-06 00:00:00', 500.00, 21.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(609, 16, 15, 13, '2023-08-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(610, 16, 15, 13, '2023-09-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(611, 16, 15, 13, '2023-10-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(612, 16, 15, 13, '2023-11-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(613, 16, 15, 13, '2023-12-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(614, 16, 15, 13, '2024-01-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(615, 16, 15, 13, '2024-02-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(616, 16, 15, 13, '2024-03-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(617, 16, 15, 13, '2024-04-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(618, 16, 15, 13, '2024-05-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(619, 16, 15, 13, '2024-06-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(620, 16, 15, 13, '2024-07-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(621, 16, 15, 13, '2024-08-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(622, 16, 15, 13, '2024-09-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(623, 16, 15, 13, '2024-10-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(624, 16, 15, 13, '2024-11-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(625, 16, 15, 13, '2024-12-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(626, 16, 15, 13, '2025-01-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(627, 16, 15, 13, '2025-02-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(628, 16, 15, 13, '2025-03-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(629, 16, 15, 13, '2025-04-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(630, 16, 15, 13, '2025-05-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(631, 17, 15, 13, '2023-06-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(632, 17, 15, 13, '2023-07-06 00:00:00', 500.00, 21.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(633, 17, 15, 13, '2023-08-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(634, 17, 15, 13, '2023-09-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(635, 17, 15, 13, '2023-10-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(636, 17, 15, 13, '2023-11-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(637, 17, 15, 13, '2023-12-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(638, 17, 15, 13, '2024-01-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(639, 17, 15, 13, '2024-02-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(640, 17, 15, 13, '2024-03-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(641, 17, 15, 13, '2024-04-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(642, 17, 15, 13, '2024-05-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(643, 17, 15, 13, '2024-06-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(644, 17, 15, 13, '2024-07-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(645, 17, 15, 13, '2024-08-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(646, 17, 15, 13, '2024-09-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(647, 17, 15, 13, '2024-10-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(648, 17, 15, 13, '2024-11-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(649, 17, 15, 13, '2024-12-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(650, 17, 15, 13, '2025-01-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(651, 17, 15, 13, '2025-02-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(652, 17, 15, 13, '2025-03-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(653, 17, 15, 13, '2025-04-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(654, 17, 15, 13, '2025-05-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(655, 18, 15, 13, '2023-06-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(656, 18, 15, 13, '2023-07-06 00:00:00', 500.00, 21.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(657, 18, 15, 13, '2023-08-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(658, 18, 15, 13, '2023-09-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(659, 18, 15, 13, '2023-10-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(660, 18, 15, 13, '2023-11-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(661, 18, 15, 13, '2023-12-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(662, 18, 15, 13, '2024-01-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(663, 18, 15, 13, '2024-02-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(664, 18, 15, 13, '2024-03-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(665, 18, 15, 13, '2024-04-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(666, 18, 15, 13, '2024-05-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(667, 18, 15, 13, '2024-06-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(668, 18, 15, 13, '2024-07-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(669, 18, 15, 13, '2024-08-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(670, 18, 15, 13, '2024-09-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(671, 18, 15, 13, '2024-10-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(672, 18, 15, 13, '2024-11-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(673, 18, 15, 13, '2024-12-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(674, 18, 15, 13, '2025-01-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(675, 18, 15, 13, '2025-02-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(676, 18, 15, 13, '2025-03-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(677, 18, 15, 13, '2025-04-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(678, 18, 15, 13, '2025-05-06 00:00:00', 500.00, 21.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(679, 19, 16, 14, '2023-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(680, 19, 16, 14, '2023-07-06 00:00:00', 400.00, 17.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(681, 19, 16, 14, '2023-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(682, 19, 16, 14, '2023-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(683, 19, 16, 14, '2023-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(684, 19, 16, 14, '2023-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(685, 19, 16, 14, '2023-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(686, 19, 16, 14, '2024-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(687, 19, 16, 14, '2024-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(688, 19, 16, 14, '2024-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(689, 19, 16, 14, '2024-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(690, 19, 16, 14, '2024-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(691, 19, 16, 14, '2024-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(692, 19, 16, 14, '2024-07-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(693, 19, 16, 14, '2024-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(694, 19, 16, 14, '2024-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(695, 19, 16, 14, '2024-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(696, 19, 16, 14, '2024-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(697, 19, 16, 14, '2024-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(698, 19, 16, 14, '2025-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(699, 19, 16, 14, '2025-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(700, 19, 16, 14, '2025-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(701, 19, 16, 14, '2025-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(702, 19, 16, 14, '2025-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(703, 20, 16, 14, '2023-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(704, 20, 16, 14, '2023-07-06 00:00:00', 400.00, 17.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(705, 20, 16, 14, '2023-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(706, 20, 16, 14, '2023-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(707, 20, 16, 14, '2023-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(708, 20, 16, 14, '2023-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(709, 20, 16, 14, '2023-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(710, 20, 16, 14, '2024-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(711, 20, 16, 14, '2024-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(712, 20, 16, 14, '2024-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(713, 20, 16, 14, '2024-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(714, 20, 16, 14, '2024-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(715, 20, 16, 14, '2024-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(716, 20, 16, 14, '2024-07-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(717, 20, 16, 14, '2024-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(718, 20, 16, 14, '2024-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(719, 20, 16, 14, '2024-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(720, 20, 16, 14, '2024-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(721, 20, 16, 14, '2024-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(722, 20, 16, 14, '2025-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(723, 20, 16, 14, '2025-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(724, 20, 16, 14, '2025-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(725, 20, 16, 14, '2025-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(726, 20, 16, 14, '2025-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(727, 21, 16, 14, '2023-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(728, 21, 16, 14, '2023-07-06 00:00:00', 400.00, 17.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(729, 21, 16, 14, '2023-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(730, 21, 16, 14, '2023-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(731, 21, 16, 14, '2023-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(732, 21, 16, 14, '2023-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(733, 21, 16, 14, '2023-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(734, 21, 16, 14, '2024-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(735, 21, 16, 14, '2024-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(736, 21, 16, 14, '2024-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(737, 21, 16, 14, '2024-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(738, 21, 16, 14, '2024-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(739, 21, 16, 14, '2024-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(740, 21, 16, 14, '2024-07-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(741, 21, 16, 14, '2024-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(742, 21, 16, 14, '2024-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(743, 21, 16, 14, '2024-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(744, 21, 16, 14, '2024-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(745, 21, 16, 14, '2024-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(746, 21, 16, 14, '2025-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(747, 21, 16, 14, '2025-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(748, 21, 16, 14, '2025-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(749, 21, 16, 14, '2025-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(750, 21, 16, 14, '2025-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(751, 22, 16, 14, '2023-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(752, 22, 16, 14, '2023-07-06 00:00:00', 400.00, 17.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(753, 22, 16, 14, '2023-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(754, 22, 16, 14, '2023-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(755, 22, 16, 14, '2023-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(756, 22, 16, 14, '2023-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(757, 22, 16, 14, '2023-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(758, 22, 16, 14, '2024-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(759, 22, 16, 14, '2024-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(760, 22, 16, 14, '2024-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(761, 22, 16, 14, '2024-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(762, 22, 16, 14, '2024-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(763, 22, 16, 14, '2024-06-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(764, 22, 16, 14, '2024-07-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(765, 22, 16, 14, '2024-08-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(766, 22, 16, 14, '2024-09-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(767, 22, 16, 14, '2024-10-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(768, 22, 16, 14, '2024-11-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(769, 22, 16, 14, '2024-12-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(770, 22, 16, 14, '2025-01-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(771, 22, 16, 14, '2025-02-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(772, 22, 16, 14, '2025-03-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(773, 22, 16, 14, '2025-04-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(774, 22, 16, 14, '2025-05-06 00:00:00', 400.00, 17.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(775, 23, 17, 15, '2023-06-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(776, 23, 17, 15, '2023-07-06 00:00:00', 1500.00, 42.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(777, 23, 17, 15, '2023-08-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(778, 23, 17, 15, '2023-09-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(779, 23, 17, 15, '2023-10-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(780, 23, 17, 15, '2023-11-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(781, 23, 17, 15, '2023-12-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(782, 23, 17, 15, '2024-01-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(783, 23, 17, 15, '2024-02-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(784, 23, 17, 15, '2024-03-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(785, 23, 17, 15, '2024-04-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(786, 23, 17, 15, '2024-05-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(787, 23, 17, 15, '2024-06-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(788, 23, 17, 15, '2024-07-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(789, 23, 17, 15, '2024-08-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(790, 23, 17, 15, '2024-09-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(791, 23, 17, 15, '2024-10-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(792, 23, 17, 15, '2024-11-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(793, 23, 17, 15, '2024-12-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(794, 23, 17, 15, '2025-01-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(795, 23, 17, 15, '2025-02-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(796, 23, 17, 15, '2025-03-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(797, 23, 17, 15, '2025-04-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(798, 23, 17, 15, '2025-05-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(799, 23, 17, 15, '2025-06-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(800, 23, 17, 15, '2025-07-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(801, 23, 17, 15, '2025-08-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(802, 23, 17, 15, '2025-09-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(803, 23, 17, 15, '2025-10-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(804, 23, 17, 15, '2025-11-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(805, 23, 17, 15, '2025-12-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(806, 23, 17, 15, '2026-01-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(807, 23, 17, 15, '2026-02-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(808, 23, 17, 15, '2026-03-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(809, 23, 17, 15, '2026-04-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(810, 23, 17, 15, '2026-05-06 00:00:00', 1500.00, 42.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(811, 24, 20, 16, '2023-06-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(812, 24, 20, 16, '2023-07-06 00:00:00', 50.00, 2.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(813, 24, 20, 16, '2023-08-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(814, 24, 20, 16, '2023-09-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(815, 24, 20, 16, '2023-10-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(816, 24, 20, 16, '2023-11-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(817, 24, 20, 16, '2023-12-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(818, 24, 20, 16, '2024-01-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(819, 24, 20, 16, '2024-02-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(820, 24, 20, 16, '2024-03-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(821, 24, 20, 16, '2024-04-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(822, 24, 20, 16, '2024-05-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(823, 24, 20, 16, '2024-06-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(824, 24, 20, 16, '2024-07-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(825, 24, 20, 16, '2024-08-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(826, 24, 20, 16, '2024-09-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(827, 24, 20, 16, '2024-10-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(828, 24, 20, 16, '2024-11-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(829, 24, 20, 16, '2024-12-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(830, 24, 20, 16, '2025-01-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(831, 24, 20, 16, '2025-02-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(832, 24, 20, 16, '2025-03-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(833, 24, 20, 16, '2025-04-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(834, 24, 20, 16, '2025-05-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(835, 24, 20, 16, '2025-06-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(836, 24, 20, 16, '2025-07-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(837, 24, 20, 16, '2025-08-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(838, 24, 20, 16, '2025-09-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(839, 24, 20, 16, '2025-10-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(840, 24, 20, 16, '2025-11-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(841, 24, 20, 16, '2025-12-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(842, 24, 20, 16, '2026-01-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(843, 24, 20, 16, '2026-02-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(844, 24, 20, 16, '2026-03-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(845, 24, 20, 16, '2026-04-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(846, 24, 20, 16, '2026-05-06 00:00:00', 50.00, 2.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(847, 25, 21, 17, '2023-06-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(848, 25, 21, 17, '2023-07-06 00:00:00', 3000.00, 250.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(849, 25, 21, 17, '2023-08-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(850, 25, 21, 17, '2023-09-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(851, 25, 21, 17, '2023-10-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(852, 25, 21, 17, '2023-11-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(853, 25, 21, 17, '2023-12-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(854, 25, 21, 17, '2024-01-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(855, 25, 21, 17, '2024-02-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48');
INSERT INTO `tbl_asset_depreciation_details` (`id`, `tbl_serializeId`, `tbl_assetProductId`, `tbl_assetPurchaseProductId`, `deducted_date`, `amount`, `deducted_amount`, `paid_month_year`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(856, 25, 21, 17, '2024-03-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(857, 25, 21, 17, '2024-04-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(858, 25, 21, 17, '2024-05-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(859, 26, 21, 17, '2023-06-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(860, 26, 21, 17, '2023-07-06 00:00:00', 3000.00, 250.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(861, 26, 21, 17, '2023-08-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(862, 26, 21, 17, '2023-09-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(863, 26, 21, 17, '2023-10-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(864, 26, 21, 17, '2023-11-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(865, 26, 21, 17, '2023-12-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(866, 26, 21, 17, '2024-01-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(867, 26, 21, 17, '2024-02-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(868, 26, 21, 17, '2024-03-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(869, 26, 21, 17, '2024-04-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(870, 26, 21, 17, '2024-05-06 00:00:00', 3000.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(871, 27, 22, 18, '2023-06-06 00:00:00', 500.00, 250.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(872, 27, 22, 18, '2023-07-06 00:00:00', 500.00, 250.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(873, 28, 23, 19, '2023-06-06 00:00:00', 1000.00, 167.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(874, 28, 23, 19, '2023-07-06 00:00:00', 1000.00, 167.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-08-20 23:30:50'),
(875, 28, 23, 19, '2023-08-06 00:00:00', 1000.00, 167.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(876, 28, 23, 19, '2023-09-06 00:00:00', 1000.00, 167.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(877, 28, 23, 19, '2023-10-06 00:00:00', 1000.00, 167.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(878, 28, 23, 19, '2023-11-06 00:00:00', 1000.00, 167.00, NULL, 'Pending', 'No', 1, '2023-06-06 10:56:48', NULL, NULL, NULL, NULL, '2023-06-06 15:56:48', '2023-06-06 15:56:48'),
(879, 29, 24, 20, '2023-06-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(880, 29, 24, 20, '2023-07-06 00:00:00', 2500.00, 105.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-08-20 23:30:50'),
(881, 29, 24, 20, '2023-08-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(882, 29, 24, 20, '2023-09-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(883, 29, 24, 20, '2023-10-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(884, 29, 24, 20, '2023-11-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(885, 29, 24, 20, '2023-12-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(886, 29, 24, 20, '2024-01-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(887, 29, 24, 20, '2024-02-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(888, 29, 24, 20, '2024-03-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(889, 29, 24, 20, '2024-04-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(890, 29, 24, 20, '2024-05-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(891, 29, 24, 20, '2024-06-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(892, 29, 24, 20, '2024-07-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(893, 29, 24, 20, '2024-08-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(894, 29, 24, 20, '2024-09-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(895, 29, 24, 20, '2024-10-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(896, 29, 24, 20, '2024-11-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(897, 29, 24, 20, '2024-12-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(898, 29, 24, 20, '2025-01-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(899, 29, 24, 20, '2025-02-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(900, 29, 24, 20, '2025-03-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(901, 29, 24, 20, '2025-04-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(902, 29, 24, 20, '2025-05-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(903, 30, 24, 20, '2023-06-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(904, 30, 24, 20, '2023-07-06 00:00:00', 2500.00, 105.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-08-20 23:30:50'),
(905, 30, 24, 20, '2023-08-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(906, 30, 24, 20, '2023-09-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(907, 30, 24, 20, '2023-10-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(908, 30, 24, 20, '2023-11-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(909, 30, 24, 20, '2023-12-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(910, 30, 24, 20, '2024-01-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(911, 30, 24, 20, '2024-02-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(912, 30, 24, 20, '2024-03-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(913, 30, 24, 20, '2024-04-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(914, 30, 24, 20, '2024-05-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(915, 30, 24, 20, '2024-06-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(916, 30, 24, 20, '2024-07-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(917, 30, 24, 20, '2024-08-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(918, 30, 24, 20, '2024-09-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(919, 30, 24, 20, '2024-10-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(920, 30, 24, 20, '2024-11-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(921, 30, 24, 20, '2024-12-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(922, 30, 24, 20, '2025-01-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(923, 30, 24, 20, '2025-02-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(924, 30, 24, 20, '2025-03-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(925, 30, 24, 20, '2025-04-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(926, 30, 24, 20, '2025-05-06 00:00:00', 2500.00, 105.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(927, 31, 25, 21, '2023-06-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(928, 31, 25, 21, '2023-07-06 00:00:00', 2400.00, 67.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-08-20 23:30:50'),
(929, 31, 25, 21, '2023-08-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(930, 31, 25, 21, '2023-09-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(931, 31, 25, 21, '2023-10-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(932, 31, 25, 21, '2023-11-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(933, 31, 25, 21, '2023-12-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(934, 31, 25, 21, '2024-01-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(935, 31, 25, 21, '2024-02-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(936, 31, 25, 21, '2024-03-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(937, 31, 25, 21, '2024-04-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(938, 31, 25, 21, '2024-05-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(939, 31, 25, 21, '2024-06-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(940, 31, 25, 21, '2024-07-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(941, 31, 25, 21, '2024-08-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(942, 31, 25, 21, '2024-09-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(943, 31, 25, 21, '2024-10-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(944, 31, 25, 21, '2024-11-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(945, 31, 25, 21, '2024-12-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(946, 31, 25, 21, '2025-01-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(947, 31, 25, 21, '2025-02-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(948, 31, 25, 21, '2025-03-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(949, 31, 25, 21, '2025-04-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(950, 31, 25, 21, '2025-05-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(951, 31, 25, 21, '2025-06-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(952, 31, 25, 21, '2025-07-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(953, 31, 25, 21, '2025-08-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(954, 31, 25, 21, '2025-09-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(955, 31, 25, 21, '2025-10-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(956, 31, 25, 21, '2025-11-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(957, 31, 25, 21, '2025-12-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(958, 31, 25, 21, '2026-01-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(959, 31, 25, 21, '2026-02-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(960, 31, 25, 21, '2026-03-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(961, 31, 25, 21, '2026-04-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(962, 31, 25, 21, '2026-05-06 00:00:00', 2400.00, 67.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(963, 32, 26, 22, '2023-06-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(964, 32, 26, 22, '2023-07-06 00:00:00', 3000.00, 125.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-08-20 23:30:50'),
(965, 32, 26, 22, '2023-08-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(966, 32, 26, 22, '2023-09-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(967, 32, 26, 22, '2023-10-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(968, 32, 26, 22, '2023-11-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(969, 32, 26, 22, '2023-12-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(970, 32, 26, 22, '2024-01-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(971, 32, 26, 22, '2024-02-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(972, 32, 26, 22, '2024-03-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(973, 32, 26, 22, '2024-04-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(974, 32, 26, 22, '2024-05-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(975, 32, 26, 22, '2024-06-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(976, 32, 26, 22, '2024-07-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(977, 32, 26, 22, '2024-08-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(978, 32, 26, 22, '2024-09-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(979, 32, 26, 22, '2024-10-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(980, 32, 26, 22, '2024-11-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(981, 32, 26, 22, '2024-12-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(982, 32, 26, 22, '2025-01-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(983, 32, 26, 22, '2025-02-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(984, 32, 26, 22, '2025-03-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(985, 32, 26, 22, '2025-04-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(986, 32, 26, 22, '2025-05-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(987, 33, 27, 23, '2023-06-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(988, 33, 27, 23, '2023-07-06 00:00:00', 3000.00, 125.00, '2023-07', 'Paid', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-08-20 23:30:50'),
(989, 33, 27, 23, '2023-08-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(990, 33, 27, 23, '2023-09-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(991, 33, 27, 23, '2023-10-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(992, 33, 27, 23, '2023-11-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(993, 33, 27, 23, '2023-12-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(994, 33, 27, 23, '2024-01-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(995, 33, 27, 23, '2024-02-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(996, 33, 27, 23, '2024-03-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(997, 33, 27, 23, '2024-04-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(998, 33, 27, 23, '2024-05-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(999, 33, 27, 23, '2024-06-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1000, 33, 27, 23, '2024-07-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1001, 33, 27, 23, '2024-08-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1002, 33, 27, 23, '2024-09-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1003, 33, 27, 23, '2024-10-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1004, 33, 27, 23, '2024-11-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1005, 33, 27, 23, '2024-12-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1006, 33, 27, 23, '2025-01-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1007, 33, 27, 23, '2025-02-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1008, 33, 27, 23, '2025-03-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1009, 33, 27, 23, '2025-04-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1010, 33, 27, 23, '2025-05-06 00:00:00', 3000.00, 125.00, NULL, 'Pending', 'No', 1, '2023-06-06 11:06:30', NULL, NULL, NULL, NULL, '2023-06-06 16:06:30', '2023-06-06 16:06:30'),
(1011, 56, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1012, 57, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1013, 58, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1014, 59, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1015, 60, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1016, 61, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1017, 62, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1018, 63, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1019, 64, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1020, 65, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1021, 66, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1022, 67, 28, 2, '2024-08-25 00:00:00', 2200.00, 2200.00, NULL, 'Pending', 'No', 1, '2024-08-25 13:30:45', NULL, NULL, NULL, NULL, '2024-08-25 07:30:45', '2024-08-25 07:30:45'),
(1023, 1, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1024, 2, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1025, 3, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1026, 4, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1027, 5, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1028, 6, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1029, 7, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1030, 8, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1031, 9, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1032, 10, 28, 1, '2024-08-27 00:00:00', 1950.00, 1950.00, NULL, 'Pending', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(1033, 11, 28, 2, '2024-12-10 00:00:00', 1.00, 1.00, NULL, 'Pending', 'No', 1, '2024-12-10 12:42:59', NULL, NULL, NULL, NULL, '2024-12-10 06:42:59', '2024-12-10 06:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_products`
--

CREATE TABLE `tbl_asset_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `productName` varchar(191) NOT NULL,
  `productCode` varchar(191) DEFAULT NULL,
  `modelNo` varchar(191) DEFAULT NULL,
  `productImage` varchar(191) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `type` enum('serialize','regular','','') NOT NULL DEFAULT 'serialize',
  `tbl_assetCategoryId` bigint(20) DEFAULT NULL,
  `tbl_assetBrandId` bigint(20) DEFAULT NULL,
  `units` varchar(191) DEFAULT NULL,
  `purchase_quantity` int(255) DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_products`
--

INSERT INTO `tbl_asset_products` (`id`, `productName`, `productCode`, `modelNo`, `productImage`, `notes`, `type`, `tbl_assetCategoryId`, `tbl_assetBrandId`, `units`, `purchase_quantity`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(28, 'Table', '000028', 'T12', '1724579448t12.jpeg', NULL, 'serialize', 2, 6, 'Piece', 47, 'Active', 'No', 1, '2024-08-25 09:50:48', NULL, NULL, NULL, NULL, '2024-08-25 03:50:48', '2024-12-10 06:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_product_brands`
--

CREATE TABLE `tbl_asset_product_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `address` varchar(191) DEFAULT NULL,
  `remarks` varchar(191) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_product_brands`
--

INSERT INTO `tbl_asset_product_brands` (`id`, `name`, `address`, `remarks`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'Common', NULL, NULL, 'Active', 'No', 1, '2023-06-05 18:10:59', NULL, NULL, NULL, NULL, '2023-06-05 23:10:59', '2023-06-05 23:10:59'),
(2, 'Riland', NULL, NULL, 'Active', 'No', 1, '2023-06-05 18:13:51', NULL, NULL, NULL, NULL, '2023-06-05 23:13:51', '2023-06-05 23:13:51'),
(3, 'Dell', NULL, NULL, 'Active', 'No', 1, '2023-06-05 18:13:58', NULL, NULL, NULL, NULL, '2023-06-05 23:13:58', '2023-06-05 23:13:58'),
(4, 'Epson', NULL, NULL, 'Active', 'No', 1, '2023-06-05 18:14:06', NULL, NULL, NULL, NULL, '2023-06-05 23:14:06', '2023-06-05 23:14:06'),
(5, 'Samsung', NULL, NULL, 'Active', 'No', 1, '2023-06-05 18:14:18', NULL, NULL, NULL, NULL, '2023-06-05 23:14:18', '2023-06-05 23:14:18'),
(6, 'RFL', NULL, NULL, 'Active', 'No', 1, '2023-06-05 18:14:48', NULL, NULL, NULL, NULL, '2023-06-05 23:14:48', '2023-06-05 23:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_product_categories`
--

CREATE TABLE `tbl_asset_product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_product_categories`
--

INSERT INTO `tbl_asset_product_categories` (`id`, `name`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'Active', 'No', 1, '2023-06-05 17:57:53', NULL, NULL, NULL, NULL, '2023-06-05 22:57:53', '2023-06-05 22:57:53'),
(2, 'Furnitures', 'Active', 'No', 1, '2023-06-05 17:58:05', NULL, NULL, NULL, NULL, '2023-06-05 22:58:05', '2023-06-05 22:58:05'),
(3, 'Hand Tools', 'Active', 'No', 1, '2023-06-05 17:59:24', NULL, NULL, NULL, NULL, '2023-06-05 22:59:24', '2023-06-05 22:59:24'),
(4, 'Compressor', 'Active', 'No', 1, '2023-06-05 17:59:53', NULL, NULL, NULL, NULL, '2023-06-05 22:59:53', '2023-06-05 22:59:53'),
(5, 'Cylinder', 'Active', 'No', 1, '2023-06-05 18:00:05', NULL, NULL, NULL, NULL, '2023-06-05 23:00:05', '2023-06-05 23:00:05'),
(6, 'Cables', 'Active', 'No', 1, '2023-06-05 18:06:00', NULL, NULL, NULL, NULL, '2023-06-05 23:06:00', '2023-06-05 23:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_product_specifications`
--

CREATE TABLE `tbl_asset_product_specifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `specificationName` varchar(191) DEFAULT NULL,
  `specificationValue` varchar(191) DEFAULT NULL,
  `tbl_assetProductId` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_purchases`
--

CREATE TABLE `tbl_asset_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_no` varchar(191) DEFAULT NULL,
  `coa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asset_brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `previous_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_with_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_payment` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sale_quantity` bigint(20) NOT NULL DEFAULT 0,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `selected_sister_concern` int(20) DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_purchases`
--

INSERT INTO `tbl_asset_purchases` (`id`, `purchase_no`, `coa_id`, `asset_brand_id`, `supplier_id`, `date`, `description`, `total_amount`, `grand_total`, `previous_due`, `total_with_due`, `current_payment`, `current_balance`, `sale_quantity`, `sister_concern_id`, `selected_sister_concern`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '000001', NULL, NULL, 1, '2024-08-27 00:00:00', NULL, 19500.00, 19500.00, 0.00, 19500.00, 19500.00, 0.00, 0, 2, 2, 'Active', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(2, '000002', NULL, NULL, 1, '2024-12-10 00:00:00', NULL, 3.00, 3.00, 0.00, 3.00, 0.00, 3.00, 0, 2, 2, 'Active', 'No', 1, '2024-12-10 12:42:59', NULL, NULL, NULL, NULL, '2024-12-10 06:42:59', '2024-12-10 06:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_purchase_products`
--

CREATE TABLE `tbl_asset_purchase_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asset_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `unit_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `expired_date` date DEFAULT NULL,
  `sell_quantity` bigint(20) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `sell_status` enum('On','Off') NOT NULL DEFAULT 'On',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` date DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_purchase_products`
--

INSERT INTO `tbl_asset_purchase_products` (`id`, `asset_purchase_id`, `asset_product_id`, `warehouse_id`, `unit`, `unit_price`, `quantity`, `subtotal`, `expired_date`, `sell_quantity`, `status`, `sell_status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `updated_at`, `created_at`) VALUES
(1, 1, 28, 1, 'Piece', 1950.00, 10, 19500.00, NULL, 0, 'Active', 'On', 'No', 1, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 06:12:24', '2024-08-27 06:12:24'),
(2, 2, 28, 1, 'Piece', 1.00, 3, 3.00, NULL, 0, 'Active', 'On', 'No', 1, '2024-12-10 12:42:59', NULL, NULL, NULL, NULL, '2024-12-10 12:42:59', '2024-12-10 12:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_sales`
--

CREATE TABLE `tbl_asset_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(255) DEFAULT NULL,
  `sale_no` varchar(191) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `coa_id` int(11) DEFAULT NULL,
  `current_payment` decimal(12,2) NOT NULL DEFAULT 0.00,
  `party_name` varchar(255) DEFAULT NULL,
  `party_contact` varchar(255) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_serialize_products`
--

CREATE TABLE `tbl_asset_serialize_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_assetProductsId` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) NOT NULL,
  `asset_purchase_id` bigint(20) DEFAULT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `serial_no` varchar(20) DEFAULT NULL,
  `depreciation` varchar(191) DEFAULT NULL,
  `no_of_month` int(11) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `per_month` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deducted` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deducted_month` int(255) DEFAULT NULL,
  `quantity` bigint(20) DEFAULT NULL,
  `used_quantity` bigint(20) NOT NULL DEFAULT 0,
  `is_sold` enum('ON','OFF') NOT NULL DEFAULT 'OFF',
  `sold_price` decimal(10,2) DEFAULT NULL,
  `price_after_depreciation` decimal(10,2) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `depricision_status` enum('Yes','No') DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `sold_by` int(11) DEFAULT NULL,
  `sold_date` varchar(50) DEFAULT NULL,
  `asset_sale_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_serialize_products`
--

INSERT INTO `tbl_asset_serialize_products` (`id`, `tbl_assetProductsId`, `warehouse_id`, `asset_purchase_id`, `sister_concern_id`, `serial_no`, `depreciation`, `no_of_month`, `price`, `per_month`, `deducted`, `deducted_month`, `quantity`, `used_quantity`, `is_sold`, `sold_price`, `price_after_depreciation`, `supplier_id`, `status`, `depricision_status`, `deleted`, `created_by`, `sold_by`, `sold_date`, `asset_sale_id`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 28, 1, 1, 2, '000001', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(2, 28, 1, 1, 2, '000002', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(3, 28, 1, 1, 2, '000003', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(4, 28, 1, 1, 2, '000004', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(5, 28, 1, 1, 2, '000005', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(6, 28, 1, 1, 2, '000006', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(7, 28, 1, 1, 2, '000007', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(8, 28, 1, 1, 2, '000008', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(9, 28, 1, 1, 2, '000009', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(10, 28, 1, 1, 2, '000010', 'One Time Pay', 1, 1950.00, 1950.00, 1950.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-08-27 06:12:24', NULL, NULL, NULL, NULL, '2024-08-27 00:12:24', '2024-08-27 00:12:24'),
(11, 28, 1, 2, NULL, '000011', 'One Time Pay', 1, 1.00, 1.00, 1.00, 1, 1, 0, 'OFF', NULL, NULL, 1, 'Yes', 'Yes', 'No', 1, NULL, NULL, NULL, '2024-12-10 12:42:59', NULL, NULL, NULL, NULL, '2024-12-10 06:42:59', '2024-12-10 06:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_shift`
--

CREATE TABLE `tbl_asset_shift` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_asset_id` bigint(20) DEFAULT NULL,
  `tbl_building_id` bigint(20) DEFAULT NULL,
  `room_to` bigint(20) DEFAULT NULL,
  `room_From` bigint(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_asset_shift`
--

INSERT INTO `tbl_asset_shift` (`id`, `tbl_asset_id`, `tbl_building_id`, `room_to`, `room_From`, `remarks`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 6, 3, NULL, 'No', 'Active', 1, '2024-07-02 13:28:51', NULL, NULL, NULL, NULL, '2024-07-02 07:28:51', '2024-07-02 07:28:51'),
(2, 28, 1, 2, 1, NULL, 'No', 'Active', 1, '2024-11-12 13:27:07', NULL, NULL, NULL, NULL, '2024-11-12 07:27:07', '2024-11-12 07:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `booking_date` datetime DEFAULT NULL,
  `approximate_arrival` datetime DEFAULT NULL,
  `approximate_checkout` datetime DEFAULT NULL,
  `booking_status` enum('pre_booked','booked') NOT NULL DEFAULT 'booked',
  `tbl_building_Id` bigint(20) DEFAULT NULL,
  `tbl_party_id` bigint(20) DEFAULT NULL,
  `adult_member` int(11) DEFAULT NULL,
  `child_member` int(11) DEFAULT NULL,
  `referal` varchar(255) DEFAULT NULL,
  `complementary_breakfast` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `totalPrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payable_tarrif` varchar(255) DEFAULT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `total_discount` double(10,2) DEFAULT NULL,
  `down_payment` double(10,2) DEFAULT NULL,
  `payable_amount` double(10,2) DEFAULT 0.00,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`id`, `code`, `booking_date`, `approximate_arrival`, `approximate_checkout`, `booking_status`, `tbl_building_Id`, `tbl_party_id`, `adult_member`, `child_member`, `referal`, `complementary_breakfast`, `payment_method`, `totalPrice`, `grand_total`, `payable_tarrif`, `discount`, `total_discount`, `down_payment`, `payable_amount`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(3, '000001', '2025-01-09 12:00:00', '2025-01-09 12:00:00', '2025-01-09 12:00:00', 'booked', 1, 3, 1, 1, NULL, 'Yes', 'Cash', 2000.00, 2000.00, NULL, 0.00, NULL, 1000.00, 0.00, 'No', 'Active', 1, '2025-01-09 10:47:29', NULL, NULL, NULL, NULL, '2025-01-09 04:47:29', '2025-01-09 04:47:29'),
(4, '000002', '2025-01-11 12:00:00', '2025-01-11 12:00:00', '2025-01-11 12:00:00', 'booked', 1, 4, 2, 2, NULL, 'Yes', 'Cash', 17500.00, 17500.00, NULL, 0.00, NULL, 10000.00, 0.00, 'No', 'Active', 1, '2025-01-11 11:18:04', NULL, NULL, NULL, NULL, '2025-01-11 05:18:04', '2025-01-11 05:18:04'),
(5, '000003', '2025-01-29 12:00:00', '2025-01-29 12:00:00', '2025-01-29 12:00:00', 'booked', 1, 4, 1, 1, NULL, 'Yes', 'Cash', 7599.00, 7599.00, NULL, 0.00, NULL, 2000.00, 0.00, 'No', 'Active', 1, '2025-01-29 07:20:22', NULL, NULL, NULL, NULL, '2025-01-29 01:20:22', '2025-01-29 01:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_details`
--

CREATE TABLE `tbl_booking_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_booking_id` bigint(20) DEFAULT NULL,
  `tbl_room_id` bigint(20) DEFAULT NULL,
  `booking_from` datetime DEFAULT NULL,
  `booking_to` datetime DEFAULT NULL,
  `tariff_fee` int(11) DEFAULT NULL,
  `adult` int(11) DEFAULT NULL,
  `child` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payable_tariff` varchar(255) DEFAULT NULL,
  `approximate_arrival` datetime DEFAULT NULL,
  `approximate_checkout` datetime DEFAULT NULL,
  `checkin_date` datetime DEFAULT NULL,
  `checkout_date` datetime DEFAULT NULL,
  `cancellation_date` datetime DEFAULT NULL,
  `occupied_time` datetime DEFAULT NULL,
  `released_time` datetime DEFAULT NULL,
  `states` enum('check_in','occupied','check_out','release','cancle') DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_booking_details`
--

INSERT INTO `tbl_booking_details` (`id`, `tbl_booking_id`, `tbl_room_id`, `booking_from`, `booking_to`, `tariff_fee`, `adult`, `child`, `price`, `payable_tariff`, `approximate_arrival`, `approximate_checkout`, `checkin_date`, `checkout_date`, `cancellation_date`, `occupied_time`, `released_time`, `states`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(3, 3, 1, NULL, NULL, NULL, 1, 1, 2000.00, NULL, '2025-01-09 12:00:00', '2025-01-09 12:00:00', '2025-01-09 11:46:00', '2025-01-13 14:46:00', NULL, NULL, NULL, 'check_out', 'No', 'Active', 1, '2025-01-09 10:47:29', 1, '2025-01-09 11:04:31', NULL, NULL, '2025-01-09 04:47:29', '2025-01-09 05:04:31'),
(4, 4, 3, NULL, NULL, NULL, 1, 1, 10000.00, NULL, '2025-01-11 12:00:00', '2025-01-11 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2025-01-11 11:18:04', NULL, NULL, NULL, NULL, '2025-01-11 05:18:04', '2025-01-11 05:18:04'),
(5, 4, 1, NULL, NULL, NULL, 1, 1, 7500.00, NULL, '2025-01-11 12:00:00', '2025-01-11 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2025-01-11 11:18:04', NULL, NULL, NULL, NULL, '2025-01-11 05:18:04', '2025-01-11 05:18:04'),
(6, 5, 1, NULL, NULL, NULL, 1, 1, 7599.00, NULL, '2025-01-29 12:00:00', '2025-01-29 12:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2025-01-29 07:20:22', NULL, NULL, NULL, NULL, '2025-01-29 01:20:22', '2025-01-29 01:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_boy_assign`
--

CREATE TABLE `tbl_boy_assign` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_our_team_id` bigint(20) DEFAULT NULL,
  `tbl_building_id` bigint(20) DEFAULT NULL,
  `room_id` bigint(20) DEFAULT NULL,
  `assigned_date` datetime DEFAULT NULL,
  `time_from` datetime DEFAULT NULL,
  `time_to` datetime DEFAULT NULL,
  `assign_status` enum('assigned','not_assigned','released') DEFAULT NULL,
  `release_time` datetime DEFAULT NULL,
  `service_1` enum('Done','Not_done') DEFAULT NULL,
  `service_2` enum('Done','Not_done') DEFAULT NULL,
  `service_3` enum('Done','Not_done') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_boy_assign`
--

INSERT INTO `tbl_boy_assign` (`id`, `tbl_our_team_id`, `tbl_building_id`, `room_id`, `assigned_date`, `time_from`, `time_to`, `assign_status`, `release_time`, `service_1`, `service_2`, `service_3`, `remarks`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 3, '2024-08-22 00:00:00', '2024-08-23 06:00:00', '2024-08-24 18:00:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2024-08-22 12:30:27', NULL, NULL, NULL, NULL, '2024-08-22 06:30:27', '2024-08-22 06:30:27'),
(2, 1, 2, 4, '2024-08-22 00:00:00', '2024-08-23 06:00:00', '2024-08-24 18:00:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2024-08-22 12:30:27', NULL, NULL, NULL, NULL, '2024-08-22 06:30:27', '2024-08-22 06:30:27'),
(3, 1, 2, 5, '2024-08-22 00:00:00', '2024-08-23 06:00:00', '2024-08-24 18:00:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'Yes', 'Active', 1, '2024-08-22 12:30:27', NULL, NULL, 1, '2024-12-07 11:43:28', '2024-08-22 06:30:27', '2024-12-07 05:43:28'),
(4, 1, 2, 6, '2024-08-22 00:00:00', '2024-08-23 06:00:00', '2024-08-24 18:00:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'Yes', 'Active', 1, '2024-08-22 12:30:27', NULL, NULL, 1, '2024-11-12 13:31:44', '2024-08-22 06:30:27', '2024-11-12 07:31:44'),
(5, 1, 2, 7, '2024-08-22 00:00:00', '2024-08-23 06:00:00', '2024-08-24 18:00:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'Yes', 'Active', 1, '2024-08-22 12:30:27', NULL, NULL, 1, '2024-11-12 13:31:37', '2024-08-22 06:30:27', '2024-11-12 07:31:37'),
(6, 2, 1, 1, '2024-12-07 00:00:00', '2024-12-05 19:11:00', '2024-12-12 20:12:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2024-12-07 12:10:35', NULL, NULL, NULL, NULL, '2024-12-07 06:10:35', '2024-12-07 06:10:35'),
(7, 2, 1, 1, '2024-12-07 00:00:00', '2024-12-11 21:37:00', '2024-12-18 21:37:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2024-12-07 13:35:48', NULL, NULL, NULL, NULL, '2024-12-07 07:35:48', '2024-12-07 07:35:48'),
(8, 2, 2, 3, '2024-12-07 00:00:00', '2024-12-07 18:00:00', '2024-12-08 18:38:00', 'assigned', NULL, NULL, NULL, NULL, 'test', 'No', 'Active', 1, '2024-12-07 13:38:46', NULL, NULL, NULL, NULL, '2024-12-07 07:38:46', '2024-12-07 07:38:46'),
(9, 2, 2, 4, '2024-12-07 00:00:00', '2024-12-07 18:00:00', '2024-12-08 18:38:00', 'assigned', NULL, NULL, NULL, NULL, 'test', 'No', 'Active', 1, '2024-12-07 13:38:46', NULL, NULL, NULL, NULL, '2024-12-07 07:38:46', '2024-12-07 07:38:46'),
(10, 2, 1, 1, '2024-12-07 00:00:00', '2024-12-07 18:00:00', '2024-12-08 18:38:00', 'released', NULL, NULL, NULL, NULL, 'undefined', 'Yes', 'Active', 1, '2024-12-07 13:39:17', 1, '2024-12-08 06:02:45', 1, '2024-12-08 06:02:58', '2024-12-07 07:39:17', '2024-12-08 00:02:58'),
(11, 2, 1, 2, '2024-12-08 00:00:00', '2024-12-08 13:18:00', '2024-12-17 15:20:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'Yes', 'Active', 1, '2024-12-08 06:17:31', NULL, NULL, 1, '2024-12-08 06:21:02', '2024-12-08 00:17:31', '2024-12-08 00:21:02'),
(12, 2, 2, 3, '2024-12-08 00:00:00', '2024-12-08 12:19:00', '2024-12-09 15:22:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'Yes', 'Active', 1, '2024-12-08 06:19:58', NULL, NULL, 1, '2024-12-08 06:20:55', '2024-12-08 00:19:58', '2024-12-08 00:20:55'),
(13, 2, 1, 2, '2024-12-08 00:00:00', '2024-12-08 12:21:00', '2024-12-09 12:21:00', 'assigned', NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2024-12-08 06:21:22', NULL, NULL, NULL, NULL, '2024-12-08 00:21:22', '2024-12-08 00:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_building`
--

CREATE TABLE `tbl_building` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `no_of_floor` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_building`
--

INSERT INTO `tbl_building` (`id`, `name`, `slug`, `color`, `no_of_floor`, `address`, `remarks`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'White House', 'White_House', '#000000', 3, 'OR Nizam,Chittagong', NULL, 'Active', 'No', 1, '2024-12-01 06:34:07', NULL, NULL, NULL, NULL, '2024-12-01 00:34:07', '2024-12-14 06:38:35'),
(2, 'Black House', 'Black_House', '#000000', 9, 'Mirpur', NULL, 'Active', 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:50:03'),
(3, 'Building 3', 'Building_3', '#000000', 5, 'GEC', '<p>test</p>', 'Active', 'No', 1, '2025-01-05 13:42:10', NULL, NULL, NULL, NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_crm_parties`
--

CREATE TABLE `tbl_crm_parties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `alternate_contact` varchar(255) DEFAULT NULL,
  `party_variety` varchar(255) DEFAULT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `credit_limit` decimal(12,2) DEFAULT NULL,
  `current_due` decimal(12,2) DEFAULT 0.00,
  `opening_due` decimal(12,2) DEFAULT NULL,
  `party_type` enum('Supplier','Customer','Walkin_Customer','Both','Investor') NOT NULL,
  `nid_no` varchar(255) DEFAULT NULL,
  `nid_image` varchar(255) DEFAULT NULL,
  `remarks` longtext DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_by` bigint(20) DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_crm_parties`
--

INSERT INTO `tbl_crm_parties` (`id`, `name`, `code`, `address`, `district`, `country_name`, `email`, `contact_person`, `contact`, `alternate_contact`, `party_variety`, `customer_type`, `credit_limit`, `current_due`, `opening_due`, `party_type`, `nid_no`, `nid_image`, `remarks`, `status`, `deleted`, `created_by`, `last_updated_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(3, 'Farhan', '000001', 'GEC', NULL, NULL, NULL, NULL, '01887922063', NULL, NULL, NULL, NULL, 1000.00, NULL, 'Walkin_Customer', '12345555433', '', 'Everything is good!', 'Active', 'No', 1, NULL, '2025-01-09 10:47:29', NULL, NULL, NULL, NULL, '2025-01-09 04:47:29', '2025-01-09 04:47:29'),
(4, 'Tonmoy', '000002', 'GEC', NULL, NULL, NULL, NULL, '01875642457', NULL, NULL, NULL, NULL, 13099.00, NULL, 'Walkin_Customer', '98765678900', '1736594284fff.jpg', 'Everything is good!', 'Active', 'No', 1, NULL, '2025-01-11 11:18:04', NULL, NULL, NULL, NULL, '2025-01-11 05:18:04', '2025-01-29 01:20:22'),
(5, 'jam shed', NULL, NULL, NULL, NULL, NULL, NULL, '028474539235', NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-01 09:27:35', NULL, NULL, NULL, NULL, '2025-02-01 03:27:35', '2025-02-01 03:27:35'),
(6, 'Salim', NULL, NULL, NULL, NULL, NULL, NULL, '01456789034', NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-01 10:20:49', NULL, NULL, NULL, NULL, '2025-02-01 04:20:49', '2025-02-01 04:20:49'),
(31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 06:02:55', NULL, NULL, NULL, NULL, '2025-02-06 00:02:55', '2025-02-06 00:02:55'),
(32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 06:15:33', NULL, NULL, NULL, NULL, '2025-02-06 00:15:33', '2025-02-06 00:15:33'),
(33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 06:15:51', NULL, NULL, NULL, NULL, '2025-02-06 00:15:51', '2025-02-06 00:15:51'),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 06:18:21', NULL, NULL, NULL, NULL, '2025-02-06 00:18:21', '2025-02-06 00:18:21'),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 06:56:59', NULL, NULL, NULL, NULL, '2025-02-06 00:56:59', '2025-02-06 00:56:59'),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:08:55', NULL, NULL, NULL, NULL, '2025-02-06 03:08:55', '2025-02-06 03:08:55'),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:10:41', NULL, NULL, NULL, NULL, '2025-02-06 03:10:41', '2025-02-06 03:10:41'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:14:00', NULL, NULL, NULL, NULL, '2025-02-06 03:14:00', '2025-02-06 03:14:00'),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:17:25', NULL, NULL, NULL, NULL, '2025-02-06 03:17:25', '2025-02-06 03:17:25'),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:20:05', NULL, NULL, NULL, NULL, '2025-02-06 03:20:05', '2025-02-06 03:20:05'),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:36:33', NULL, NULL, NULL, NULL, '2025-02-06 03:36:33', '2025-02-06 03:36:33'),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 09:50:32', NULL, NULL, NULL, NULL, '2025-02-06 03:50:32', '2025-02-06 03:50:32'),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 10:59:25', NULL, NULL, NULL, NULL, '2025-02-06 04:59:25', '2025-02-06 04:59:25'),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 11:01:22', NULL, NULL, NULL, NULL, '2025-02-06 05:01:22', '2025-02-06 05:01:22'),
(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 11:03:53', NULL, NULL, NULL, NULL, '2025-02-06 05:03:53', '2025-02-06 05:03:53'),
(46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 11:32:00', NULL, NULL, NULL, NULL, '2025-02-06 05:32:00', '2025-02-06 05:32:00'),
(47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'Walkin_Customer', NULL, NULL, NULL, 'Active', 'No', 1, NULL, '2025-02-06 11:36:42', NULL, NULL, NULL, NULL, '2025-02-06 05:36:42', '2025-02-06 05:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currentstock`
--

CREATE TABLE `tbl_currentstock` (
  `id` bigint(20) NOT NULL,
  `tbl_productsId` bigint(20) NOT NULL,
  `tbl_wareHouseId` bigint(20) DEFAULT NULL,
  `currentStock` float NOT NULL,
  `purchaseStock` float NOT NULL DEFAULT 0,
  `salesStock` float NOT NULL DEFAULT 0,
  `purchaseReturnStock` decimal(10,0) NOT NULL DEFAULT 0,
  `salesReturnStock` decimal(10,0) NOT NULL DEFAULT 0,
  `initialStock` float NOT NULL DEFAULT 0,
  `break_Quantity` int(20) DEFAULT NULL,
  `broken_quantity` bigint(20) DEFAULT NULL,
  `broken_sold` bigint(20) DEFAULT NULL,
  `broken_damage` bigint(20) DEFAULT NULL,
  `broken_remaining` bigint(20) DEFAULT NULL,
  `broken_perslice_price` decimal(10,2) DEFAULT NULL,
  `purchaseDelete` int(11) NOT NULL DEFAULT 0,
  `salesDelete` int(11) NOT NULL DEFAULT 0,
  `transferFrom` int(11) NOT NULL DEFAULT 0,
  `transferTo` int(11) NOT NULL DEFAULT 0,
  `transferFromDelete` int(11) NOT NULL DEFAULT 0,
  `transferToDelete` int(11) NOT NULL DEFAULT 0,
  `lastUpdatedDate` datetime DEFAULT NULL,
  `lastUpdatedBy` bigint(20) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `entryBy` bigint(20) DEFAULT NULL,
  `entryDate` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `purchaseReturnDelete` decimal(10,2) NOT NULL DEFAULT 0.00,
  `salesReturnDelete` decimal(10,2) NOT NULL DEFAULT 0.00,
  `damageProducts` int(11) NOT NULL DEFAULT 0,
  `damageDelete` int(11) NOT NULL DEFAULT 0,
  `deletedBy` bigint(20) DEFAULT NULL,
  `deletedDate` datetime DEFAULT NULL,
  `dbInsertDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_currentstock`
--

INSERT INTO `tbl_currentstock` (`id`, `tbl_productsId`, `tbl_wareHouseId`, `currentStock`, `purchaseStock`, `salesStock`, `purchaseReturnStock`, `salesReturnStock`, `initialStock`, `break_Quantity`, `broken_quantity`, `broken_sold`, `broken_damage`, `broken_remaining`, `broken_perslice_price`, `purchaseDelete`, `salesDelete`, `transferFrom`, `transferTo`, `transferFromDelete`, `transferToDelete`, `lastUpdatedDate`, `lastUpdatedBy`, `deleted`, `entryBy`, `entryDate`, `updated_at`, `created_at`, `purchaseReturnDelete`, `salesReturnDelete`, `damageProducts`, `damageDelete`, `deletedBy`, `deletedDate`, `dbInsertDate`) VALUES
(7, 13, 5, 0, 30, 0, 5, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 30, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-25 13:07:02', '2024-11-27 23:51:45', '2024-11-25 07:07:02', 5.00, 0.00, 0, 0, NULL, NULL, '2024-11-25 19:07:02'),
(6, 13, 1, 60, 20, 0, 0, 0, 50, NULL, NULL, NULL, NULL, NULL, NULL, 10, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-25 10:49:32', '2024-11-27 23:50:34', '2024-11-25 04:49:32', 0.00, 0.00, 10, 10, NULL, NULL, '2024-11-25 16:49:32'),
(5, 13, NULL, 20, 0, 0, 0, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-25 10:48:56', '2024-11-25 04:48:56', '2024-11-25 04:48:56', 0.00, 0.00, 0, 0, NULL, NULL, '2024-11-25 16:48:56'),
(8, 13, 10, -25, 30, 0, 55, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-26 07:39:45', '2024-11-27 04:59:07', '2024-11-26 01:39:45', 0.00, 0.00, 0, 0, NULL, NULL, '2024-11-26 13:39:45'),
(9, 14, NULL, 20, 0, 0, 0, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-27 13:07:20', '2024-11-27 07:07:20', '2024-11-27 07:07:20', 0.00, 0.00, 0, 0, NULL, NULL, '2024-11-27 19:07:20'),
(10, 14, 1, 30, 0, 0, 0, 0, 30, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-27 13:07:57', '2024-11-27 07:07:57', '2024-11-27 07:07:57', 0.00, 0.00, 5, 5, NULL, NULL, '2024-11-27 19:07:57'),
(11, 14, 5, -40, 10, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 50, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-27 13:10:22', '2024-11-27 23:42:19', '2024-11-27 07:10:22', 0.00, 0.00, 0, 0, NULL, NULL, '2024-11-27 19:10:22'),
(12, 15, NULL, 45, 0, 0, 10, 0, 50, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-28 05:54:22', '2024-11-28 00:08:51', '2024-11-27 23:54:22', 5.00, 0.00, 0, 0, NULL, NULL, '2024-11-28 11:54:22'),
(13, 15, 1, 40, 0, 0, 0, 0, 40, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-28 05:55:05', '2024-11-27 23:55:05', '2024-11-27 23:55:05', 0.00, 0.00, 10, 10, NULL, NULL, '2024-11-28 11:55:05'),
(14, 15, 5, 10, 10, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-11-28 05:56:43', '2024-11-27 23:56:43', '2024-11-27 23:56:43', 0.00, 0.00, 0, 0, NULL, NULL, '2024-11-28 11:56:43'),
(15, 13, 4, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2024-12-05 11:17:38', '2024-12-05 05:17:38', '2024-12-05 05:17:38', 0.00, 0.00, 0, 0, NULL, NULL, '2024-12-05 17:17:38'),
(16, 16, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 07:20:22', '2025-01-12 01:20:22', '2025-01-12 01:20:22', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 13:20:22'),
(17, 16, 1, 20, 0, 0, 0, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 07:21:14', '2025-01-12 01:21:14', '2025-01-12 01:21:14', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 13:21:14'),
(18, 17, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 09:13:15', '2025-01-12 03:13:15', '2025-01-12 03:13:15', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:13:15'),
(19, 18, NULL, 9.5, 0, 0.5, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 09:14:50', '2025-02-06 00:02:55', '2025-01-12 03:14:50', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:14:50'),
(20, 19, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 09:16:28', '2025-01-12 03:16:28', '2025-01-12 03:16:28', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:16:28'),
(21, 20, NULL, 7, 0, 3, 0, 0, 10, NULL, 0, 0, NULL, 0, 0.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:32:00', '2025-02-06 05:32:00', '2025-01-12 03:19:24', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:19:24'),
(22, 21, NULL, 98, 0, 2, 0, 0, 100, NULL, 0, 0, NULL, 0, 0.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:32:00', '2025-02-06 05:32:00', '2025-01-12 03:20:11', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:20:11'),
(23, 22, NULL, 98, 0, 2, 0, 0, 100, NULL, 0, 0, NULL, 0, 0.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:32:00', '2025-02-06 05:32:00', '2025-01-12 03:21:18', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:21:18'),
(24, 23, NULL, 99, 0, 1, 0, 0, 100, NULL, 0, 0, NULL, 0, 0.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:36:42', '2025-02-06 05:36:42', '2025-01-12 03:23:41', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:23:41'),
(25, 24, NULL, 15, 0, 0, 0, 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 09:24:35', '2025-01-12 03:24:35', '2025-01-12 03:24:35', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:24:35'),
(26, 25, NULL, 97, 0, 3, 0, 0, 100, NULL, 0, 0, NULL, 0, 0.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:36:42', '2025-02-06 05:36:42', '2025-01-12 03:26:10', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:26:10'),
(27, 26, NULL, 100, 0, 0, 0, 0, 100, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 09:30:16', '2025-01-12 03:30:16', '2025-01-12 03:30:16', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:30:16'),
(28, 27, NULL, 99, 0, 1, 0, 0, 100, NULL, 0, 0, NULL, 0, 0.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:03:53', '2025-02-06 05:03:53', '2025-01-12 03:31:06', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:31:06'),
(29, 28, NULL, 100, 0, 0, 0, 0, 100, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 09:31:52', '2025-01-12 03:31:52', '2025-01-12 03:31:52', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 15:31:52'),
(30, 29, NULL, 7, 0, 3, 0, 0, 10, NULL, 10, 8, NULL, 2, 39.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:32:00', '2025-02-06 05:32:00', '2025-01-12 04:19:06', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 16:19:06'),
(31, 30, NULL, 0, 0, 1, 0, 0, 100, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 10:20:02', '2025-02-05 04:53:12', '2025-01-12 04:20:02', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 16:20:02'),
(32, 31, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 12:23:02', '2025-01-12 06:23:02', '2025-01-12 06:23:02', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 18:23:02'),
(33, 32, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 12:25:33', '2025-01-12 06:25:33', '2025-01-12 06:25:33', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 18:25:33'),
(34, 33, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-12 12:28:08', '2025-01-12 06:28:08', '2025-01-12 06:28:08', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-12 18:28:08'),
(35, 34, NULL, 3, 0, 0, 0, 0, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-26 08:34:16', '2025-01-26 02:34:16', '2025-01-26 02:34:16', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-26 14:34:16'),
(36, 35, NULL, 9, 0, 1, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-27 05:43:19', '2025-02-05 05:09:19', '2025-01-26 23:43:19', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-27 11:43:19'),
(37, 36, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-27 05:44:09', '2025-01-26 23:44:09', '2025-01-26 23:44:09', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-27 11:44:09'),
(38, 37, NULL, 15, 0, 0, 0, 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-27 05:46:42', '2025-01-26 23:46:42', '2025-01-26 23:46:42', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-27 11:46:42'),
(39, 38, NULL, 10, 0, 0, 0, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-28 10:00:50', '2025-01-28 04:00:50', '2025-01-28 04:00:50', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-28 16:00:50'),
(40, 39, NULL, 15, 0, 0, 0, 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-28 10:01:38', '2025-01-28 04:01:38', '2025-01-28 04:01:38', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-28 16:01:38'),
(41, 40, NULL, 15, 0, 0, 0, 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-28 10:02:33', '2025-01-28 04:02:33', '2025-01-28 04:02:33', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-28 16:02:33'),
(42, 41, NULL, 20, 0, 0, 0, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-28 10:03:29', '2025-01-28 04:03:29', '2025-01-28 04:03:29', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-28 16:03:29'),
(43, 42, NULL, 15, 0, 0, 0, 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-01-28 10:41:41', '2025-01-28 04:41:41', '2025-01-28 04:41:41', 0.00, 0.00, 0, 0, NULL, NULL, '2025-01-28 16:41:41'),
(44, 30, 1, 150, 0, 0, 0, 0, 150, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-05 10:56:31', '2025-02-05 04:56:31', '2025-02-05 04:56:31', 0.00, 0.00, 0, 0, NULL, NULL, '2025-02-05 16:56:31'),
(47, 45, NULL, 88, 0, 12, 0, 0, 100, NULL, 10, 5, NULL, 5, 40.00, 0, 0, 0, 0, 0, 0, NULL, NULL, 'No', 1, '2025-02-06 11:36:42', '2025-02-06 05:36:42', '2025-02-06 03:35:46', 0.00, 0.00, 0, 0, NULL, NULL, '2025-02-06 15:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `sheet_id` bigint(20) DEFAULT NULL,
  `sisterConcern_id` varchar(191) DEFAULT NULL,
  `nid_no` bigint(100) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `member_desingnation` varchar(255) DEFAULT NULL,
  `priority` bigint(20) DEFAULT NULL,
  `mobile_number` bigint(20) DEFAULT NULL,
  `working_hour` bigint(20) DEFAULT NULL,
  `current_grade` bigint(20) DEFAULT NULL,
  `current_step` bigint(20) DEFAULT NULL,
  `account_no` bigint(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `laundry` decimal(10,2) DEFAULT NULL,
  `phone_bill` decimal(10,2) DEFAULT NULL,
  `ta_da` decimal(8,2) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `member_image` varchar(255) DEFAULT NULL,
  `job_location` varchar(255) DEFAULT NULL,
  `salary_type` varchar(255) DEFAULT NULL,
  `is_employee` varchar(255) DEFAULT NULL,
  `member_education` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `social_links` text DEFAULT NULL,
  `short_note` longtext DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `job_left_date` date DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`id`, `group_id`, `sheet_id`, `sisterConcern_id`, `nid_no`, `member_name`, `member_desingnation`, `priority`, `mobile_number`, `working_hour`, `current_grade`, `current_step`, `account_no`, `amount`, `salary`, `laundry`, `phone_bill`, `ta_da`, `address`, `member_image`, `job_location`, `salary_type`, `is_employee`, `member_education`, `description`, `social_links`, `short_note`, `joining_date`, `job_left_date`, `referred_by`, `deleted`, `status`, `created_by`, `created_date`, `last_updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '1,2', 1254789654, 'Supti Kana Dhar', NULL, NULL, 1874444125, NULL, NULL, NULL, NULL, NULL, 15000.00, NULL, NULL, NULL, 'GEC Circle', '1733570022brand.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-13', NULL, NULL, 'No', 'Active', 1, '2024-12-07 07:26:35', 1, '2024-12-07 11:40:18', NULL, NULL, '2024-12-07 01:26:35', '2024-12-07 05:40:18'),
(2, NULL, NULL, '4,5', 214785412547, 'Mr Bean', NULL, NULL, 18745621478, NULL, NULL, NULL, NULL, NULL, 20000.00, NULL, NULL, NULL, 'OR Nizam,GEC', '1733571610NID3225.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-28', NULL, NULL, 'No', 'Active', 1, '2024-12-07 11:40:10', NULL, NULL, NULL, NULL, '2024-12-07 05:40:10', '2024-12-07 05:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_facilities`
--

CREATE TABLE `tbl_facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facility_name` varchar(255) DEFAULT NULL,
  `facility_value` varchar(255) DEFAULT NULL,
  `serial` varchar(255) DEFAULT NULL,
  `icons` varchar(255) DEFAULT NULL,
  `facility_head` varchar(255) DEFAULT NULL,
  `tbl_category_id` bigint(20) DEFAULT NULL,
  `tbl_sisterconcern_id` bigint(20) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_facilities`
--

INSERT INTO `tbl_facilities` (`id`, `facility_name`, `facility_value`, `serial`, `icons`, `facility_head`, `tbl_category_id`, `tbl_sisterconcern_id`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'super delux', '20', NULL, NULL, NULL, 1, NULL, 'No', 'Active', 1, '2024-11-12 12:06:27', 1, '2024-11-12 13:25:10', NULL, NULL, '2024-11-12 06:06:27', '2024-11-12 07:25:10'),
(2, 'asdfm,asfgjasdflk635743674', 'rendom', NULL, NULL, NULL, 2, NULL, 'Yes', 'Active', 1, '2024-11-12 12:06:27', 1, '2024-12-14 12:47:17', 1, '2024-12-14 12:47:31', '2024-11-12 06:06:27', '2024-12-14 06:47:31'),
(3, 'delux', '20', NULL, NULL, NULL, 1, NULL, 'No', 'Active', 1, '2024-11-12 13:25:51', NULL, NULL, NULL, NULL, '2024-11-12 07:25:51', '2024-11-12 07:25:51'),
(4, 'High Delux', 'Best Services', NULL, NULL, NULL, NULL, NULL, 'No', 'Active', 1, '2024-12-14 12:39:56', 1, '2024-12-14 12:43:48', NULL, NULL, '2024-12-14 06:39:56', '2024-12-14 06:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_floor`
--

CREATE TABLE `tbl_floor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `floor_no` int(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `tbl_building_id` bigint(20) DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_floor`
--

INSERT INTO `tbl_floor` (`id`, `name`, `floor_no`, `slug`, `status`, `serial_no`, `tbl_building_id`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '1st', 1, '1st', 'Active', NULL, 1, 'No', 1, '2024-12-01 06:34:07', 1, '2024-12-01 06:41:54', NULL, NULL, '2024-12-01 00:34:07', '2024-12-01 00:41:54'),
(2, '2nd', 2, '2nd', 'Inactive', NULL, 1, 'Yes', 1, '2024-12-01 06:34:07', NULL, NULL, 1, '2024-12-14 12:38:35', '2024-12-01 00:34:07', '2024-12-14 06:38:35'),
(3, '3rd', 3, '3rd', 'Inactive', NULL, 1, 'Yes', 1, '2024-12-01 06:34:07', NULL, NULL, 1, '2024-12-01 06:38:53', '2024-12-01 00:34:07', '2024-12-01 00:38:53'),
(4, '4th', 4, '4th', 'Inactive', NULL, 1, 'Yes', 1, '2024-12-01 06:34:07', NULL, NULL, 1, '2024-12-01 06:38:57', '2024-12-01 00:34:07', '2024-12-01 00:38:57'),
(5, '5th', 5, '5th', 'Inactive', NULL, 1, 'Yes', 1, '2024-12-01 06:34:07', NULL, NULL, 1, '2024-12-01 06:36:17', '2024-12-01 00:34:07', '2024-12-01 00:36:17'),
(6, '1st', 1, '1st', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(7, '2nd', 2, '2nd', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(8, '3rd', 3, '3rd', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(9, '4th', 4, '4th', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(10, '5th', 5, '5th', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(11, '6th', 6, '6th', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(12, '7th', 7, '7th', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(13, '8th', 8, '8th', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(14, '9th', 9, '9th', 'Inactive', NULL, 2, 'Yes', 1, '2024-12-01 06:42:25', NULL, NULL, 1, '2024-12-01 06:50:03', '2024-12-01 00:42:25', '2024-12-01 00:50:03'),
(15, '10th', 10, '10th', 'Inactive', NULL, 2, 'Yes', 1, '2024-12-01 06:42:25', NULL, NULL, 1, '2024-12-01 06:49:59', '2024-12-01 00:42:25', '2024-12-01 00:49:59'),
(16, '11th', 11, '11th', 'Inactive', NULL, 2, 'Yes', 1, '2024-12-01 06:42:25', NULL, NULL, 1, '2024-12-01 06:44:24', '2024-12-01 00:42:25', '2024-12-01 00:44:24'),
(17, '12th', 12, '12th', 'Active', NULL, 2, 'No', 1, '2024-12-01 06:42:25', NULL, NULL, NULL, NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(18, 'Test', 5, 'Test', 'Active', NULL, 1, 'No', 1, '2024-12-14 11:54:56', NULL, NULL, NULL, NULL, '2024-12-14 05:54:56', '2024-12-14 05:54:56'),
(19, 'Test', 3, 'Test', 'Active', NULL, 1, 'No', 1, '2024-12-14 11:58:23', NULL, NULL, NULL, NULL, '2024-12-14 05:58:23', '2024-12-14 05:58:23'),
(20, 'Test2 foor', 4, 'Test2_foor', 'Active', NULL, 1, 'No', 1, '2024-12-14 12:05:30', NULL, NULL, NULL, NULL, '2024-12-14 06:05:30', '2024-12-14 06:05:30'),
(21, '1st', 1, '1st', 'Active', NULL, 3, 'No', 1, '2025-01-05 13:42:10', NULL, NULL, NULL, NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(22, '2nd', 2, '2nd', 'Active', NULL, 3, 'No', 1, '2025-01-05 13:42:10', NULL, NULL, NULL, NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(23, '3rd', 3, '3rd', 'Active', NULL, 3, 'No', 1, '2025-01-05 13:42:10', NULL, NULL, NULL, NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(24, '4th', 4, '4th', 'Active', NULL, 3, 'No', 1, '2025-01-05 13:42:10', NULL, NULL, NULL, NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(25, '5th', 5, '5th', 'Active', NULL, 3, 'No', 1, '2025-01-05 13:42:10', NULL, NULL, NULL, NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('room','floor','product','hotel') DEFAULT NULL,
  `type_id` bigint(20) DEFAULT NULL,
  `specifiacation` varchar(255) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`id`, `name`, `type`, `type_id`, `specifiacation`, `deleted`, `created_by`, `created_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '1732796278download (1).jpg', 'room', 12, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-28 06:17:59', '2024-11-28 06:17:59'),
(2, '1732950779download (1).jpg', 'room', 13, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-30 01:12:59', '2024-11-30 01:12:59'),
(3, '1732951019download (1).jpg', 'room', 14, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-30 01:16:59', '2024-11-30 01:16:59'),
(4, '1732960201groupinstructor_background_changed.png', 'room', 14, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-30 03:50:02', '2024-11-30 03:50:02'),
(5, '17329602021654599993011.jpg', 'room', 14, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-30 03:50:02', '2024-11-30 03:50:02'),
(6, '17329602021663136741WhatsApp Image 2022-06-11 at 4.17.12 PM.jpeg', 'room', 14, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-30 03:50:02', '2024-11-30 03:50:02'),
(7, '1732966827download (1).jpg', 'room', 1, NULL, 'No', NULL, NULL, NULL, NULL, '2024-11-30 05:40:27', '2024-11-30 05:40:27'),
(8, '1733035086download (1).jpg', 'room', 1, NULL, 'No', NULL, NULL, NULL, NULL, '2024-12-01 00:38:06', '2024-12-01 00:38:06'),
(9, '1733035086DALL·E 2024-11-28 16.27.38 - A modern, digital version of a yellow \'bodna\' (traditional water container) with similar shape to the one in the image. The body of the bodna is futur.webp', 'room', 1, NULL, 'No', NULL, NULL, NULL, NULL, '2024-12-01 00:38:07', '2024-12-01 00:38:07'),
(10, '1733035087download.jpg', 'room', 1, NULL, 'No', NULL, NULL, NULL, NULL, '2024-12-01 00:38:07', '2024-12-01 00:38:07'),
(11, '1733035087DALL·E 2024-11-28 16.24.20 - A modern, digital version of a traditional \'bodna\' (water container), typically used in South Asia, reimagined with sleek, futuristic elements. The bo.webp', 'room', 1, NULL, 'No', NULL, NULL, NULL, NULL, '2024-12-01 00:38:07', '2024-12-01 00:38:07'),
(12, '1733035087download (1).jfif', 'room', 1, NULL, 'No', NULL, NULL, NULL, NULL, '2024-12-01 00:38:07', '2024-12-01 00:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_damage_products`
--

CREATE TABLE `tbl_inventory_damage_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `damage_order_no` varchar(255) DEFAULT NULL,
  `products_id` bigint(20) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `damage_quantity` bigint(20) DEFAULT NULL,
  `damage_date` date DEFAULT NULL,
  `remarks` longtext DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` date DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_damage_products`
--

INSERT INTO `tbl_inventory_damage_products` (`id`, `damage_order_no`, `products_id`, `warehouse_id`, `damage_quantity`, `damage_date`, `remarks`, `status`, `deleted`, `created_by`, `updated_by`, `deleted_by`, `deleted_date`, `created_date`, `updated_date`, `created_at`, `updated_at`) VALUES
(1, '000001', 11, 2, 5, '2024-11-25', NULL, 'Active', 'Yes', 1, NULL, 1, '2024-11-25', '2024-11-25 09:17:15', NULL, '2024-11-25 03:17:15', '2024-11-25 03:17:25'),
(2, '000002', 13, 1, 5, '2024-11-25', NULL, 'Active', 'Yes', 1, NULL, 1, '2024-11-25', '2024-11-25 10:52:58', NULL, '2024-11-25 04:52:58', '2024-11-25 05:02:45'),
(3, '000003', 13, 1, 5, '2024-11-25', NULL, 'Active', 'Yes', 1, NULL, 1, '2024-11-25', '2024-11-25 11:03:11', NULL, '2024-11-25 05:03:11', '2024-11-25 05:03:25'),
(4, '000004', 14, 1, 5, '2024-11-27', NULL, 'Active', 'Yes', 1, NULL, 1, '2024-11-27', '2024-11-27 13:08:12', NULL, '2024-11-27 07:08:12', '2024-11-27 07:08:51'),
(5, '000005', 15, 1, 10, '2024-11-28', NULL, 'Active', 'Yes', 1, NULL, 1, '2024-11-28', '2024-11-28 05:55:32', NULL, '2024-11-27 23:55:32', '2024-11-27 23:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_products`
--

CREATE TABLE `tbl_inventory_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `barcode_no` varchar(255) DEFAULT NULL,
  `model_no` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `unit_id` bigint(20) DEFAULT NULL,
  `opening_stock` bigint(20) DEFAULT NULL,
  `remainder_quantity` bigint(20) NOT NULL DEFAULT 0,
  `purchase_quantity` bigint(20) DEFAULT NULL,
  `current_stock` bigint(20) DEFAULT NULL,
  `sale_quantity` bigint(20) DEFAULT NULL,
  `items_in_box` bigint(20) DEFAULT NULL,
  `purchase_price` decimal(12,2) DEFAULT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `total_purchase_price` decimal(12,2) DEFAULT NULL,
  `total_sale_price` decimal(12,2) DEFAULT NULL,
  `remaining_price` decimal(12,2) DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  `type` enum('regular','serialize','service') DEFAULT NULL,
  `stock_check` enum('Yes','No') DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_products`
--

INSERT INTO `tbl_inventory_products` (`id`, `name`, `code`, `image`, `barcode_no`, `model_no`, `category_id`, `brand_id`, `unit_id`, `opening_stock`, `remainder_quantity`, `purchase_quantity`, `current_stock`, `sale_quantity`, `items_in_box`, `purchase_price`, `sale_price`, `discount`, `total_purchase_price`, `total_sale_price`, `remaining_price`, `notes`, `type`, `stock_check`, `slug`, `sister_concern_id`, `status`, `deleted`, `created_by`, `updated_by`, `deleted_by`, `deleted_date`, `created_date`, `updated_date`, `created_at`, `updated_at`) VALUES
(13, 'Tomato', '000001', '1732531736tomato.jfif', '', NULL, 4, NULL, 1, 70, 10, NULL, 105, NULL, 0, 10.00, 12.00, NULL, NULL, NULL, NULL, NULL, 'regular', 'Yes', NULL, NULL, 'Active', 'No', 1, NULL, NULL, NULL, '2024-11-25 10:48:56', NULL, '2024-11-25 04:48:56', '2024-12-05 05:17:38'),
(14, 'potato', '000002', '1732712839download (1).jfif', '0', NULL, 4, 1, 1, 50, 5, NULL, 60, NULL, 0, 10.00, 12.00, NULL, NULL, NULL, NULL, NULL, 'regular', 'Yes', NULL, NULL, 'Active', 'No', 1, 1, NULL, NULL, '2024-11-27 13:07:20', '2024-11-27 13:07:41', '2024-11-27 07:07:20', '2024-11-27 07:11:14'),
(15, 'mutton biriyani', '000003', '1732773261istockphoto-960867816-612x612.jpg', '0', NULL, 5, 1, 1, 90, 10, NULL, 100, NULL, 0, 370.00, 390.00, NULL, NULL, NULL, NULL, 'best biriyani', 'regular', 'Yes', NULL, NULL, 'Active', 'No', 1, 1, NULL, NULL, '2024-11-28 05:54:22', '2024-11-28 05:54:42', '2024-11-27 23:54:22', '2024-11-28 00:08:51'),
(16, 'Mountain due', '000004', '1736666421due.jpg', '0', NULL, 7, 5, 1, 21, 5, NULL, 21, NULL, 0, 50.00, 60.00, 5.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', NULL, 2, 'Active', 'No', 1, 1, NULL, NULL, '2025-01-12 07:20:22', '2025-01-12 09:09:59', '2025-01-12 01:20:22', '2025-01-12 03:09:59'),
(17, 'Cream Tost', '000005', '1736673195CreamToast.jpg', '', NULL, 36, 5, 4, 10, 5, NULL, 10, NULL, 0, 250.00, 280.00, 5.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'cream_tost', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:13:15', NULL, '2025-01-12 03:13:15', '2025-01-12 03:13:15'),
(18, 'Cream jam', '000006', '1736673290CreamJam.jpg', '', NULL, 36, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 390.00, 4.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'cream_jam', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:14:50', NULL, '2025-01-12 03:14:50', '2025-01-12 03:14:50'),
(19, 'Khir Tost', '000007', '1736673388khirToast.jpg', '', NULL, 36, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 390.00, 4.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Khir_tost', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:16:28', NULL, '2025-01-12 03:16:28', '2025-01-12 03:16:28'),
(20, 'Chocolate Milk', '000008', '17366735641640842331-Amul Milk Chocolate - 150 gm.jpg', '', NULL, 37, 5, 1, 10, 5, NULL, 10, NULL, 0, 270.00, 290.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Chocolate_Milk', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:19:24', NULL, '2025-01-12 03:19:24', '2025-01-12 03:19:24'),
(21, 'Kitkat', '000009', '1736673611kitkat.jpg', '', NULL, 37, 5, 1, 100, 10, NULL, 100, NULL, 0, 150.00, 170.00, 4.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Kitkat', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:20:11', NULL, '2025-01-12 03:20:11', '2025-01-12 03:20:11'),
(22, 'Dark Milk', '000010', '17366736771640781336-Cadbury Dairy Milk Bubbly Chocolate Bar 120gm.jpg', '', NULL, 37, 5, 1, 100, 10, NULL, 100, NULL, 0, 260.00, 290.00, 4.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Dark_Milk', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:21:18', NULL, '2025-01-12 03:21:18', '2025-01-12 03:21:18'),
(23, 'Chocolate Cookies', '000011', '1736673821biscuits1.jpg', '0', NULL, 38, 5, 5, 100, 10, NULL, 100, NULL, 0, 210.00, 230.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Chocolate_Cookies', 2, 'Active', 'No', 1, 1, NULL, NULL, '2025-01-12 09:23:41', '2025-01-12 09:25:09', '2025-01-12 03:23:41', '2025-01-12 03:25:09'),
(24, 'Butter cookies', '000012', '1736673875buttercokies.jpg', '0', NULL, 38, 5, 5, 15, 11, NULL, 15, NULL, 0, 170.00, 200.00, 3.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Butter_cookies', 2, 'Active', 'No', 1, 1, NULL, NULL, '2025-01-12 09:24:35', '2025-01-12 09:25:17', '2025-01-12 03:24:35', '2025-01-12 03:25:17'),
(25, 'Amul Chocolate Biscuits', '000013', '1736673970amulcookies.jpg', '', NULL, 38, 5, 5, 100, 10, NULL, 100, NULL, 0, 120.00, 150.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Amul_Chocolate_Biscuits', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:26:10', NULL, '2025-01-12 03:26:10', '2025-01-12 03:26:10'),
(26, 'Cream Buns', '000014', '1736674216buns2.jpg', '', NULL, 40, 5, 1, 100, 10, NULL, 100, NULL, 0, 30.00, 45.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Cream_Buns', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:30:16', NULL, '2025-01-12 03:30:16', '2025-01-12 03:30:16'),
(27, 'Chicken Buns', '000015', '1736674266burbun.jpg', '', NULL, 40, 5, 1, 100, 10, NULL, 100, NULL, 0, 120.00, 150.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Chicken_Buns', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:31:06', NULL, '2025-01-12 03:31:06', '2025-01-12 03:31:06'),
(28, 'Butter Buns', '000016', '1736674312butterbuns.jpg', '', NULL, 40, 5, 1, 100, 10, NULL, 100, NULL, 0, 30.00, 50.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Butter_Buns', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 09:31:52', NULL, '2025-01-12 03:31:52', '2025-01-12 03:31:52'),
(29, 'Fruits Cake', '000017', '1736677146cakes2.jpg', '', NULL, 39, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 390.00, 2.00, NULL, NULL, NULL, NULL, 'regular', 'No', 'Fruits_Cake', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 10:19:06', NULL, '2025-01-12 04:19:06', '2025-01-12 04:19:06'),
(30, 'cake-Deleted-30', '000018-Deleted-30', '17366772021632311908614b1a64dea24.png', '-Deleted-30', NULL, 39, 5, 5, 250, 10, NULL, 250, NULL, 0, 370.00, 400.00, 3.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'cake', 2, 'Inactive', 'Yes', 1, NULL, 1, '2025-02-05 10:57:45', '2025-01-12 10:20:02', NULL, '2025-01-12 04:20:02', '2025-02-05 04:57:45'),
(31, 'Rosogolla', '000019', '1736684582rosogolla.jpg', '', NULL, 7, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 370.00, 10.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Rosogolla', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 12:23:02', NULL, '2025-01-12 06:23:02', '2025-01-12 06:23:02'),
(32, 'Chomcom', '000020', '1736684742rosogolla.jpg', '0', NULL, 36, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 370.00, 10.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Chomcom', 2, 'Active', 'No', 1, 1, NULL, NULL, '2025-01-12 12:25:33', '2025-01-12 12:25:42', '2025-01-12 06:25:33', '2025-01-12 06:25:42'),
(33, 'KhirChomcom', '000021', '1736684888rosogolla.jpg', '', NULL, 36, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 470.00, 20.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Khir_Chomcom', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-12 12:28:08', NULL, '2025-01-12 06:28:08', '2025-01-12 06:28:08'),
(34, 'celebration Cake', '000022', '1737880455cake-2.png', '', NULL, 6, 5, 4, 3, 1, NULL, 3, NULL, 0, 480.00, 520.00, 5.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'celebration_Cake', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-26 08:34:16', NULL, '2025-01-26 02:34:16', '2025-01-26 02:34:16'),
(35, 'Alfatun', '000023', '1737956598Aplatun.jpg', '', NULL, 36, 5, 4, 10, 3, NULL, 10, NULL, 0, 370.00, 420.00, 50.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Alfatun', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-27 05:43:19', NULL, '2025-01-26 23:43:19', '2025-01-26 23:43:19'),
(36, 'Doi', '000024', '1737956649Doi.jpg', '', NULL, 36, 5, 4, 10, 3, NULL, 10, NULL, 0, 420.00, 450.00, 30.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Doi', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-27 05:44:09', NULL, '2025-01-26 23:44:09', '2025-01-26 23:44:09'),
(37, 'Mix sweets', '000025', '1737956802bonoful_sweets7.jpg', '', NULL, 36, 5, 4, 15, 5, NULL, 15, NULL, 0, 350.00, 370.00, 20.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'Mix_sweets', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-27 05:46:42', NULL, '2025-01-26 23:46:42', '2025-01-26 23:46:42'),
(38, 'KanchaGolla', '000026', '1738058449KanchaGolla.jpg', '', NULL, 36, 5, 4, 10, 5, NULL, 10, NULL, 0, 350.00, 380.00, 30.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'KanchaGolla', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-28 10:00:50', NULL, '2025-01-28 04:00:50', '2025-01-28 04:00:50'),
(39, 'KanchaSondes', '000027', '1738058498KanchaSondes.jpg', '', NULL, 36, 5, 4, 15, 5, NULL, 15, NULL, 0, 420.00, 450.00, 30.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'KanchaSondes', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-28 10:01:38', NULL, '2025-01-28 04:01:38', '2025-01-28 04:01:38'),
(40, 'KadamLaddu', '000028', '1738058553KadamLaddu.jpg', '', NULL, 36, 5, 4, 15, 5, NULL, 15, NULL, 0, 370.00, 390.00, 20.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'KadamLaddu', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-28 10:02:33', NULL, '2025-01-28 04:02:33', '2025-01-28 04:02:33'),
(41, 'KhirChamcham', '000029', '1738058609KhirChamcham.jpg', '', NULL, 36, 5, 4, 20, 5, NULL, 20, NULL, 0, 350.00, 380.00, 30.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'KhirChamcham', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-28 10:03:29', NULL, '2025-01-28 04:03:29', '2025-01-28 04:03:29'),
(42, 'RajVogue', '000030', '1738060901RajVogue.jpg', '', NULL, 36, 5, 4, 15, 5, NULL, 15, NULL, 0, 350.00, 370.00, 20.00, NULL, NULL, NULL, 'Best Quality', 'regular', 'Yes', 'RajVogue', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-01-28 10:41:41', NULL, '2025-01-28 04:41:41', '2025-01-28 04:41:41'),
(45, 'cake', '000031', '17388345451632311908614b1a64dea24.png', '', NULL, 39, 5, 1, 100, 10, NULL, 100, NULL, 0, 370.00, 400.00, 5.00, NULL, NULL, NULL, NULL, 'regular', 'Yes', 'cake', 2, 'Active', 'No', 1, NULL, NULL, NULL, '2025-02-06 09:35:46', NULL, '2025-02-06 03:35:46', '2025-02-06 03:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_product_specification`
--

CREATE TABLE `tbl_inventory_product_specification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_product_id` bigint(20) NOT NULL,
  `specification_name` varchar(255) DEFAULT NULL,
  `specification_value` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_inventory_product_specification`
--

INSERT INTO `tbl_inventory_product_specification` (`id`, `tbl_product_id`, `specification_name`, `specification_value`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 18, 'pre Kg', '390', 'Active', 'No', 1, '2025-01-12 09:14:50', NULL, NULL, NULL, NULL, '2025-01-12 03:14:50', '2025-01-12 03:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_sale`
--

CREATE TABLE `tbl_inventory_sale` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_no` varchar(50) NOT NULL,
  `coa_id` int(11) NOT NULL,
  `tbl_vehicle_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) DEFAULT 0.00,
  `carrying_cost` decimal(15,2) DEFAULT 0.00,
  `vat` decimal(15,2) DEFAULT 0.00,
  `type` varchar(50) NOT NULL,
  `ait` decimal(15,2) DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL,
  `previous_due` decimal(15,2) DEFAULT 0.00,
  `current_balance` decimal(15,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `total_with_due` decimal(15,2) NOT NULL,
  `current_payment` decimal(15,2) NOT NULL,
  `dues_amount` decimal(15,2) DEFAULT 0.00,
  `no_of_tenure` int(11) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `sales_type` varchar(50) NOT NULL,
  `current_dues` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_sale_orders`
--

CREATE TABLE `tbl_inventory_sale_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `sale_no` varchar(255) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `purchase_from` varchar(255) DEFAULT NULL,
  `manufature_no` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `service_note` longtext DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `carrying_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ait` decimal(10,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `advance_payment` decimal(12,2) NOT NULL DEFAULT 0.00,
  `previous_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_with_due` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_payment` decimal(12,2) NOT NULL DEFAULT 0.00,
  `final_sale_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `dues_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_dues` decimal(12,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `sales_type` enum('walkin_sale','FS','party_sale') NOT NULL,
  `work_approval_date` varchar(20) DEFAULT NULL,
  `expected_delivery_date` varchar(20) DEFAULT NULL,
  `manufacturing_si_no` varchar(255) DEFAULT NULL,
  `accessories_recieved` varchar(255) DEFAULT NULL,
  `other_accessories` varchar(255) DEFAULT NULL,
  `quantity` bigint(20) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `service_start_date` date DEFAULT NULL,
  `delivered_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `ready_to_deliver_date` date DEFAULT NULL,
  `customer_change_date` date DEFAULT NULL,
  `order_status` enum('Pending','Completed','Servicing','Cancelled','Delivered','Decline','ReadyToDeliverd') NOT NULL DEFAULT 'Pending',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `sale_status` enum('Incomplete','Completed') NOT NULL DEFAULT 'Incomplete',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory_serialize_products`
--

CREATE TABLE `tbl_inventory_serialize_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tbl_productsId` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) NOT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `serial_no` varchar(20) NOT NULL,
  `quantity` bigint(20) DEFAULT NULL,
  `used_quantity` bigint(20) NOT NULL DEFAULT 0,
  `is_sold` enum('ON','OFF') NOT NULL DEFAULT 'ON',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchases`
--

CREATE TABLE `tbl_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `coa_id` bigint(20) NOT NULL,
  `purchase_no` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `carrying_cost` bigint(20) DEFAULT NULL,
  `grand_total` decimal(12,2) NOT NULL,
  `previous_due` decimal(12,2) NOT NULL,
  `total_with_due` decimal(12,2) NOT NULL,
  `current_payment` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(12,2) NOT NULL,
  `lot_no` int(11) DEFAULT NULL,
  `sale_quantity` bigint(20) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `sister_concern_id` bigint(100) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_purchases`
--

INSERT INTO `tbl_purchases` (`id`, `supplier_id`, `coa_id`, `purchase_no`, `date`, `description`, `total_amount`, `discount`, `carrying_cost`, `grand_total`, `previous_due`, `total_with_due`, `current_payment`, `current_balance`, `lot_no`, `sale_quantity`, `status`, `sister_concern_id`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(2, 1, 30, '000001', '2024-11-25 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -300.00, 400.00, 100.00, 300.00, NULL, 0, 'Active', NULL, 'Yes', 1, '2024-11-25 11:18:09', NULL, NULL, NULL, '2024-11-28 05:50:34', '2024-11-25 05:18:09', '2024-11-27 23:50:34'),
(3, 1, 30, '000002', '2024-11-25 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -300.00, 400.00, 100.00, 300.00, NULL, 0, 'Active', 2, 'Yes', 1, '2024-11-25 13:07:02', NULL, NULL, NULL, '2024-11-28 05:51:45', '2024-11-25 07:07:02', '2024-11-27 23:51:45'),
(4, 1, 30, '000003', '2024-11-26 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -300.00, 400.00, 0.00, 400.00, NULL, 0, 'Active', 2, 'No', 1, '2024-11-26 07:39:45', NULL, NULL, NULL, NULL, '2024-11-26 01:39:45', '2024-11-26 01:39:45'),
(5, 1, 30, '000004', '2024-11-26 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -400.00, 500.00, 0.00, 500.00, NULL, 0, 'Active', 2, 'No', 1, '2024-11-26 07:44:43', NULL, NULL, NULL, NULL, '2024-11-26 01:44:43', '2024-11-26 01:44:43'),
(6, 1, 30, '000005', '2024-11-26 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -500.00, 600.00, 0.00, 600.00, NULL, 0, 'Active', NULL, 'Yes', 1, '2024-11-26 08:06:10', NULL, NULL, NULL, '2024-11-28 05:44:06', '2024-11-26 02:06:10', '2024-11-27 23:44:06'),
(7, 1, 30, '000006', '2024-11-27 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -600.00, 700.00, 0.00, 700.00, NULL, 0, 'Active', 1, 'No', 1, '2024-11-27 08:48:24', NULL, NULL, NULL, NULL, '2024-11-27 02:48:24', '2024-11-27 02:48:24'),
(8, 1, 30, '000007', '2024-11-27 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -700.00, 800.00, 0.00, 800.00, NULL, 0, 'Active', 2, 'No', 1, '2024-11-27 09:36:22', NULL, NULL, NULL, NULL, '2024-11-27 03:36:22', '2024-11-27 03:36:22'),
(9, 1, 30, '000008', '2024-11-27 00:00:00', NULL, 100.00, 0.00, 0, 100.00, -730.00, 830.00, 0.00, 830.00, NULL, 0, 'Active', 4, 'No', 1, '2024-11-27 13:10:22', NULL, NULL, NULL, NULL, '2024-11-27 07:10:22', '2024-11-27 07:10:22'),
(10, 1, 30, '000009', '2024-11-28 00:00:00', NULL, 3700.00, 0.00, 0, 3700.00, -730.00, 4430.00, 0.00, 4430.00, NULL, 0, 'Active', 5, 'No', 1, '2024-11-28 05:56:43', NULL, NULL, NULL, NULL, '2024-11-27 23:56:43', '2024-11-27 23:56:43'),
(11, 1, 30, '000010', '2024-12-05 00:00:00', NULL, 10.00, 0.00, 0, 10.00, -4440.00, 4450.00, 0.00, 4450.00, NULL, 0, 'Active', 2, 'No', 1, '2024-12-05 11:17:38', NULL, NULL, NULL, NULL, '2024-12-05 05:17:38', '2024-12-05 05:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_products`
--

CREATE TABLE `tbl_purchase_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `unit_id` bigint(20) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `lot_no` bigint(20) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `expired_date` date DEFAULT NULL,
  `sell_quantity` bigint(20) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `sell_status` enum('On','Off') NOT NULL DEFAULT 'On',
  `sister_concern_id` bigint(100) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_purchase_products`
--

INSERT INTO `tbl_purchase_products` (`id`, `purchase_id`, `product_id`, `warehouse_id`, `unit_id`, `unit_price`, `quantity`, `lot_no`, `subtotal`, `expired_date`, `sell_quantity`, `status`, `sell_status`, `sister_concern_id`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(2, 2, 13, 1, 1, 10.00, 10, 1, 100.00, NULL, 0, 'Active', 'On', NULL, 'Yes', 1, '2024-11-25 11:18:09', NULL, NULL, 1, '2024-11-28', '2024-11-25 05:18:09', '2024-11-27 23:50:34'),
(3, 3, 13, 5, 1, 10.00, 10, 2, 100.00, NULL, 0, 'Active', 'On', 2, 'Yes', 1, '2024-11-25 13:07:02', NULL, NULL, 1, '2024-11-28', '2024-11-25 07:07:02', '2024-11-27 23:51:45'),
(4, 4, 13, 10, 1, 10.00, 10, 3, 100.00, NULL, 0, 'Active', 'On', 2, 'No', 1, '2024-11-26 07:39:45', NULL, NULL, NULL, NULL, '2024-11-26 01:39:45', '2024-11-26 01:39:45'),
(5, 5, 13, 10, 1, 10.00, 10, 4, 100.00, NULL, 0, 'Active', 'On', 2, 'No', 1, '2024-11-26 07:44:43', NULL, NULL, NULL, NULL, '2024-11-26 01:44:43', '2024-11-26 01:44:43'),
(6, 6, 13, 5, 1, 10.00, 10, 5, 100.00, NULL, 0, 'Active', 'On', NULL, 'Yes', 1, '2024-11-26 08:06:10', NULL, NULL, 1, '2024-11-28', '2024-11-26 02:06:10', '2024-11-27 23:44:06'),
(7, 7, 13, 10, 1, 10.00, 10, 6, 100.00, NULL, 0, 'Active', 'On', 1, 'No', 1, '2024-11-27 08:48:24', NULL, NULL, NULL, NULL, '2024-11-27 02:48:24', '2024-11-27 02:48:24'),
(8, 8, 13, 5, 1, 10.00, 10, 7, 100.00, NULL, 0, 'Active', 'On', 2, 'No', 1, '2024-11-27 09:36:22', NULL, NULL, NULL, NULL, '2024-11-27 03:36:22', '2024-11-27 03:36:22'),
(9, 9, 14, 5, 1, 10.00, 10, 1, 100.00, NULL, 0, 'Active', 'On', 4, 'No', 1, '2024-11-27 13:10:22', NULL, NULL, NULL, NULL, '2024-11-27 07:10:22', '2024-11-27 07:10:22'),
(10, 10, 15, 5, 1, 370.00, 10, 1, 3700.00, NULL, 0, 'Active', 'On', 5, 'No', 1, '2024-11-28 05:56:43', NULL, NULL, NULL, NULL, '2024-11-27 23:56:43', '2024-11-27 23:56:43'),
(11, 11, 13, 4, 1, 10.00, 1, 8, 10.00, NULL, 0, 'Active', 'On', 2, 'No', 1, '2024-12-05 11:17:38', NULL, NULL, NULL, NULL, '2024-12-05 05:17:38', '2024-12-05 05:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurant_order`
--

CREATE TABLE `tbl_restaurant_order` (
  `id` bigint(100) NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `party_id` bigint(100) DEFAULT NULL,
  `room_id` bigint(100) DEFAULT NULL,
  `table_id` bigint(100) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_discount` double(10,2) DEFAULT 0.00,
  `vat` decimal(10,2) DEFAULT NULL,
  `grand_discount` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `due` decimal(10,2) DEFAULT 0.00,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `grand_total` decimal(10,2) DEFAULT 0.00,
  `order_status` enum('Open','Closed','Cancle') NOT NULL DEFAULT 'Open',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('No','Yes') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_restaurant_order`
--

INSERT INTO `tbl_restaurant_order` (`id`, `code`, `party_id`, `room_id`, `table_id`, `total_amount`, `total_discount`, `vat`, `grand_discount`, `paid_amount`, `due`, `order_date`, `grand_total`, `order_status`, `status`, `deleted`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_by`, `deleted_date`) VALUES
(1, '000001', 44, NULL, NULL, 1900.00, 0.00, NULL, NULL, 1900.00, 0.00, '2025-02-06 11:01:22', 1900.00, 'Closed', 'Active', 'No', '2025-02-06 05:01:22', 1, '2025-02-06 05:01:22', NULL, NULL, NULL),
(2, '000002', 45, NULL, NULL, 713.00, 0.00, NULL, NULL, 713.00, 0.00, '2025-02-06 11:03:53', 713.00, 'Closed', 'Active', 'No', '2025-02-06 05:03:53', 1, '2025-02-06 05:03:53', NULL, NULL, NULL),
(3, '000003', 46, NULL, NULL, 1062.00, 0.00, NULL, NULL, 1062.00, 0.00, '2025-02-06 11:32:00', 1062.00, 'Closed', 'Active', 'No', '2025-02-06 05:32:00', 1, '2025-02-06 05:32:00', NULL, NULL, NULL),
(4, '000004', 47, NULL, NULL, 580.00, 0.00, NULL, NULL, 580.00, 0.00, '2025-02-06 11:36:42', 580.00, 'Closed', 'Active', 'No', '2025-02-06 05:36:42', 1, '2025-02-06 05:36:42', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_restaurant_order_details`
--

CREATE TABLE `tbl_restaurant_order_details` (
  `id` bigint(100) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `menu_id` bigint(20) DEFAULT NULL,
  `menu_quantity` bigint(100) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT 0.00,
  `unit_discount_price` decimal(10,2) DEFAULT 0.00,
  `unit_price_after_discount` decimal(12,2) DEFAULT NULL,
  `unit_total_price` decimal(10,2) DEFAULT 0.00,
  `product_broken_type` enum('Yes','No') NOT NULL DEFAULT 'No',
  `sub_quantity` decimal(10,2) DEFAULT NULL,
  `sub_unit_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_restaurant_order_details`
--

INSERT INTO `tbl_restaurant_order_details` (`id`, `order_id`, `category_id`, `menu_id`, `menu_quantity`, `unit_price`, `unit_discount_price`, `unit_price_after_discount`, `unit_total_price`, `product_broken_type`, `sub_quantity`, `sub_unit_price`, `status`, `deleted`, `deleted_at`, `deleted_by`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, NULL, 45, 5, 400.00, 0.00, 370.00, 2000.00, 'Yes', 95.00, 20.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:01:22', 1, '2025-02-06 05:01:22', NULL),
(2, 2, NULL, 29, 1, 390.00, 0.00, 350.00, 390.00, 'Yes', 7.00, 39.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:03:53', 1, '2025-02-06 05:03:53', NULL),
(3, 2, NULL, 27, 1, 150.00, 0.00, 120.00, 150.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:03:53', 1, '2025-02-06 05:03:53', NULL),
(4, 2, NULL, 22, 1, 290.00, 0.00, 260.00, 290.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:03:53', 1, '2025-02-06 05:03:53', NULL),
(5, 3, NULL, 29, 1, 390.00, 0.00, 350.00, 312.00, 'Yes', 8.00, 39.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:32:00', 1, '2025-02-06 05:32:00', NULL),
(6, 3, NULL, 20, 1, 290.00, 0.00, 270.00, 290.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:32:00', 1, '2025-02-06 05:32:00', NULL),
(7, 3, NULL, 22, 1, 290.00, 0.00, 260.00, 290.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:32:00', 1, '2025-02-06 05:32:00', NULL),
(8, 3, NULL, 21, 1, 170.00, 0.00, 150.00, 170.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:32:00', 1, '2025-02-06 05:32:00', NULL),
(9, 4, NULL, 45, 1, 400.00, 0.00, 370.00, 200.00, 'Yes', 5.00, 40.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:36:42', 1, '2025-02-06 05:36:42', NULL),
(10, 4, NULL, 25, 1, 150.00, 0.00, 120.00, 150.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:36:42', 1, '2025-02-06 05:36:42', NULL),
(11, 4, NULL, 23, 1, 230.00, 0.00, 210.00, 230.00, 'No', 0.00, 0.00, 'Active', 'No', NULL, NULL, '2025-02-06 05:36:42', 1, '2025-02-06 05:36:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_facilities`
--

CREATE TABLE `tbl_room_facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `tbl_facilities_id` bigint(20) DEFAULT NULL,
  `tbl_room_id` bigint(20) DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_room_facilities`
--

INSERT INTO `tbl_room_facilities` (`id`, `value`, `remarks`, `tbl_facilities_id`, `tbl_room_id`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '200', NULL, 1, 9, 'No', 'Active', 1, '2024-11-12 12:16:55', NULL, NULL, NULL, NULL, '2024-11-12 06:16:55', '2024-11-12 06:16:55'),
(2, '20', NULL, 1, 10, 'No', 'Active', 1, '2024-11-12 12:17:50', NULL, NULL, NULL, NULL, '2024-11-12 06:17:50', '2024-11-12 06:17:50'),
(3, '200', NULL, 1, 11, 'No', 'Active', 1, '2024-11-12 12:47:39', NULL, NULL, NULL, NULL, '2024-11-12 06:47:39', '2024-11-12 06:47:39'),
(4, '20                                                ', NULL, 1, 12, 'No', 'Active', 1, '2024-11-28 12:20:21', NULL, NULL, NULL, NULL, '2024-11-28 06:20:21', '2024-11-28 06:20:21'),
(5, ' 40', NULL, 1, 12, 'No', 'Active', 1, '2024-11-28 12:20:21', NULL, NULL, NULL, NULL, '2024-11-28 06:20:21', '2024-11-28 06:20:21'),
(6, '20 ', NULL, 1, 14, 'No', 'Active', 1, '2024-11-30 09:56:49', NULL, NULL, NULL, NULL, '2024-11-30 03:56:49', '2024-11-30 03:56:49'),
(7, ' 50', NULL, 3, 14, 'No', 'Active', 1, '2024-11-30 09:56:49', NULL, NULL, NULL, NULL, '2024-11-30 03:56:49', '2024-11-30 03:56:49'),
(8, '20', NULL, 1, 1, 'No', 'Active', 1, '2024-11-30 11:40:53', NULL, NULL, NULL, NULL, '2024-11-30 05:40:53', '2024-11-30 05:40:53'),
(9, '20 ', NULL, 1, 1, 'No', 'Active', 1, '2024-11-30 11:41:05', NULL, NULL, NULL, NULL, '2024-11-30 05:41:05', '2024-11-30 05:41:05'),
(10, ' 20', NULL, 3, 1, 'No', 'Active', 1, '2024-11-30 11:41:05', NULL, NULL, NULL, NULL, '2024-11-30 05:41:05', '2024-11-30 05:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_floor_and_warehouses`
--

CREATE TABLE `tbl_room_floor_and_warehouses` (
  `id` int(10) UNSIGNED NOT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `floor_id` bigint(20) DEFAULT NULL,
  `room_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings_company_settings`
--

CREATE TABLE `tbl_settings_company_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `vertical_logo` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `report_header` text DEFAULT NULL,
  `report_footer` text DEFAULT NULL,
  `watermark` varchar(255) DEFAULT NULL,
  `month_year` varchar(255) DEFAULT NULL,
  `terms_conditions` varchar(255) DEFAULT NULL,
  `default_party` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `is_admin` enum('Yes','No') DEFAULT NULL,
  `is_hotel` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_restaurent` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_shop` enum('Yes','No') NOT NULL DEFAULT 'No',
  `is_office` enum('Yes','No') NOT NULL DEFAULT 'No',
  `manage_stock_to_sale` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `barcode_exists` enum('Yes','No') DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_settings_company_settings`
--

INSERT INTO `tbl_settings_company_settings` (`id`, `logo`, `vertical_logo`, `name`, `email`, `phone`, `address`, `website`, `report_header`, `report_footer`, `watermark`, `month_year`, `terms_conditions`, `default_party`, `currency`, `is_admin`, `is_hotel`, `is_restaurent`, `is_shop`, `is_office`, `manage_stock_to_sale`, `barcode_exists`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '1736581524hotellogo.png', '1736581524hotellogo.png', 'Hotel', 'hotel@gmail.com', '01874521478', 'GEC ,Chittagong', 'www.hotel@gmail.com', '<p>Nothing</p>', '<p>Nothing Eese</p>', '1731402727hotel.png', NULL, '<p>not defined</p>', '-999', 'Taka', 'Yes', 'Yes', 'Yes', 'No', 'No', 'Yes', NULL, 'No', 'Active', NULL, NULL, 1, '2025-01-11 07:45:24', NULL, NULL, '2023-10-28 01:11:20', '2025-01-11 01:45:24'),
(2, '1738412213logodfjkdgh.png', '1738412213logodfjkdgh.png', 'ABC Restaurent', 'Abc@gmail.com', '018745522147', 'GEC', 'test', NULL, NULL, NULL, NULL, NULL, NULL, 'Taka', 'Yes', 'Yes', 'Yes', 'No', 'No', 'Yes', NULL, 'No', 'Active', 1, '2023-11-07 05:22:14', 1, '2025-02-01 12:16:53', NULL, NULL, '2023-11-06 17:22:14', '2025-02-01 06:16:53'),
(4, 'no_image.png', NULL, 'Sugandha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'No', 'No', 'No', 'No', 'Yes', NULL, 'No', 'Active', 1, '2023-11-20 12:33:47', 1, '2024-12-04 10:04:38', NULL, NULL, '2023-11-20 00:33:47', '2024-12-04 04:04:38'),
(5, 'no_image.png', NULL, 'City Motel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'No', 'No', 'No', 'No', 'Yes', NULL, 'No', 'Active', 1, '2023-11-21 07:11:17', NULL, NULL, NULL, NULL, '2023-11-20 19:11:17', '2023-11-20 19:11:17'),
(6, '1733311434city mall image.jpg', '1733310773citrymallvertical.png', 'City Mall', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'No', 'No', 'No', 'No', 'Yes', NULL, 'No', 'Active', 1, '2023-11-21 07:19:23', 1, '2024-12-04 11:23:54', NULL, NULL, '2023-11-20 19:19:23', '2024-12-04 05:23:54'),
(8, '1733311488DALL·E 2024-11-28 16.27.38 - A modern, digital version of a yellow \'bodna\' (traditional water container) with similar shape to the one in the image. The body of the bodna is futur.webp', NULL, 'Yunosco-Deleted-8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'No', 'No', 'No', 'No', 'Yes', NULL, 'Yes', 'Active', 1, '2024-12-04 11:24:33', 1, '2024-12-04 11:24:48', 1, '2024-12-04 11:24:52', '2024-12-04 05:24:33', '2024-12-04 05:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_brands`
--

CREATE TABLE `tbl_setups_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setups_brands`
--

INSERT INTO `tbl_setups_brands` (`id`, `name`, `image`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'RFl', '1736672983rfl.png', 'Active', 'No', 1, '2024-08-25 09:20:57', 1, '2025-01-12 09:09:43', NULL, NULL, '2024-08-25 03:20:57', '2025-01-12 03:09:43'),
(2, 'all resturant brand-Deleted-2', '17314034661665573685jafree.png', 'Inactive', 'Yes', 1, '2024-11-12 09:24:08', 1, '2024-11-12 09:24:26', 1, '2024-11-12 09:24:31', '2024-11-12 03:24:08', '2024-11-12 03:24:31'),
(3, 'DHABA-Deleted-3', 'no_image.png', 'Active', 'Yes', 1, '2024-12-04 13:46:28', 1, '2024-12-04 13:46:38', 1, '2024-12-04 13:46:42', '2024-12-04 07:46:28', '2024-12-04 07:46:42'),
(4, 'Dhaba-Deleted-4', '1733378076brand.jpg', 'Active', 'Yes', 1, '2024-12-05 05:54:36', NULL, NULL, 1, '2024-12-05 05:54:47', '2024-12-04 23:54:36', '2024-12-04 23:54:47'),
(5, 'Bonoful', '1736672956bonuful.png', 'Active', 'No', 1, '2025-01-12 09:09:16', NULL, NULL, NULL, NULL, '2025-01-12 03:09:16', '2025-01-12 03:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_categories`
--

CREATE TABLE `tbl_setups_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_type` enum('Product','Room','Room Facility','Food Menu','Sweets_and_confectionery') DEFAULT NULL,
  `sort_code` int(20) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setups_categories`
--

INSERT INTO `tbl_setups_categories` (`id`, `name`, `image`, `category_type`, `sort_code`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'First Class', 'no_image.png', 'Room', NULL, 'Active', 'No', 1, '2024-02-11 10:15:20', NULL, NULL, NULL, NULL, '2024-02-11 04:15:20', '2024-02-11 04:15:20'),
(2, 'Popular', 'no_image.png', 'Food Menu', NULL, 'Active', 'No', 1, '2024-09-01 06:50:00', 1, '2024-12-11 06:14:20', NULL, NULL, '2024-09-01 00:50:00', '2024-12-11 00:14:20'),
(4, 'Curry', 'no_image.png', 'Food Menu', 111, 'Active', 'No', 1, '2024-09-01 06:51:17', 1, '2024-12-11 06:14:12', NULL, NULL, '2024-09-01 00:51:17', '2024-12-11 00:14:12'),
(5, 'Biriyani', 'no_image.png', 'Food Menu', 118, 'Active', 'No', 1, '2024-09-01 06:51:26', 1, '2024-12-11 06:14:07', NULL, NULL, '2024-09-01 00:51:26', '2024-12-11 00:14:07'),
(6, 'Dessert', 'no_image.png', 'Food Menu', 120, 'Active', 'No', 1, '2024-09-01 06:51:51', 1, '2024-12-11 06:14:03', NULL, NULL, '2024-09-01 00:51:51', '2024-12-11 00:14:03'),
(7, 'Drinks', 'no_image.png', 'Food Menu', 121, 'Active', 'No', 1, '2024-09-01 06:51:58', 1, '2024-12-11 06:13:56', NULL, NULL, '2024-09-01 00:51:58', '2024-12-11 00:13:56'),
(13, 'Noodle', 'no_image.png', 'Food Menu', 107, 'Active', 'No', 1, '2024-09-26 07:17:51', 1, '2024-12-11 06:13:51', NULL, NULL, '2024-09-26 01:17:51', '2024-12-11 00:13:51'),
(14, 'Dosa', 'no_image.png', 'Food Menu', 108, 'Active', 'No', 1, '2024-09-26 07:18:13', 1, '2024-12-11 06:13:45', NULL, NULL, '2024-09-26 01:18:13', '2024-12-11 00:13:45'),
(15, 'Paratha & Nann', 'no_image.png', 'Food Menu', 109, 'Active', 'No', 1, '2024-09-26 07:19:02', 1, '2024-12-11 06:13:40', NULL, NULL, '2024-09-26 01:19:02', '2024-12-11 00:13:40'),
(16, 'Kabab & Grill', 'no_image.png', 'Food Menu', 110, 'Active', 'No', 1, '2024-09-26 07:19:53', 1, '2024-12-11 06:13:35', NULL, NULL, '2024-09-26 01:19:53', '2024-12-11 00:13:35'),
(17, 'Vegetable', 'no_image.png', 'Food Menu', 112, 'Active', 'No', 1, '2024-09-26 07:20:32', 1, '2024-12-11 06:13:31', NULL, NULL, '2024-09-26 01:20:32', '2024-12-11 00:13:31'),
(18, 'Chicken', 'no_image.png', 'Food Menu', 113, 'Active', 'No', 1, '2024-09-26 07:20:54', 1, '2024-12-11 06:13:27', NULL, NULL, '2024-09-26 01:20:54', '2024-12-11 00:13:27'),
(19, 'Beef', 'no_image.png', 'Food Menu', 114, 'Active', 'No', 1, '2024-09-26 07:21:08', 1, '2024-12-11 06:13:19', NULL, NULL, '2024-09-26 01:21:08', '2024-12-11 00:13:19'),
(20, 'Fish', 'no_image.png', 'Food Menu', 115, 'Active', 'No', 1, '2024-09-26 07:21:23', 1, '2024-12-11 06:13:15', NULL, NULL, '2024-09-26 01:21:23', '2024-12-11 00:13:15'),
(21, 'Seafood', 'no_image.png', 'Food Menu', 116, 'Active', 'No', 1, '2024-09-26 07:21:36', 1, '2024-12-11 06:13:10', NULL, NULL, '2024-09-26 01:21:36', '2024-12-11 00:13:10'),
(22, 'sizzlers', 'no_image.png', 'Food Menu', 117, 'Active', 'No', 1, '2024-09-26 07:22:04', 1, '2024-12-11 06:13:05', NULL, NULL, '2024-09-26 01:22:04', '2024-12-11 00:13:05'),
(23, 'Rice', 'no_image.png', 'Food Menu', 119, 'Active', 'No', 1, '2024-09-26 07:23:38', 1, '2024-12-11 06:12:58', NULL, NULL, '2024-09-26 01:23:38', '2024-12-11 00:12:58'),
(24, 'Appetizer', '1733319797appitizer.jpg', 'Food Menu', 101, 'Active', 'No', 1, '2024-09-26 07:50:51', 1, '2024-12-04 13:44:12', NULL, NULL, '2024-09-26 01:50:51', '2024-12-04 07:44:12'),
(25, 'Soup', '1733318619soup.jpg', 'Food Menu', 102, 'Active', 'No', 1, '2024-09-26 07:51:29', 1, '2024-12-04 13:23:39', NULL, NULL, '2024-09-26 01:51:29', '2024-12-04 07:23:39'),
(26, 'salad-Deleted-26', '1733317629salad.jpg', 'Food Menu', 104, 'Active', 'Yes', 1, '2024-09-26 09:59:35', 1, '2024-12-04 13:07:09', 1, '2024-12-04 13:07:16', '2024-09-26 03:59:35', '2024-12-04 07:07:16'),
(27, 'Chaat & Fuchka', '1733317301fuchka.jpg', 'Food Menu', 104, 'Active', 'No', 1, '2024-09-26 10:12:11', 1, '2024-12-04 13:01:41', NULL, NULL, '2024-09-26 04:12:11', '2024-12-04 07:01:41'),
(28, 'Roll', '1733317218roll.jpg', 'Food Menu', 105, 'Active', 'No', 1, '2024-09-26 10:19:54', 1, '2024-12-04 13:43:42', NULL, NULL, '2024-09-26 04:19:54', '2024-12-04 07:43:42'),
(29, 'Tomato-Deleted-29', '1733312281tomato.jfif', 'Product', 12, 'Active', 'Yes', 1, '2024-12-04 11:38:01', NULL, NULL, 1, '2024-12-04 11:38:09', '2024-12-04 05:38:01', '2024-12-04 05:38:09'),
(30, 'Tomato-Deleted-30', '1733312357tomato.jfif', 'Food Menu', 10, 'Active', 'Yes', 1, '2024-12-04 11:39:17', 1, '2024-12-04 11:39:45', 1, '2024-12-04 11:39:55', '2024-12-04 05:39:17', '2024-12-04 05:39:55'),
(31, 'Tomato-Deleted-31', '1733312697tomato.jfif', 'Product', 13, 'Active', 'Yes', 1, '2024-12-04 11:44:57', 1, '2024-12-04 11:45:21', 1, '2024-12-04 11:46:13', '2024-12-04 05:44:57', '2024-12-04 05:46:13'),
(32, 'Salad-Deleted-32', '1733317876salad.jpg', 'Food Menu', 1, 'Active', 'Yes', 1, '2024-12-04 13:11:16', 1, '2024-12-04 13:11:29', 1, '2024-12-04 13:11:37', '2024-12-04 07:11:16', '2024-12-04 07:11:37'),
(33, 'Salad-Deleted-33', '1733317916salad.jpg', 'Food Menu', 1, 'Active', 'Yes', 1, '2024-12-04 13:11:56', 1, '2024-12-04 13:12:14', 1, '2024-12-04 13:12:19', '2024-12-04 07:11:56', '2024-12-04 07:12:19'),
(34, 'salad-Deleted-34', '1733318330salad.jpg', 'Food Menu', 11, 'Active', 'Yes', 1, '2024-12-04 13:18:50', NULL, NULL, 1, '2024-12-04 13:22:57', '2024-12-04 07:18:50', '2024-12-04 07:22:57'),
(35, 'salad', '1733318712salad.jpg', 'Food Menu', 112, 'Active', 'No', 1, '2024-12-04 13:25:12', NULL, NULL, NULL, NULL, '2024-12-04 07:25:12', '2024-12-04 07:25:12'),
(36, 'Sweets', '1736669316sweets.jpg', 'Sweets_and_confectionery', 11, 'Active', 'No', 1, '2025-01-12 08:08:36', NULL, NULL, NULL, NULL, '2025-01-12 02:08:36', '2025-01-12 02:08:36'),
(37, 'Chocolate', '1736669403istockphoto-458250835-612x612.jpg', 'Sweets_and_confectionery', 22, 'Active', 'No', 1, '2025-01-12 08:10:03', NULL, NULL, NULL, NULL, '2025-01-12 02:10:03', '2025-01-12 02:10:03'),
(38, 'Bisciuts', '1736670077bis.jpg', 'Sweets_and_confectionery', 3, 'Active', 'No', 1, '2025-01-12 08:21:17', NULL, NULL, NULL, NULL, '2025-01-12 02:21:17', '2025-01-12 02:21:17'),
(39, 'cake', '1736672379cake.jpg', 'Sweets_and_confectionery', 3, 'Active', 'No', 1, '2025-01-12 08:59:39', NULL, NULL, NULL, NULL, '2025-01-12 02:59:39', '2025-01-12 02:59:39'),
(40, 'Buns', '1736672515buns.jpg', 'Sweets_and_confectionery', 3, 'Active', 'No', 1, '2025-01-12 09:01:55', NULL, NULL, NULL, NULL, '2025-01-12 03:01:55', '2025-01-12 03:01:55'),
(41, 'Spiecy Food', 'no_image.png', 'Sweets_and_confectionery', 33, 'Active', 'No', 1, '2025-01-12 10:32:40', NULL, NULL, NULL, NULL, '2025-01-12 04:32:40', '2025-01-12 04:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_damage_products`
--

CREATE TABLE `tbl_setups_damage_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `products_id` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `damage_quantity` bigint(20) NOT NULL,
  `remarks` text DEFAULT NULL,
  `damage_date` date NOT NULL,
  `damage_order_no` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_sisterconcern_categories`
--

CREATE TABLE `tbl_setups_sisterconcern_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `sort_code` bigint(20) DEFAULT 1,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setups_sisterconcern_categories`
--

INSERT INTO `tbl_setups_sisterconcern_categories` (`id`, `sister_concern_id`, `category_id`, `sort_code`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(24, 2, 29, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:38:09', '2024-12-04 05:38:01', '2024-12-04 05:38:09'),
(25, 4, 29, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:38:09', '2024-12-04 05:38:01', '2024-12-04 05:38:09'),
(26, 2, 30, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:39:45', '2024-12-04 05:39:17', '2024-12-04 05:39:45'),
(27, 2, 30, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:39:55', '2024-12-04 05:39:45', '2024-12-04 05:39:55'),
(28, 5, 30, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:39:55', '2024-12-04 05:39:45', '2024-12-04 05:39:55'),
(29, 2, 31, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:45:21', '2024-12-04 05:44:57', '2024-12-04 05:45:21'),
(30, 5, 31, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:45:21', '2024-12-04 05:44:57', '2024-12-04 05:45:21'),
(31, 6, 31, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:45:21', '2024-12-04 05:44:57', '2024-12-04 05:45:21'),
(32, 2, 31, 14, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:46:13', '2024-12-04 05:45:21', '2024-12-04 05:46:13'),
(33, 5, 31, 14, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:46:13', '2024-12-04 05:45:21', '2024-12-04 05:46:13'),
(34, 6, 31, 14, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:46:13', '2024-12-04 05:45:21', '2024-12-04 05:46:13'),
(35, 4, 31, 14, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 11:46:13', '2024-12-04 05:45:21', '2024-12-04 05:46:13'),
(36, 2, 28, 111, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:31:45', '2024-12-04 07:00:18', '2024-12-04 07:31:45'),
(37, 2, 27, 112, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:01:41', '2024-12-04 07:01:41'),
(38, 2, 26, 112, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:07:16', '2024-12-04 07:07:09', '2024-12-04 07:07:16'),
(39, 6, 26, 112, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:07:16', '2024-12-04 07:07:09', '2024-12-04 07:07:16'),
(40, 2, 32, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:11:29', '2024-12-04 07:11:16', '2024-12-04 07:11:29'),
(41, 4, 32, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:11:29', '2024-12-04 07:11:16', '2024-12-04 07:11:29'),
(42, 2, 32, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:11:37', '2024-12-04 07:11:29', '2024-12-04 07:11:37'),
(43, 2, 33, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:12:14', '2024-12-04 07:11:56', '2024-12-04 07:12:14'),
(44, 2, 33, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:12:19', '2024-12-04 07:12:14', '2024-12-04 07:12:19'),
(45, 1, 33, 1, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:12:19', '2024-12-04 07:12:14', '2024-12-04 07:12:19'),
(46, 2, 34, 11, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:22:57', '2024-12-04 07:18:50', '2024-12-04 07:22:57'),
(47, 5, 34, 11, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:22:57', '2024-12-04 07:18:50', '2024-12-04 07:22:57'),
(48, 6, 34, 11, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:22:57', '2024-12-04 07:18:50', '2024-12-04 07:22:57'),
(49, 2, 25, 112, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:23:39', '2024-12-04 07:23:39'),
(50, 4, 25, 112, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:23:39', '2024-12-04 07:23:39'),
(51, 6, 25, 112, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:23:39', '2024-12-04 07:23:39'),
(52, 2, 35, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:25:12', '2024-12-04 07:25:12'),
(53, 4, 35, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:25:12', '2024-12-04 07:25:12'),
(54, 6, 35, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:25:12', '2024-12-04 07:25:12'),
(55, 2, 28, 111, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:43:42', '2024-12-04 07:31:45', '2024-12-04 07:43:42'),
(56, 2, 24, 112, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:44:12', '2024-12-04 07:43:17', '2024-12-04 07:44:12'),
(57, 4, 24, 112, 'Yes', 'Inactive', 1, NULL, NULL, NULL, 1, '2024-12-04 13:44:12', '2024-12-04 07:43:17', '2024-12-04 07:44:12'),
(58, 2, 28, 111, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:43:42', '2024-12-04 07:43:42'),
(59, 2, 24, 112, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:44:12', '2024-12-04 07:44:12'),
(60, 4, 24, 112, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-04 07:44:12', '2024-12-04 07:44:12'),
(61, 2, 23, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:12:58', '2024-12-11 00:12:58'),
(62, 2, 22, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:05', '2024-12-11 00:13:05'),
(63, 2, 21, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:10', '2024-12-11 00:13:10'),
(64, 2, 20, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:15', '2024-12-11 00:13:15'),
(65, 2, 19, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:19', '2024-12-11 00:13:19'),
(66, 2, 18, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:27', '2024-12-11 00:13:27'),
(67, 2, 17, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:31', '2024-12-11 00:13:31'),
(68, 2, 16, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:35', '2024-12-11 00:13:35'),
(69, 2, 15, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:40', '2024-12-11 00:13:40'),
(70, 2, 14, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:45', '2024-12-11 00:13:45'),
(71, 2, 13, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:51', '2024-12-11 00:13:51'),
(72, 2, 7, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:13:56', '2024-12-11 00:13:56'),
(73, 2, 6, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:14:03', '2024-12-11 00:14:03'),
(74, 2, 5, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:14:07', '2024-12-11 00:14:07'),
(75, 2, 4, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:14:12', '2024-12-11 00:14:12'),
(76, 2, 2, 11, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2024-12-11 00:14:20', '2024-12-11 00:14:20'),
(77, 2, 36, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2025-01-12 02:08:36', '2025-01-12 02:08:36'),
(78, 2, 37, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2025-01-12 02:10:03', '2025-01-12 02:10:03'),
(79, 2, 38, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2025-01-12 02:21:17', '2025-01-12 02:21:17'),
(80, 2, 39, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2025-01-12 02:59:39', '2025-01-12 02:59:39'),
(81, 2, 40, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2025-01-12 03:01:55', '2025-01-12 03:01:55'),
(82, 2, 41, 1, 'No', 'Active', 1, NULL, NULL, NULL, NULL, NULL, '2025-01-12 04:32:40', '2025-01-12 04:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_sister_concern_to_warehouses`
--

CREATE TABLE `tbl_setups_sister_concern_to_warehouses` (
  `id` int(10) UNSIGNED NOT NULL,
  `sister_concern_id` bigint(20) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `building_id` bigint(20) DEFAULT NULL,
  `floor_id` bigint(20) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `deleted` enum('Yes','No') DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setups_sister_concern_to_warehouses`
--

INSERT INTO `tbl_setups_sister_concern_to_warehouses` (`id`, `sister_concern_id`, `warehouse_id`, `building_id`, `floor_id`, `status`, `deleted`, `created_by`, `last_updated_by`, `deleted_by`, `created_date`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 1, 0, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:34:07', NULL, '2024-12-01 00:34:07', '2024-12-01 00:34:07'),
(2, 2, 0, 1, 1, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:34:07', NULL, '2024-12-01 00:34:07', '2024-12-01 00:34:07'),
(3, 2, 0, 1, 2, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:34:07', '2024-12-01 06:38:50', '2024-12-01 00:34:07', '2024-12-01 00:38:50'),
(4, 2, 0, 1, 3, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:34:07', '2024-12-01 06:38:53', '2024-12-01 00:34:07', '2024-12-01 00:38:53'),
(5, 2, 0, 1, 4, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:34:07', '2024-12-01 06:38:57', '2024-12-01 00:34:07', '2024-12-01 00:38:57'),
(6, 2, 0, 1, 5, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:34:07', '2024-12-01 06:36:17', '2024-12-01 00:34:07', '2024-12-01 00:36:17'),
(7, 2, 0, 2, 0, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(8, 2, 0, 2, 6, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(9, 2, 0, 2, 7, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(10, 2, 0, 2, 8, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(11, 2, 0, 2, 9, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(12, 2, 0, 2, 10, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(13, 2, 0, 2, 11, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(14, 2, 0, 2, 12, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(15, 2, 0, 2, 13, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(16, 2, 0, 2, 14, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:42:25', '2024-12-01 06:50:03', '2024-12-01 00:42:25', '2024-12-01 00:50:03'),
(17, 2, 0, 2, 15, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:42:25', '2024-12-01 06:49:59', '2024-12-01 00:42:25', '2024-12-01 00:49:59'),
(18, 2, 0, 2, 16, 'Inactive', 'Yes', 1, NULL, 1, '2024-12-01 06:42:25', '2024-12-01 06:44:24', '2024-12-01 00:42:25', '2024-12-01 00:44:24'),
(19, 2, 0, 2, 17, 'Active', 'No', 1, NULL, NULL, '2024-12-01 06:42:25', NULL, '2024-12-01 00:42:25', '2024-12-01 00:42:25'),
(20, 8, 0, 0, 0, 'Active', 'No', 1, NULL, NULL, '2024-12-04 11:24:33', NULL, '2024-12-04 05:24:33', '2024-12-04 05:24:33'),
(21, 2, 0, 1, 18, 'Active', 'No', 1, NULL, NULL, '2024-12-14 11:54:56', NULL, '2024-12-14 05:54:56', '2024-12-14 05:54:56'),
(22, 2, 0, 1, 19, 'Active', 'No', 1, NULL, NULL, '2024-12-14 11:58:23', NULL, '2024-12-14 05:58:23', '2024-12-14 05:58:23'),
(23, 2, 0, 1, 20, 'Active', 'No', 1, NULL, NULL, '2024-12-14 12:05:30', NULL, '2024-12-14 06:05:30', '2024-12-14 06:05:30'),
(24, 2, 0, 3, 0, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(25, 4, 0, 3, 0, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(26, 2, 0, 3, 21, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(27, 4, 0, 3, 21, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(28, 2, 0, 3, 22, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(29, 4, 0, 3, 22, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(30, 2, 0, 3, 23, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(31, 4, 0, 3, 23, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(32, 2, 0, 3, 24, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(33, 4, 0, 3, 24, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(34, 2, 0, 3, 25, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(35, 4, 0, 3, 25, 'Active', 'No', 1, NULL, NULL, '2025-01-05 13:42:10', NULL, '2025-01-05 07:42:10', '2025-01-05 07:42:10'),
(36, 2, 6, NULL, NULL, 'Active', 'No', 1, NULL, NULL, NULL, NULL, '2025-02-05 23:03:46', '2025-02-05 23:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_units`
--

CREATE TABLE `tbl_setups_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setups_units`
--

INSERT INTO `tbl_setups_units` (`id`, `name`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 'Piece', 'Active', 'No', 1, '2024-08-25 09:01:32', NULL, NULL, NULL, NULL, '2024-08-25 03:01:32', '2024-08-25 03:01:32'),
(2, 'KG-Deleted-2', 'Inactive', 'Yes', 1, '2024-11-12 09:24:47', 1, '2024-11-12 09:24:57', 1, '2024-11-12 09:25:01', '2024-11-12 03:24:47', '2024-11-12 03:25:01'),
(3, 'KG-Deleted-3', 'Active', 'Yes', 1, '2024-12-04 13:46:57', 1, '2024-12-04 13:47:03', 1, '2024-12-04 13:47:07', '2024-12-04 07:46:57', '2024-12-04 07:47:07'),
(4, 'KG', 'Active', 'No', 1, '2025-01-12 09:08:40', NULL, NULL, NULL, NULL, '2025-01-12 03:08:40', '2025-01-12 03:08:40'),
(5, 'Packet', 'Active', 'No', 1, '2025-01-12 09:24:55', NULL, NULL, NULL, NULL, '2025-01-12 03:24:55', '2025-01-12 03:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setups_warehouses`
--

CREATE TABLE `tbl_setups_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `present_status` enum('available','pre_booked','booked','occupied') DEFAULT NULL,
  `no_of_ac` bigint(20) DEFAULT NULL,
  `no_of_beds` int(11) DEFAULT NULL,
  `no_of_rooms` int(11) DEFAULT NULL,
  `no_of_washroom` int(11) DEFAULT NULL,
  `no_of_belcony` int(11) DEFAULT NULL,
  `bath_tubs` int(11) DEFAULT NULL,
  `room_size` varchar(255) DEFAULT NULL,
  `room_capacity_adult` varchar(255) DEFAULT NULL,
  `room_capacity_child` varchar(255) DEFAULT NULL,
  `spectacular_view` varchar(255) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `corporate_price` double(10,2) DEFAULT NULL,
  `multiple_images` double(8,2) DEFAULT NULL,
  `tbl_building_id` bigint(20) DEFAULT NULL,
  `tbl_floor_id` bigint(20) DEFAULT NULL,
  `tbl_sister_concern_id` bigint(20) DEFAULT NULL,
  `tbl_category_id` bigint(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('room','warehouse') DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_setups_warehouses`
--

INSERT INTO `tbl_setups_warehouses` (`id`, `name`, `slug`, `present_status`, `no_of_ac`, `no_of_beds`, `no_of_rooms`, `no_of_washroom`, `no_of_belcony`, `bath_tubs`, `room_size`, `room_capacity_adult`, `room_capacity_child`, `spectacular_view`, `price`, `corporate_price`, `multiple_images`, `tbl_building_id`, `tbl_floor_id`, `tbl_sister_concern_id`, `tbl_category_id`, `description`, `type`, `deleted`, `status`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, '101', NULL, 'booked', NULL, 1, 1, 1, 1, 1, '100', '1', '1', NULL, 5000.00, 7599.00, NULL, 1, 1, 2, 1, NULL, 'room', 'No', 'Active', 1, '2024-12-01 06:38:06', 1, '2025-01-09 11:04:31', NULL, NULL, '2024-12-01 00:38:06', '2025-01-11 05:18:04'),
(2, '102', NULL, NULL, NULL, 1, 1, 1, 1, 1, '100', '1', '1', NULL, 4500.00, 6599.00, NULL, 1, 1, 2, 1, NULL, 'room', 'No', 'Active', 1, '2024-12-01 06:41:19', NULL, NULL, NULL, NULL, '2024-12-01 00:41:19', '2024-12-01 00:41:19'),
(3, '1201', NULL, 'booked', NULL, 1, 1, 1, 1, 1, '100', '1', '1', NULL, 4899.00, 12599.00, NULL, 2, 17, 2, 1, NULL, 'room', 'No', 'Active', 1, '2024-12-01 06:43:23', 1, '2024-12-09 07:37:11', NULL, NULL, '2024-12-01 00:43:23', '2025-01-11 05:18:04'),
(4, '801', NULL, 'available', NULL, 1, 1, 1, 1, 1, '100', '1', '1', NULL, 5000.00, 7000.00, NULL, 2, 13, 2, 1, NULL, 'room', 'No', 'Active', 1, '2024-12-01 06:51:36', 1, '2024-12-09 11:02:09', NULL, NULL, '2024-12-01 00:51:36', '2024-12-09 05:02:09'),
(5, 'Room 1001', NULL, 'available', NULL, 1, 1, 1, 1, 1, '100', '1', '1', NULL, 1500.00, 2000.00, NULL, 3, 21, 2, 1, NULL, 'room', 'No', 'Active', 1, '2025-01-05 13:44:19', 1, '2025-01-08 12:17:38', NULL, NULL, '2025-01-05 07:44:19', '2025-01-08 06:17:38'),
(6, 'Bonoful warehouse', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'warehouse', 'No', 'Active', 1, '2025-02-06 05:03:46', NULL, NULL, NULL, NULL, '2025-02-05 23:03:46', '2025-02-05 23:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_payment_vouchers`
--

CREATE TABLE `tbl_voucher_payment_vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) DEFAULT NULL,
  `tbl_booking_id` int(30) DEFAULT 0,
  `resturant_order_id` bigint(100) DEFAULT NULL,
  `purchase_id` bigint(20) DEFAULT NULL,
  `order_sale_id` bigint(20) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `entryBy` bigint(20) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) DEFAULT NULL,
  `chequeNo` varchar(255) DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `chequeIssueDate` date DEFAULT NULL,
  `accountNo` varchar(255) DEFAULT NULL,
  `type` enum('Payment Received','Payment','Payable','Party Payable','Payment Adjustment','Adjustment','Discount') NOT NULL,
  `remarks` longtext DEFAULT NULL,
  `bill_id` bigint(20) DEFAULT NULL,
  `tbl_bankInfoId` bigint(20) DEFAULT NULL,
  `lastUpdatedBy` bigint(20) DEFAULT NULL,
  `voucherType` enum('Local Purchase','Foreign Purchase','WalkinSale','PartySale','FS','TS','PurchaseReturn','SalesReturn','Expense','Bill','Asset Purchase','Asset Sale') NOT NULL,
  `sales_id` bigint(20) DEFAULT NULL,
  `purchase_return_id` bigint(20) DEFAULT NULL,
  `tbl_asset_purchase_id` bigint(20) DEFAULT NULL,
  `tbl_asset_sale_id` bigint(20) DEFAULT NULL,
  `sales_return_id` bigint(20) DEFAULT NULL,
  `expense_id` bigint(20) DEFAULT NULL,
  `tbl_repairing_center_id` bigint(20) DEFAULT NULL,
  `customerType` enum('WalkingCustomer','Party') NOT NULL DEFAULT 'Party',
  `voucherNo` varchar(255) NOT NULL,
  `chequeBank` varchar(255) DEFAULT NULL,
  `dbInsertDate` datetime DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `from_warehouse` bigint(100) DEFAULT 0,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_voucher_payment_vouchers`
--

INSERT INTO `tbl_voucher_payment_vouchers` (`id`, `party_id`, `tbl_booking_id`, `resturant_order_id`, `purchase_id`, `order_sale_id`, `amount`, `entryBy`, `discount`, `payment_method`, `chequeNo`, `paymentDate`, `chequeIssueDate`, `accountNo`, `type`, `remarks`, `bill_id`, `tbl_bankInfoId`, `lastUpdatedBy`, `voucherType`, `sales_id`, `purchase_return_id`, `tbl_asset_purchase_id`, `tbl_asset_sale_id`, `sales_return_id`, `expense_id`, `tbl_repairing_center_id`, `customerType`, `voucherNo`, `chequeBank`, `dbInsertDate`, `status`, `from_warehouse`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `created_at`, `updated_at`) VALUES
(1, 44, 0, 1, NULL, NULL, 1900.00, 1, 0.00, 'Cash', NULL, '2025-02-06', NULL, NULL, 'Payment Received', 'WalkinSale:  payment: 1900', NULL, NULL, NULL, 'WalkinSale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Party', '000001', NULL, NULL, 'Active', 0, 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-06 05:01:22', '2025-02-06 05:01:22'),
(2, 45, 0, 2, NULL, NULL, 713.00, 1, 0.00, 'Cash', NULL, '2025-02-06', NULL, NULL, 'Payment Received', 'WalkinSale:  payment: 713', NULL, NULL, NULL, 'WalkinSale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Party', '000002', NULL, NULL, 'Active', 0, 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-06 05:03:53', '2025-02-06 05:03:53'),
(3, 46, 0, 3, NULL, NULL, 1062.00, 1, 0.00, 'Cash', NULL, '2025-02-06', NULL, NULL, 'Payment Received', 'WalkinSale:  payment: 1062', NULL, NULL, NULL, 'WalkinSale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Party', '000003', NULL, NULL, 'Active', 0, 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-06 05:32:00', '2025-02-06 05:32:00'),
(4, 47, 0, 4, NULL, NULL, 580.00, 1, 0.00, 'Cash', NULL, '2025-02-06', NULL, NULL, 'Payment Received', 'WalkinSale:  payment: 580', NULL, NULL, NULL, 'WalkinSale', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Party', '000004', NULL, NULL, 'Active', 0, 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-06 05:36:42', '2025-02-06 05:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `usertype_id` bigint(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `sister_concern_id` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `deleted` enum('Yes','No') NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_by` bigint(20) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `current_team_id` bigint(20) DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `usertype_id`, `image`, `designation`, `department`, `mobile_no`, `address`, `sister_concern_id`, `role`, `status`, `deleted`, `created_by`, `created_date`, `updated_by`, `updated_date`, `deleted_by`, `deleted_date`, `current_team_id`, `profile_photo_path`, `signature`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin', 'superadmin@gmail.com', NULL, '$2y$10$t46EDnz5ZY2bjaExOB8UF.Kj0VrAsKos5NWtKeloassfb2Quye4Ym', NULL, '1698925518png-transparent-system-administrator-computer-icons-user-others-business-web-browser-user-thumbnail.png', 'super admin', 'super admin', '01882000000', 'admin address', '1,2,3,4,5,6', 'Super Admin', 'Active', 'No', NULL, NULL, 1, '2024-02-11 10:14:16', NULL, NULL, NULL, NULL, 'no_image.png', NULL, '2023-10-28 18:54:10', '2024-02-11 04:14:16'),
(11, 'test', 'test 568', 'test@gmail.com', NULL, '$2y$10$PHzQ7PG3EqV4TCLMHD0fA.wtJ6WeG1/wyof4XseOHa/Wdrp42Kzpi', -999, 'no_image.png', 'test', NULL, '01887922063', 'test', NULL, 'Super Admin', 'Active', 'No', 1, '2023-11-09 13:11:50', 1, '2023-11-11 11:01:26', NULL, NULL, NULL, NULL, 'no_image.png', NULL, '2023-11-09 01:11:50', '2023-11-10 23:01:26'),
(13, 'Farihan', 'farihan', 'farihan@gmail.com', NULL, '$2y$10$tUnFh1ZU97sD/FG2TPlqne/JsYHeEA6y2.Kbjx3ICDe.UxuBEJPTK', -999, '1733037539download (1).jpg', 'test', 'test', '01874521478', 'test', NULL, 'Manager', 'Active', 'No', 1, '2024-12-01 07:18:59', NULL, NULL, NULL, NULL, NULL, NULL, '1733037539DALL·E 2024-11-28 16.27.38 - A modern, digital version of a yellow \'bodna\' (traditional water container) with similar shape to the one in the image. The body of the bodna is futur.webp', NULL, '2024-12-01 01:18:59', '2024-12-01 01:18:59'),
(15, 'Farihan rpiom', 'priom', 'priom@gmail.com', NULL, '$2y$10$vphGTi6eYTx4jP.aCcv7dOXq3VOR4q0T9aYfpnutAGhqe6zRC5zJ.', -999, '1733038384DALL·E 2024-11-20 12.18.14 - A group of five professional instructors standing together, dressed in formal attire with friendly expressions. The background should be a sleek, mode.webp', 'test', 'test', '01874521479', 'test', NULL, 'Manager', 'Active', 'No', 1, '2024-12-01 07:32:25', 1, '2024-12-01 07:35:12', NULL, NULL, NULL, NULL, '1733038372banner1.jpg', NULL, '2024-12-01 01:32:25', '2024-12-01 01:35:12'),
(17, 'SDFGKSZDFfdgh', 'superadmisdfgh', 'asdgfasdfgFSDFG@GMAIL.COM', NULL, '$2y$10$1PF8CDdcXjzgtwCwDJlyxOiPKSoZyVwhPeyBv0sYtBIRLsWS1v9rK', -999, '1733054953download (1).jfif', 'TEST', 'TEST', '01874444148', 'TEST', '4,6', 'Manager', 'Active', 'No', 1, '2024-12-01 09:05:40', 1, '2024-12-01 12:13:43', NULL, NULL, NULL, NULL, '1733048458download (1).jfif', NULL, '2024-12-01 03:05:40', '2024-12-01 06:13:43'),
(18, 'MR. BeanDeleted18', 'beanDeleted18', 'bean@gmail.comDeleted18', NULL, '$2y$10$tWdiCwbrJ82PEkPnELOnGuWGxWr0L6WkV66MTC2tKr5XVzMwvQ.Zq', -999, '17330590061654599993011.jpg', 'test', 'test', '01874555521Deleted18', 'GEC', '2,4', 'Super Admin', 'Active', 'Yes', 1, '2024-12-01 13:16:46', 1, '2024-12-01 13:17:41', 1, '2024-12-01 13:18:42', NULL, NULL, '1733059006download.jpg', NULL, '2024-12-01 07:16:46', '2024-12-01 07:18:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calender_tbl`
--
ALTER TABLE `calender_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dues`
--
ALTER TABLE `dues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_images`
--
ALTER TABLE `menu_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_specifications`
--
ALTER TABLE `menu_specifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `purchase_product_returns`
--
ALTER TABLE `purchase_product_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_accounts_coas`
--
ALTER TABLE `tbl_accounts_coas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_accounts_vouchers`
--
ALTER TABLE `tbl_accounts_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_acc_voucher_details`
--
ALTER TABLE `tbl_acc_voucher_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_assign`
--
ALTER TABLE `tbl_asset_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_depreciation_details`
--
ALTER TABLE `tbl_asset_depreciation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_products`
--
ALTER TABLE `tbl_asset_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_product_brands`
--
ALTER TABLE `tbl_asset_product_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_product_categories`
--
ALTER TABLE `tbl_asset_product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_product_specifications`
--
ALTER TABLE `tbl_asset_product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_asset_product_specifications_tbl_assetproductid_foreign` (`tbl_assetProductId`);

--
-- Indexes for table `tbl_asset_purchases`
--
ALTER TABLE `tbl_asset_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_purchase_products`
--
ALTER TABLE `tbl_asset_purchase_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_sales`
--
ALTER TABLE `tbl_asset_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_serialize_products`
--
ALTER TABLE `tbl_asset_serialize_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_asset_shift`
--
ALTER TABLE `tbl_asset_shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_booking_details`
--
ALTER TABLE `tbl_booking_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_boy_assign`
--
ALTER TABLE `tbl_boy_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_building`
--
ALTER TABLE `tbl_building`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_crm_parties`
--
ALTER TABLE `tbl_crm_parties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_idx` (`contact`);

--
-- Indexes for table `tbl_currentstock`
--
ALTER TABLE `tbl_currentstock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_productsId` (`tbl_productsId`,`tbl_wareHouseId`,`deleted`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_facilities`
--
ALTER TABLE `tbl_facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_floor`
--
ALTER TABLE `tbl_floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_damage_products`
--
ALTER TABLE `tbl_inventory_damage_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_products`
--
ALTER TABLE `tbl_inventory_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_product_specification`
--
ALTER TABLE `tbl_inventory_product_specification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_sale`
--
ALTER TABLE `tbl_inventory_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_sale_orders`
--
ALTER TABLE `tbl_inventory_sale_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_inventory_serialize_products`
--
ALTER TABLE `tbl_inventory_serialize_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchases`
--
ALTER TABLE `tbl_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_purchase_products`
--
ALTER TABLE `tbl_purchase_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_restaurant_order`
--
ALTER TABLE `tbl_restaurant_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_restaurant_order_details`
--
ALTER TABLE `tbl_restaurant_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_room_facilities`
--
ALTER TABLE `tbl_room_facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_room_floor_and_warehouses`
--
ALTER TABLE `tbl_room_floor_and_warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings_company_settings`
--
ALTER TABLE `tbl_settings_company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_brands`
--
ALTER TABLE `tbl_setups_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_categories`
--
ALTER TABLE `tbl_setups_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_damage_products`
--
ALTER TABLE `tbl_setups_damage_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_sisterconcern_categories`
--
ALTER TABLE `tbl_setups_sisterconcern_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_sister_concern_to_warehouses`
--
ALTER TABLE `tbl_setups_sister_concern_to_warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_units`
--
ALTER TABLE `tbl_setups_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_setups_warehouses`
--
ALTER TABLE `tbl_setups_warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_voucher_payment_vouchers`
--
ALTER TABLE `tbl_voucher_payment_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calender_tbl`
--
ALTER TABLE `calender_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1828;

--
-- AUTO_INCREMENT for table `dues`
--
ALTER TABLE `dues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `menu_images`
--
ALTER TABLE `menu_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `menu_specifications`
--
ALTER TABLE `menu_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_product_returns`
--
ALTER TABLE `purchase_product_returns`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_accounts_coas`
--
ALTER TABLE `tbl_accounts_coas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_accounts_vouchers`
--
ALTER TABLE `tbl_accounts_vouchers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_acc_voucher_details`
--
ALTER TABLE `tbl_acc_voucher_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_asset_assign`
--
ALTER TABLE `tbl_asset_assign`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_asset_depreciation_details`
--
ALTER TABLE `tbl_asset_depreciation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1034;

--
-- AUTO_INCREMENT for table `tbl_asset_products`
--
ALTER TABLE `tbl_asset_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_asset_product_brands`
--
ALTER TABLE `tbl_asset_product_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_asset_product_categories`
--
ALTER TABLE `tbl_asset_product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_asset_product_specifications`
--
ALTER TABLE `tbl_asset_product_specifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_asset_purchases`
--
ALTER TABLE `tbl_asset_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_asset_purchase_products`
--
ALTER TABLE `tbl_asset_purchase_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_asset_sales`
--
ALTER TABLE `tbl_asset_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_asset_serialize_products`
--
ALTER TABLE `tbl_asset_serialize_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_asset_shift`
--
ALTER TABLE `tbl_asset_shift`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_booking_details`
--
ALTER TABLE `tbl_booking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_boy_assign`
--
ALTER TABLE `tbl_boy_assign`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_building`
--
ALTER TABLE `tbl_building`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_crm_parties`
--
ALTER TABLE `tbl_crm_parties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_currentstock`
--
ALTER TABLE `tbl_currentstock`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_facilities`
--
ALTER TABLE `tbl_facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_floor`
--
ALTER TABLE `tbl_floor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_inventory_damage_products`
--
ALTER TABLE `tbl_inventory_damage_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_inventory_products`
--
ALTER TABLE `tbl_inventory_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_inventory_product_specification`
--
ALTER TABLE `tbl_inventory_product_specification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_inventory_sale`
--
ALTER TABLE `tbl_inventory_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_inventory_sale_orders`
--
ALTER TABLE `tbl_inventory_sale_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_inventory_serialize_products`
--
ALTER TABLE `tbl_inventory_serialize_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_purchases`
--
ALTER TABLE `tbl_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_purchase_products`
--
ALTER TABLE `tbl_purchase_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_restaurant_order`
--
ALTER TABLE `tbl_restaurant_order`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_restaurant_order_details`
--
ALTER TABLE `tbl_restaurant_order_details`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_room_facilities`
--
ALTER TABLE `tbl_room_facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_room_floor_and_warehouses`
--
ALTER TABLE `tbl_room_floor_and_warehouses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings_company_settings`
--
ALTER TABLE `tbl_settings_company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_setups_brands`
--
ALTER TABLE `tbl_setups_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_setups_categories`
--
ALTER TABLE `tbl_setups_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_setups_damage_products`
--
ALTER TABLE `tbl_setups_damage_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_setups_sisterconcern_categories`
--
ALTER TABLE `tbl_setups_sisterconcern_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tbl_setups_sister_concern_to_warehouses`
--
ALTER TABLE `tbl_setups_sister_concern_to_warehouses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_setups_units`
--
ALTER TABLE `tbl_setups_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_setups_warehouses`
--
ALTER TABLE `tbl_setups_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_voucher_payment_vouchers`
--
ALTER TABLE `tbl_voucher_payment_vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_asset_product_specifications`
--
ALTER TABLE `tbl_asset_product_specifications`
  ADD CONSTRAINT `tbl_asset_product_specifications_tbl_assetproductid_foreign` FOREIGN KEY (`tbl_assetProductId`) REFERENCES `tbl_asset_products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
