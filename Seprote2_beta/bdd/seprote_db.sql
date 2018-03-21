-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 20 mars 2018 à 13:25
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `seprote`
--

DROP DATABASE IF EXISTS `seprote`;

CREATE DATABASE IF NOT EXISTS `seprote` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `seprote`;

-- --------------------------------------------------------

--
-- Structure de la table `annee`
--

DROP TABLE IF EXISTS `annee`;
CREATE TABLE IF NOT EXISTS `annee` (
  `id_a` int(11) NOT NULL AUTO_INCREMENT,
  `dat_deb_a` date DEFAULT NULL,
  `dat_fin_a` date DEFAULT NULL,
  PRIMARY KEY (`id_a`),
  UNIQUE KEY `id_a` (`id_a`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `annee`
--

INSERT INTO `annee` (`id_a`, `dat_deb_a`, `dat_fin_a`) VALUES
(1, '2018-01-01', '2018-12-28');

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id_d` int(11) NOT NULL AUTO_INCREMENT,
  `nom_d` varchar(50) NOT NULL,
  PRIMARY KEY (`id_d`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id_d`, `nom_d`) VALUES
(1, 'INFO');

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id_f` int(11) NOT NULL AUTO_INCREMENT,
  `nom_f` varchar(50) NOT NULL,
  `group_td` int(11) DEFAULT NULL,
  `group_tp` int(11) DEFAULT NULL,
  `id_d` int(11) NOT NULL,
  PRIMARY KEY (`id_f`),
  KEY `fk_formation_-_id_d` (`id_d`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_f`, `nom_f`, `group_td`, `group_tp`, `id_d`) VALUES
