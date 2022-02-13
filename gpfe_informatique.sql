-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 30, 2020 at 08:59 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gpfe_informatique`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE `administration` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(125) NOT NULL,
  `departement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`id`, `username`, `password`, `email`, `departement`) VALUES
(1, 'admin', '$2y$10$VCEEWcJ7ktLukooRwlGuI.v9pqCR.WElso.ijvToD9BoXfMLtXCCO', 'admin@gmail.com', 'informatique');

-- --------------------------------------------------------

--
-- Table structure for table `choix`
--

CREATE TABLE `choix` (
  `id` int(11) NOT NULL,
  `idCompte` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `moyenne_compte` double NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `dateChoix` date NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT 0,
  `departement` varchar(255) NOT NULL,
  `priority` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `compte_etudiants`
--

CREATE TABLE `compte_etudiants` (
  `idCompte` int(11) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `sujet` varchar(255) NOT NULL DEFAULT '',
  `moyenne_compte` double NOT NULL,
  `typeC` varchar(20) NOT NULL,
  `niveau` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

CREATE TABLE `departement` (
  `id` int(11) NOT NULL,
  `nom` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `encadreur`
--

CREATE TABLE `encadreur` (
  `id` int(11) NOT NULL,
  `matricule` int(10) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `email` varchar(125) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `number` int(9) NOT NULL,
  `grade` varchar(125) NOT NULL,
  `domaine` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `matricule` int(10) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(125) NOT NULL,
  `moyenne_e` double NOT NULL,
  `pin` int(4) NOT NULL,
  `niveau` varchar(20) NOT NULL,
  `id_compte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messagerie`
--

CREATE TABLE `messagerie` (
  `id` int(11) NOT NULL,
  `expiditeur` varchar(255) NOT NULL,
  `natureExp` varchar(255) NOT NULL,
  `recepteur` varchar(255) NOT NULL,
  `natureRec` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contenu` varchar(2000) NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 0,
  `date_vue` datetime DEFAULT NULL,
  `departement` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `encadreur` varchar(255) NOT NULL,
  `compte_etudiant` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `validEncadreur` tinyint(1) NOT NULL,
  `validEtudiant` tinyint(1) NOT NULL,
  `departement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sujet`
--

CREATE TABLE `sujet` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `encadreur` varchar(200) NOT NULL,
  `contenu` varchar(2000) NOT NULL,
  `keywords` varchar(200) NOT NULL,
  `environement` varchar(255) NOT NULL,
  `bibliographie` varchar(1000) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 0,
  `nb_choix` int(11) NOT NULL DEFAULT 0,
  `etat` tinyint(1) NOT NULL DEFAULT 0,
  `dateValidation` date DEFAULT NULL,
  `niveau` varchar(20) NOT NULL,
  `tauxAvancement` int(3) NOT NULL DEFAULT 0,
  `departement` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sujetHistory`
--

CREATE TABLE `sujetHistory` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `encadreur` int(10) NOT NULL,
  `contenu` varchar(2000) NOT NULL,
  `keywords` varchar(200) NOT NULL,
  `environement` varchar(255) NOT NULL,
  `bibliographie` varchar(1000) NOT NULL,
  `dateValidation` date NOT NULL,
  `niveau` varchar(20) NOT NULL,
  `departement` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `choix`
--
ALTER TABLE `choix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compte_etudiants`
--
ALTER TABLE `compte_etudiants`
  ADD PRIMARY KEY (`idCompte`);

--
-- Indexes for table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `encadreur`
--
ALTER TABLE `encadreur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `matricule` (`matricule`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`matricule`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `messagerie`
--
ALTER TABLE `messagerie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sujet`
--
ALTER TABLE `sujet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titre` (`titre`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administration`
--
ALTER TABLE `administration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `choix`
--
ALTER TABLE `choix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compte_etudiants`
--
ALTER TABLE `compte_etudiants`
  MODIFY `idCompte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `encadreur`
--
ALTER TABLE `encadreur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messagerie`
--
ALTER TABLE `messagerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sujet`
--
ALTER TABLE `sujet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
