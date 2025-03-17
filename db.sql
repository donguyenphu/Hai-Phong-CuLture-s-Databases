-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `travel_location_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine: ~1 rows (approximately)
DELETE FROM `cuisine`;
INSERT INTO `cuisine` (`id`, `name`, `image`, `description`, `status`, `order`, `created_at`, `updated_at`, `travel_location_id`) VALUES
	(5, 'Coconut', NULL, 'abc', 0, 1, '2025-01-27 21:54:52', NULL, NULL);

-- Dumping structure for table hai_phong_culture_database.cuisine_address
CREATE TABLE IF NOT EXISTS `cuisine_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `google_map` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `cuisine_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `cuisine_address_fk7` (`cuisine_id`),
  CONSTRAINT `cuisine_address_fk7` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisine` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine_address: ~1 rows (approximately)
DELETE FROM `cuisine_address`;
INSERT INTO `cuisine_address` (`id`, `name`, `google_map`, `status`, `order`, `created_at`, `updated_at`, `cuisine_id`) VALUES
	(2, 'ádasd', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5);

-- Dumping structure for table hai_phong_culture_database.cuisine_ingredient
CREATE TABLE IF NOT EXISTS `cuisine_ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `cuisine_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `cuisine_ingredient_fk3` (`cuisine_id`),
  CONSTRAINT `cuisine_ingredient_fk3` FOREIGN KEY (`cuisine_id`) REFERENCES `cuisine` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine_ingredient: ~0 rows (approximately)
DELETE FROM `cuisine_ingredient`;

-- Dumping structure for table hai_phong_culture_database.cuisine_ingredient_detail
CREATE TABLE IF NOT EXISTS `cuisine_ingredient_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cuisine_ingredient_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `cuisine_ingredient_detail_fk3` (`cuisine_ingredient_id`),
  CONSTRAINT `cuisine_ingredient_detail_fk3` FOREIGN KEY (`cuisine_ingredient_id`) REFERENCES `cuisine_ingredient` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.cuisine_ingredient_detail: ~0 rows (approximately)
DELETE FROM `cuisine_ingredient_detail`;

-- Dumping structure for table hai_phong_culture_database.home_section
CREATE TABLE IF NOT EXISTS `home_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=315 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.home_section: ~8 rows (approximately)
DELETE FROM `home_section`;
INSERT INTO `home_section` (`id`, `name`, `image`, `url`, `status`, `order`, `created_at`, `updated_at`) VALUES
	(337, 'Kuame Pope', 'wdtl6Screenshot_5.png', 'Ut tempora iusto non', 1, 1, '2025-03-17 10:24:09', NULL),
	(338, 'Octavia Hoover', 'Kd4QnScreenshot_3.png', 'Nulla doloremque ill', 1, 1, '2025-03-17 10:24:17', NULL),
	(339, 'Imogene Maddox', 'bFVMDScreenshot_4.png', 'Autem nisi ex verita', 1, 1, '2025-03-17 10:24:26', NULL),
	(340, 'Michael Alvarado', 'xJlecScreenshot_7.png', 'Dolorum in praesenti', 1, 1, '2025-03-17 10:24:39', NULL),
	(341, 'Benjamin Weeks', 'aG8iVScreenshot_6.png', 'Aut quos qui et aut', 1, 1, '2025-03-17 10:24:50', NULL);

-- Dumping structure for table hai_phong_culture_database.travel
CREATE TABLE IF NOT EXISTS `travel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.travel: ~0 rows (approximately)
DELETE FROM `travel`;

-- Dumping structure for table hai_phong_culture_database.travel_location_info
CREATE TABLE IF NOT EXISTS `travel_location_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `time_to_go` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `google_map` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.travel_location_info: ~0 rows (approximately)
DELETE FROM `travel_location_info`;

-- Dumping structure for table hai_phong_culture_database.travel_overall_image
CREATE TABLE IF NOT EXISTS `travel_overall_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_link` varchar(255) NOT NULL,
  `travel_id` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `image_attached_link` varchar(255) NOT NULL,
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
