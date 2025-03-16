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
) ENGINE=InnoDB AUTO_INCREMENT=300 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hai_phong_culture_database.home_section: ~17 rows (approximately)
DELETE FROM `home_section`;
INSERT INTO `home_section` (`id`, `name`, `image`, `url`, `status`, `order`, `created_at`, `updated_at`) VALUES
	(4, 'Travel', './image/HaiPhongTravel.jpg', './travel.php', 1, 5, '2025-02-02 09:53:17', '2025-03-01 03:13:49'),
	(5, 'Cuisines', './image/HaiPhongCuisines.jpg', './cuisine.php', 0, 6, '2025-02-04 09:53:20', '2025-03-01 03:13:52'),
	(6, 'People', './image/HaiPhongPeople.jpg', './people.php', 1, 6, '2025-02-09 09:53:22', '2025-03-01 03:13:55'),
	(241, 'dophu3', 'DoSon4.png', './indexx.php', 0, 8, '2025-02-27 08:26:11', '2025-03-05 00:26:08'),
	(244, 'dophu', 'HaiPhongLogo.png', './indexx.php', 0, 8, '2025-02-27 08:34:29', '2025-03-05 00:34:21'),
	(246, 'History', 'HaiPhongHistory.jpg', './history.php', 1, 1, '2025-03-01 03:15:06', '2025-03-04 05:25:28'),
	(247, 'Home', 'HaiPhongPeople.jpg', './index.php', 1, 2, '2025-03-04 05:17:07', '2025-03-04 05:22:36'),
	(248, 'Contact', 'Contact.jpg', 'contact.php', 1, 3, '2025-03-04 05:23:40', '2025-03-04 05:23:59'),
	(249, 'Culture', 'lanHaBay.jpg', 'culture.php', 1, 4, '2025-03-04 05:25:09', '2025-03-04 05:25:18'),
	(292, 'dophu3', 'Screenshot_3.png', './index.php', 1, 1, '2025-03-15 12:42:45', NULL),
	(293, 'dophu3344', 'Screenshot_2.png', 'ddddd', 1, 1, '2025-03-15 12:43:06', NULL),
	(294, 'dophubro', NULL, './index.php', 1, 1, '2025-03-15 12:43:22', NULL),
	(295, 'dophu222222', NULL, './index.php', 0, 1, '2025-03-15 20:59:12', NULL),
	(296, 'Ray Mclean', NULL, 'Dolorem cupiditate d', 1, 1, '2025-03-16 00:09:07', NULL),
	(297, 'Jada Madden', NULL, 'Cumque perferendis n', 1, 1, '2025-03-16 00:09:28', NULL),
	(298, 'Charity Houston', 'Screenshot_3.png', 'Mollitia velit reici', 1, 1, '2025-03-16 00:12:13', NULL),
	(299, 'Prescott Lindsey', 'Screenshot_1.png', 'Quia id consectetur', 1, 1, '2025-03-16 14:15:39', NULL);

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
