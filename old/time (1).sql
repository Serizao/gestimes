-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 14 Mars 2016 à 06:54
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `time`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_domaine` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `id_domaine`) VALUES
(2, 'administration generale', 3),
(3, 'fabrication resines', 6),
(4, 'Controle qualite', 6),
(5, 'traitement commercial', 5),
(6, 'traitement/T.M.D', 5),
(7, 'SÃ©curitÃ© produits (REACH, FDSâ€¦)', 5),
(8, 'Support technique', 5),
(9, 'Salons/ConfÃ©rences', 5),
(10, 'Visite distributeurs / clients', 5),
(11, 'RÃ©unions Utilisateurs', 5),
(13, 'DÃ©veloppement commercial', 5),
(14, 'Temps de voyages', 5),
(15, 'Processus ISO 9001', 4),
(16, 'Environnement', 4),
(17, 'SÃ©curitÃ©', 4),
(18, 'CARAT', 2),
(19, 'Scandium_CDI', 2),
(20, 'FIRM', 2),
(21, 'Zr_93 (Haasi)', 2),
(22, '"DeterminatÂ° vials" for 99Tc (Un. Barcelone)', 2),
(23, 'BOKU (nom du projet Ã  venir)', 2),
(24, 'Autres (en cours de nÃ©gociations)', 2),
(25, 'Inventaire', 3),
(27, 'RÃ©unions entreprises', 3),
(28, 'RÃ©unions SÃ©curitÃ©', 3),
(29, 'Formations/connaissances et pratiques', 3),
(32, 'Outils Marketing', 5),
(31, 'test', 0);

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

CREATE TABLE IF NOT EXISTS `domaine` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `domaine`
--

INSERT INTO `domaine` (`id`, `nom`) VALUES
(2, 'Recherche et developpement'),
(3, 'administration'),
(4, 'qualitÃ© (norme iso)'),
(5, 'commerciale/marketing'),
(6, 'production');

-- --------------------------------------------------------

--
-- Structure de la table `es`
--

CREATE TABLE IF NOT EXISTS `es` (
`id` int(11) NOT NULL,
  `es` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `temps` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=151 ;

--
-- Contenu de la table `es`
--

INSERT INTO `es` (`id`, `es`, `id_user`, `temps`) VALUES
(150, 's', 1, '2016-03-12 00:29:47'),
(149, 'e', 1, '2016-03-12 00:29:42'),
(148, 's', 1, '2016-03-11 10:51:30'),
(147, 'e', 1, '2016-03-11 10:51:24'),
(145, 's', 1, '2016-03-09 21:29:42'),
(144, 'e', 1, '2016-03-09 18:51:58'),
(143, 's', 1, '2016-03-09 18:51:51'),
(142, 'e', 1, '2016-03-09 18:48:55'),
(141, 's', 1, '2016-03-09 18:36:35'),
(140, 's', 1, '2016-03-08 23:00:00'),
(139, 'e', 1, '2016-03-08 19:00:00'),
(138, 's', 1, '2016-03-08 18:00:00'),
(137, 'e', 1, '2016-03-08 14:00:00'),
(136, 's', 1, '2016-03-09 15:27:31'),
(135, 's', 1, '2016-03-08 11:00:00'),
(134, 'e', 1, '2016-03-08 10:00:00'),
(133, 's', 1, '2016-03-09 10:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `heure`
--

CREATE TABLE IF NOT EXISTS `heure` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nb` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `heure`
--

INSERT INTO `heure` (`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES
(12, 1, 3660, 2, '2016-03-09'),
(14, 1, 3600, 2, '2016-03-09');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `acl` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `contrat` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `nom`, `prenom`, `password`, `acl`, `mail`, `contrat`) VALUES
(1, 'serizao', 'le berre', 'william', '729245b9bfc7d67eede5ae2acb071baf7e9cb291fcbc315586fe8b8835c2fff195e6c70a1a3dff0e4003d3964c081d9d1080da89ab376b1711f564410443002f', '10', 'w.w@w.fr', '35');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `domaine`
--
ALTER TABLE `domaine`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `es`
--
ALTER TABLE `es`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `heure`
--
ALTER TABLE `heure`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT pour la table `domaine`
--
ALTER TABLE `domaine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `es`
--
ALTER TABLE `es`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=151;
--
-- AUTO_INCREMENT pour la table `heure`
--
ALTER TABLE `heure`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
