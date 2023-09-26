-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 15 août 2023 à 17:19
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `announces`
--

DROP TABLE IF EXISTS `announces`;
CREATE TABLE IF NOT EXISTS `announces` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `dt_send` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `announces`
--

INSERT INTO `announces` (`id`, `title`, `description`, `content`, `dt_send`) VALUES
(2, 'second announce', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'lorem ipsum dolor sit 2e announce', '2022-11-27 17:21:42'),
(3, 'second announce 567890', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'lorem ipsum dolor sit 2e announce', '2022-11-29 12:43:53'),
(4, 'second announce 567890', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'lorem ipsum dolor sit 2e announce', '2022-12-20 13:55:37'),
(5, 'second announce 567890', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'lorem ipsum dolor sit 2e announce', '2022-12-20 13:56:19'),
(6, 'second announce 567890', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'lorem ipsum dolor sit 2e announce', '2022-12-20 13:56:27');

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `dt_signup` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `password`, `avatar`, `dt_signup`) VALUES
(4, '_kevin1026__', 'kevin.bento@free.fr', '$2y$10$1wdf8JvZqDZjlq9/mLtGW.qfxm3.JhKL.DrkMvyTAlWbx05U.MAOa', 'cours-php-max.jpg', '2023-03-15 19:51:29');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `dt_sent` datetime NOT NULL,
  `answered` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_name`, `sender_email`, `topic`, `content`, `dt_sent`, `answered`) VALUES
(1, ' BENTO Kévin', 'kevin.bento@free.fr', 'test', 'test', '2022-12-23 13:57:32', 1),
(2, 'BENTO Kévin', 'kevin.bento@free.fr', 'test 2', 'test 2', '2022-12-23 13:58:14', 1);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `domain` enum('Développement Web','Divers','3rd domain') DEFAULT NULL,
  `category` enum('Le front-end','Annonces','Test','Testtt') DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `dt_upload` datetime NOT NULL,
  `dt_update` datetime DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `views` int DEFAULT NULL,
  `upvotes` int DEFAULT NULL,
  `comments` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `domain`, `category`, `title`, `description`, `content`, `dt_upload`, `dt_update`, `thumbnail`, `views`, `upvotes`, `comments`) VALUES
(1, '3rd domain', 'Testtt', 'Test 2.5', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'content', '2022-05-17 07:32:05', '2022-12-18 09:23:39', 'test1.jpg', 0, 0, 0),
(2, '3rd domain', 'Testtt', 'Test 2.5', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'content', '2022-05-17 16:19:33', '2022-12-18 09:23:39', 'test2.jpg', 0, 0, 0),
(3, '3rd domain', 'Testtt', 'Test 2.5', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'content', '2022-05-17 04:52:33', '2022-12-18 09:23:39', 'test3.jpg', 0, 0, 0),
(4, '3rd domain', 'Testtt', 'Test 2.5', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'content', '2022-05-08 09:31:08', '2022-12-18 09:23:39', 'test4.jpg', 96, 45, 32),
(6, 'Développement Web', 'Testtt', 'Test 2.5', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'content', '2022-12-08 09:31:08', '2022-12-21 08:28:07', 'test6.jpg', 96, 45, 32),
(15, '3rd domain', 'Testtt', 'Test 2.5', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus officia itaque vero veritatis, optio distinctio beatae repudiandae libero nisi eligendi', 'content', '2022-11-26 11:20:12', '2022-12-18 09:23:39', 'patoche henry.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `posts_comments`
--

DROP TABLE IF EXISTS `posts_comments`;
CREATE TABLE IF NOT EXISTS `posts_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `dt_sent` datetime NOT NULL,
  `author_id` int NOT NULL,
  `post_id` int NOT NULL,
  `is_answer` tinyint NOT NULL,
  `comment_referer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts_comments`
--

INSERT INTO `posts_comments` (`id`, `content`, `dt_sent`, `author_id`, `post_id`, `is_answer`, `comment_referer_id`) VALUES
(1, 'test', '2023-01-22 21:03:21', 1, 4, 0, NULL),
(2, 'test', '2023-01-22 21:03:29', 1, 4, 1, 1),
(3, 'test', '2023-01-22 21:03:40', 1, 4, 1, 1),
(4, 'test', '2023-01-23 16:06:55', 1, 4, 0, NULL),
(5, 'test', '2023-01-23 16:07:19', 1, 4, 0, NULL),
(6, 'test', '2023-01-23 16:08:21', 1, 4, 0, NULL),
(7, 'test', '2023-01-23 16:08:49', 1, 4, 0, NULL),
(8, 'test', '2023-01-23 16:10:23', 1, 4, 0, NULL),
(9, 'test', '2023-01-23 16:10:37', 1, 4, 0, NULL),
(10, 'test', '2023-01-23 16:10:39', 1, 4, 0, NULL),
(11, 'test', '2023-01-23 16:10:52', 1, 4, 0, NULL),
(12, 'test', '2023-01-24 08:59:38', 1, 4, 0, NULL),
(13, 'test', '2023-01-24 08:59:49', 1, 4, 1, 12),
(14, 'test. @test1 test @test2 testtest @test3', '2023-01-24 09:00:11', 1, 4, 1, 12);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dt_signup` datetime NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `dt_signup`, `profile_picture`) VALUES
(1, 'k.bento', '$2y$10$rlmdIg7YQ0LkEf/lZWoiQOXDx6F1oyMxyM405gwErBX.m1Rd0ba6.', '2022-06-10 09:16:00', '1.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
