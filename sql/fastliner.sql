-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 16 Novembre 2014 à 10:36
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `fastliner`
--

-- --------------------------------------------------------

--
-- Structure de la table `avances`
--

CREATE TABLE IF NOT EXISTS `avances` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `valeur` int(250) NOT NULL,
  `date` date NOT NULL,
  `idroute` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

--
-- Contenu de la table `avances`
--

INSERT INTO `avances` (`id`, `valeur`, `date`, `idroute`) VALUES
(127, 25000, '2014-10-14', 14),
(128, 0, '0000-00-00', 14),
(129, 0, '0000-00-00', 11),
(130, 30000, '0000-00-00', 9),
(131, 33000, '0000-00-00', 7),
(133, 0, '2014-10-14', 15),
(134, 0, '2014-10-14', 16),
(135, 0, '2014-10-16', 17),
(137, 12000, '2014-10-16', 17),
(138, 21000, '0000-00-00', 17),
(140, 0, '0000-00-00', 17),
(144, 0, '2014-10-16', 18),
(145, 0, '2014-10-16', 19),
(146, 0, '2014-10-16', 20),
(147, 0, '2014-10-16', 21),
(148, 0, '2014-10-16', 22),
(149, 0, '2014-10-16', 23),
(150, 0, '2014-10-16', 24),
(151, 0, '2014-10-16', 25),
(152, 20000, '2014-10-19', 25),
(154, 0, '2014-10-19', 26),
(155, 1, '0000-00-00', 6),
(159, 0, '0000-00-00', 12),
(163, 13000, '0000-00-00', 25),
(166, 33000, '0000-00-00', 10),
(168, 0, '0000-00-00', 4),
(169, 0, '0000-00-00', 5),
(170, 0, '0000-00-00', 6),
(171, 0, '0000-00-00', 7),
(172, 19000, '0000-00-00', 2),
(173, 1, '2014-10-23', 26),
(174, 0, '2014-10-26', 27),
(175, 0, '2014-10-27', 28),
(177, 0, '2014-10-28', 29),
(178, 0, '2014-10-28', 30),
(179, 0, '2014-10-28', 31),
(180, 0, '2014-10-28', 32),
(181, 10000, '2014-10-28', 32),
(182, 20000, '2014-10-28', 31),
(183, 40000, '2014-10-28', 29),
(184, 0, '2014-10-28', 33),
(185, 0, '2014-10-28', 34),
(186, 0, '2014-10-28', 35),
(187, 0, '2014-10-28', 36),
(188, 5000, '2014-10-28', 36),
(189, 15000, '2014-11-06', 36),
(190, 0, '2014-11-12', 37),
(192, 0, '2014-11-12', 38),
(193, 5000, '2014-11-12', 37),
(194, 2000, '2014-11-12', 38);

-- --------------------------------------------------------

--
-- Structure de la table `avances_creances`
--

CREATE TABLE IF NOT EXISTS `avances_creances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` float NOT NULL,
  `date` date NOT NULL,
  `id_creance` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `avances_creances`
--


-- --------------------------------------------------------

--
-- Structure de la table `avances_debits`
--

CREATE TABLE IF NOT EXISTS `avances_debits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` float NOT NULL,
  `date` date NOT NULL,
  `id_debit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `avances_debits`
--


-- --------------------------------------------------------

--
-- Structure de la table `avances_projets`
--

CREATE TABLE IF NOT EXISTS `avances_projets` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `valeur` int(250) NOT NULL,
  `date` date NOT NULL,
  `idprojet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `avances_projets`
--

INSERT INTO `avances_projets` (`id`, `valeur`, `date`, `idprojet`) VALUES
(26, 0, '2014-10-28', 16),
(27, 0, '2014-10-28', 17),
(28, 0, '2014-11-12', 18);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `wilaya` varchar(20) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `observation` text NOT NULL,
  `idproduit` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `clients`
--


-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE IF NOT EXISTS `comptes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `comptes`
--

INSERT INTO `comptes` (`id`, `nom`, `mdp`, `type`) VALUES
(19, 'khalil', 'khalil', 'super-administrateur'),
(20, 'sara', 'sarah', 'super-administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `creances`
--

CREATE TABLE IF NOT EXISTS `creances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `objet` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `somme` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `creances`
--


-- --------------------------------------------------------

--
-- Structure de la table `debits`
--

CREATE TABLE IF NOT EXISTS `debits` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `objet` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `somme` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `debits`
--


-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE IF NOT EXISTS `factures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprojet` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `factures`
--

INSERT INTO `factures` (`id`, `idprojet`, `nom`, `date`) VALUES
(13, 16, '1', '2014-10-28'),
(14, 16, '2', '2014-10-28'),
(16, 17, 'frfr', '2014-11-04'),
(17, 17, 'sara', '2014-11-12'),
(18, 18, '1', '2014-11-12'),
(19, 18, '2', '2014-11-12');

-- --------------------------------------------------------

--
-- Structure de la table `itineraires`
--

CREATE TABLE IF NOT EXISTS `itineraires` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `idprojet` int(50) NOT NULL,
  `depart` varchar(250) NOT NULL,
  `destination` varchar(250) NOT NULL,
  `prix` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `itineraires`
--