(1, 'Licence Pro DIM', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `for_annee`
--

DROP TABLE IF EXISTS `for_annee`;
CREATE TABLE IF NOT EXISTS `for_annee` (
  `id_f` int(11) NOT NULL,
  `id_a` int(11) NOT NULL,
  PRIMARY KEY (`id_f`,`id_a`),
  KEY `fk_for_annee_-_id_a` (`id_a`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `for_annee`
--

INSERT INTO `for_annee` (`id_f`, `id_a`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id_m` int(11) NOT NULL AUTO_INCREMENT,
  `nom_m` varchar(255) DEFAULT NULL,
  `code_m` varchar(10) NOT NULL,
  `cm_g` int(11) NOT NULL,
  `td_g` int(11) NOT NULL,
  `tp_g` int(11) NOT NULL,
  PRIMARY KEY (`id_m`),
  UNIQUE KEY `id_m` (`id_m`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `module`
--

INSERT INTO `module` (`id_m`, `nom_m`, `code_m`, `cm_g`, `td_g`, `tp_g`) VALUES
(1, 'Java', 'UE0', 5, 5, 15);

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

DROP TABLE IF EXISTS `periode`;
CREATE TABLE IF NOT EXISTS `periode` (
  `id_p` int(11) NOT NULL AUTO_INCREMENT,
  `dat_deb_p` date DEFAULT NULL,
  `dat_fin_p` date DEFAULT NULL,
  PRIMARY KEY (`id_p`),
  UNIQUE KEY `id_p` (`id_p`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `periode`
--

INSERT INTO `periode` (`id_p`, `dat_deb_p`, `dat_fin_p`) VALUES
(15, '2018-01-01', '2018-06-28'),
(16, '2018-07-02', '2018-12-28'),
(17, '2018-01-01', '2018-06-28'),
(18, '2018-07-02', '2018-12-28');

-- --------------------------------------------------------

--
-- Structure de la table `per_mod`
--

DROP TABLE IF EXISTS `per_mod`;
CREATE TABLE IF NOT EXISTS `per_mod` (
  `id_per` int(11) NOT NULL,
  `id_mod` int(11) NOT NULL,
  PRIMARY KEY (`id_per`,`id_mod`),
  KEY `fk_per_mod_-_id_mod` (`id_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `per_mod`
--

INSERT INTO `per_mod` (`id_per`, `id_mod`) VALUES
(17, 1);

-- --------------------------------------------------------

--
-- Structure de la table `per_sem`
--

DROP TABLE IF EXISTS `per_sem`;
CREATE TABLE IF NOT EXISTS `per_sem` (
  `id_per` int(11) NOT NULL,
  `id_sem` int(11) NOT NULL,
  PRIMARY KEY (`id_sem`,`id_per`),
  KEY `fk_per_sem_-_id_per` (`id_per`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `per_sem`
--

INSERT INTO `per_sem` (`id_per`, `id_sem`) VALUES
(15, 1),
(16, 2),
(17, 3),
(18, 4);

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id_prog` int(11) NOT NULL AUTO_INCREMENT,
  `ppn` tinyint(1) NOT NULL,
  `ppn_relie` int(11) DEFAULT NULL,
  `prog_nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id_prog`) USING BTREE,
  KEY `fk_ppn` (`ppn`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `programme`
--

INSERT INTO `programme` (`id_prog`, `ppn`, `ppn_relie`, `prog_nom`) VALUES
(1, 1, NULL, 'PPN_LPDIM'),
(2, 0, 1, 'LPDIM');

-- --------------------------------------------------------

--
-- Structure de la table `prog_for`
--

DROP TABLE IF EXISTS `prog_for`;
CREATE TABLE IF NOT EXISTS `prog_for` (
  `id_prog` int(11) NOT NULL,
  `id_f` int(11) NOT NULL,
  PRIMARY KEY (`id_prog`,`id_f`),
  KEY `fk_prog_for_-_id_f` (`id_f`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `prog_for`
--

INSERT INTO `prog_for` (`id_prog`, `id_f`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_r` int(11) NOT NULL AUTO_INCREMENT,
  `nom_r` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_r`),
  UNIQUE KEY `id_r` (`id_r`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_r`, `nom_r`) VALUES
(1, 'Administrateur'),
(2, 'Gestionnaire'),
(3, 'Professeur');

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

DROP TABLE IF EXISTS `semestre`;
CREATE TABLE IF NOT EXISTS `semestre` (
  `id_s` int(11) NOT NULL AUTO_INCREMENT,
  `dat_deb_s` date DEFAULT NULL,
  `dat_fin_s` date DEFAULT NULL,
  `id_prog` int(11) NOT NULL,
  PRIMARY KEY (`id_s`,`id_prog`),
  UNIQUE KEY `id_s` (`id_s`),
  KEY `id_prog` (`id_prog`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `semestre`
--

INSERT INTO `semestre` (`id_s`, `dat_deb_s`, `dat_fin_s`, `id_prog`) VALUES
(1, '2018-01-01', '2018-06-28', 1),
(2, '2018-07-02', '2018-12-28', 1),
(3, '2018-01-01', '2018-06-28', 2),
(4, '2018-07-02', '2018-12-28', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_u` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_u`),
  UNIQUE KEY `id_u` (`id_u`),
  KEY `fk_utilisateur_-_id_role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_u`, `nom`, `prenom`, `id_role`, `mail`, `mdp`) VALUES
(1, 'Admin', 'Admin', 1, 'test@test.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(2, 'Delepoulle', 'Samuel', 3, 'delepoulle.samuel@univ-littoral.fr', '304606830e32cb3e3d8ccc6abb5efe6f41043d18');

-- --------------------------------------------------------

--
-- Structure de la table `util_dep`
--

DROP TABLE IF EXISTS `util_dep`;
CREATE TABLE IF NOT EXISTS `util_dep` (
  `id_u` int(11) NOT NULL,
  `id_d` int(11) NOT NULL,
  PRIMARY KEY (`id_u`,`id_d`),
  KEY `fk_util_dep_-_id_d` (`id_d`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `util_dep`
--

INSERT INTO `util_dep` (`id_u`, `id_d`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `volume_horaire`
--

DROP TABLE IF EXISTS `volume_horaire`;
CREATE TABLE IF NOT EXISTS `volume_horaire` (
  `id_module` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `cm` int(11) DEFAULT NULL,
  `td` int(11) DEFAULT NULL,
  `tp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_module`),
  KEY `fk_volume_horaire_-_id_module` (`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `volume_horaire`
--

INSERT INTO `volume_horaire` (`id_module`, `id_utilisateur`, `cm`, `td`, `tp`) VALUES
(1, 2, 5, 5, 15);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `fk_formation_-_id_d` FOREIGN KEY (`id_d`) REFERENCES `departement` (`id_d`);

--
-- Contraintes pour la table `for_annee`
--
ALTER TABLE `for_annee`
  ADD CONSTRAINT `fk_for_annee_-_id_a` FOREIGN KEY (`id_a`) REFERENCES `annee` (`id_a`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_for_annee_-_id_f` FOREIGN KEY (`id_f`) REFERENCES `formation` (`id_f`) ON DELETE CASCADE;

--
-- Contraintes pour la table `per_mod`
--
ALTER TABLE `per_mod`
  ADD CONSTRAINT `fk_per_mod_-_id_mod` FOREIGN KEY (`id_mod`) REFERENCES `module` (`id_m`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_per_mod_-_id_per` FOREIGN KEY (`id_per`) REFERENCES `periode` (`id_p`) ON DELETE CASCADE;

--
-- Contraintes pour la table `per_sem`
--
ALTER TABLE `per_sem`
  ADD CONSTRAINT `fk_per_sem_-_id_per` FOREIGN KEY (`id_per`) REFERENCES `periode` (`id_p`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_per_sem_-_id_sem` FOREIGN KEY (`id_sem`) REFERENCES `semestre` (`id_s`) ON DELETE CASCADE;

--
-- Contraintes pour la table `prog_for`
--
ALTER TABLE `prog_for`
  ADD CONSTRAINT `fk_prog_for_-_id_f` FOREIGN KEY (`id_f`) REFERENCES `formation` (`id_f`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prog_for_-_id_prog` FOREIGN KEY (`id_prog`) REFERENCES `programme` (`id_prog`) ON DELETE CASCADE;

--
-- Contraintes pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD CONSTRAINT `fk_semestre_-_id_prog` FOREIGN KEY (`id_prog`) REFERENCES `programme` (`id_prog`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_utilisateur_-_id_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_r`);

--
-- Contraintes pour la table `util_dep`
--
ALTER TABLE `util_dep`
  ADD CONSTRAINT `fk_util_dep_-_id_d` FOREIGN KEY (`id_d`) REFERENCES `departement` (`id_d`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_util_dep_-_id_u` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`) ON DELETE CASCADE;

--
-- Contraintes pour la table `volume_horaire`
--
ALTER TABLE `volume_horaire`
  ADD CONSTRAINT `fk_volume_horaire_-_id_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_m`),
  ADD CONSTRAINT `fk_volume_horaire_-_id_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_u`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
