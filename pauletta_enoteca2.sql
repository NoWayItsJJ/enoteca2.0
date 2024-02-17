-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2024 at 12:23 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pauletta_enoteca2`
--

-- --------------------------------------------------------

--
-- Table structure for table `articoli`
--

CREATE TABLE `articoli` (
  `id_articolo` int(16) NOT NULL,
  `numero_inventario` varchar(32) NOT NULL,
  `tipologia` set('hardware','software') NOT NULL,
  `categoria` set('computer','tablet','ebook','console') NOT NULL,
  `stato` set('disponibile','guasto','prenotato','in prestito') NOT NULL,
  `fk_id_centro` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `centri`
--

CREATE TABLE `centri` (
  `id_centro` int(16) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `città` varchar(32) NOT NULL,
  `indirizzo` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `id_prenotazione` int(16) NOT NULL,
  `data_inizio` date NOT NULL,
  `fk_id_utente` int(16) DEFAULT NULL,
  `fk_id_articolo` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prestiti`
--

CREATE TABLE `prestiti` (
  `id_prestito` int(16) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `fk_id_utente` int(16) DEFAULT NULL,
  `fk_id_articolo` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(16) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `indirizzo` varchar(64) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `tipologia` set('cliente','operatore','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`id_articolo`),
  ADD KEY `fk_id_centro` (`fk_id_centro`);

--
-- Indexes for table `centri`
--
ALTER TABLE `centri`
  ADD PRIMARY KEY (`id_centro`);

--
-- Indexes for table `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id_prenotazione`),
  ADD KEY `fk_id_utente` (`fk_id_utente`,`fk_id_articolo`),
  ADD KEY `fk_id_articolo` (`fk_id_articolo`);

--
-- Indexes for table `prestiti`
--
ALTER TABLE `prestiti`
  ADD PRIMARY KEY (`id_prestito`),
  ADD KEY `fk_id_utente` (`fk_id_utente`,`fk_id_articolo`),
  ADD KEY `fk_id_articolo` (`fk_id_articolo`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articoli`
--
ALTER TABLE `articoli`
  MODIFY `id_articolo` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centri`
--
ALTER TABLE `centri`
  MODIFY `id_centro` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id_prenotazione` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestiti`
--
ALTER TABLE `prestiti`
  MODIFY `id_prestito` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(16) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articoli`
--
ALTER TABLE `articoli`
  ADD CONSTRAINT `articoli_ibfk_1` FOREIGN KEY (`fk_id_centro`) REFERENCES `centri` (`id_centro`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`fk_id_utente`) REFERENCES `utenti` (`id_utente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`fk_id_articolo`) REFERENCES `articoli` (`id_articolo`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `prestiti`
--
ALTER TABLE `prestiti`
  ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`fk_id_utente`) REFERENCES `utenti` (`id_utente`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prestiti_ibfk_2` FOREIGN KEY (`fk_id_articolo`) REFERENCES `articoli` (`id_articolo`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
