-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 26 Juillet 2016 à 15:47
-- Version du serveur :  5.6.20-log
-- Version de PHP :  5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `t3`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_domaine` int(11) NOT NULL,
  `cir` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE IF NOT EXISTS `contrat` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pourcent` int(11) NOT NULL,
  `conge` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `contrat`
--

INSERT INTO `contrat` (`id`, `nom`, `pourcent`, `conge`) VALUES
(4, 'Temps plein', 100, '25');

-- --------------------------------------------------------

--
-- Structure de la table `credit_conge`
--

CREATE TABLE IF NOT EXISTS `credit_conge` (
`id` int(11) NOT NULL,
  `nb_jour` float NOT NULL,
  `id_user` int(11) NOT NULL,
  `maj` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Contenu de la table `credit_conge`
--



-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

CREATE TABLE IF NOT EXISTS `domaine` (
`id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
  `temps` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1305 ;

-- --------------------------------------------------------

--
-- Structure de la table `heure`
--

CREATE TABLE IF NOT EXISTS `heure` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nb` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=855 ;

-- --------------------------------------------------------

--
-- Structure de la table `heure_sup`
--

CREATE TABLE IF NOT EXISTS `heure_sup` (
`id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `heure` int(11) NOT NULL,
  `date_refresh` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Structure de la table `motif`
--

CREATE TABLE IF NOT EXISTS `motif` (
`id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_cat` int(220) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

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
(1, 'admin', 'admin', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '10', 'admin@admin.fr', '4', '2016-07-25', 1);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT pour la table `conge`
--
ALTER TABLE `conge`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `credit_conge`
--
ALTER TABLE `credit_conge`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT pour la table `domaine`
--
ALTER TABLE `domaine`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `es`
--
ALTER TABLE `es`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1305;
--
-- AUTO_INCREMENT pour la table `heure`
--
ALTER TABLE `heure`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=855;
--
-- AUTO_INCREMENT pour la table `heure_sup`
--
ALTER TABLE `heure_sup`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `motif`
--
ALTER TABLE `motif`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
