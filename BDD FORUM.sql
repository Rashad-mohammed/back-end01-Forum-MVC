-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
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


-- Listage de la structure de la base pour forum_dwwm3
CREATE DATABASE IF NOT EXISTS `forum_dwwm3` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_dwwm3`;

-- Listage de la structure de table forum_dwwm3. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `nameCategory` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_dwwm3.category : ~4 rows (environ)
INSERT INTO `category` (`id_category`, `nameCategory`) VALUES
	(1, 'Technology'),
	(2, 'Science'),
	(3, 'Travel'),
	(4, 'Sports');

-- Listage de la structure de table forum_dwwm3. message
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `messCreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `FK__user` (`user_id`),
  KEY `FK_message_topic` (`topic_id`),
  CONSTRAINT `FK__user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK_message_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Listage des données de la table forum_dwwm3.message : ~2 rows (environ)
INSERT INTO `message` (`id_message`, `text`, `messCreatedAt`, `user_id`, `topic_id`) VALUES
	(40, 'ffffffffffff', '2023-12-06 10:19:18', 7, 1),
	(41, 'ggggggggggggggggggggggggggggggggggg', '2023-12-06 11:01:10', 7, 4),
	(42, 'zdddddddd', '2023-12-06 11:34:44', 7, 96),
	(43, 'dddddddddddddddddddddddddd', '2023-12-06 11:34:50', 7, 97),
	(44, 'vvvvvvvvvvvvvvvvvvvvv', '2023-12-06 13:39:24', 6, 97);

-- Listage de la structure de table forum_dwwm3. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lockTopic` tinyint(1) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `id_user` (`user_id`) USING BTREE,
  KEY `id_category` (`category_id`) USING BTREE,
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE,
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_dwwm3.topic : ~5 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `content`, `user_id`, `creationdate`, `lockTopic`, `category_id`) VALUES
	(1, 'Latest Technology Trends', '01-lorem ipsum content ipsummmmmmmmmmmmmmmmmmmmmmmmmmmm', 1, '2023-01-01 08:00:00', 0, 1),
	(2, 'Space Exploration Updates', '02-lorem ipsum content ipsummmmmmmmmmmmmmmmmmmmmmmmmmmm', 2, '2023-02-15 10:30:00', 0, 2),
	(3, 'Best Travel Destinations', '03-lorem ipsum content ipsummmmmmmmmmmmmmmmmmmmmmmmmmmm', 1, '2023-03-20 15:45:00', 0, 3),
	(4, 'Soccer World Cup 2022', '04-lorem ipsum content ipsummmmmmmmmmmmmmmmmmmmmmmmmmmm', 4, '2023-12-04 14:16:11', 0, 4),
	(5, 'lorem05', '05-loremipsum content ipsummmmmmmmmmmmmmmmmmmm', 3, '2023-12-01 13:26:22', 1, 1),
	(96, 'dddddddddddddddd', 'sssssssssssssssssssssssssss', 6, '2023-12-06 10:34:01', 0, 4),
	(97, 'qlskddsdsdddd', 'ddddddddddddddddeeeeeeeeeeeeee', 6, '2023-12-06 10:34:22', 0, 2);

-- Listage de la structure de table forum_dwwm3. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` json NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_dwwm3.user : ~9 rows (environ)
INSERT INTO `user` (`id_user`, `pseudo`, `email`, `password`, `role`) VALUES
	(1, 'Admin', 'admin@gmail.com', '$2y$10$B7.wgzh0itmZsjU1NeghoOXTEQ/rjMws/OorkE9LniQYfhix6M.xW', '"\'ROLE_USER"'),
	(2, 'User2', 'user2@example.com', 'password2', '"\'ROLE_USER"'),
	(3, 'user3', 'adminc@gmail.com', 'password3', '"\'ROLE_USER"'),
	(4, 'user4', 'maher@gmail.com', '$2y$10$QIx2gHolI/GceaGUd9E3GegJ/wdaxwBndUvanYbxBXrPyJREbYNLa', '"\'ROLE_USER"'),
	(5, 'user5', 'sdddd@gmail.com', '$2y$10$SQQzWywpVZM/jXtb7DahW.c6gIDomtnh5yewyPIGPXSzm6Lhl83RO', '"\'ROLE_USER"'),
	(6, 'rashad', 'rashad@gmail.com', '$2y$10$uBkGWnzvXDHh6UzIG1g11O3800brX2D8O8bWsney/ajDfrSAGBqVy', '"\'ROLE_USER"'),
	(7, 'nico', 'nico@gmail.com', '$2y$10$hgiBCFy9KHnRzSYzrejs7e5A8TyW1ZRYWua8RYCwK0G/Gi7iyLop.', '"ROLE_ADMIN"'),
	(13, 'user06', 'user06@gmail.com', '$2y$10$pySDsKkAeiiQjNJ5yjKamODbTpjPHRlDhPk6Q1a7mBkONv/L.3AzS', '"ROLE_USER"'),
	(14, 'gggg', 'user06@gmail.com', '$2y$10$t4FW8YNWzkzehY4u/P8CL.QrWBv.4ajAhxqB00a4Ip34cWBOaQcPK', '"ROLE_USER"');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
