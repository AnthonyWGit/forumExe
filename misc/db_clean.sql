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


-- Listage de la structure de la base pour forum
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum`;

-- Listage de la structure de table forum. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.category : ~3 rows (environ)
INSERT INTO `category` (`id_category`, `name`, `img`) VALUES
	(1, 'Animals', '/img/animals.jpg'),
	(2, 'Plants', '/img/plants.jpg'),
	(3, 'Sports', '/img/sports.jpg');

-- Listage de la structure de table forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `creationdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `edit` int NOT NULL DEFAULT '0',
  `editDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_post`),
  KEY `FK_post_user` (`user_id`) USING BTREE,
  KEY `FK_post_topic` (`topic_id`) USING BTREE,
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.post : ~0 rows (environ)
INSERT INTO `post` (`id_post`, `creationdate`, `content`, `user_id`, `topic_id`, `edit`, `editDate`) VALUES
	(74, '2023-09-18 08:30:51', 'This is first post topic', 13, 24, 0, '2023-09-18 08:30:51'),
	(75, '2023-09-18 08:31:15', 'This is second post', 13, 24, 0, '2023-09-18 08:31:15');

-- Listage de la structure de table forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `lock` tinyint NOT NULL DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `posts` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_user` (`user_id`) USING BTREE,
  KEY `FK_topic_category` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.topic : ~0 rows (environ)
INSERT INTO `topic` (`id_topic`, `lock`, `title`, `creationDate`, `posts`, `user_id`, `category_id`) VALUES
	(24, 0, 'Ani mauls', '2023-09-18 08:30:51', '2', 13, 1);

-- Listage de la structure de table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'member',
  `registerDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'free',
  `bandate` datetime DEFAULT NULL,
  `kickdate` datetime DEFAULT NULL,
  `profileImg` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '/img/placeholder.jpg',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.user : ~12 rows (environ)
INSERT INTO `user` (`id_user`, `username`, `role`, `registerDate`, `password`, `email`, `state`, `bandate`, `kickdate`, `profileImg`) VALUES
	(1, 'user1', 'member', '2023-09-05 15:53:26', 'pass', 'email@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(2, 'JBernard', 'member', '2023-09-06 11:54:30', 'poss', 'email@hotmail.fr', 'kicked', NULL, '2023-09-20 12:49:00', '/img/placeholder.jpg'),
	(3, 'UseR55', 'member', '2023-09-06 11:54:59', 'password', 'emailed@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(4, 'Truc', 'member', '2023-09-11 10:00:04', 'Azerty1!', 'truc@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(5, 'TrucO', 'member', '2023-09-11 10:56:55', 'Azerty1!', 'truco@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(6, 'HHHH', 'member', '2023-09-11 11:04:56', '$2y$10$oz/fq.fVVTHOwPDES2h1IuOBd3KTqAdkJSyFsdkJuwhsHJ2UJOlL6', 'azerty@ag.fr', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(7, 'username', 'member', '2023-09-11 11:28:56', '$2y$10$Ph11AyQdVO9Cp8Jpi1b8rOT8WPBX/qDTHH9334nJBTMbIYEI58JP6', 'us@gmail.fr', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(8, 'Ys', 'mod', '2023-09-11 13:31:20', '$2y$10$jonch8A/gjaB3nWBdecFEOyCp7qUqqmsa.3j8TVuGbPiRGq5KtkcW', 'ax@gmail.vom', 'kicked', NULL, '2023-09-20 11:59:00', '/img/placeholder.jpg'),
	(10, 'ZZZ', 'member', '2023-09-12 11:47:29', '$2y$10$.5dZINQIMsaKKnjQEpAcie02.7Y2sFvhfWgJO2k2VQihc1nOGzw0K', 'treuc@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(11, 'merise', 'member', '2023-09-12 14:51:44', '$2y$10$LaL4C2AvWc2LxQBEtofqRO8DXcEF7eIH7XxHbMdt7FbAO6gLxrszG', 'merise@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(12, 'Test', 'member', '2023-09-13 16:38:35', '$2y$10$EaCxbN59uumUw7YwbHDc5ObXtzWZU6SzgO56GSGV4Bx5o/WdLwhr.', 'axss@gmail.com', 'free', NULL, NULL, '/img/placeholder.jpg'),
	(13, 'Mouah', 'admin', '2023-09-15 13:49:45', '$2y$10$spK3l5WTdhkCkHkRGV.bt.uHCgOXxjvesk7sWQLLPoX2CPfXLXJgO', 'trukage@gmail.com', 'free', NULL, NULL, '/uploads/placeholder.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
