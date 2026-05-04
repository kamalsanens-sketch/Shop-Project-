-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 04 mai 2026 à 19:56
-- Version du serveur : 10.4.6-MariaDB
-- Version de PHP : 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Vente`
--

-- --------------------------------------------------------

--
-- Structure de la table `Article`
--

CREATE TABLE `Article` (
  `id_article` varchar(20) NOT NULL,
  `design` varchar(20) NOT NULL,
  `prix` float NOT NULL,
  `categorie` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Article`
--

INSERT INTO `Article` (`id_article`, `design`, `prix`, `categorie`) VALUES
('DELL35', 'Laptop', 350, 'PC'),
('HP 47', 'Laptop ', 256.78, 'PC'),
('HPM 27', 'Electronic Mouse ', 40, 'Mouse PC'),
('SONY 23', 'Curvy Screen', 345.23, 'Screen'),
('TOSHIBA 23', 'Laptop ', 356.29, 'PC');

-- --------------------------------------------------------

--
-- Structure de la table `Client`
--

CREATE TABLE `Client` (
  `id_client` int(80) NOT NULL,
  `nom` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `adress` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Client`
--

INSERT INTO `Client` (`id_client`, `nom`, `password`, `adress`, `email`, `city`) VALUES
(1, 'Kamal', '$2y$10$uQSzqCYnk7RovWkPJ098euRPngivS2agWpl5tiDjvMQHBwKv0b1Ii', 'Godomey', 'sanoussikamal76@gmail.com', 'Cotonou '),
(2, 'Tom', '$2y$10$jkLwWmHvYRKMjs1eZgBvzepP.5sOyEr5As9dbd2RzMbET1vCqRZLa', 'Avenue 42 caen', 'tarick@gmail.com', 'Paris'),
(3, 'Martial', '$2y$10$L3pw7gfUsj8O737n7PBpOOqwPE3GU0ecbWx7PCvvmFgU870wUkNcO', 'Godomey', 'martial@gmail.com', 'Cotonou '),
(4, 'Ryan', '$2y$10$50wJ7zCMcHxVPa5d74Heo.I4tMm0SwpkS0Dorm0VTlNFN/n88jHOm', 'Avenue 32 rue du val', 'ryan@gmail.com', 'Paris');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_comm` int(20) NOT NULL,
  `id_cust` int(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_comm`, `id_cust`, `date`) VALUES
(1, 1, '2026-05-04');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `id_cust` int(60) NOT NULL,
  `id_comm` int(80) NOT NULL,
  `quantite` int(20) NOT NULL,
  `prix_unitaire` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`id_cust`, `id_comm`, `quantite`, `prix_unitaire`) VALUES
(1, 1, 2, 245.67);

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE `customer` (
  `id_cust` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id_cust`, `nom`, `prenom`, `age`, `adresse`, `ville`, `email`) VALUES
(1, 'FATI', 'Ansu', 22, '15 avenue du troie', 'Monaco', 'ansufati@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Article`
--
ALTER TABLE `Article`
  ADD PRIMARY KEY (`id_article`);

--
-- Index pour la table `Client`
--
ALTER TABLE `Client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_comm`),
  ADD KEY `id_client` (`id_cust`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD KEY `id_cust` (`id_cust`,`id_comm`);

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_cust`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Client`
--
ALTER TABLE `Client`
  MODIFY `id_client` int(80) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_comm` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_cust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
