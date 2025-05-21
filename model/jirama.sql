-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2025 at 01:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jirama`
--

-- --------------------------------------------------------

--
-- Table structure for table `CLIENT`
--

CREATE TABLE `CLIENT` (
  `codecli` varchar(100) NOT NULL,
  `nom` varchar(1000) NOT NULL,
  `sexe` varchar(1000) NOT NULL,
  `quartier` varchar(1000) NOT NULL,
  `niveau` varchar(1000) NOT NULL,
  `mail` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `CLIENT`
--

INSERT INTO `CLIENT` (`codecli`, `nom`, `sexe`, `quartier`, `niveau`, `mail`) VALUES
('codeclient1', 'client1', 'M', 'fianara', 'moyenne', 'client1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `COMPTEUR`
--

CREATE TABLE `COMPTEUR` (
  `codecompteur` varchar(100) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `pu` int(11) NOT NULL,
  `codecli` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `COMPTEUR`
--

INSERT INTO `COMPTEUR` (`codecompteur`, `type`, `pu`, `codecli`) VALUES
('codecompteur1', 'EAU', 5000, 'codeclient1'),
('codecompteur2', 'ELECTRICITE', 4000, 'codeclient1');

-- --------------------------------------------------------

--
-- Table structure for table `EAU`
--

CREATE TABLE `EAU` (
  `codeEau` varchar(100) NOT NULL,
  `codecompteur` varchar(1000) NOT NULL,
  `valeur2` int(100) NOT NULL,
  `date_releve2` date NOT NULL,
  `date_presentation2` date NOT NULL,
  `date_limite_paie2` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `EAU`
--

INSERT INTO `EAU` (`codeEau`, `codecompteur`, `valeur2`, `date_releve2`, `date_presentation2`, `date_limite_paie2`) VALUES
('codeeau1', 'codecompteur2', 2504, '2025-03-05', '2025-03-26', '2025-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `ELEC`
--

CREATE TABLE `ELEC` (
  `codeElec` varchar(100) NOT NULL,
  `codecompteur` varchar(1000) NOT NULL,
  `valeur1` int(100) NOT NULL,
  `date_releve` date NOT NULL,
  `date_presentation` date NOT NULL,
  `date_limite_paie` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `ELEC`
--

INSERT INTO `ELEC` (`codeElec`, `codecompteur`, `valeur1`, `date_releve`, `date_presentation`, `date_limite_paie`) VALUES
('codeelec1', 'codecompteur1', 5848, '2025-03-01', '2025-03-12', '2025-03-25'),
('codeelec2', 'codecompteur2', 5848, '2025-03-08', '2025-03-26', '2025-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `PAYER`
--

CREATE TABLE `PAYER` (
  `idpaye` varchar(100) NOT NULL,
  `codecli` varchar(1000) NOT NULL,
  `datepaie` date NOT NULL,
  `montant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `REVELE_EAU`
--

CREATE TABLE `REVELE_EAU` (
  `codeEau` varchar(100) NOT NULL,
  `codecompteur` varchar(100) NOT NULL,
  `valeur2` int(100) NOT NULL,
  `date_releve2` date NOT NULL,
  `date_presentation2` date NOT NULL,
  `date_limite_paie2` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `REVELE_EAU`
--

INSERT INTO `REVELE_EAU` (`codeEau`, `codecompteur`, `valeur2`, `date_releve2`, `date_presentation2`, `date_limite_paie2`) VALUES
('okokok', 'ok', 22, '2025-03-13', '2025-03-17', '2025-03-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD PRIMARY KEY (`codecli`);

--
-- Indexes for table `COMPTEUR`
--
ALTER TABLE `COMPTEUR`
  ADD PRIMARY KEY (`codecompteur`);

--
-- Indexes for table `EAU`
--
ALTER TABLE `EAU`
  ADD PRIMARY KEY (`codeEau`);

--
-- Indexes for table `ELEC`
--
ALTER TABLE `ELEC`
  ADD PRIMARY KEY (`codeElec`);

--
-- Indexes for table `PAYER`
--
ALTER TABLE `PAYER`
  ADD PRIMARY KEY (`idpaye`);

--
-- Indexes for table `REVELE_EAU`
--
ALTER TABLE `REVELE_EAU`
  ADD PRIMARY KEY (`codeEau`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
