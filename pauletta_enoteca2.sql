-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 23, 2024 alle 12:02
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.2.0

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
-- Struttura della tabella `articoli`
--

CREATE TABLE `articoli` (
  `id_articolo` int(16) NOT NULL,
  `numero_inventario` varchar(32) NOT NULL,
  `articolo` varchar(64) NOT NULL,
  `stato` set('disponibile','guasto','prenotato','in prestito') NOT NULL,
  `fk_id_categoria` int(16) DEFAULT NULL,
  `fk_id_centro` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `articoli`
--

INSERT INTO `articoli` (`id_articolo`, `numero_inventario`, `articolo`, `stato`, `fk_id_categoria`, `fk_id_centro`) VALUES
(1, '000017243', 'xbox one', 'disponibile', 1, 1),
(2, '69420', 'ready player one', 'disponibile', 2, 2),
(4, '12345', 'playstation 5', 'guasto', 1, 3),
(5, '32834', 'harry potter', 'disponibile', 2, 3),
(9, '071', 'game of thrones', 'in prestito', 2, 3);

--
-- Trigger `articoli`
--
DELIMITER $$
CREATE TRIGGER `copy_and_delete_trigger` BEFORE DELETE ON `articoli` FOR EACH ROW BEGIN
    -- Copy the deleted record to the articoli_dismessi table
    INSERT INTO articoli_dismessi (id_articolo2, numero_inventario, articolo, stato, fk_id_categoria, fk_id_centro) 
    VALUES (OLD.id_articolo, OLD.numero_inventario, OLD.articolo, OLD.stato, OLD.fk_id_categoria, OLD.fk_id_centro);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `articoli_dismessi`
--

CREATE TABLE `articoli_dismessi` (
  `id_articolo2` int(16) NOT NULL,
  `numero_inventario` varchar(32) NOT NULL,
  `articolo` varchar(64) NOT NULL,
  `stato` set('disponibile','guasto','prenotato','in prestito') NOT NULL,
  `fk_id_categoria` int(16) DEFAULT NULL,
  `fk_id_centro` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `articoli_dismessi`
--

INSERT INTO `articoli_dismessi` (`id_articolo2`, `numero_inventario`, `articolo`, `stato`, `fk_id_categoria`, `fk_id_centro`) VALUES
(8, '100', 'test guasto', 'guasto', 2, 3),
(11, '123456', 'test restore', 'guasto', 1, 2);

--
-- Trigger `articoli_dismessi`
--
DELIMITER $$
CREATE TRIGGER `restore_trigger` BEFORE DELETE ON `articoli_dismessi` FOR EACH ROW BEGIN
    -- Copy the deleted record to the articoli_dismessi table
    INSERT INTO articoli (id_articolo, numero_inventario, articolo, stato, fk_id_categoria, fk_id_centro) 
    VALUES (OLD.id_articolo2, OLD.numero_inventario, OLD.articolo, OLD.stato, OLD.fk_id_categoria, OLD.fk_id_centro);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id_categoria` int(16) NOT NULL,
  `categoria` varchar(32) NOT NULL,
  `tipologia` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id_categoria`, `categoria`, `tipologia`) VALUES
(1, 'console', 'hardware'),
(2, 'ebook', 'software');

-- --------------------------------------------------------

--
-- Struttura della tabella `centri`
--

CREATE TABLE `centri` (
  `id_centro` int(16) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `citta` varchar(32) NOT NULL,
  `indirizzo` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `centri`
--

INSERT INTO `centri` (`id_centro`, `nome`, `citta`, `indirizzo`) VALUES
(1, 'videoteca1', 'pordenone', 'piazza cavour'),
(2, 'videoteca2', 'maniago', 'piazza italia'),
(3, 'itst kennedy', 'pordenone', 'via interna 7');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `id_prenotazione` int(16) NOT NULL,
  `data_inizio` date NOT NULL,
  `fk_id_utente` int(16) DEFAULT NULL,
  `fk_id_articolo` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `prestiti`
--

CREATE TABLE `prestiti` (
  `id_prestito` int(16) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date DEFAULT NULL,
  `fk_id_utente` int(16) DEFAULT NULL,
  `fk_id_articolo` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prestiti`
--

INSERT INTO `prestiti` (`id_prestito`, `data_inizio`, `data_fine`, `fk_id_utente`, `fk_id_articolo`) VALUES
(1, '2024-01-14', '2024-01-28', 2, 1),
(3, '2024-03-25', '2024-03-25', 2, 11);

--
-- Trigger `prestiti`
--
DELIMITER $$
CREATE TRIGGER `check_dates` BEFORE UPDATE ON `prestiti` FOR EACH ROW BEGIN
   IF NEW.data_fine < NEW.data_inizio THEN
      SET NEW.data_fine = NEW.data_inizio;
   END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(16) NOT NULL,
  `nome` varchar(32) NOT NULL,
  `cognome` varchar(32) NOT NULL,
  `indirizzo` varchar(64) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `tipo_utente` set('cliente','operatore','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `indirizzo`, `email`, `password`, `tipo_utente`) VALUES
(1, 'fabio', 'pauletta', 'via interna 7, pordenone', '1@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'admin'),
(2, 'federica', 'casiraghi', 'via interna 7, pordenone', '2@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'cliente'),
(5, 'kevin', 'cesco', 'via roma 77, pramaggiore', '3@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'cliente'),
(6, 'riccardo', 'saro', 'via amalteo, nave', '4@gmail.com', '6e6bc4e49dd477ebc98ef4046c067b5f', 'cliente');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `articoli`
--
ALTER TABLE `articoli`
  ADD PRIMARY KEY (`id_articolo`),
  ADD KEY `fk_id_centro` (`fk_id_centro`),
  ADD KEY `fk_id_categoria` (`fk_id_categoria`);

--
-- Indici per le tabelle `articoli_dismessi`
--
ALTER TABLE `articoli_dismessi`
  ADD PRIMARY KEY (`id_articolo2`),
  ADD KEY `fk_id_centro` (`fk_id_centro`),
  ADD KEY `fk_id_categoria` (`fk_id_categoria`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indici per le tabelle `centri`
--
ALTER TABLE `centri`
  ADD PRIMARY KEY (`id_centro`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id_prenotazione`),
  ADD KEY `fk_id_utente` (`fk_id_utente`,`fk_id_articolo`),
  ADD KEY `fk_id_articolo` (`fk_id_articolo`);

--
-- Indici per le tabelle `prestiti`
--
ALTER TABLE `prestiti`
  ADD PRIMARY KEY (`id_prestito`),
  ADD KEY `fk_id_utente` (`fk_id_utente`,`fk_id_articolo`),
  ADD KEY `fk_id_articolo` (`fk_id_articolo`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `articoli`
--
ALTER TABLE `articoli`
  MODIFY `id_articolo` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `articoli_dismessi`
--
ALTER TABLE `articoli_dismessi`
  MODIFY `id_articolo2` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categoria` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `centri`
--
ALTER TABLE `centri`
  MODIFY `id_centro` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `id_prenotazione` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT per la tabella `prestiti`
--
ALTER TABLE `prestiti`
  MODIFY `id_prestito` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `articoli`
--
ALTER TABLE `articoli`
  ADD CONSTRAINT `articoli_ibfk_1` FOREIGN KEY (`fk_id_centro`) REFERENCES `centri` (`id_centro`) ON UPDATE CASCADE,
  ADD CONSTRAINT `articoli_ibfk_2` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categorie` (`id_categoria`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `articoli_dismessi`
--
ALTER TABLE `articoli_dismessi`
  ADD CONSTRAINT `articoli_dismessi_ibfk_1` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categorie` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `articoli_dismessi_ibfk_2` FOREIGN KEY (`fk_id_centro`) REFERENCES `centri` (`id_centro`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`fk_id_utente`) REFERENCES `utenti` (`id_utente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`fk_id_articolo`) REFERENCES `articoli` (`id_articolo`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `prestiti`
--
ALTER TABLE `prestiti`
  ADD CONSTRAINT `prestiti_ibfk_1` FOREIGN KEY (`fk_id_utente`) REFERENCES `utenti` (`id_utente`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
