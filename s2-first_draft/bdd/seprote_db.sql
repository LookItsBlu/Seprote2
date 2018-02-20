-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 09 Janvier 2018 à 07:58
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

CREATE TABLE `annee` (
  `id_a` int(11) NOT NULL,
  `dat_deb_a` date DEFAULT NULL,
  `dat_fin_a` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `annee`
--

INSERT INTO `annee` (`id_a`, `dat_deb_a`, `dat_fin_a`) VALUES
(1, '2018-01-01', '2018-12-28');

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE IF NOT EXISTS `departement` (
  `id_d` int(11) NOT NULL,
  `nom_d` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Contenu de la table `departement`
--

INSERT INTO `departement` (`id_d`, `nom_d`) VALUES
(1, 'INFO');

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `id_f` int(11) NOT NULL,
  `nom_f` varchar(50) NOT NULL,
  `group_td` int(11) DEFAULT NULL,
  `group_tp` int(11) DEFAULT NULL,
  `id_d` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `formation`
--

INSERT INTO `formation` (`id_f`, `nom_f`, `group_td`, `group_tp`, `id_d`) VALUES
(1, 'Licence Pro DIM', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `for_annee`
--

CREATE TABLE `for_annee` (
  `id_f` int(11) NOT NULL,
  `id_a` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `for_annee`
--

INSERT INTO `for_annee` (`id_f`, `id_a`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `id_m` int(11) NOT NULL,
  `nom_m` varchar(255) DEFAULT NULL,
  `code_m` varchar(10) NOT NULL,
  `cm_g` int(11) NOT NULL,
  `td_g` int(11) NOT NULL,
  `tp_g` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `module`
--

INSERT INTO `module` (`id_m`, `nom_m`, `code_m`, `cm_g`, `td_g`, `tp_g`) VALUES
(1, 'Java', 'UE0', 5, 5, 15);

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `id_p` int(11) NOT NULL,
  `dat_deb_p` date DEFAULT NULL,
  `dat_fin_p` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `periode`
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

CREATE TABLE `per_mod` (
  `id_per` int(11) NOT NULL,
  `id_mod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `per_mod`
--

INSERT INTO `per_mod` (`id_per`, `id_mod`) VALUES
(17, 1);

-- --------------------------------------------------------

--
-- Structure de la table `per_sem`
--

CREATE TABLE `per_sem` (
  `id_per` int(11) NOT NULL,
  `id_sem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `per_sem`
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

CREATE TABLE `programme` (
  `id_prog` int(11) NOT NULL,
  `ppn` tinyint(1) NOT NULL,
  `ppn_relie` int(11) DEFAULT NULL,
  `prog_nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `programme`
--

INSERT INTO `programme` (`id_prog`, `ppn`, `ppn_relie`, `prog_nom`) VALUES
(1, 1, NULL, 'PPN_LPDIM'),
(2, 0, 1, 'LPDIM');

-- --------------------------------------------------------

--
-- Structure de la table `prog_for`
--

CREATE TABLE `prog_for` (
  `id_prog` int(11) NOT NULL,
  `id_f` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `prog_for`
--

INSERT INTO `prog_for` (`id_prog`, `id_f`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_r` int(11) NOT NULL,
  `nom_r` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id_r`, `nom_r`) VALUES
(1, 'Administrateur'),
(2, 'Gestionnaire'),
(3, 'Professeur');

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre` (
  `id_s` int(11) NOT NULL,
  `dat_deb_s` date DEFAULT NULL,
  `dat_fin_s` date DEFAULT NULL,
  `id_prog` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `semestre`
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

CREATE TABLE `utilisateur` (
  `id_u` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_u`, `nom`, `prenom`, `id_role`, `mail`, `mdp`) VALUES
(1, 'Admin', 'Admin', 1, 'test@test.fr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(2, 'Delepoulle', 'Samuel', 3, 'delepoulle.samuel@univ-littoral.fr', '304606830e32cb3e3d8ccc6abb5efe6f41043d18');

-- --------------------------------------------------------

--
-- Structure de la table `util_dep`
--

CREATE TABLE `util_dep` (
  `id_u` int(11) NOT NULL,
  `id_d` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `util_dep`
--

INSERT INTO `util_dep` (`id_u`, `id_d`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `volume_horaire`
--

CREATE TABLE `volume_horaire` (
  `id_module` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `cm` int(11) DEFAULT NULL,
  `td` int(11) DEFAULT NULL,
  `tp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `volume_horaire`
--

INSERT INTO `volume_horaire` (`id_module`, `id_utilisateur`, `cm`, `td`, `tp`) VALUES
(1, 2, 5, 5, 15);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `annee`
--
ALTER TABLE `annee`
  ADD PRIMARY KEY (`id_a`),
  ADD UNIQUE KEY `id_a` (`id_a`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_d`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`id_f`),
  ADD KEY `fk_formation_-_id_d` (`id_d`);

--
-- Index pour la table `for_annee`
--
ALTER TABLE `for_annee`
  ADD PRIMARY KEY (`id_f`,`id_a`),
  ADD KEY `fk_for_annee_-_id_a` (`id_a`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_m`),
  ADD UNIQUE KEY `id_m` (`id_m`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_p`),
  ADD UNIQUE KEY `id_p` (`id_p`);

--
-- Index pour la table `per_mod`
--
ALTER TABLE `per_mod`
  ADD PRIMARY KEY (`id_per`,`id_mod`),
  ADD KEY `fk_per_mod_-_id_mod` (`id_mod`);

--
-- Index pour la table `per_sem`
--
ALTER TABLE `per_sem`
  ADD PRIMARY KEY (`id_sem`,`id_per`),
  ADD KEY `fk_per_sem_-_id_per` (`id_per`);

--
-- Index pour la table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`id_prog`) USING BTREE,
  ADD KEY `fk_ppn` (`ppn`);

--
-- Index pour la table `prog_for`
--
ALTER TABLE `prog_for`
  ADD PRIMARY KEY (`id_prog`,`id_f`),
  ADD KEY `fk_prog_for_-_id_f` (`id_f`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_r`),
  ADD UNIQUE KEY `id_r` (`id_r`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`id_s`,`id_prog`),
  ADD UNIQUE KEY `id_s` (`id_s`),
  ADD KEY `id_prog` (`id_prog`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_u`),
  ADD UNIQUE KEY `id_u` (`id_u`),
  ADD KEY `fk_utilisateur_-_id_role` (`id_role`);

--
-- Index pour la table `util_dep`
--
ALTER TABLE `util_dep`
  ADD PRIMARY KEY (`id_u`,`id_d`),
  ADD KEY `fk_util_dep_-_id_d` (`id_d`);

--
-- Index pour la table `volume_horaire`
--
ALTER TABLE `volume_horaire`
  ADD PRIMARY KEY (`id_utilisateur`,`id_module`),
  ADD KEY `fk_volume_horaire_-_id_module` (`id_module`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `annee`
--
ALTER TABLE `annee`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id_d` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `id_f` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `id_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `programme`
--
ALTER TABLE `programme`
  MODIFY `id_prog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
  MODIFY `id_s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

-- Contraintes pour la table `formation`
ALTER TABLE `formation`
  ADD CONSTRAINT `fk_formation_-_id_d` FOREIGN KEY (`id_d`) REFERENCES `departement` (`id_d`);

--
-- Contraintes pour la table `for_annee`
--
ALTER TABLE `for_annee`
  ADD CONSTRAINT `fk_for_annee_-_id_a` FOREIGN KEY (`id_a`) REFERENCES `annee` (`id_a`),
  ADD CONSTRAINT `fk_for_annee_-_id_f` FOREIGN KEY (`id_f`) REFERENCES `formation` (`id_f`);

--
-- Contraintes pour la table `per_mod`
--
ALTER TABLE `per_mod`
  ADD CONSTRAINT `fk_per_mod_-_id_mod` FOREIGN KEY (`id_mod`) REFERENCES `module` (`id_m`),
  ADD CONSTRAINT `fk_per_mod_-_id_per` FOREIGN KEY (`id_per`) REFERENCES `periode` (`id_p`);

--
-- Contraintes pour la table `per_sem`
--
ALTER TABLE `per_sem`
  ADD CONSTRAINT `fk_per_sem_-_id_per` FOREIGN KEY (`id_per`) REFERENCES `periode` (`id_p`),
  ADD CONSTRAINT `fk_per_sem_-_id_sem` FOREIGN KEY (`id_sem`) REFERENCES `semestre` (`id_s`);

--
-- Contraintes pour la table `prog_for`
--
ALTER TABLE `prog_for`
  ADD CONSTRAINT `fk_prog_for_-_id_f` FOREIGN KEY (`id_f`) REFERENCES `formation` (`id_f`),
  ADD CONSTRAINT `fk_prog_for_-_id_prog` FOREIGN KEY (`id_prog`) REFERENCES `programme` (`id_prog`);

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
  ADD CONSTRAINT `fk_util_dep_-_id_d` FOREIGN KEY (`id_d`) REFERENCES `departement` (`id_d`),
  ADD CONSTRAINT `fk_util_dep_-_id_u` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`);

--
-- Contraintes pour la table `volume_horaire`
--
ALTER TABLE `volume_horaire`
  ADD CONSTRAINT `fk_volume_horaire_-_id_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_m`),
  ADD CONSTRAINT `fk_volume_horaire_-_id_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_u`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
