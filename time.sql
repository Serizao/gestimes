-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 27 Avril 2016 à 08:44
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_domaine` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `categorie`
--



-- --------------------------------------------------------

--
-- Structure de la table `conge`
--

CREATE TABLE IF NOT EXISTS `conge` (
`id` int(11) NOT NULL,
  `id_motif` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE IF NOT EXISTS `contrat` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pourcent` int(11) NOT NULL,
  `conge` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Contenu de la table `contrat`
--

INSERT INTO `contrat` (`id`, `nom`, `pourcent`, `conge`) VALUES
(3, 'temps plein', 100, '25'),
(2, 'temps partiel', 80, '20');

-- --------------------------------------------------------

--
-- Structure de la table `credit_conge`
--

CREATE TABLE IF NOT EXISTS `credit_conge` (
`id` int(11) NOT NULL,
  `nb_jour` decimal(20,5) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

CREATE TABLE IF NOT EXISTS `domaine` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `domaine`
--

INSERT INTO `domaine` (`id`, `nom`) VALUES
(7, 'autre');

-- --------------------------------------------------------

--
-- Structure de la table `es`
--

CREATE TABLE IF NOT EXISTS `es` (
`id` int(11) NOT NULL,
  `es` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `temps` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=283 ;

-- --------------------------------------------------------

--
-- Structure de la table `heure_sup`
--

CREATE TABLE IF NOT EXISTS `heure_sup` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `heure` int(11) NOT NULL,
  `date_refresh` date NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `heure_sup`
--

INSERT INTO `heure_sup` (`id`, `id_user`, `heure`, `date_refresh`) VALUES
(19, 1, 0, '2016-04-27');

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE IF NOT EXISTS `motif` (
`id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `motif`
--

INSERT INTO `motif` (`id`, `type`, `nom`) VALUES
(1, 1, 'congÃ© payÃ©'),
(2, 2, 'deplacement'),
(3, 0, 'rÃ©cupÃ©ration');

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
  `id_contrat` varchar(255) NOT NULL,
  `begin` date NOT NULL DEFAULT '0000-00-00',
  `state` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `nom`, `prenom`, `password`, `acl`, `mail`, `id_contrat`, `begin`, `state`) VALUES
(1, 'admin', 'admin', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '10', 'admin@admin.fr', '3', '2016-04-25', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conge`
--
ALTER TABLE `conge`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contrat`
--
ALTER TABLE `contrat`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `credit_conge`
--
ALTER TABLE `credit_conge`
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
-- Index pour la table `heure_sup`
--
ALTER TABLE `heure_sup`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `motif`
--
ALTER TABLE `motif`
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT pour la table `conge`
--
ALTER TABLE `conge`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT pour la table `credit_conge`
--
ALTER TABLE `credit_conge`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `domaine`
--
ALTER TABLE `domaine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `es`
--
ALTER TABLE `es`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT pour la table `heure`
--
ALTER TABLE `heure`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=283;
--
-- AUTO_INCREMENT pour la table `heure_sup`
--
ALTER TABLE `heure_sup`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `motif`
--
ALTER TABLE `motif`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
