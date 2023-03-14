-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 14 mars 2023 à 22:53
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `monsalonline`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `tel` int(11) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_user`, `nom`, `prenom`, `tel`, `reference`) VALUES
(30, 'RAFIK', 'enefida', 1999, 'enefida30'),
(38, 'rofix', 'enfida', 11, 'enfida38'),
(39, 'rof', 'enfida', 11, 'enfida39'),
(40, 'enefida30', 'enefida30', 11, 'enefida3040'),
(41, 'enefida30', 'enefida30', 11, 'enefida3041'),
(139, 'youssef', 'enefida', 2021, 'enefida139'),
(140, 'rafik', 'ENEFIDA', 2021, 'ENEFIDA140'),
(141, 'safae', 'safae', 2021, 'safae141'),
(142, 'oussal', 'ter', 2021, 'ter142'),
(143, 'trer', 'etretr', 2021, 'etretr143'),
(144, 'hicham ', 'hghjghjg', 2021, 'hghjghjg144'),
(154, '', '', 0, '154'),
(155, '', '', 0, '155'),
(156, '', '', 0, '156'),
(157, '', '', 0, '157'),
(158, '', '', 0, '158'),
(159, 'amina', 'amina', 0, 'amina159'),
(160, 'amina', 'amina', 10, 'amina160'),
(161, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk161'),
(162, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk162'),
(163, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk163'),
(164, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk164'),
(165, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk165'),
(166, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk166'),
(167, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk167'),
(168, 'kkkkkk', 'kkkkkkkk', 0, 'kkkkkkkk168'),
(169, 'ooo', 'ooo', 111, 'ooo169'),
(170, 'www', 'www', 0, 'www170'),
(171, '', '', 0, '171'),
(172, 'hhh', 'hhh', 111, 'hhh172'),
(173, 'rafik', 'ene', 634567889, 'ene173'),
(174, 'amina', 'ertyuh', 656464645, 'ertyuh174'),
(175, '', '', 0, '175'),
(176, '', '', 0, '176'),
(177, 'amina', 'el hakik', 20555, 'el hakik177'),
(178, 'a', 'aa', 0, 'aa178'),
(179, 'a', 'aa', 0, 'aa179'),
(180, 'aaaa', 'karim', 444, 'karim180'),
(181, 'aa', 'aa', 0, 'aa181'),
(182, 'shd', 'uysgdu', 0, 'uysgdu182'),
(183, 'hh', 'jjj', 55, 'jjj183'),
(184, 'jyusged', 'ygsd', 666, 'ygsd184');

-- --------------------------------------------------------

--
-- Structure de la table `créneau`
--

CREATE TABLE `créneau` (
  `id_cr` int(11) NOT NULL,
  `time_on` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `dimanche` int(11) DEFAULT NULL,
  `vendredi` int(11) DEFAULT NULL,
  `restesemaine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `créneau`
--

INSERT INTO `créneau` (`id_cr`, `time_on`, `time_out`, `dimanche`, `vendredi`, `restesemaine`) VALUES
(1, '09:00:00', '10:00:00', 1, 1, 1),
(2, '10:00:00', '11:00:00', 1, 1, 1),
(3, '11:00:00', '12:00:00', 1, 1, 1),
(4, '14:00:00', '15:00:00', 0, 0, 1),
(5, '15:00:00', '16:00:00', 0, 0, 1),
(6, '16:00:00', '17:00:00', 0, 1, 1),
(7, '17:00:00', '18:00:00', 0, 1, 1),
(8, '18:00:00', '19:00:00', 0, 1, 1),
(9, '19:00:00', '20:00:00', 0, 1, 1),
(10, '20:00:00', '21:00:00', 0, 1, 0),
(11, '21:00:00', '22:00:00', 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_user` int(11) DEFAULT NULL,
  `id_reservation` int(11) NOT NULL,
  `id_cr` int(11) DEFAULT NULL,
  `jour` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_user`, `id_reservation`, `id_cr`, `jour`) VALUES
(30, 7, 9, '2023-03-15'),
(30, 8, 2, '2023-03-15'),
(30, 9, 1, '2023-03-15');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `créneau`
--
ALTER TABLE `créneau`
  ADD PRIMARY KEY (`id_cr`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cr` (`id_cr`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT pour la table `créneau`
--
ALTER TABLE `créneau`
  MODIFY `id_cr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `client` (`id_user`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_cr`) REFERENCES `créneau` (`id_cr`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
