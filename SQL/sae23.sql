-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 31 Mai 2023 à 10:25
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `sae23`
--

-- --------------------------------------------------------

--
-- Structure de la table `Administration`
--

CREATE TABLE IF NOT EXISTS `Administration` (
  `login` varchar(30) NOT NULL,
  `mdp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Administration`
--

INSERT INTO `Administration` (`login`, `mdp`) VALUES
('admin1', 'passadmin1');

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

CREATE TABLE IF NOT EXISTS `batiment` (
`id_batiment` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `mdp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=598613 ;

--
-- Contenu de la table `batiment`
--

INSERT INTO `batiment` (`id_batiment`, `nom`, `login`, `mdp`) VALUES
(486945, 'E', 'toto', 'totoE'),
(598612, 'C', 'tata', 'tataC');

-- --------------------------------------------------------

--
-- Structure de la table `capteur`
--

CREATE TABLE IF NOT EXISTS `capteur` (
`id_capteur` int(11) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `id_batiment` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2598613 ;

--
-- Contenu de la table `capteur`
--

INSERT INTO `capteur` (`id_capteur`, `nom`, `type`, `id_batiment`) VALUES
(1486945, 'capteur_E207', 'temperature', 486945),
(1598612, 'capteur_C004', 'co2', 598612),
(2486945, 'capteur_E208', 'temperature', 486945),
(2598612, 'capteur_C006', 'co2', 598612);

-- --------------------------------------------------------

--
-- Structure de la table `mesure`
--

CREATE TABLE IF NOT EXISTS `mesure` (
`id_mesure` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `horaire` varchar(10) DEFAULT NULL,
  `valeur` decimal(10,2) DEFAULT NULL,
  `id_capteur` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25986123 ;

--
-- Contenu de la table `mesure`
--

INSERT INTO `mesure` (`id_mesure`, `date`, `horaire`, `valeur`, `id_capteur`) VALUES
(1, NULL, NULL, NULL, NULL),
(14869451, '2023-06-28', '17:20:25', '25.60', 1486945),
(15986121, '2023-06-28', '17:20:25', '450.00', 1598612),
(24869452, '2023-06-28', '17:20:25', '25.20', 2486945),
(25986122, '2023-06-28', '17:20:25', '443.00', 2598612);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `batiment`
--
ALTER TABLE `batiment`
 ADD PRIMARY KEY (`id_batiment`);

--
-- Index pour la table `capteur`
--
ALTER TABLE `capteur`
 ADD PRIMARY KEY (`id_capteur`), ADD KEY `id_batiment` (`id_batiment`);

--
-- Index pour la table `mesure`
--
ALTER TABLE `mesure`
 ADD PRIMARY KEY (`id_mesure`), ADD KEY `id_capteur` (`id_capteur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `batiment`
--
ALTER TABLE `batiment`
MODIFY `id_batiment` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=598613;
--
-- AUTO_INCREMENT pour la table `capteur`
--
ALTER TABLE `capteur`
MODIFY `id_capteur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2598613;
--
-- AUTO_INCREMENT pour la table `mesure`
--
ALTER TABLE `mesure`
MODIFY `id_mesure` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25986123;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `capteur`
--
ALTER TABLE `capteur`
ADD CONSTRAINT `capteur_ibfk_1` FOREIGN KEY (`id_batiment`) REFERENCES `batiment` (`id_batiment`);

--
-- Contraintes pour la table `mesure`
--
ALTER TABLE `mesure`
ADD CONSTRAINT `mesure_ibfk_1` FOREIGN KEY (`id_capteur`) REFERENCES `capteur` (`id_capteur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
