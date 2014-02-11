-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Serveur: infongd15955:3316
-- Généré le : Mardi 09 Août 2011 à 17:56
-- Version du serveur: 5.0.92
-- Version de PHP: 5.3.3-7+squeeze1
-- 
-- Base de données: `db339428562`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `admin`
-- 

CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `derniereconnexion` datetime NOT NULL,
  `online` char(1) NOT NULL default 'N',
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `admin`
-- 

INSERT INTO `admin` VALUES (2, 'test', 'test', '2010-11-17 13:27:05', 'Y', '', '', '');
INSERT INTO `admin` VALUES (3, 'demo', 'demo', '2010-09-02 10:47:04', 'Y', 'Demo', 'Demo', 'demo@funkylab.info');

-- --------------------------------------------------------

-- 
-- Structure de la table `images`
-- 

CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `online` char(1) NOT NULL default 'N',
  `filename` varchar(255) NOT NULL,
  `date_crea` datetime NOT NULL,
  `date_modif` datetime NOT NULL,
  `user_modif` varchar(45) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- 
-- Contenu de la table `images`
-- 

INSERT INTO `images` VALUES (4, 'Y', 'xmas.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');
INSERT INTO `images` VALUES (5, 'N', 'Hiver.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');
INSERT INTO `images` VALUES (6, 'N', 'NÃ©nuphars.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');
INSERT INTO `images` VALUES (7, 'N', 'Mornings.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');
INSERT INTO `images` VALUES (9, 'N', 'NÃ©nuphars.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');
INSERT INTO `images` VALUES (10, 'N', 'Collines.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');
INSERT INTO `images` VALUES (11, 'N', 'Mornings.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');

-- --------------------------------------------------------

-- 
-- Structure de la table `link_page_contenu`
-- 

CREATE TABLE `link_page_contenu` (
  `id_pere` int(11) NOT NULL default '0',
  `id_child` int(11) NOT NULL default '0',
  `ordre` int(11) NOT NULL default '0',
  `tablename` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `link_page_contenu`
-- 

INSERT INTO `link_page_contenu` VALUES (14, 2, 1, 'texte');
INSERT INTO `link_page_contenu` VALUES (12, 4, 9, 'images');
INSERT INTO `link_page_contenu` VALUES (12, 5, 5, 'images');
INSERT INTO `link_page_contenu` VALUES (12, 6, 1, 'images');
INSERT INTO `link_page_contenu` VALUES (12, 7, 3, 'images');
INSERT INTO `link_page_contenu` VALUES (12, 3, 4, 'texte');
INSERT INTO `link_page_contenu` VALUES (14, 9, 1, 'images');
INSERT INTO `link_page_contenu` VALUES (14, 10, 1, 'images');
INSERT INTO `link_page_contenu` VALUES (12, 11, 1, 'images');
INSERT INTO `link_page_contenu` VALUES (15, 4, 1, 'texte');

-- --------------------------------------------------------

-- 
-- Structure de la table `page`
-- 

CREATE TABLE `page` (
  `id` int(11) NOT NULL auto_increment,
  `titre` varchar(255) NOT NULL default '',
  `ordre` int(11) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  `folderopen` int(11) NOT NULL default '0',
  `fait_le` datetime NOT NULL default '0000-00-00 00:00:00',
  `modif_le` datetime NOT NULL default '0000-00-00 00:00:00',
  `fait_par` int(11) NOT NULL default '0',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- 
-- Contenu de la table `page`
-- 

INSERT INTO `page` VALUES (10, 'test', 0, 0, 1, '2010-08-30 14:51:59', '0000-00-00 00:00:00', 0);
INSERT INTO `page` VALUES (11, 'nouvelle page', 0, 10, 1, '2010-08-30 14:52:04', '0000-00-00 00:00:00', 0);
INSERT INTO `page` VALUES (12, 'Aiman', 0, 13, 1, '2010-08-30 14:52:06', '0000-00-00 00:00:00', 0);
INSERT INTO `page` VALUES (13, 'nouvelle page', 0, 0, 1, '2010-08-30 14:52:07', '0000-00-00 00:00:00', 0);
INSERT INTO `page` VALUES (14, 'nouvelle page', 0, 13, 0, '2010-08-30 14:52:10', '0000-00-00 00:00:00', 0);
INSERT INTO `page` VALUES (15, 'test', 0, 12, 0, '2010-11-17 13:28:19', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `texte`
-- 

CREATE TABLE `texte` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `online` char(1) NOT NULL default 'N',
  `text_fr` text NOT NULL,
  `text_uk` text NOT NULL,
  `date_crea` datetime NOT NULL,
  `date_modif` datetime NOT NULL,
  `user_modif` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `texte`
-- 

INSERT INTO `texte` VALUES (2, 'Y', 'test', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);
INSERT INTO `texte` VALUES (3, 'N', 'Texte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introductionTexte d\\\\\\''introduction', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);
INSERT INTO `texte` VALUES (4, 'N', 'dfsdf', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `videos`
-- 

CREATE TABLE `videos` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `online` char(1) NOT NULL default 'N',
  `filename` varchar(255) NOT NULL,
  `date_crea` datetime NOT NULL,
  `date_modif` datetime NOT NULL,
  `user_modif` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contenu de la table `videos`
-- 

