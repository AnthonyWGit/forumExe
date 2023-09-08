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
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum`;

-- Listage de la structure de table forum. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.category : ~2 rows (environ)
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Animals'),
	(2, 'Plants'),
	(3, 'Sports');

-- Listage de la structure de table forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `postDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `FK_post_user` (`user_id`) USING BTREE,
  KEY `FK_post_topic` (`topic_id`) USING BTREE,
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.post : ~10 rows (environ)
INSERT INTO `post` (`id_post`, `postDate`, `content`, `user_id`, `topic_id`) VALUES
	(1, '2023-09-06 08:40:36', 'Inital post', 1, 1),
	(2, '2023-09-06 11:55:49', 'Whaa trop bien !!!!!! \r\nBises, bernard', 2, 1),
	(3, '2023-09-06 11:56:32', 'Inital post', 3, 2),
	(17, '2023-09-08 14:07:37', 'Posty', 1, 52),
	(18, '2023-09-08 14:07:51', 'Reposty', 1, 52),
	(19, '2023-09-08 14:09:08', 'Topic msg', 1, 53),
	(20, '2023-09-08 14:10:22', 'Trop cool !', 1, 1),
	(21, '2023-09-08 15:53:52', 'Rate doggo', 1, 54),
	(23, '2023-09-08 16:01:57', '&lt;input type=&quot;textarea&quot;/&gt;', 1, 55),
	(25, '2023-09-08 16:03:19', '&lt;button&gt;Create button &lt;/button&gt;', 1, 55);

-- Listage de la structure de table forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `lock` tinyint NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `posts` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1',
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `FK_topic_user` (`user_id`) USING BTREE,
  KEY `FK_topic_category` (`category_id`) USING BTREE,
  CONSTRAINT `FK_topic_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_topic_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.topic : ~2 rows (environ)
INSERT INTO `topic` (`id_topic`, `lock`, `title`, `creationDate`, `posts`, `user_id`, `category_id`) VALUES
	(1, 0, 'Topico', '2023-09-05 15:53:52', '1', 1, 2),
	(2, 0, 'Tpac', '2023-09-06 10:11:00', '1', 1, 1),
	(52, 0, 'Topic title', '2023-09-08 14:07:37', '1', 1, 1),
	(53, 0, 'First topic', '2023-09-08 14:09:08', '1', 1, 3),
	(54, 0, 'My dog/220', '2023-09-08 15:53:52', '1', 1, 1),
	(55, 0, 'Mbapp&eacute; au r&eacute;al !!!!', '2023-09-08 16:00:14', '1', 1, 3);

-- Listage de la structure de table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `registerDate` datetime NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table forum.user : ~3 rows (environ)
INSERT INTO `user` (`id_user`, `username`, `role`, `registerDate`, `password`, `email`) VALUES
	(1, 'user1', 'member', '2023-09-05 15:53:26', 'pass', 'email@gmail.com'),
	(2, 'JBernard', 'member', '2023-09-06 11:54:30', 'poss', 'email@hotmail.fr'),
	(3, 'UseR55', 'member', '2023-09-06 11:54:59', 'password', 'emailed@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
