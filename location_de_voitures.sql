-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 fév. 2024 à 16:06
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `location_de_voitures`
--
CREATE DATABASE IF NOT EXISTS `location_de_voitures` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `location_de_voitures`;

-- --------------------------------------------------------

--
-- Structure de la table `assurances`
--

CREATE TABLE `assurances` (
  `idAssurance` int(11) NOT NULL,
  `nom_assurance` varchar(255) DEFAULT NULL,
  `tarif_quotidien` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `assurances`
--

INSERT INTO `assurances` (`idAssurance`, `nom_assurance`, `tarif_quotidien`, `description`) VALUES
(1, 'Assurance Basique', '20.00', 'Couverture minimale pour les dommages matériels. Responsabilité civile limitée.'),
(2, 'Assurance Standard', '30.00', 'Couverture standard pour les dommages matériels. Responsabilité civile étendue. Assistance routière incluse.'),
(3, 'Assurance Premium', '40.00', 'Couverture complète pour les dommages matériels. Responsabilité civile étendue. Assistance routière. Protection contre le vol et le vandalisme.'),
(4, 'Assurance Jeune Permis', '50.00', 'Couverture complète pour les dommages matériels. Responsabilité civile étendue. Assistance routière. Protection contre le vol et le vandalisme. Obligatoire si vous avez le permis depuis moins de 3 ans.'),
(5, 'Assurance Habitué', '15.00', 'Couverture complète pour les dommages matériels. Responsabilité civile étendue. Assistance routière. Protection contre le vol et le vandalisme. Pour les habitué de nos locations et si vous n\'avez jamais eu d\'accident chez nous.');

-- --------------------------------------------------------

--
-- Structure de la table `carburants`
--

CREATE TABLE `carburants` (
  `idCarburant` int(11) NOT NULL,
  `nom_carburant` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `carburants`
--

INSERT INTO `carburants` (`idCarburant`, `nom_carburant`) VALUES
(4, 'B7 (gazole)'),
(1, 'E10 (SP95-E-10)'),
(2, 'E5 (SP95, SP98)'),
(3, 'E85 (Superéthanol)');

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

CREATE TABLE `marques` (
  `idMarque` int(11) NOT NULL,
  `nom_marque` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `marques`
--

INSERT INTO `marques` (`idMarque`, `nom_marque`, `logo`) VALUES
(1, 'Rolls-Royce', 'Photo/logo_RollsRoyce.png'),
(2, 'Ferrari', 'Photo/logo_Ferrari.png'),
(3, 'Lamborghini', 'Photo/logo_Lamborghini.png'),
(4, 'Bugatti', 'Photo/logo_Bugatti.png');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `idPhoto` int(11) NOT NULL,
  `idVehicule` int(11) DEFAULT NULL,
  `chemin_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`idPhoto`, `idVehicule`, `chemin_photo`) VALUES
(1, 9, 'Photo/ghost01.jpg'),
(2, 9, 'Photo/ghost02.jpg'),
(3, 9, 'Photo/ghost03.jpg'),
(4, 8, 'Photo/cloud01.jpg'),
(5, 8, 'Photo/cloud02.jpg'),
(6, 8, 'Photo/cloud03.jpg'),
(7, 7, 'Photo/F1-7501.jpg'),
(8, 7, 'Photo/F1-7502.jpg'),
(9, 7, 'Photo/F1-7503.jpg'),
(10, 6, 'Photo/296GTB01.jpg'),
(11, 6, 'Photo/296GTB02.jpg'),
(12, 6, 'Photo/296GTB03.jpg'),
(13, 5, 'Photo/centenario01.jpg'),
(14, 5, 'Photo/centenario02.jpg'),
(15, 5, 'Photo/centenario03.jpg'),
(16, 4, 'Photo/aventador01.jpg'),
(17, 4, 'Photo/aventador02.jpg'),
(18, 4, 'Photo/aventador03.jpg'),
(19, 3, 'Photo/mistral01.jpg'),
(20, 3, 'Photo/mistral02.jpg'),
(21, 3, 'Photo/mistral03.jpg'),
(22, 2, 'Photo/bolide01.jpg'),
(23, 2, 'Photo/bolide03.jpg'),
(24, 2, 'Photo/bolide02.jpg'),
(25, 1, 'Photo/centodieci01.jpg'),
(26, 1, 'Photo/centodieci02.jpg'),
(27, 1, 'Photo/centodieci03.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `idReservation` int(11) NOT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  `idVehicule` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `montant_total` decimal(10,2) DEFAULT NULL,
  `idAssurance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`idReservation`, `idUtilisateur`, `idVehicule`, `date_debut`, `date_fin`, `montant_total`, `idAssurance`) VALUES
(44, 4, 6, '2024-02-24', '2024-02-24', '490.00', 3),
(45, 4, 7, '2024-02-12', '2024-02-18', '37940.00', 1),
(47, 4, 3, '2024-02-25', '2024-02-25', '1620.00', 1),
(48, 4, 4, '2024-02-24', '2024-02-24', '770.00', 1),
(49, 4, 8, '2024-03-04', '2024-03-28', '16625.00', 5);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_inscription`) VALUES
(4, 'Billaud', 'Emilien', 'emilien.billaud@email', '$2y$10$DADKJ78YAIlCbibgviLsZe1PsjErhJed2NF7JbCTZIWVDnCeGQHny', '2024-02-24 14:43:27');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

CREATE TABLE `vehicules` (
  `idVehicule` int(11) NOT NULL,
  `idMarque` int(11) DEFAULT NULL,
  `modele` varchar(255) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `prix_journalier` decimal(10,2) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `idCarburant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`idVehicule`, `idMarque`, `modele`, `annee`, `prix_journalier`, `disponible`, `couleur`, `transmission`, `idCarburant`) VALUES
(1, 4, 'Centodieci', 2019, '800.00', 1, 'Bleu', 'Automatique', 1),
(2, 4, 'Bolide', 2024, '1500.00', 1, 'Noir', 'Manuelle', 2),
(3, 4, 'Mistral', 2024, '1600.00', 1, 'Noir', 'Automatique', 1),
(4, 3, 'Aventador', 2012, '750.00', 1, 'Jaune', 'Manuel', 2),
(5, 3, 'Centenario', 2017, '900.00', 1, 'Bleu', 'Automatique', 3),
(6, 2, '296 GTB', 2017, '450.00', 1, 'Rouge', 'Manuel', 1),
(7, 2, 'F1-75', 2015, '5400.00', 1, 'Rouge', 'Manuel', 4),
(8, 1, 'Cloud', 2014, '650.00', 1, 'Noir', 'Manuel', 2),
(9, 1, 'Ghost', 1996, '980.00', 1, 'Gris', 'Manuel', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `assurances`
--
ALTER TABLE `assurances`
  ADD PRIMARY KEY (`idAssurance`),
  ADD UNIQUE KEY `nom_assurance` (`nom_assurance`);

--
-- Index pour la table `carburants`
--
ALTER TABLE `carburants`
  ADD PRIMARY KEY (`idCarburant`),
  ADD UNIQUE KEY `nom_carburant` (`nom_carburant`);

--
-- Index pour la table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`idMarque`),
  ADD UNIQUE KEY `nom_marque` (`nom_marque`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`idPhoto`),
  ADD KEY `idVehicule` (`idVehicule`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `FK_Reservations_Utilisateurs` (`idUtilisateur`),
  ADD KEY `FK_Reservations_Vehicules` (`idVehicule`),
  ADD KEY `FK_Reservations_Assurances` (`idAssurance`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`idVehicule`),
  ADD KEY `FK_Vehicules_Marques` (`idMarque`),
  ADD KEY `FK_Vehicules_Carburants` (`idCarburant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `assurances`
--
ALTER TABLE `assurances`
  MODIFY `idAssurance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `carburants`
--
ALTER TABLE `carburants`
  MODIFY `idCarburant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `marques`
--
ALTER TABLE `marques`
  MODIFY `idMarque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `idPhoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `idVehicule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `FK_Reservations_Assurances` FOREIGN KEY (`idAssurance`) REFERENCES `assurances` (`idAssurance`),
  ADD CONSTRAINT `FK_Reservations_Utilisateurs` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `FK_Reservations_Vehicules` FOREIGN KEY (`idVehicule`) REFERENCES `vehicules` (`idVehicule`);

--
-- Contraintes pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD CONSTRAINT `FK_Vehicules_Carburants` FOREIGN KEY (`idCarburant`) REFERENCES `carburants` (`idCarburant`),
  ADD CONSTRAINT `FK_Vehicules_Marques` FOREIGN KEY (`idMarque`) REFERENCES `marques` (`idMarque`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
