-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ollyo-test.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `title` (`title`),
  KEY `date` (`date`),
  KEY `time` (`time`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ollyo-test.events: ~4 rows (approximately)
INSERT INTO `events` (`id`, `user_id`, `title`, `slug`, `description`, `banner`, `date`, `time`, `location`, `capacity`) VALUES
	(1, 1, 'Tech Conference 2025', 'tech-conference-2025', 'Lorem ipsum dolor sit amet consectetur adipiscing elit cum vulputate, ut enim mus bibendum porta felis mauris torquent. Suscipit magnis mollis massa vehicula volutpat sed taciti pretium torquent, penatibus tellus porta habitant lectus vestibulum dapibus a fusce ultricies, dui per vulputate ac interdum at luctus in. Nec ante ridiculus nam massa pulvinar penatibus curabitur sem, sollicitudin mauris justo dictum non pellentesque nisl interdum in, porttitor accumsan phasellus convallis habitant euismod senectus.\r\n\r\nSodales egestas duis feugiat magna vestibulum dictum laoreet, congue volutpat quis litora curabitur est in conubia, cursus curae aliquet ornare vivamus velit. Dis fermentum odio tellus tortor auctor suscipit, cubilia parturient potenti ac vitae maecenas vestibulum, ultricies at nullam mi vehicula. Suscipit risus turpis hendrerit facilisis curae volutpat suspendisse sociosqu odio potenti urna, pellentesque libero commodo sem ad venenatis vitae dignissim integer mi.', 'uploads/banners/jcorl_monument_valley.jpg', '2025-07-25', '22:03:00', 'Dhaka', 1000),
	(2, 1, 'Art & Culture Fest', 'art-&-culture-fest', 'Experience the best of art, music, and culture in this one-of-a-kind festival.', 'uploads/banners/top-10-tech-events-in-September.webp', '2025-01-31', '10:00:00', 'Dhaka', 50),
	(6, 2, 'Eveniet sint volupt', 'exercitationem-in-vo', 'Consequuntur dolor i', 'uploads/banners/1737829537_speed-internet-technology-backgr.webp', '1987-07-24', '07:39:00', 'Dolor id amet cupi', 60),
	(7, 3, 'A et minima cumque e', 'ex-sed-laborum-aut-v', 'Aliqua Quia culpa n', 'uploads/banners/1737832787_technology_teachers.png', '2010-01-23', '19:01:00', 'Quia rerum non dolor', 19);

-- Dumping structure for table ollyo-test.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ollyo-test.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `profile_picture`, `password`) VALUES
	(1, 'MEHEDI HASAN HASIB', 'hasib@gmail.com', NULL, '$2y$10$iCG7S1gmMvW.Ga/1oSlAvOvqyCPO42s7Sf.9ORvgS.Zv/u2mMe53y'),
	(2, 'Peter Bird', 'lakihog@mailinator.com', 'uploads/1737828871_2867297.png', '$2y$10$rRYNRREO6VfuGZIKdo4MqO4RiBcFEybaIMiAE3eotq9io21MSYPdu'),
	(3, 'Hope Chavez', 'rowuqojucu@mailinator.com', NULL, '$2y$10$pArCJR5hSNqleRPEQ.CAxOk48roUyUI343PPNyosg.hZMLTjBgRHi'),
	(4, 'Timon Mcintyre', 'digytow@mailinator.com', NULL, '$2y$10$w0zNt/uBdtAIJMBt1xnmv.tKXOpTG/SSrWxRdnWMPlStN9XZLEZWi');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
