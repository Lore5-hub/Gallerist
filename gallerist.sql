-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 22, 2026 alle 17:50
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallerist`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `artista`
--

CREATE TABLE `artista` (
  `idUtente` int(11) NOT NULL,
  `biografia` text DEFAULT NULL,
  `stileArtistico` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `id` int(11) NOT NULL,
  `testo` text NOT NULL,
  `valutazione` int(11) DEFAULT NULL,
  `dataPubblicazione` datetime DEFAULT current_timestamp(),
  `idAutore` int(11) NOT NULL,
  `idOpera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine`
--

CREATE TABLE `immagine` (
  `id` int(11) NOT NULL,
  `nome_file` varchar(255) NOT NULL,
  `idOpera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `opera`
--

CREATE TABLE `opera` (
  `id` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `anno` int(11) NOT NULL,
  `dimensioni` varchar(50) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `statoOpera` varchar(50) DEFAULT 'In esposizione',
  `idArtista` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idTecnica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `opera_tag`
--

CREATE TABLE `opera_tag` (
  `idOpera` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `id` int(11) NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `idUtente` int(11) NOT NULL,
  `idOpera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `offerta`
--

CREATE TABLE `offerta` (
  `id`            int(11)        NOT NULL AUTO_INCREMENT,
  `cifraProposta` decimal(10,2)  NOT NULL,
  `nota`          text           DEFAULT NULL,
  `stato`         enum('inviata','accettata','rifiutata') NOT NULL DEFAULT 'inviata',
  `dataOfferta`   datetime       NOT NULL DEFAULT current_timestamp(),
  `idOfferente`   int(11)        NOT NULL,
  `idOpera`       int(11)        NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ------------------------------------------------------
--
-- Struttura della tabella `provvedimento`
--

CREATE TABLE `provvedimento` (
  `id` int(11) NOT NULL,
  `tipoBan` varchar(50) NOT NULL,
  `dataInizio` date NOT NULL,
  `dataFine` date DEFAULT NULL,
  `motivo` text NOT NULL,
  `idUtenteSanzionato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazione`
--

CREATE TABLE `segnalazione` (
  `id` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `dataSegnalazione` date NOT NULL,
  `stato` enum('Aperta','Archiviata','Risolta') DEFAULT 'Aperta',
  `tipoOggetto` enum('Commento','Profilo','Opera') NOT NULL,
  `idOggettoSegnalato` int(11) NOT NULL,
  `idSegnalatore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tecnica`
--

CREATE TABLE `tecnica` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` enum('Utente registrato','Artista','Amministratore') NOT NULL,
  `statoAccount` enum('Attivo','Bannato','In attesa di validazione') DEFAULT 'Attivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`idUtente`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAutore` (`idAutore`),
  ADD KEY `idOpera` (`idOpera`);

--
-- Indici per le tabelle `immagine`
--
ALTER TABLE `immagine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOpera` (`idOpera`);

--
-- Indici per le tabelle `opera`
--
ALTER TABLE `opera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idArtista` (`idArtista`),
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `opera_ibfk_3` (`idTecnica`);

--
-- Indici per le tabelle `opera_tag`
--
ALTER TABLE `opera_tag`
  ADD PRIMARY KEY (`idOpera`,`idTag`),
  ADD KEY `idTag` (`idTag`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtente` (`idUtente`),
  ADD KEY `idOpera` (`idOpera`);

--
-- Indici per le tabelle `provvedimento`
--
ALTER TABLE `provvedimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUtenteSanzionato` (`idUtenteSanzionato`);

--
-- Indici per le tabelle `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSegnalatore` (`idSegnalatore`);

--
-- Indici per le tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `tecnica`
--
ALTER TABLE `tecnica`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `immagine`
--
ALTER TABLE `immagine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `opera`
--
ALTER TABLE `opera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `offerta`
--

ALTER TABLE `offerta`
  ADD CONSTRAINT `offerta_ibfk_1` FOREIGN KEY (`idOfferente`) REFERENCES `utente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offerta_ibfk_2` FOREIGN KEY (`idOpera`)     REFERENCES `opera`  (`id`) ON DELETE CASCADE;


--
-- AUTO_INCREMENT per la tabella `provvedimento`
--
ALTER TABLE `provvedimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tecnica`
--
ALTER TABLE `tecnica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `artista`
--
ALTER TABLE `artista`
  ADD CONSTRAINT `artista_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`idAutore`) REFERENCES `utente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`idOpera`) REFERENCES `opera` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `immagine`
--
ALTER TABLE `immagine`
  ADD CONSTRAINT `immagine_ibfk_1` FOREIGN KEY (`idOpera`) REFERENCES `opera` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `opera`
--
ALTER TABLE `opera`
  ADD CONSTRAINT `opera_ibfk_1` FOREIGN KEY (`idArtista`) REFERENCES `artista` (`idUtente`) ON DELETE CASCADE,
  ADD CONSTRAINT `opera_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `opera_ibfk_3` FOREIGN KEY (`idTecnica`) REFERENCES `tecnica` (`id`);

--
-- Limiti per la tabella `opera_tag`
--
ALTER TABLE `opera_tag`
  ADD CONSTRAINT `operatag_ibfk_1` FOREIGN KEY (`idOpera`) REFERENCES `opera` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `operatag_ibfk_2` FOREIGN KEY (`idTag`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`idUtente`) REFERENCES `utente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`idOpera`) REFERENCES `opera` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `provvedimento`
--
ALTER TABLE `provvedimento`
  ADD CONSTRAINT `provvedimento_ibfk_1` FOREIGN KEY (`idUtenteSanzionato`) REFERENCES `utente` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD CONSTRAINT `segnalazione_ibfk_1` FOREIGN KEY (`idSegnalatore`) REFERENCES `utente` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