INSERT INTO `itineraires` (`id`, `idprojet`, `depart`, `destination`, `prix`) VALUES
(11, 16, 'Annaba', 'Oran', 50000),
(12, 16, 'Oran', 'Tamenrasset', 72000),
(13, 17, 'Alger', 'Ouergla', 90000),
(14, 17, 'Constantine', 'Skikda', 30000),
(15, 18, 'ghardaya', 'hassirmal', 130000);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE IF NOT EXISTS `parametres` (
  `etiquette` varchar(25) NOT NULL,
  `valeur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `parametres`
--

INSERT INTO `parametres` (`etiquette`, `valeur`) VALUES
('elements_par_page', '4'),
('type', 'sous-traitant'),
('limite', '10'),
('delai_paye_chauffeur', '3'),
('delai_assurance', '11'),
('delai_vignette', '11'),
('delai_scanner', '11'),
('delai_assurance_chauffeur', '31'),
('delai_controle_technique', '11'),
('suffixe', 'DA');

-- --------------------------------------------------------

--
-- Structure de la table `prets`
--

CREATE TABLE IF NOT EXISTS `prets` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `idroute` int(9) NOT NULL,
  `avance` int(7) NOT NULL,
  `date` date NOT NULL,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `prets`
--


-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE IF NOT EXISTS `projets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `projet` varchar(100) NOT NULL,
  `client` varchar(100) NOT NULL,
  `prix` int(10) NOT NULL,
  `observation` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `projets`
--

INSERT INTO `projets` (`id`, `date`, `projet`, `client`, `prix`, `observation`) VALUES
(16, '2014-10-28', 'RGZ1', 'Alphapipe', 0, ''),
(17, '2014-10-28', 'RGZ2', 'Alphapipe', 0, ''),
(18, '2014-11-12', 'hassi', 'Alphapipe', 0, 'rien');

-- --------------------------------------------------------

--
-- Structure de la table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iditineraire` int(50) NOT NULL,
  `idfacture` int(11) NOT NULL,
  `nfr` int(5) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `matricule` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `idproduit` int(9) NOT NULL,
  `poids` varchar(9) NOT NULL,
  `ndocument` varchar(10) NOT NULL,
  `prix` int(15) NOT NULL,
  `observation` text NOT NULL,
  `receptionne` tinyint(1) NOT NULL,
  `idprojet` int(11) NOT NULL,
  `fichier` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Contenu de la table `routes`
--

INSERT INTO `routes` (`id`, `iditineraire`, `idfacture`, `nfr`, `nom`, `matricule`, `date`, `idproduit`, `poids`, `ndocument`, `prix`, `observation`, `receptionne`, `idprojet`, `fichier`) VALUES
(29, 11, 0, 1, 'Khalil', '123456', '2014-10-28', 1, '40T', '1', 40000, '', 0, 16, ''),
(30, 11, 0, 2, 'Yacine', '1234565', '2014-10-28', 2, '40T', '2', 40000, '', 0, 16, ''),
(31, 12, 0, 3, 'Mondersky', '098765', '2014-10-28', 1, '40T', '1', 50000, '', 0, 16, ''),
(32, 12, 0, 4, 'Hichem', '87654', '2014-10-28', 1, '40T', '5', 30000, '', 0, 16, ''),
(33, 13, 0, 1, 'Hamid', '123455', '2014-10-28', 0, '', '', 40000, '', 0, 17, ''),
(34, 13, 0, 2, 'Abdallah', '6786', '2014-10-28', 0, '', '', 40000, '', 0, 17, ''),
(35, 14, 0, 3, 'Said', '67889', '2014-10-28', 0, '', '', 20000, '', 0, 17, ''),
(36, 14, 0, 4, 'Bessam', '7689', '2014-10-28', 0, '', '', 20000, '', 1, 17, ''),
(37, 15, 18, 1, 'GJHVJHG', '56789', '2014-11-12', 1, '40T', '1', 10000, '', 0, 18, ''),
(38, 15, 18, 2, 'GHVBJHGVHJ', '76898756', '2014-11-12', 0, '40T', '', 10000, '', 0, 18, '');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

CREATE TABLE IF NOT EXISTS `vehicules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marque` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `date_assurance` date NOT NULL,
  `date_vignette` date NOT NULL,
  `date_scanner` date NOT NULL,
  `controle_technique` date NOT NULL,
  `prix_assurance` float NOT NULL,
  `prix_vignette` float NOT NULL,
  `prix_scanner` float NOT NULL,
  `prix_controle` float NOT NULL,
  `nom_chauffeur` varchar(50) NOT NULL,
  `paye_chauffeur` float NOT NULL,
  `date_chauffeur` date NOT NULL,
  `assurance_chauffeur` int(50) NOT NULL,
  `date_assurance_chauffeur` date NOT NULL,
  `image_vehicule` varchar(200) NOT NULL,
  `fichier` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `marque`, `type`, `matricule`, `date_assurance`, `date_vignette`, `date_scanner`, `controle_technique`, `prix_assurance`, `prix_vignette`, `prix_scanner`, `prix_controle`, `nom_chauffeur`, `paye_chauffeur`, `date_chauffeur`, `assurance_chauffeur`, `date_assurance_chauffeur`, `image_vehicule`, `fichier`) VALUES
(1, '', 'hhhhh', 'hhhhhhh', '2014-10-12', '2014-10-12', '2014-10-12', '2014-10-12', 11111, 111111, 11111, 1111110, 'monder', 111111000, '0000-00-00', 0, '0000-00-00', '', ''),
(2, '', 'hhhhh', 'hhhhhhh', '2014-10-12', '2014-10-12', '2014-10-12', '2014-10-12', 11111, 111111, 11111, 1111110, 'monder', 111111000, '0000-00-00', 0, '0000-00-00', '', 'monder_1413190146.jpg'),
(3, '', 'hhhhh', 'hhhhhhh', '2014-10-12', '2014-10-12', '2014-10-12', '2014-10-12', 11111, 111111, 11111, 1111110, 'monder', 111111000, '0000-00-00', 0, '0000-00-00', '', 'monder_1413191258.pdf');
