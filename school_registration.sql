-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 21 avr. 2025 à 12:27
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `school_registration`
--

-- --------------------------------------------------------

--
-- Structure de la table `schools`
--

DROP TABLE IF EXISTS `schools`;
CREATE TABLE IF NOT EXISTS `schools` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` text,
  `devise` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `siteweb` varchar(255) DEFAULT NULL,
  `teacherCount` int DEFAULT NULL,
  `EcoleImage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logoImage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `schools`
--

INSERT INTO `schools` (`id`, `name`, `address`, `description`, `devise`, `section`, `email`, `phoneNumber`, `siteweb`, `teacherCount`, `EcoleImage`, `logoImage`) VALUES
(1, 'imani', 'golf faustin', 'shshs', 'nsnsn', 'secondary', 'sgsg@gmail.com', 'sjjsj', 'sjnsn', 7, NULL, NULL),
(2, 'bellevue', 'golf faustin avenue de la sante n6', 'its a good school', 'work', 'primary', 'arielshongoordi@gmail.com', '0829255398', 'sh.com', 49, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `sexe` enum('Man','Woman') DEFAULT NULL,
  `school_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `school_id` (`school_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `students`
--

INSERT INTO `students` (`id`, `firstName`, `lastName`, `birthdate`, `nationality`, `email`, `phoneNumber`, `address`, `sexe`, `school_id`) VALUES
(1, 'gg', 'hhhhhhhh', '2025-04-11', '', 'aakak@gmail.com', '0829255398', 'hshs', 'Man', 0),
(2, 'gg', 'hhhhhhhh', '2025-04-11', '', 'aakak@gmail.com', '0829255398', 'hshs', 'Man', 0),
(3, 'gg', 'hhhhhhhh', '2025-04-11', '', 'aakak@gmail.com', '0829255398', 'hshs', 'Man', 0),
(4, 'ariel3', 'hhhhhhhh', '2025-04-30', 'Angola', 'dgdgdgdg@gmail.com', '0829255398', 'hshs', 'Woman', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
