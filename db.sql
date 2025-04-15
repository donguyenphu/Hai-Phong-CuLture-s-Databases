-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table hai_phong_culture_database.cuisine
CREATE TABLE IF NOT EXISTS `cuisine` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `travel_location_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine: ~1 rows (approximately)
DELETE FROM `cuisine`;
INSERT INTO `cuisine` (`id`, `name`, `image`, `description`, `status`, `order`, `created_at`, `updated_at`, `travel_location_id`) VALUES
	(5, 'Coconut', NULL, 'abc', 0, 1, '2025-01-27 21:54:52', NULL, NULL);

-- Dumping structure for table hai_phong_culture_database.cuisine_address
CREATE TABLE IF NOT EXISTS `cuisine_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `google_map` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `order` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `cuisine_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine_address: ~1 rows (approximately)
DELETE FROM `cuisine_address`;
INSERT INTO `cuisine_address` (`id`, `name`, `google_map`, `status`, `order`, `created_at`, `updated_at`, `cuisine_id`) VALUES
	(2, 'ádasd', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5);

-- Dumping structure for table hai_phong_culture_database.cuisine_ingredient
CREATE TABLE IF NOT EXISTS `cuisine_ingredient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` int NOT NULL,
  `order` int NOT NULL,
  `cuisine_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `status` tinyint NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine_ingredient: ~0 rows (approximately)
DELETE FROM `cuisine_ingredient`;

-- Dumping structure for table hai_phong_culture_database.cuisine_ingredient_detail
CREATE TABLE IF NOT EXISTS `cuisine_ingredient_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `cuisine_ingredient_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine_ingredient_detail: ~0 rows (approximately)
DELETE FROM `cuisine_ingredient_detail`;

-- Dumping structure for table hai_phong_culture_database.home_section
CREATE TABLE IF NOT EXISTS `home_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=438 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.home_section: ~15 rows (approximately)
DELETE FROM `home_section`;
INSERT INTO `home_section` (`id`, `name`, `image`, `url`, `status`, `order`, `created_at`, `updated_at`) VALUES
	(409, 'Georgia Boston', 'Array', 'Nisi voluptatem volu', 1, 3, '2025-03-24 10:33:02', '2025-03-24 10:33:02'),
	(418, 'Tatiana Hahn', 'iWzPV.png', 'Omnis velit qui in q', 1, 2, '2025-03-22 01:14:39', '2025-03-22 01:30:03'),
	(422, 'Chase Chaney', 'EOfCg.png', 'Quis ut vel laboris', 0, 3, '2025-03-22 01:18:59', '2025-03-22 03:37:05'),
	(423, 'Carlos Mccarty', 'B8LwT.png', 'Rerum ea voluptatum', 1, 33, '2025-03-22 01:19:02', '2025-03-22 03:37:33'),
	(424, 'Chase Chaney', 'wzNMt.png', 'Quis ut vel laboris', 1, 2, '2025-03-22 01:19:02', '2025-03-22 03:36:02'),
	(426, 'Scarlett Berry', 'BcG81.png', 'Sint ea voluptatibus', 1, 1, '2025-03-22 01:19:12', '2025-03-22 03:36:16'),
	(427, 'Madeson Burks', 'eUVZA.png', 'Quos deserunt fugiat', 1, 1, '2025-03-22 01:19:26', '2025-04-07 13:24:19'),
	(428, 'Madeson Burks', 'LKpDu.png', 'Quos deserunt fugiat', 0, 3, '2025-03-22 01:19:36', NULL),
	(429, 'Illiana Gentry', 'UMSqi.png', 'Non pariatur Irure', 1, 2, '2025-03-22 01:19:46', '2025-03-22 03:36:34'),
	(432, 'Devin Schroeder', '2FX8Y.png', 'Deserunt quos volupt', 1, 2, '2025-03-22 01:25:21', '2025-03-22 03:36:57'),
	(433, 'April Calderon', NULL, 'Voluptate sapiente i', 1, 4, '2025-03-24 09:19:48', NULL),
	(434, 'Craig Hesterrer', 'e8a3C.png', 'Sunt doloribus imped', 1, 2, '2025-03-24 09:20:28', NULL),
	(435, 'Demetria Thomass', '', 'Ea dolor quae aperia', 0, 3, '2025-03-24 10:17:12', NULL),
	(436, 'Mariam Richhhh', '', 'Temporibus at pariat', 1, 5, '2025-03-24 10:33:06', NULL),
	(437, 'Neil Hoover', 'HKfX8.png', 'Aut exercitationem u', 0, 1, '2025-03-24 10:33:43', '2025-04-07 14:28:24');

-- Dumping structure for table hai_phong_culture_database.travel
CREATE TABLE IF NOT EXISTS `travel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `order` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.travel: ~0 rows (approximately)
DELETE FROM `travel`;

-- Dumping structure for table hai_phong_culture_database.travel_location_info
CREATE TABLE IF NOT EXISTS `travel_location_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time_to_go` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `google_map` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.travel_location_info: ~0 rows (approximately)
DELETE FROM `travel_location_info`;

-- Dumping structure for table hai_phong_culture_database.travel_overall_image
CREATE TABLE IF NOT EXISTS `travel_overall_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `travel_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `image_attached_link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.travel_overall_image: ~0 rows (approximately)
DELETE FROM `travel_overall_image`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
