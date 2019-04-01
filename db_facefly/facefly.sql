-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 01, 2019 at 05:47 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facefly`
--

-- --------------------------------------------------------

--
-- Table structure for table `airlines`
--

DROP TABLE IF EXISTS `airlines`;
CREATE TABLE IF NOT EXISTS `airlines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `airline_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `airline_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `airline_country_id` int(11) NOT NULL,
  `airline_revenue` double NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `airlines`
--

INSERT INTO `airlines` (`id`, `airline_name`, `airline_code`, `airline_country_id`, `airline_revenue`, `created_at`, `updated_at`) VALUES
(1, 'Vietnam Ailrlines', 'VN', 1, 17070000, '0000-00-00 00:00:00', '2019-04-01 10:23:59'),
(2, 'VietJet Airlines', 'VJ', 1, 5400000, '0000-00-00 00:00:00', '2019-03-31 11:07:25'),
(3, 'Quatar Airways', 'QR', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'China Southern Airlines', 'CN', 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Jetstar Pacific Airlines', 'PL', 1, 18000000, '0000-00-00 00:00:00', '2019-03-31 11:07:25'),
(6, 'Bamboo Airways', 'QH', 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Japan Airlines ', 'JAL', 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'All Nippon Airways', 'ANA', 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Peach Airlines', 'PA', 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Vanilla Air', 'VA', 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Quepos Costa Rica Air', 'QCR', 4, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

DROP TABLE IF EXISTS `airports`;
CREATE TABLE IF NOT EXISTS `airports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `airport_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `amount_airline_from` int(11) NOT NULL,
  `amount_airline_to` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `airport_name`, `city_id`, `amount_airline_from`, `amount_airline_to`, `created_at`, `updated_at`) VALUES
(1, 'Sân bay quốc tế Tân Sơn Nhất', 1, 10, 5, '0000-00-00 00:00:00', '2019-04-01 09:08:16'),
(2, 'Sân bay quốc tế Nội Bài', 2, 5, 6, '0000-00-00 00:00:00', '2019-04-01 10:46:09'),
(3, 'Sân bay quốc tế Phú Quốc', 3, 1, 1, '0000-00-00 00:00:00', '2019-04-01 09:06:49'),
(4, 'Sân bay quốc tế Đà Nẵng', 4, 3, 2, '0000-00-00 00:00:00', '2019-04-01 09:07:30'),
(5, 'Sân bay quốc tế Cam Ranh', 5, 1, 2, '0000-00-00 00:00:00', '2019-04-01 09:07:30'),
(6, 'Sân bay quốc tế Cần Thơ', 6, 0, 2, '0000-00-00 00:00:00', '2019-04-01 10:45:06'),
(7, 'Sân bay quốc tế Cát Bi', 7, 1, 0, '0000-00-00 00:00:00', '2019-04-01 10:36:23'),
(8, 'Sân bay quốc tế Phú Bài', 8, 0, 1, '0000-00-00 00:00:00', '2019-04-01 10:36:23'),
(9, 'Sân bay quốc tế Liên Khương', 9, 0, 3, '0000-00-00 00:00:00', '2019-04-01 10:44:04'),
(10, 'Sân bay quốc tế Chu Lai', 10, 1, 0, '0000-00-00 00:00:00', '2019-04-01 10:46:09'),
(11, 'Sân bay quốc tế Vinh', 11, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Sân bay quốc tế Tokyo', 12, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Sân bay quốc tế Kansai', 13, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Sân bay quốc tế Chubu', 14, 1, 0, '0000-00-00 00:00:00', '2019-04-01 10:37:06'),
(15, 'Sân bay quốc tế Thủ đô Bắc Kinh', 15, 1, 0, '0000-00-00 00:00:00', '2019-04-01 09:08:16'),
(16, 'Sân bay quốc tế Thái Bình Cáp Nhĩ Tân', 16, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Sân bay quốc tế Bạch Vân Quảng Châu', 17, 0, 1, '0000-00-00 00:00:00', '2019-04-01 10:37:06'),
(18, 'Sân bay quốc tế Juan Santamaría', 18, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `city_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `city_airport_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `city_code`, `city_airport_id`, `country_id`) VALUES
(1, 'TP. Hồ Chí Minh', 'SGN', 1, 1),
(2, 'Hà Nội', 'HAN', 2, 1),
(3, 'Phú Quốc, Kiên Giang', 'PQC', 3, 1),
(4, 'Đà Nẵng', 'DAD', 4, 1),
(5, 'Cam Ranh, Khánh Hòa', 'CXR', 5, 1),
(6, 'Cần Thơ', 'VCA', 6, 1),
(7, 'Hải Phòng', 'HPH', 7, 1),
(8, 'Huế', 'HUI', 8, 1),
(9, 'Đà Lạt, Lâm Đồng	', 'DLI', 9, 1),
(10, 'Chu Lai, Quảng Nam', 'VCL', 10, 1),
(11, 'Vinh, Nghệ An', 'VII', 11, 1),
(12, 'Tokyo', 'HND', 12, 2),
(13, 'Osaka', 'KIX', 13, 2),
(14, 'Nagoya', 'NGO', 14, 2),
(15, 'Bắc Kinh', 'PEK', 15, 3),
(16, 'Cáp Nhĩ Tân', 'HRB', 16, 3),
(17, 'Quảng Châu', 'CAN', 17, 3),
(18, 'San José de Costa Rica', 'SJO', 18, 4);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `country_code`) VALUES
(1, 'Việt Nam', 'VN'),
(2, 'Nhật Bản', 'JP'),
(3, 'Trung Quốc', 'CN'),
(4, 'Costa Rica', 'CR');

-- --------------------------------------------------------

--
-- Table structure for table `countries_relationship`
--

DROP TABLE IF EXISTS `countries_relationship`;
CREATE TABLE IF NOT EXISTS `countries_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id_one` int(11) NOT NULL,
  `country_id_two` int(11) NOT NULL,
  `relationship` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries_relationship`
--

INSERT INTO `countries_relationship` (`id`, `country_id_one`, `country_id_two`, `relationship`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 1),
(3, 2, 3, 1),
(4, 1, 4, 0),
(5, 2, 4, 0),
(6, 3, 4, 0),
(7, 2, 1, 1),
(8, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_user_id` int(11) NOT NULL,
  `customer_book_id` int(11) NOT NULL,
  `customer_first_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_last_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_title` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_transfer` tinyint(4) NOT NULL DEFAULT '0',
  `customer_paypal` tinyint(4) NOT NULL DEFAULT '0',
  `customer_credit_card` tinyint(4) NOT NULL DEFAULT '0',
  `customer_credit_number` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_credit_name` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_credit_ccv` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_user_id`, `customer_book_id`, `customer_first_name`, `customer_last_name`, `customer_title`, `customer_transfer`, `customer_paypal`, `customer_credit_card`, `customer_credit_number`, `customer_credit_name`, `customer_credit_ccv`, `token`, `created_at`, `updated_at`) VALUES
(59, 18, 39, 'Nguyen', 'Van Phuc', 'mr', 1, 0, 0, '', '', '', 'HKRJEC1KkFje0182IfzGON6GhUMpGhqrbiQwRudk', '2019-03-31 11:06:46', '2019-03-31 11:06:46'),
(60, 18, 40, 'nguyễn', 'hạng', 'mr', 1, 0, 0, '', '', '', 'HKRJEC1KkFje0182IfzGON6GhUMpGhqrbiQwRudk', '2019-03-31 11:07:25', '2019-03-31 11:07:25'),
(61, 18, 41, 'phuc', 'nguyen', 'mr', 1, 0, 0, '', '', '', 'xTKXTfubahgiSDX8UdmkOAGyVscHYSxrwpyxOkqi', '2019-04-01 09:01:09', '2019-04-01 09:01:09'),
(62, 18, 42, 'phuc', 'nguyen', 'mr', 1, 0, 0, '', '', '', 'xTKXTfubahgiSDX8UdmkOAGyVscHYSxrwpyxOkqi', '2019-04-01 10:23:59', '2019-04-01 10:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `flight_booking`
--

DROP TABLE IF EXISTS `flight_booking`;
CREATE TABLE IF NOT EXISTS `flight_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_user_id` int(11) NOT NULL,
  `fb_fl_to_id` int(11) NOT NULL,
  `fb_fl_return_id` int(11) NOT NULL DEFAULT '0',
  `fb_class_id` tinyint(4) NOT NULL,
  `fb_total_person` int(11) NOT NULL,
  `fb_total_cost_to` float NOT NULL,
  `fb_total_cost_return` float NOT NULL DEFAULT '0',
  `fb_time_book` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flight_booking`
--

INSERT INTO `flight_booking` (`id`, `fb_user_id`, `fb_fl_to_id`, `fb_fl_return_id`, `fb_class_id`, `fb_total_person`, `fb_total_cost_to`, `fb_total_cost_return`, `fb_time_book`, `created_at`, `updated_at`) VALUES
(39, 18, 6, 0, 1, 1, 5700000, 0, '2019-03-31 18:06:46', '2019-03-31 11:06:46', '2019-03-31 11:06:46'),
(40, 18, 16, 7, 1, 1, 18000000, 5400000, '2019-03-31 18:07:25', '2019-03-31 11:07:25', '2019-03-31 11:07:25'),
(41, 18, 6, 0, 1, 1, 5700000, 0, '2019-04-01 16:01:09', '2019-04-01 09:01:09', '2019-04-01 09:01:09'),
(42, 18, 11, 0, 1, 1, 5670000, 0, '2019-04-01 17:23:59', '2019-04-01 10:23:59', '2019-04-01 10:23:59');

-- --------------------------------------------------------

--
-- Table structure for table `flight_class`
--

DROP TABLE IF EXISTS `flight_class`;
CREATE TABLE IF NOT EXISTS `flight_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fc_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `flight_class`
--

INSERT INTO `flight_class` (`id`, `fc_name`) VALUES
(1, 'Economy'),
(2, 'Business'),
(3, 'Premium Economy');

-- --------------------------------------------------------

--
-- Table structure for table `flight_lists`
--

DROP TABLE IF EXISTS `flight_lists`;
CREATE TABLE IF NOT EXISTS `flight_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fl_city_from_id` int(11) NOT NULL,
  `fl_city_to_id` int(11) NOT NULL,
  `fl_departure_date` datetime NOT NULL,
  `fl_landing_date` datetime NOT NULL,
  `fl_airline_id` int(11) NOT NULL,
  `fl_seat_limit` int(11) NOT NULL,
  `fl_total_seat` int(11) NOT NULL,
  `fl_distance` float NOT NULL,
  `fl_cost` float NOT NULL,
  `fl_transit_count` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `flight_lists`
--

INSERT INTO `flight_lists` (`id`, `fl_city_from_id`, `fl_city_to_id`, `fl_departure_date`, `fl_landing_date`, `fl_airline_id`, `fl_seat_limit`, `fl_total_seat`, `fl_distance`, `fl_cost`, `fl_transit_count`, `created_at`, `updated_at`) VALUES
(6, 1, 2, '2019-05-25 07:00:00', '2019-05-25 10:30:00', 1, 200, 8, 2000, 6000000, 0, '2019-04-01 17:23:12', '2019-04-01 09:01:09'),
(7, 1, 2, '2019-06-15 11:00:00', '2019-06-15 14:30:00', 2, 600, 6, 2000, 6000000, 0, '2019-03-31 18:07:25', '2019-03-31 11:07:25'),
(8, 1, 2, '2019-11-11 22:30:00', '2019-11-12 01:00:00', 5, 300, 2, 2000, 6000000, 0, '2019-03-31 12:12:37', '2019-03-31 05:12:37'),
(9, 1, 2, '2019-12-11 08:30:00', '2019-12-11 11:00:00', 1, 500, 0, 2000, 6000000, 0, '2019-03-30 03:17:42', '2019-03-30 03:17:42'),
(10, 1, 2, '2019-05-02 15:30:00', '2019-05-02 18:00:00', 5, 600, 7, 2000, 6300000, 0, '2019-03-31 17:58:44', '2019-03-31 10:58:44'),
(11, 2, 1, '2018-06-15 12:00:00', '2019-06-15 14:30:00', 1, 300, 5, 2000, 6300000, 0, '2019-04-01 17:24:56', '2019-04-01 10:23:59'),
(12, 1, 4, '2019-05-11 14:00:00', '2019-05-11 15:00:00', 5, 100, 0, 700, 3150000, 0, '2019-03-30 04:01:10', '2019-03-30 04:01:10'),
(13, 1, 5, '2019-05-13 10:30:00', '2019-04-12 11:30:00', 5, 100, 0, 200, 1050000, 0, '2019-03-30 04:16:17', '2019-03-30 04:16:17'),
(14, 1, 12, '2019-05-06 11:30:00', '2019-05-06 17:30:00', 5, 300, 0, 5100, 31500000, 0, '2019-03-30 07:53:47', '2019-03-30 07:53:47'),
(15, 2, 1, '2019-05-17 10:30:00', '2019-05-17 12:00:00', 2, 200, 3, 2000, 6300000, 0, '2019-03-31 17:02:21', '2019-03-31 10:02:21'),
(16, 2, 1, '2019-08-30 05:00:00', '2019-08-30 19:30:00', 5, 500, 1, 2500, 20000000, 0, '2019-04-01 17:23:05', '2019-03-31 11:07:25'),
(17, 5, 4, '2019-06-09 11:00:00', '2019-06-09 14:40:00', 1, 400, 0, 400, 2100000, 0, '2019-03-31 07:41:14', '2019-03-31 07:41:14'),
(18, 1, 12, '2019-05-23 10:00:00', '2019-05-23 23:03:00', 1, 300, 0, 5000, 21000000, 0, '2019-03-31 07:55:57', '2019-03-31 07:55:57'),
(19, 12, 1, '2019-06-22 03:00:00', '2019-06-22 15:30:00', 1, 300, 0, 5500, 31500000, 0, '2019-03-31 07:56:50', '2019-03-31 07:56:50'),
(20, 4, 9, '2019-07-19 07:00:00', '2019-07-19 10:30:00', 1, 200, 0, 600, 3000000, 0, '2019-04-01 08:03:15', '2019-04-01 08:03:15'),
(21, 1, 3, '2019-07-19 06:00:00', '2019-07-19 11:30:00', 5, 400, 0, 500, 2000000, 0, '2019-04-01 09:03:52', '2019-04-01 09:03:52'),
(22, 3, 6, '2019-06-15 11:00:00', '2019-06-15 15:00:00', 1, 300, 0, 600, 3150000, 0, '2019-04-01 09:06:49', '2019-04-01 09:06:49'),
(23, 4, 5, '2019-11-11 11:11:00', '2019-11-11 17:00:00', 2, 500, 0, 300, 2000000, 0, '2019-04-01 09:07:30', '2019-04-01 09:07:30'),
(24, 15, 1, '2019-12-12 05:00:00', '2019-12-12 17:30:00', 4, 600, 0, 5000, 20000000, 0, '2019-04-01 09:08:16', '2019-04-01 09:08:16'),
(25, 7, 8, '2019-07-11 08:30:00', '2019-07-11 11:30:00', 2, 400, 0, 300, 2000000, 0, '2019-04-01 10:36:23', '2019-04-01 10:36:23'),
(26, 14, 17, '2019-06-22 05:30:00', '2019-06-22 18:00:00', 8, 600, 0, 5000, 21000000, 0, '2019-04-01 10:37:06', '2019-04-01 10:37:06'),
(27, 2, 9, '2019-07-18 05:55:00', '2019-07-18 10:00:00', 5, 300, 0, 1500, 6000000, 0, '2019-04-01 10:44:04', '2019-04-01 10:44:04'),
(28, 2, 6, '2019-07-27 08:08:00', '2019-07-27 20:00:00', 2, 300, 0, 3000, 20000000, 0, '2019-04-01 10:45:06', '2019-04-01 10:45:06'),
(29, 10, 2, '2019-07-20 05:55:00', '2019-07-20 13:00:00', 1, 200, 0, 1000, 3000000, 0, '2019-04-01 10:46:09', '2019-04-01 10:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transits`
--

DROP TABLE IF EXISTS `transits`;
CREATE TABLE IF NOT EXISTS `transits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transit_fl_city_from_id` int(11) NOT NULL,
  `transit_fl_departure_date` datetime NOT NULL,
  `transit_city_id` int(11) NOT NULL,
  `transit_date` datetime NOT NULL,
  `transit_time` time NOT NULL,
  `transit_landing_date` datetime NOT NULL,
  `transit_fl_id` int(11) NOT NULL,
  `transit_city_to_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_access` datetime NOT NULL,
  `attempt` tinyint(4) NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `gender`, `birthdate`, `address`, `last_access`, `attempt`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(18, 'Phuc', 'Nguyen', 'phuc@gmail.com', '$2y$10$z3MXd//uD5a0HOPkTOpgN.AlQ0oIhzhMaqDQh9Nb9Z1CC/tC0Bw9m', '01676093546', 1, '2019-02-28', '48, 48', '2019-04-02 00:23:28', 0, 'default', 'U4X6GSmipHKGFlwZuViaYVl81XYXS7QNsiSLUSJ3MkB6EZwznceln5PAssjc', '0000-00-00 00:00:00', '2019-04-01 10:24:14'),
(20, 'hanh', 'Nguyen', 'hanh@gmail.com', '$2y$10$To2FQC1dORt8L.f3l3VT6.HcW84Ctgce8IuJKThiBHA5AB8x5LTdW', '01676093546', 0, '2019-03-01', 'Ho chi minh', '2019-03-26 08:16:17', 0, 'default', 'kbDIxnvj0o1z6D5WMBxBnJlB5JkBxtRItjAc6O4O0Q1OhBBhPAumu6ICcGbf', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Abc', 'XYZ', 'abc@gmail.com', '$2y$10$lDuUvniOkYr75G.2YOYEAeiu3kFbmaoNSP5rDb2kRNCH4Rjm3VQuW', '01676093546', 1, '2012-12-12', 'asasasasasasasasasa', '2019-03-11 19:03:48', 2, 'default', '4a6ki5wGzB3EYzusMKyV8j5QDCC0Zqa6QEXfVEY52aYCdmunogwsJD3UoUpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'admin', '', 'admin@admin.com', '$2y$10$sZjQLd/U5GjZHL3btoYLIO7zw6ivz1F7HjbGxC/uUNhd8LWHSIho6', '0383808195', 0, '2019-03-28', '', '2019-04-02 00:24:21', 0, 'admin', '8cfBkOFb403Cp3PiYWHE2P9bRRJKH3q0BV0vfwiv9zkQmik2VVdhsyYXPazc', '0000-00-00 00:00:00', '2019-04-01 10:23:18'),
(26, 'nguyễn', '', 'meolilom1997@gmail.com', '$2y$10$OYC9j7aKYX9jRPxB0gdhAOYBmVHHBWglLB.1Q83Tosio7cR5Mehqu', '0383808195', 0, '0000-00-00', '', '0000-00-00 00:00:00', 0, 'default', 'ApYkwC9vPh9rx6kPIbJqOBSjvJ9dZvGDqlOQpRphmKg8UrmaRlUqVlA8icqX', '2019-03-28 09:06:55', '2019-03-28 09:09:35'),
(27, 'admin', '', 'admin@gmail.com', '$2y$10$QFV6HQ/EwXLIZdVzlBk7fuYNqezUeDS774fz8YUS2BxklZ10o4zw.', '09999999999', 0, '0000-00-00', '', '2019-04-01 23:02:55', 0, 'admin', 'eFffOBHIye331bsmEKqpYKrmqKWndk9PlEzackktIqPwhYHzRm5KTjyR8LOO', '2019-03-31 08:50:50', '2019-04-01 09:09:24'),
(28, 'phuc', '2323', 'phuc.nv995@gmail.com', '$2y$10$rCRYK0XNUr478/1dlbiswuVYsdtcSYMh1xGxLCgVkx.m80UxuZSQa', '0167609354', 1, '2019-04-21', 'weweew', '2019-04-01 23:37:26', 0, 'default', 'oCaezez9iVGJUVsuUXzxvcDiuWQky4sj41pro7ERStvXi79ZEg4ENWOQrJh4', '2019-04-01 09:09:49', '2019-04-01 09:43:11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
