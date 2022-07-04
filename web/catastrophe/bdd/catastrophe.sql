-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 juin 2022 à 09:20
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `catastrophe`
--

-- --------------------------------------------------------

--
-- Structure de la table `messages_tbl`
--

DROP TABLE IF EXISTS `messages_tbl`;
CREATE TABLE IF NOT EXISTS `messages_tbl` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_content` varchar(200) NOT NULL,
  `usr_id` int(11) NOT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `usr_id` (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `messages_tbl`
--

INSERT INTO `messages_tbl` (`msg_id`, `msg_content`, `usr_id`) VALUES
(1, 'Bienvenu sur mon serveur petit **script kittie** !\r\n', 1),
(2, 'Un black hat utilise des balises.\nUn black cat mark les balises.', 1),
(3, 'Click on the cat to erase your **mistakes**', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_tbl`
--

DROP TABLE IF EXISTS `users_tbl`;
CREATE TABLE IF NOT EXISTS `users_tbl` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_username` varchar(10) NOT NULL,
  `usr_permissions` tinyint(1) NOT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users_tbl`
--

INSERT INTO `users_tbl` (`usr_id`, `usr_username`, `usr_permissions`) VALUES
(1, 'admin', 1),
(2, 'anonymous', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `messages_tbl`
--
ALTER TABLE `messages_tbl`
  ADD CONSTRAINT `messages_tbl_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `users_tbl` (`usr_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
