SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Base de données : `geotracer`
DROP TABLE IF EXISTS `reponses`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `posseder`;
DROP TABLE IF EXISTS `voiture`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `pays`;

CREATE TABLE IF NOT EXISTS `pays` (
  `id_pays` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `difficultés` varchar(1000) NOT NULL,
  `récompenses` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `pseudo` varchar(1000) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `voiture` (
  `id_voiture` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(1000) NOT NULL,
  `nom` varchar(1000) NOT NULL,
  `prix` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posseder` (
  `id_users` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id_users` (`id_users`),
  KEY `id_voiture` (`id_voiture`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `questions` (
  `id_questions` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` varchar(1000) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_questions`),
  KEY `id_pays` (`id_pays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `reponses` (
  `id_reponses` int(11) NOT NULL,
  `phrase` varchar(1000) NOT NULL,
  `résultat` varchar(1000) NOT NULL,
  `id_questions` int(11) NOT NULL,
  KEY `id_questions` (`id_questions`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `posseder`
  ADD CONSTRAINT `posseder_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`),
  ADD CONSTRAINT `posseder_ibfk_2` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`id_questions`) REFERENCES `questions` (`id_questions`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;