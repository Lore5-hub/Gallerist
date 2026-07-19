-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Lug 17, 2026 alle 22:28
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

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
  `stileArtistico` varchar(100) DEFAULT NULL,
  `carta_identita` varchar(255) DEFAULT NULL,
  `stato_validazione` varchar(50) DEFAULT 'IN_ATTESA',
  `portfolio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `artista`
--

INSERT INTO `artista` (`idUtente`, `biografia`, `stileArtistico`, `carta_identita`, `stato_validazione`, `portfolio`) VALUES
(50, 'Ciao sono Mario, un fotografo! Vorrei far diventare famosi i miei scatti qui.', 'Fotografo', '4501c3e11e12c103f873c6177ae162d1.jpg', 'APPROVATO', 'cf1b4cdda92619da62a14290bb27225f.zip'),
(51, 'Ciao, sono un collezionista e vorrei vendere qualche opera che ho di troppo in casa.', 'Scultura e pittura', '24c1cc5d3cf49a83c7cb40d6b1a82891.jpg', 'APPROVATO', '96b273353bc9d63530c72c5a91e81ace.zip'),
(52, 'Sono un critico d\'arte e voglio avere il profilo da artista.', 'Astrattismo', '409342a781307684898df139cacbb3d4.jpg', 'IN_ATTESA', '2c37a1963cfa1e139658c90f844d9c0b.zip');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `descrizione`) VALUES
(1, 'Pittura', 'Opere pittoriche di vario genere'),
(2, 'Scultura', 'Opere scultoree'),
(3, 'Fotografia', 'Opere fotografiche');

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

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`id`, `testo`, `valutazione`, `dataPubblicazione`, `idAutore`, `idOpera`) VALUES
(1, 'Bella questa!', 5, '2026-07-16 13:03:50', 48, 3),
(2, 'Che bello!!!', 4, '2026-07-16 14:52:32', 51, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine`
--

CREATE TABLE `immagine` (
  `id` int(11) NOT NULL,
  `nome_file` varchar(255) NOT NULL,
  `idOpera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `immagine`
--

INSERT INTO `immagine` (`id`, `nome_file`, `idOpera`) VALUES
(1, 'c806a3c1b76e8c8858859de4503c519c.jpg', 1),
(2, '0d353fc9159dc56ac434d69ee16a4d4c.jpg', 2),
(3, 'bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', 3),
(9, 'dd4deede48d9bbafedf25897cf65f6a0.jpg', 6),
(10, '6b233483d3f07cbb5a0753073a97a97d.jpeg', 6),
(11, 'c3f40124a8cebe51d5ec56ab4a77e437.jpeg', 7),
(12, '8352fe80ac2bdb870331c63c3686f6e9.jpg', 7),
(13, '3c17282cdaefb9d360cdf8b57cbb2a1a.jpg', 7),
(14, '36bfaf8371613fc3db56977ed9b26bbd.jpg', 8),
(17, '23ce175bb41809411a03f7192d326928.jpg', 10),
(18, 'ee03e028e66b73c97bb2f37ec898eca0.jpg', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `offerta`
--

CREATE TABLE `offerta` (
  `id` int(11) NOT NULL,
  `cifraProposta` decimal(10,2) NOT NULL,
  `nota` text DEFAULT NULL,
  `stato` enum('inviata','accettata','rifiutata') NOT NULL DEFAULT 'inviata',
  `dataOfferta` datetime NOT NULL DEFAULT current_timestamp(),
  `idOfferente` int(11) NOT NULL,
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
  `idTecnica` int(11) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `tecnica` varchar(100) DEFAULT NULL,
  `stato` varchar(50) DEFAULT 'pubblicata',
  `larghezza` decimal(10,2) DEFAULT NULL,
  `altezza` decimal(10,2) DEFAULT NULL,
  `profondita` decimal(10,2) DEFAULT NULL,
  `unitaMisura` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `opera`
--

INSERT INTO `opera` (`id`, `titolo`, `anno`, `dimensioni`, `descrizione`, `prezzo`, `statoOpera`, `idArtista`, `idCategoria`, `idTecnica`, `categoria`, `tecnica`, `stato`, `larghezza`, `altezza`, `profondita`, `unitaMisura`) VALUES
(1, 'London', 2024, '50x30 cm', 'Foto nel traffico quotidiano di Londra', 0.00, 'In esposizione', 50, 3, 4, 'Fotografia', 'Fotografia digitale', 'pubblicata', 50.00, 30.00, 1.00, 'cm'),
(2, 'Ripartenza malinconica', 2024, '60x30 cm', 'Aereo di ritorno da un viaggio con un malinconico tramonto', 0.00, 'In esposizione', 50, 3, 4, 'Fotografia', 'Fotografia digitale', 'pubblicata', 60.00, 30.00, 1.00, 'cm'),
(3, 'London city', 2024, '45x35 cm', 'Foto urbana di Londra sulle sponde del Tamigi', 0.00, 'In esposizione', 50, 3, 17, 'Fotografia', 'Fotografia di paesaggio', 'pubblicata', 45.00, 35.00, 1.00, 'cm'),
(6, 'Gioconda', 1503, '53x77 cm', 'Opera di Leonardo Da Vinci storica e importante', 700.00, 'In esposizione', 51, 1, 1, 'Pittura', 'Olio su tela', 'Venduta', 53.00, 77.00, 3.00, 'cm'),
(7, 'Musei vaticani', 2025, '60x30 cm', 'Foto dei Musei Vaticani e le sue opere', 0.00, 'In esposizione', 50, 3, 4, 'Fotografia', 'Fotografia digitale', 'pubblicata', 60.00, 30.00, 1.00, 'cm'),
(8, 'Colazione sull\'erba', 1862, '264x208 cm', 'Opera di Manet tanto famosa', 2000.00, 'In esposizione', 51, 1, 1, 'Pittura', 'Olio su tela', 'in_vendita', 264.00, 208.00, 1.00, 'cm'),
(10, 'Pietà', 1500, '120x180 cm', 'Scultura storica di Michelangelo', 4000.00, 'In esposizione', 51, 2, 5, 'Scultura', 'Scultura in marmo', 'in_vendita', 120.00, 180.00, 90.00, 'cm');

-- --------------------------------------------------------

--
-- Struttura della tabella `opera_tag`
--

CREATE TABLE `opera_tag` (
  `idOpera` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `opera_tag`
--

INSERT INTO `opera_tag` (`idOpera`, `idTag`) VALUES
(1, 3),
(6, 4),
(8, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `id` int(11) NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `idUtente` int(11) NOT NULL,
  `idOpera` int(11) DEFAULT NULL,
  `tipo` enum('diretto','offerta') NOT NULL DEFAULT 'diretto',
  `indirizzo_spedizione` varchar(255) DEFAULT NULL,
  `metodo_pagamento` varchar(50) DEFAULT NULL,
  `totale_articolo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commissione_piattaforma` decimal(10,2) NOT NULL DEFAULT 0.00,
  `titolo_opera_snapshot` varchar(255) DEFAULT NULL,
  `id_artista_snapshot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`id`, `data`, `idUtente`, `idOpera`, `tipo`, `indirizzo_spedizione`, `metodo_pagamento`, `totale_articolo`, `commissione_piattaforma`, `titolo_opera_snapshot`, `id_artista_snapshot`) VALUES
(1, '2026-07-16 22:15:13', 48, 6, 'diretto', 'Via Roma 26', 'carta', 0.00, 0.00, NULL, NULL),
(3, '2026-07-17 12:07:16', 48, NULL, 'diretto', 'Via Roma 26', 'carta', 5000.00, 500.00, 'Pietà', 51);

-- --------------------------------------------------------

--
-- Struttura della tabella `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `scadenza` datetime NOT NULL,
  `usato` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `token`, `scadenza`, `usato`) VALUES
(1, 'silviomarrone@gmail.com', '7641dcf3afcd444754c906f649e942a71e1728852e5ad2cb75bcf91876abbfa8', '2026-07-16 23:27:02', 1);

-- --------------------------------------------------------

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

--
-- Dump dei dati per la tabella `provvedimento`
--

INSERT INTO `provvedimento` (`id`, `tipoBan`, `dataInizio`, `dataFine`, `motivo`, `idUtenteSanzionato`) VALUES
(1, 'permanente', '2026-07-16', NULL, 'Sei stato inappropriato.', 53);

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

--
-- Dump dei dati per la tabella `segnalazione`
--

INSERT INTO `segnalazione` (`id`, `motivo`, `descrizione`, `dataSegnalazione`, `stato`, `tipoOggetto`, `idOggettoSegnalato`, `idSegnalatore`) VALUES
(1, 'Contenuto che non mi piace', '', '2026-07-16', 'Archiviata', 'Opera', 1, 48),
(2, 'Non mi piace quello che sto vedendo', '', '2026-07-16', 'Aperta', 'Opera', 2, 48),
(3, 'Commento inappropriato segnalato dall\'utente', '', '2026-07-16', 'Aperta', 'Commento', 2, 48),
(4, 'Commento inappropriato segnalato dall\'utente', '', '2026-07-16', 'Archiviata', 'Commento', 3, 48);

-- --------------------------------------------------------

--
-- Struttura della tabella `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tag`
--

INSERT INTO `tag` (`id`, `nome`) VALUES
(2, 'Paesaggio'),
(3, 'Paesaggio Urbano'),
(4, 'Ritratto'),
(1, 'sjhxwhj');

-- --------------------------------------------------------

--
-- Struttura della tabella `tecnica`
--

CREATE TABLE `tecnica` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tecnica`
--

INSERT INTO `tecnica` (`id`, `nome`) VALUES
(1, 'Olio su tela'),
(2, 'Acquerello'),
(3, 'Matita'),
(4, 'Fotografia digitale'),
(5, 'Scultura in marmo'),
(6, 'Scultura in bronzo'),
(7, 'Scultura in legno'),
(8, 'Terracotta'),
(9, 'Ceramica'),
(10, 'Scultura in pietra'),
(11, 'Scultura in metallo'),
(12, 'Modellato in argilla'),
(13, 'Intaglio'),
(14, 'Fotografia analogica (pellicola)'),
(15, 'Fotografia in bianco e nero'),
(16, 'Fotografia di ritratto'),
(17, 'Fotografia di paesaggio'),
(18, 'Fotomontaggio / collage fotografico'),
(19, 'Polaroid');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `data_nascita` date NOT NULL,
  `indirizzo` varchar(255) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `immagine_profilo` varchar(255) DEFAULT NULL,
  `stato_account` varchar(50) NOT NULL,
  `ruolo` varchar(50) NOT NULL,
  `data_registrazione` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `data_nascita`, `indirizzo`, `nickname`, `telefono`, `email`, `password`, `immagine_profilo`, `stato_account`, `ruolo`, `data_registrazione`) VALUES
(22, 'Admin', 'Gallerist', '1990-01-01', 'Via Admin 1, Roma', 'admin', '+39 0000000000', 'admin@gallerist.it', '$2y$10$T4DkrsqDn6BqnaK/UFn/IuOUmEx4vwebvTBFA3GBpy5xzUjmwKeaq', NULL, 'attivo', 'Amministratore', '2026-07-05 23:01:40'),
(48, 'Lorenzo', 'Di Zio', '2005-02-26', 'Via Roma 26', 'lordiz', '+39 3331773344', 'lorenzodizio@gmail.com', '$2y$10$9ZeWvKPPMSa.yc71mS9BXu1zaMrljOpzbb8IJAarZAEblHitvnQla', '/uploads/profilo/6620fc67ef6eb7ad951e29714f49e0f7.jpeg', 'attivo', 'Utente registrato', '2026-07-15 12:28:55'),
(50, 'Mario', 'Rossi', '2002-09-30', 'Via Napoleone 12', 'mariored', '+39 3331116768', 'mariorossi@gmail.com', '$2y$10$a1T0fPAyb56sa0zr0XLxVupcCEGYOs7lrdgkds60suAJX3lTERsva', '/uploads/profilo/a9c8fdd8f1f8ad4dc93f8175df28b852.jpeg', 'attivo', 'Artista', '2026-07-16 12:49:54'),
(51, 'Alberto', 'Angela', '1992-08-20', 'Via Padova 71', 'AlbAng', '+39 3234447123', 'albertoangela@gmail.com', '$2y$10$ZT3y80Y2/Rmnl5NHaHURY.8iudMviPaCK6Lj2BdmZE7zMydjWSLDu', '/uploads/profilo/8d77e38bedd5931699cceaf7b8ad86fd.jpg', 'attivo', 'Artista', '2026-07-16 14:47:50'),
(52, 'Vittorio', 'Sgarbi', '1984-04-03', 'Via Strinella 30', 'VittoSG', '+39 3331118989', 'vittoriosgarbi@gmail.com', '$2y$10$ZQwClHcjuJIjF8bCwAEquuI3aGTkZ1wXbn7WkOrskMrsVU4QXEQxS', '/uploads/profilo/cdac7d098e125c5811645a93e1f05726.jpg', 'attivo', 'Artista', '2026-07-16 15:24:05'),
(53, 'Silvio', 'Marrone', '1957-05-02', 'Via Fernando XX 12', 'silviobrown', '+39 3332229890', 'silviomarrone@gmail.com', '$2y$10$zhNIMRvcT.C43co4JQvCkeTOtvFj./w6Ax/oSK30MBLoMh4gbro82', NULL, 'Bannato', 'Utente registrato', '2026-07-16 22:26:12');

-- --------------------------------------------------------

--
-- Struttura della tabella `visita`
--

CREATE TABLE `visita` (
  `id` int(11) NOT NULL,
  `pagina` varchar(255) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `sessione` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `visita`
--

INSERT INTO `visita` (`id`, `pagina`, `data`, `sessione`) VALUES
(1, '/utente/login', '2026-07-15 12:25:31', 'o02ddtnbk4c1mh76605pp863lb'),
(2, '/Utente/verifica', '2026-07-15 12:26:03', 'o02ddtnbk4c1mh76605pp863lb'),
(3, '/Admin/dashboard', '2026-07-15 12:26:03', 'o02ddtnbk4c1mh76605pp863lb'),
(4, '/', '2026-07-15 12:27:56', 'o02ddtnbk4c1mh76605pp863lb'),
(5, '/Admin/dashboard', '2026-07-15 12:27:59', 'o02ddtnbk4c1mh76605pp863lb'),
(6, '/utente/logout', '2026-07-15 12:28:03', 'o02ddtnbk4c1mh76605pp863lb'),
(7, '/utente/login', '2026-07-15 12:28:03', 'o02ddtnbk4c1mh76605pp863lb'),
(8, '/utente/registrazione', '2026-07-15 12:28:06', 'o02ddtnbk4c1mh76605pp863lb'),
(9, '/utente/verificaRegistrazione', '2026-07-15 12:28:54', 'o02ddtnbk4c1mh76605pp863lb'),
(10, '/utente/login', '2026-07-15 12:28:59', 'o02ddtnbk4c1mh76605pp863lb'),
(11, '/Utente/verifica', '2026-07-15 12:29:09', 'o02ddtnbk4c1mh76605pp863lb'),
(12, '/catalogo/esploraCatalogo', '2026-07-15 12:29:09', 'o02ddtnbk4c1mh76605pp863lb'),
(13, '/', '2026-07-15 12:29:17', 'o02ddtnbk4c1mh76605pp863lb'),
(14, '/utente/logout', '2026-07-15 12:30:06', 'o02ddtnbk4c1mh76605pp863lb'),
(15, '/utente/login', '2026-07-15 12:30:06', 'o02ddtnbk4c1mh76605pp863lb'),
(16, '/utente/registrazione', '2026-07-15 12:30:07', 'o02ddtnbk4c1mh76605pp863lb'),
(17, '/utente/verificaRegistrazione', '2026-07-15 12:44:35', 'o02ddtnbk4c1mh76605pp863lb'),
(18, '/utente/login', '2026-07-16 12:42:07', 'o02ddtnbk4c1mh76605pp863lb'),
(19, '/Utente/verifica', '2026-07-16 12:42:19', 'o02ddtnbk4c1mh76605pp863lb'),
(20, '/catalogo/esploraCatalogo', '2026-07-16 12:42:19', 'o02ddtnbk4c1mh76605pp863lb'),
(21, '/utente/profilo', '2026-07-16 12:42:22', 'o02ddtnbk4c1mh76605pp863lb'),
(22, '/utente/profilo', '2026-07-16 12:42:34', 'o02ddtnbk4c1mh76605pp863lb'),
(23, '/utente/logout', '2026-07-16 12:48:16', 'o02ddtnbk4c1mh76605pp863lb'),
(24, '/utente/login', '2026-07-16 12:48:16', 'o02ddtnbk4c1mh76605pp863lb'),
(25, '/utente/registrazione', '2026-07-16 12:48:19', 'o02ddtnbk4c1mh76605pp863lb'),
(26, '/utente/verificaRegistrazione', '2026-07-16 12:49:53', 'o02ddtnbk4c1mh76605pp863lb'),
(27, '/utente/login', '2026-07-16 12:49:59', 'o02ddtnbk4c1mh76605pp863lb'),
(28, '/Utente/verifica', '2026-07-16 12:50:13', 'o02ddtnbk4c1mh76605pp863lb'),
(29, '/utente/login', '2026-07-16 12:51:09', 'o02ddtnbk4c1mh76605pp863lb'),
(30, '/Utente/verifica', '2026-07-16 12:51:33', 'o02ddtnbk4c1mh76605pp863lb'),
(31, '/Admin/dashboard', '2026-07-16 12:51:33', 'o02ddtnbk4c1mh76605pp863lb'),
(32, '/Admin/mostraValidazione', '2026-07-16 12:51:37', 'o02ddtnbk4c1mh76605pp863lb'),
(33, '/Admin/verificaArtista', '2026-07-16 12:52:34', 'o02ddtnbk4c1mh76605pp863lb'),
(34, '/Admin/dashboard', '2026-07-16 12:52:38', 'o02ddtnbk4c1mh76605pp863lb'),
(35, '/utente/logout', '2026-07-16 12:52:43', 'o02ddtnbk4c1mh76605pp863lb'),
(36, '/utente/login', '2026-07-16 12:52:43', 'o02ddtnbk4c1mh76605pp863lb'),
(37, '/Utente/verifica', '2026-07-16 12:52:51', 'o02ddtnbk4c1mh76605pp863lb'),
(38, '/catalogo/esploraCatalogo', '2026-07-16 12:52:51', 'o02ddtnbk4c1mh76605pp863lb'),
(39, '/utente/profilo', '2026-07-16 12:53:06', 'o02ddtnbk4c1mh76605pp863lb'),
(40, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 12:53:17', 'o02ddtnbk4c1mh76605pp863lb'),
(41, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 12:55:25', 'o02ddtnbk4c1mh76605pp863lb'),
(42, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 12:56:44', 'o02ddtnbk4c1mh76605pp863lb'),
(43, '/utente/profilo', '2026-07-16 12:56:44', 'o02ddtnbk4c1mh76605pp863lb'),
(44, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 12:56:49', 'o02ddtnbk4c1mh76605pp863lb'),
(45, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 12:58:40', 'o02ddtnbk4c1mh76605pp863lb'),
(46, '/utente/profilo', '2026-07-16 12:58:40', 'o02ddtnbk4c1mh76605pp863lb'),
(47, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 12:58:44', 'o02ddtnbk4c1mh76605pp863lb'),
(48, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 13:00:19', 'o02ddtnbk4c1mh76605pp863lb'),
(49, '/utente/profilo', '2026-07-16 13:00:19', 'o02ddtnbk4c1mh76605pp863lb'),
(50, '/catalogo/esploraCatalogo', '2026-07-16 13:00:28', 'o02ddtnbk4c1mh76605pp863lb'),
(51, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 13:00:32', 'o02ddtnbk4c1mh76605pp863lb'),
(52, '/catalogo/esploraCatalogo', '2026-07-16 13:00:45', 'o02ddtnbk4c1mh76605pp863lb'),
(53, '/catalogo/visualizzaDettagliOpera/2', '2026-07-16 13:00:49', 'o02ddtnbk4c1mh76605pp863lb'),
(54, '/catalogo/esploraCatalogo', '2026-07-16 13:00:50', 'o02ddtnbk4c1mh76605pp863lb'),
(55, '/catalogo/visualizzaDettagliOpera/1', '2026-07-16 13:00:53', 'o02ddtnbk4c1mh76605pp863lb'),
(56, '/catalogo/esploraCatalogo', '2026-07-16 13:00:54', 'o02ddtnbk4c1mh76605pp863lb'),
(57, '/', '2026-07-16 13:00:56', 'o02ddtnbk4c1mh76605pp863lb'),
(58, '/catalogo/filtraCatalogo', '2026-07-16 13:00:59', 'o02ddtnbk4c1mh76605pp863lb'),
(59, '/', '2026-07-16 13:01:01', 'o02ddtnbk4c1mh76605pp863lb'),
(60, '/catalogo/filtraCatalogo', '2026-07-16 13:01:04', 'o02ddtnbk4c1mh76605pp863lb'),
(61, '/', '2026-07-16 13:01:06', 'o02ddtnbk4c1mh76605pp863lb'),
(62, '/catalogo/filtraCatalogo', '2026-07-16 13:01:12', 'o02ddtnbk4c1mh76605pp863lb'),
(63, '/', '2026-07-16 13:01:13', 'o02ddtnbk4c1mh76605pp863lb'),
(64, '/catalogo/filtraCatalogo', '2026-07-16 13:01:20', 'o02ddtnbk4c1mh76605pp863lb'),
(65, '/', '2026-07-16 13:01:24', 'o02ddtnbk4c1mh76605pp863lb'),
(66, '/catalogo/esploraCatalogo', '2026-07-16 13:02:13', 'o02ddtnbk4c1mh76605pp863lb'),
(67, '/', '2026-07-16 13:02:17', 'o02ddtnbk4c1mh76605pp863lb'),
(68, '/catalogo/filtraCatalogo', '2026-07-16 13:02:22', 'o02ddtnbk4c1mh76605pp863lb'),
(69, '/catalogo/esploraCatalogo', '2026-07-16 13:02:24', 'o02ddtnbk4c1mh76605pp863lb'),
(70, '/', '2026-07-16 13:02:25', 'o02ddtnbk4c1mh76605pp863lb'),
(71, '/catalogo/filtraCatalogo', '2026-07-16 13:02:29', 'o02ddtnbk4c1mh76605pp863lb'),
(72, '/', '2026-07-16 13:02:31', 'o02ddtnbk4c1mh76605pp863lb'),
(73, '/catalogo/esploraCatalogo', '2026-07-16 13:02:31', 'o02ddtnbk4c1mh76605pp863lb'),
(74, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 13:02:33', 'o02ddtnbk4c1mh76605pp863lb'),
(75, '/catalogo/visualizzaProfiloArtista/50', '2026-07-16 13:02:36', 'o02ddtnbk4c1mh76605pp863lb'),
(76, '/utente/profilo', '2026-07-16 13:02:36', 'o02ddtnbk4c1mh76605pp863lb'),
(77, '/', '2026-07-16 13:02:37', 'o02ddtnbk4c1mh76605pp863lb'),
(78, '/utente/profilo', '2026-07-16 13:03:03', 'o02ddtnbk4c1mh76605pp863lb'),
(79, '/utente/logout', '2026-07-16 13:03:08', 'o02ddtnbk4c1mh76605pp863lb'),
(80, '/utente/login', '2026-07-16 13:03:08', 'o02ddtnbk4c1mh76605pp863lb'),
(81, '/Utente/verifica', '2026-07-16 13:03:36', 'o02ddtnbk4c1mh76605pp863lb'),
(82, '/catalogo/esploraCatalogo', '2026-07-16 13:03:36', 'o02ddtnbk4c1mh76605pp863lb'),
(83, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 13:03:38', 'o02ddtnbk4c1mh76605pp863lb'),
(84, '/gestioneInterazioni/salvaRecensione', '2026-07-16 13:03:50', 'o02ddtnbk4c1mh76605pp863lb'),
(85, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 13:03:50', 'o02ddtnbk4c1mh76605pp863lb'),
(86, '/catalogo/esploraCatalogo', '2026-07-16 13:04:02', 'o02ddtnbk4c1mh76605pp863lb'),
(87, '/catalogo/visualizzaDettagliOpera/1', '2026-07-16 13:04:09', 'o02ddtnbk4c1mh76605pp863lb'),
(88, '/gestioneInterazioni/inviaSegnalazione', '2026-07-16 13:04:18', 'o02ddtnbk4c1mh76605pp863lb'),
(89, '/catalogo/visualizzaDettagliOpera/1', '2026-07-16 13:04:18', 'o02ddtnbk4c1mh76605pp863lb'),
(90, '/utente/logout', '2026-07-16 13:04:21', 'o02ddtnbk4c1mh76605pp863lb'),
(91, '/utente/login', '2026-07-16 13:04:21', 'o02ddtnbk4c1mh76605pp863lb'),
(92, '/Utente/verifica', '2026-07-16 13:04:29', 'o02ddtnbk4c1mh76605pp863lb'),
(93, '/Admin/dashboard', '2026-07-16 13:04:29', 'o02ddtnbk4c1mh76605pp863lb'),
(94, '/Admin/mostraSegnalazione', '2026-07-16 13:04:44', 'o02ddtnbk4c1mh76605pp863lb'),
(95, '/Admin/dashboard', '2026-07-16 13:05:01', 'o02ddtnbk4c1mh76605pp863lb'),
(96, '/utente/login', '2026-07-16 14:39:34', 'o02ddtnbk4c1mh76605pp863lb'),
(97, '/Utente/verifica', '2026-07-16 14:39:48', 'o02ddtnbk4c1mh76605pp863lb'),
(98, '/Admin/dashboard', '2026-07-16 14:39:49', 'o02ddtnbk4c1mh76605pp863lb'),
(99, '/Admin/mostraSegnalazione', '2026-07-16 14:39:52', 'o02ddtnbk4c1mh76605pp863lb'),
(100, '/Admin/processaModerazione', '2026-07-16 14:39:58', 'o02ddtnbk4c1mh76605pp863lb'),
(101, '/Admin/dashboard', '2026-07-16 14:39:58', 'o02ddtnbk4c1mh76605pp863lb'),
(102, '/utente/logout', '2026-07-16 14:40:10', 'o02ddtnbk4c1mh76605pp863lb'),
(103, '/utente/login', '2026-07-16 14:40:10', 'o02ddtnbk4c1mh76605pp863lb'),
(104, '/Utente/verifica', '2026-07-16 14:40:23', 'o02ddtnbk4c1mh76605pp863lb'),
(105, '/catalogo/esploraCatalogo', '2026-07-16 14:40:23', 'o02ddtnbk4c1mh76605pp863lb'),
(106, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 14:40:25', 'o02ddtnbk4c1mh76605pp863lb'),
(107, '/catalogo/visualizzaDettagliOpera/2', '2026-07-16 14:40:33', 'o02ddtnbk4c1mh76605pp863lb'),
(108, '/gestioneInterazioni/inviaSegnalazione', '2026-07-16 14:40:48', 'o02ddtnbk4c1mh76605pp863lb'),
(109, '/catalogo/visualizzaDettagliOpera/2', '2026-07-16 14:40:48', 'o02ddtnbk4c1mh76605pp863lb'),
(110, '/', '2026-07-16 14:40:51', 'o02ddtnbk4c1mh76605pp863lb'),
(111, '/', '2026-07-16 14:42:45', 'o02ddtnbk4c1mh76605pp863lb'),
(112, '/', '2026-07-16 14:42:52', 'o02ddtnbk4c1mh76605pp863lb'),
(113, '/', '2026-07-16 14:42:55', 'o02ddtnbk4c1mh76605pp863lb'),
(114, '/catalogo/filtraCatalogo', '2026-07-16 14:43:07', 'o02ddtnbk4c1mh76605pp863lb'),
(115, '/', '2026-07-16 14:43:08', 'o02ddtnbk4c1mh76605pp863lb'),
(116, '/utente/logout', '2026-07-16 14:43:53', 'o02ddtnbk4c1mh76605pp863lb'),
(117, '/utente/login', '2026-07-16 14:43:53', 'o02ddtnbk4c1mh76605pp863lb'),
(118, '/utente/registrazione', '2026-07-16 14:43:56', 'o02ddtnbk4c1mh76605pp863lb'),
(119, '/utente/verificaRegistrazione', '2026-07-16 14:47:49', 'o02ddtnbk4c1mh76605pp863lb'),
(120, '/', '2026-07-16 14:48:00', 'o02ddtnbk4c1mh76605pp863lb'),
(121, '/', '2026-07-16 14:49:56', 'o02ddtnbk4c1mh76605pp863lb'),
(122, '/utente/login', '2026-07-16 14:50:03', 'o02ddtnbk4c1mh76605pp863lb'),
(123, '/Utente/verifica', '2026-07-16 14:50:18', 'o02ddtnbk4c1mh76605pp863lb'),
(124, '/Admin/dashboard', '2026-07-16 14:50:18', 'o02ddtnbk4c1mh76605pp863lb'),
(125, '/Admin/mostraValidazione', '2026-07-16 14:51:45', 'o02ddtnbk4c1mh76605pp863lb'),
(126, '/Admin/verificaArtista', '2026-07-16 14:51:50', 'o02ddtnbk4c1mh76605pp863lb'),
(127, '/Admin/dashboard', '2026-07-16 14:51:52', 'o02ddtnbk4c1mh76605pp863lb'),
(128, '/utente/login', '2026-07-16 14:51:58', 'o02ddtnbk4c1mh76605pp863lb'),
(129, '/Utente/verifica', '2026-07-16 14:52:13', 'o02ddtnbk4c1mh76605pp863lb'),
(130, '/catalogo/esploraCatalogo', '2026-07-16 14:52:13', 'o02ddtnbk4c1mh76605pp863lb'),
(131, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 14:52:19', 'o02ddtnbk4c1mh76605pp863lb'),
(132, '/catalogo/esploraCatalogo', '2026-07-16 14:52:20', 'o02ddtnbk4c1mh76605pp863lb'),
(133, '/catalogo/visualizzaDettagliOpera/2', '2026-07-16 14:52:22', 'o02ddtnbk4c1mh76605pp863lb'),
(134, '/gestioneInterazioni/salvaRecensione', '2026-07-16 14:52:32', 'o02ddtnbk4c1mh76605pp863lb'),
(135, '/catalogo/visualizzaDettagliOpera/2', '2026-07-16 14:52:32', 'o02ddtnbk4c1mh76605pp863lb'),
(136, '/catalogo/visualizzaProfiloArtista/51', '2026-07-16 14:52:35', 'o02ddtnbk4c1mh76605pp863lb'),
(137, '/utente/profilo', '2026-07-16 14:52:35', 'o02ddtnbk4c1mh76605pp863lb'),
(138, '/', '2026-07-16 14:52:51', 'o02ddtnbk4c1mh76605pp863lb'),
(139, '/utente/profilo', '2026-07-16 14:52:54', 'o02ddtnbk4c1mh76605pp863lb'),
(140, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 14:54:15', 'o02ddtnbk4c1mh76605pp863lb'),
(141, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 14:54:31', 'o02ddtnbk4c1mh76605pp863lb'),
(142, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 14:55:08', 'o02ddtnbk4c1mh76605pp863lb'),
(143, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 14:55:36', 'o02ddtnbk4c1mh76605pp863lb'),
(144, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 14:55:48', 'o02ddtnbk4c1mh76605pp863lb'),
(145, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 15:02:49', 'o02ddtnbk4c1mh76605pp863lb'),
(146, '/utente/profilo', '2026-07-16 15:02:49', 'o02ddtnbk4c1mh76605pp863lb'),
(147, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:04:42', 'o02ddtnbk4c1mh76605pp863lb'),
(148, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:05:04', 'o02ddtnbk4c1mh76605pp863lb'),
(149, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:05:14', 'o02ddtnbk4c1mh76605pp863lb'),
(150, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:05:24', 'o02ddtnbk4c1mh76605pp863lb'),
(151, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:05:36', 'o02ddtnbk4c1mh76605pp863lb'),
(152, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:13:24', 'o02ddtnbk4c1mh76605pp863lb'),
(153, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:14:03', 'o02ddtnbk4c1mh76605pp863lb'),
(154, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 15:16:20', 'o02ddtnbk4c1mh76605pp863lb'),
(155, '/utente/profilo', '2026-07-16 15:16:20', 'o02ddtnbk4c1mh76605pp863lb'),
(156, '/', '2026-07-16 15:16:31', 'o02ddtnbk4c1mh76605pp863lb'),
(157, '/catalogo/esploraCatalogo', '2026-07-16 15:16:32', 'o02ddtnbk4c1mh76605pp863lb'),
(158, '/utente/logout', '2026-07-16 15:16:40', 'o02ddtnbk4c1mh76605pp863lb'),
(159, '/utente/login', '2026-07-16 15:16:40', 'o02ddtnbk4c1mh76605pp863lb'),
(160, '/Utente/verifica', '2026-07-16 15:16:51', 'o02ddtnbk4c1mh76605pp863lb'),
(161, '/catalogo/esploraCatalogo', '2026-07-16 15:16:51', 'o02ddtnbk4c1mh76605pp863lb'),
(162, '/catalogo/visualizzaDettagliOpera/4', '2026-07-16 15:16:54', 'o02ddtnbk4c1mh76605pp863lb'),
(163, '/catalogo/visualizzaDettagliOpera/4', '2026-07-16 15:17:08', 'o02ddtnbk4c1mh76605pp863lb'),
(164, '/catalogo/visualizzaDettagliOpera/4', '2026-07-16 15:17:10', 'o02ddtnbk4c1mh76605pp863lb'),
(165, '/catalogo/visualizzaDettagliOpera/4', '2026-07-16 15:17:18', 'o02ddtnbk4c1mh76605pp863lb'),
(166, '/compravendita/avviaPropostaOfferta/4', '2026-07-16 15:17:44', 'o02ddtnbk4c1mh76605pp863lb'),
(167, '/catalogo/visualizzaDettagliOpera/4', '2026-07-16 15:17:47', 'o02ddtnbk4c1mh76605pp863lb'),
(168, '/utente/logout', '2026-07-16 15:17:50', 'o02ddtnbk4c1mh76605pp863lb'),
(169, '/utente/login', '2026-07-16 15:17:50', 'o02ddtnbk4c1mh76605pp863lb'),
(170, '/Utente/verifica', '2026-07-16 15:18:03', 'o02ddtnbk4c1mh76605pp863lb'),
(171, '/catalogo/esploraCatalogo', '2026-07-16 15:18:03', 'o02ddtnbk4c1mh76605pp863lb'),
(172, '/utente/profilo', '2026-07-16 15:18:06', 'o02ddtnbk4c1mh76605pp863lb'),
(173, '/utente/cambiaFotoProfilo', '2026-07-16 15:18:15', 'o02ddtnbk4c1mh76605pp863lb'),
(174, '/utente/profilo', '2026-07-16 15:18:15', 'o02ddtnbk4c1mh76605pp863lb'),
(175, '/utente/logout', '2026-07-16 15:18:19', 'o02ddtnbk4c1mh76605pp863lb'),
(176, '/utente/login', '2026-07-16 15:18:19', 'o02ddtnbk4c1mh76605pp863lb'),
(177, '/Utente/verifica', '2026-07-16 15:18:33', 'o02ddtnbk4c1mh76605pp863lb'),
(178, '/catalogo/esploraCatalogo', '2026-07-16 15:18:33', 'o02ddtnbk4c1mh76605pp863lb'),
(179, '/utente/profilo', '2026-07-16 15:18:41', 'o02ddtnbk4c1mh76605pp863lb'),
(180, '/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-16 15:18:57', 'o02ddtnbk4c1mh76605pp863lb'),
(181, '/utente/profilo', '2026-07-16 15:18:59', 'o02ddtnbk4c1mh76605pp863lb'),
(182, '/utente/logout', '2026-07-16 15:20:40', 'o02ddtnbk4c1mh76605pp863lb'),
(183, '/utente/login', '2026-07-16 15:20:40', 'o02ddtnbk4c1mh76605pp863lb'),
(184, '/utente/registrazione', '2026-07-16 15:20:42', 'o02ddtnbk4c1mh76605pp863lb'),
(185, '/utente/verificaRegistrazione', '2026-07-16 15:24:05', 'o02ddtnbk4c1mh76605pp863lb'),
(186, '/Admin/dashboard', '2026-07-16 15:25:05', 'o02ddtnbk4c1mh76605pp863lb'),
(187, '/Utente/login', '2026-07-16 15:25:05', 'o02ddtnbk4c1mh76605pp863lb'),
(188, '/Utente/verifica', '2026-07-16 15:25:22', 'o02ddtnbk4c1mh76605pp863lb'),
(189, '/Utente/verifica', '2026-07-16 15:25:37', 'o02ddtnbk4c1mh76605pp863lb'),
(190, '/Utente/verifica', '2026-07-16 15:25:47', 'o02ddtnbk4c1mh76605pp863lb'),
(191, '/Admin/dashboard', '2026-07-16 15:25:47', 'o02ddtnbk4c1mh76605pp863lb'),
(192, '/Admin/mostraValidazione', '2026-07-16 15:25:51', 'o02ddtnbk4c1mh76605pp863lb'),
(193, '/Admin/dashboard', '2026-07-16 15:25:59', 'o02ddtnbk4c1mh76605pp863lb'),
(194, '/utente/login', '2026-07-16 15:26:11', 'o02ddtnbk4c1mh76605pp863lb'),
(195, '/Utente/verifica', '2026-07-16 15:26:21', 'o02ddtnbk4c1mh76605pp863lb'),
(196, '/catalogo/esploraCatalogo', '2026-07-16 15:26:21', 'o02ddtnbk4c1mh76605pp863lb'),
(197, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 15:26:25', 'o02ddtnbk4c1mh76605pp863lb'),
(198, '/catalogo/visualizzaDettagliOpera/2', '2026-07-16 15:26:42', 'o02ddtnbk4c1mh76605pp863lb'),
(199, '/gestioneInterazioni/inviaSegnalazione', '2026-07-16 15:26:47', 'o02ddtnbk4c1mh76605pp863lb'),
(200, '/catalogo/esploraCatalogo', '2026-07-16 15:26:47', 'o02ddtnbk4c1mh76605pp863lb'),
(201, '/Admin/dashboard', '2026-07-16 15:27:28', 'o02ddtnbk4c1mh76605pp863lb'),
(202, '/Utente/login', '2026-07-16 15:27:28', 'o02ddtnbk4c1mh76605pp863lb'),
(203, '/Utente/verifica', '2026-07-16 15:27:45', 'o02ddtnbk4c1mh76605pp863lb'),
(204, '/Admin/dashboard', '2026-07-16 15:27:45', 'o02ddtnbk4c1mh76605pp863lb'),
(205, '/catalogo/esploraCatalogo', '2026-07-16 15:27:50', 'o02ddtnbk4c1mh76605pp863lb'),
(206, '/', '2026-07-16 15:27:57', 'o02ddtnbk4c1mh76605pp863lb'),
(207, '/catalogo/esploraCatalogo', '2026-07-16 15:27:58', 'o02ddtnbk4c1mh76605pp863lb'),
(208, '/utente/logout', '2026-07-16 15:28:17', 'o02ddtnbk4c1mh76605pp863lb'),
(209, '/utente/login', '2026-07-16 15:28:17', 'o02ddtnbk4c1mh76605pp863lb'),
(210, '/Utente/verifica', '2026-07-16 15:28:30', 'o02ddtnbk4c1mh76605pp863lb'),
(211, '/catalogo/esploraCatalogo', '2026-07-16 15:28:31', 'o02ddtnbk4c1mh76605pp863lb'),
(212, '/Admin/dashboard', '2026-07-16 15:28:33', 'o02ddtnbk4c1mh76605pp863lb'),
(213, '/Utente/login', '2026-07-16 15:28:34', 'o02ddtnbk4c1mh76605pp863lb'),
(214, '/utente/profilo', '2026-07-16 15:28:39', 'o02ddtnbk4c1mh76605pp863lb'),
(215, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:28:42', 'o02ddtnbk4c1mh76605pp863lb'),
(216, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 15:33:04', 'o02ddtnbk4c1mh76605pp863lb'),
(217, '/utente/profilo', '2026-07-16 15:33:04', 'o02ddtnbk4c1mh76605pp863lb'),
(218, '/utente/logout', '2026-07-16 15:33:21', 'o02ddtnbk4c1mh76605pp863lb'),
(219, '/utente/login', '2026-07-16 15:33:21', 'o02ddtnbk4c1mh76605pp863lb'),
(220, '/Utente/verifica', '2026-07-16 15:33:39', 'o02ddtnbk4c1mh76605pp863lb'),
(221, '/catalogo/esploraCatalogo', '2026-07-16 15:33:39', 'o02ddtnbk4c1mh76605pp863lb'),
(222, '/utente/profilo', '2026-07-16 15:33:44', 'o02ddtnbk4c1mh76605pp863lb'),
(223, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:33:48', 'o02ddtnbk4c1mh76605pp863lb'),
(224, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 15:36:48', 'o02ddtnbk4c1mh76605pp863lb'),
(225, '/utente/profilo', '2026-07-16 15:36:48', 'o02ddtnbk4c1mh76605pp863lb'),
(226, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:36:51', 'o02ddtnbk4c1mh76605pp863lb'),
(227, '/', '2026-07-16 15:37:39', 'o02ddtnbk4c1mh76605pp863lb'),
(228, '/utente/logout', '2026-07-16 15:37:41', 'o02ddtnbk4c1mh76605pp863lb'),
(229, '/utente/login', '2026-07-16 15:37:41', 'o02ddtnbk4c1mh76605pp863lb'),
(230, '/Utente/verifica', '2026-07-16 15:37:53', 'o02ddtnbk4c1mh76605pp863lb'),
(231, '/catalogo/esploraCatalogo', '2026-07-16 15:37:53', 'o02ddtnbk4c1mh76605pp863lb'),
(232, '/utente/profilo', '2026-07-16 15:37:57', 'o02ddtnbk4c1mh76605pp863lb'),
(233, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 15:37:59', 'o02ddtnbk4c1mh76605pp863lb'),
(234, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 15:42:34', 'o02ddtnbk4c1mh76605pp863lb'),
(235, '/utente/profilo', '2026-07-16 15:42:34', 'o02ddtnbk4c1mh76605pp863lb'),
(236, '/', '2026-07-16 15:42:57', 'o02ddtnbk4c1mh76605pp863lb'),
(237, '/utente/logout', '2026-07-16 15:43:00', 'o02ddtnbk4c1mh76605pp863lb'),
(238, '/utente/login', '2026-07-16 15:43:00', 'o02ddtnbk4c1mh76605pp863lb'),
(239, '/Utente/verifica', '2026-07-16 15:43:14', 'o02ddtnbk4c1mh76605pp863lb'),
(240, '/Admin/dashboard', '2026-07-16 15:43:14', 'o02ddtnbk4c1mh76605pp863lb'),
(241, '/Admin/statistiche', '2026-07-16 15:43:18', 'o02ddtnbk4c1mh76605pp863lb'),
(242, '/utente/login', '2026-07-16 21:31:21', 'o02ddtnbk4c1mh76605pp863lb'),
(243, '/Utente/verifica', '2026-07-16 21:31:31', 'o02ddtnbk4c1mh76605pp863lb'),
(244, '/catalogo/esploraCatalogo', '2026-07-16 21:31:31', 'o02ddtnbk4c1mh76605pp863lb'),
(245, '/', '2026-07-16 21:31:34', 'o02ddtnbk4c1mh76605pp863lb'),
(246, '/catalogo/esploraCatalogo', '2026-07-16 21:31:41', 'o02ddtnbk4c1mh76605pp863lb'),
(247, '/catalogo/visualizzaDettagliOpera/5', '2026-07-16 21:31:52', 'o02ddtnbk4c1mh76605pp863lb'),
(248, '/catalogo/esploraCatalogo', '2026-07-16 21:31:59', 'o02ddtnbk4c1mh76605pp863lb'),
(249, '/utente/profilo', '2026-07-16 21:32:21', 'o02ddtnbk4c1mh76605pp863lb'),
(250, '/utente/logout', '2026-07-16 21:32:23', 'o02ddtnbk4c1mh76605pp863lb'),
(251, '/utente/login', '2026-07-16 21:32:23', 'o02ddtnbk4c1mh76605pp863lb'),
(252, '/Utente/verifica', '2026-07-16 21:32:34', 'o02ddtnbk4c1mh76605pp863lb'),
(253, '/Admin/dashboard', '2026-07-16 21:32:34', 'o02ddtnbk4c1mh76605pp863lb'),
(254, '/Admin/statistiche', '2026-07-16 21:33:04', 'o02ddtnbk4c1mh76605pp863lb'),
(255, '/utente/logout', '2026-07-16 21:33:52', 'o02ddtnbk4c1mh76605pp863lb'),
(256, '/utente/login', '2026-07-16 21:33:52', 'o02ddtnbk4c1mh76605pp863lb'),
(257, '/Utente/verifica', '2026-07-16 21:34:05', 'o02ddtnbk4c1mh76605pp863lb'),
(258, '/catalogo/esploraCatalogo', '2026-07-16 21:34:05', 'o02ddtnbk4c1mh76605pp863lb'),
(259, '/catalogo/visualizzaDettagliOpera/6', '2026-07-16 21:34:17', 'o02ddtnbk4c1mh76605pp863lb'),
(260, '/compravendita/avviaAcquisto/6', '2026-07-16 21:34:21', 'o02ddtnbk4c1mh76605pp863lb'),
(261, '/compravendita/confermaAcquisto/6', '2026-07-16 21:34:28', 'o02ddtnbk4c1mh76605pp863lb'),
(262, '/catalogo/esploraCatalogo', '2026-07-16 21:34:34', 'o02ddtnbk4c1mh76605pp863lb'),
(263, '/catalogo/visualizzaDettagliOpera/6', '2026-07-16 21:34:36', 'o02ddtnbk4c1mh76605pp863lb'),
(264, '/compravendita/avviaAcquisto/6', '2026-07-16 21:34:38', 'o02ddtnbk4c1mh76605pp863lb'),
(265, '/compravendita/confermaAcquisto/6', '2026-07-16 21:34:45', 'o02ddtnbk4c1mh76605pp863lb'),
(266, '/catalogo/esploraCatalogo', '2026-07-16 21:34:56', 'o02ddtnbk4c1mh76605pp863lb'),
(267, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 21:37:03', 'o02ddtnbk4c1mh76605pp863lb'),
(268, '/', '2026-07-16 21:37:14', 'o02ddtnbk4c1mh76605pp863lb'),
(269, '/catalogo/visualizzaDettagliOpera/8', '2026-07-16 21:37:23', 'o02ddtnbk4c1mh76605pp863lb'),
(270, '/', '2026-07-16 21:37:25', 'o02ddtnbk4c1mh76605pp863lb'),
(271, '/', '2026-07-16 22:04:30', 'o02ddtnbk4c1mh76605pp863lb'),
(272, '/catalogo/esploraCatalogo', '2026-07-16 22:04:32', 'o02ddtnbk4c1mh76605pp863lb'),
(273, '/catalogo/visualizzaDettagliOpera/8', '2026-07-16 22:04:33', 'o02ddtnbk4c1mh76605pp863lb'),
(274, '/compravendita/avviaAcquisto/8', '2026-07-16 22:04:36', 'o02ddtnbk4c1mh76605pp863lb'),
(275, '/compravendita/confermaAcquisto/8', '2026-07-16 22:04:37', 'o02ddtnbk4c1mh76605pp863lb'),
(276, '/compravendita/confermaAcquisto/8', '2026-07-16 22:09:29', 'o02ddtnbk4c1mh76605pp863lb'),
(277, '/catalogo/esploraCatalogo', '2026-07-16 22:15:01', 'o02ddtnbk4c1mh76605pp863lb'),
(278, '/catalogo/visualizzaDettagliOpera/6', '2026-07-16 22:15:10', 'o02ddtnbk4c1mh76605pp863lb'),
(279, '/compravendita/avviaAcquisto/6', '2026-07-16 22:15:11', 'o02ddtnbk4c1mh76605pp863lb'),
(280, '/compravendita/confermaAcquisto/6', '2026-07-16 22:15:13', 'o02ddtnbk4c1mh76605pp863lb'),
(281, '/catalogo/esploraCatalogo', '2026-07-16 22:15:19', 'o02ddtnbk4c1mh76605pp863lb'),
(282, '/utente/logout', '2026-07-16 22:15:24', 'o02ddtnbk4c1mh76605pp863lb'),
(283, '/utente/login', '2026-07-16 22:15:24', 'o02ddtnbk4c1mh76605pp863lb'),
(284, '/Utente/verifica', '2026-07-16 22:15:34', 'o02ddtnbk4c1mh76605pp863lb'),
(285, '/Admin/dashboard', '2026-07-16 22:15:34', 'o02ddtnbk4c1mh76605pp863lb'),
(286, '/Admin/statistiche', '2026-07-16 22:15:39', 'o02ddtnbk4c1mh76605pp863lb'),
(287, '/Admin/statistiche', '2026-07-16 22:22:28', 'o02ddtnbk4c1mh76605pp863lb'),
(288, '/utente/logout', '2026-07-16 22:24:07', 'o02ddtnbk4c1mh76605pp863lb'),
(289, '/utente/login', '2026-07-16 22:24:07', 'o02ddtnbk4c1mh76605pp863lb'),
(290, '/utente/registrazione', '2026-07-16 22:24:14', 'o02ddtnbk4c1mh76605pp863lb'),
(291, '/utente/verificaRegistrazione', '2026-07-16 22:26:12', 'o02ddtnbk4c1mh76605pp863lb'),
(292, '/utente/login', '2026-07-16 22:26:17', 'o02ddtnbk4c1mh76605pp863lb'),
(293, '/Utente/verifica', '2026-07-16 22:26:31', 'o02ddtnbk4c1mh76605pp863lb'),
(294, '/Utente/verifica', '2026-07-16 22:26:47', 'o02ddtnbk4c1mh76605pp863lb'),
(295, '/Utente/verifica', '2026-07-16 22:26:53', 'o02ddtnbk4c1mh76605pp863lb'),
(296, '/utente/recuperoPassword', '2026-07-16 22:26:54', 'o02ddtnbk4c1mh76605pp863lb'),
(297, '/utente/inviaLinkReset', '2026-07-16 22:27:02', 'o02ddtnbk4c1mh76605pp863lb'),
(298, '/utente/resetPassword', '2026-07-16 22:27:19', 'o02ddtnbk4c1mh76605pp863lb'),
(299, '/utente/resetPassword', '2026-07-16 22:27:29', 'o02ddtnbk4c1mh76605pp863lb'),
(300, '/Utente/verifica', '2026-07-16 22:27:38', 'o02ddtnbk4c1mh76605pp863lb'),
(301, '/catalogo/esploraCatalogo', '2026-07-16 22:27:38', 'o02ddtnbk4c1mh76605pp863lb'),
(302, '/catalogo/visualizzaDettagliOpera/8', '2026-07-16 22:27:41', 'o02ddtnbk4c1mh76605pp863lb'),
(303, '/catalogo/esploraCatalogo', '2026-07-16 22:27:53', 'o02ddtnbk4c1mh76605pp863lb'),
(304, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 22:27:56', 'o02ddtnbk4c1mh76605pp863lb'),
(305, '/gestioneInterazioni/salvaRecensione', '2026-07-16 22:28:09', 'o02ddtnbk4c1mh76605pp863lb'),
(306, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 22:28:09', 'o02ddtnbk4c1mh76605pp863lb'),
(307, '/utente/logout', '2026-07-16 22:28:15', 'o02ddtnbk4c1mh76605pp863lb'),
(308, '/utente/login', '2026-07-16 22:28:15', 'o02ddtnbk4c1mh76605pp863lb'),
(309, '/Utente/verifica', '2026-07-16 22:28:24', 'o02ddtnbk4c1mh76605pp863lb'),
(310, '/catalogo/esploraCatalogo', '2026-07-16 22:28:24', 'o02ddtnbk4c1mh76605pp863lb'),
(311, '/catalogo/esploraCatalogo', '2026-07-16 22:28:28', 'o02ddtnbk4c1mh76605pp863lb'),
(312, '/', '2026-07-16 22:28:29', 'o02ddtnbk4c1mh76605pp863lb'),
(313, '/catalogo/visualizzaDettagliOpera/3', '2026-07-16 22:28:33', 'o02ddtnbk4c1mh76605pp863lb'),
(314, '/gestioneInterazioni/inviaSegnalazione', '2026-07-16 22:28:37', 'o02ddtnbk4c1mh76605pp863lb'),
(315, '/catalogo/esploraCatalogo', '2026-07-16 22:28:37', 'o02ddtnbk4c1mh76605pp863lb'),
(316, '/utente/logout', '2026-07-16 22:28:40', 'o02ddtnbk4c1mh76605pp863lb'),
(317, '/utente/login', '2026-07-16 22:28:40', 'o02ddtnbk4c1mh76605pp863lb'),
(318, '/Utente/verifica', '2026-07-16 22:28:53', 'o02ddtnbk4c1mh76605pp863lb'),
(319, '/Admin/dashboard', '2026-07-16 22:28:53', 'o02ddtnbk4c1mh76605pp863lb'),
(320, '/Admin/mostraSegnalazione', '2026-07-16 22:29:01', 'o02ddtnbk4c1mh76605pp863lb'),
(321, '/Admin/dashboard', '2026-07-16 22:29:07', 'o02ddtnbk4c1mh76605pp863lb'),
(322, '/Admin/mostraSegnalazione', '2026-07-16 22:29:10', 'o02ddtnbk4c1mh76605pp863lb'),
(323, '/Admin/processaModerazione', '2026-07-16 22:29:44', 'o02ddtnbk4c1mh76605pp863lb'),
(324, '/Admin/dashboard', '2026-07-16 22:29:47', 'o02ddtnbk4c1mh76605pp863lb'),
(325, '/utente/logout', '2026-07-16 22:29:53', 'o02ddtnbk4c1mh76605pp863lb'),
(326, '/utente/login', '2026-07-16 22:29:53', 'o02ddtnbk4c1mh76605pp863lb'),
(327, '/Utente/verifica', '2026-07-16 22:30:05', 'o02ddtnbk4c1mh76605pp863lb'),
(328, '/catalogo/esploraCatalogo', '2026-07-16 22:32:17', 'o02ddtnbk4c1mh76605pp863lb'),
(329, '/utente/registrazione', '2026-07-16 22:32:41', 'o02ddtnbk4c1mh76605pp863lb'),
(330, '/utente/login', '2026-07-16 22:32:42', 'o02ddtnbk4c1mh76605pp863lb'),
(331, '/Utente/verifica', '2026-07-16 22:33:00', 'o02ddtnbk4c1mh76605pp863lb'),
(332, '/catalogo/esploraCatalogo', '2026-07-16 22:33:00', 'o02ddtnbk4c1mh76605pp863lb'),
(333, '/utente/profilo', '2026-07-16 22:33:05', 'o02ddtnbk4c1mh76605pp863lb'),
(334, '/utente/storicoVendite', '2026-07-16 22:33:10', 'o02ddtnbk4c1mh76605pp863lb'),
(335, '/catalogo/esploraCatalogo', '2026-07-16 22:33:24', 'o02ddtnbk4c1mh76605pp863lb'),
(336, '/utente/profilo', '2026-07-16 22:33:27', 'o02ddtnbk4c1mh76605pp863lb'),
(337, '/gestioneProfiloPortfolio/eliminaOpera', '2026-07-16 22:33:36', 'o02ddtnbk4c1mh76605pp863lb'),
(338, '/utente/profilo', '2026-07-16 22:33:36', 'o02ddtnbk4c1mh76605pp863lb'),
(339, '/gestioneProfiloPortfolio/eliminaOpera', '2026-07-16 22:33:40', 'o02ddtnbk4c1mh76605pp863lb'),
(340, '/utente/profilo', '2026-07-16 22:33:40', 'o02ddtnbk4c1mh76605pp863lb'),
(341, '/utente/profilo', '2026-07-16 22:33:42', 'o02ddtnbk4c1mh76605pp863lb'),
(342, '/utente/profilo', '2026-07-16 22:33:45', 'o02ddtnbk4c1mh76605pp863lb'),
(343, '/utente/profilo', '2026-07-16 22:33:45', 'o02ddtnbk4c1mh76605pp863lb'),
(344, '/Utente/login', '2026-07-16 22:33:50', 'o02ddtnbk4c1mh76605pp863lb'),
(345, '/utente/profilo', '2026-07-16 22:33:52', 'o02ddtnbk4c1mh76605pp863lb'),
(346, '/gestioneProfiloPortfolio/eliminaOpera', '2026-07-16 22:33:56', 'o02ddtnbk4c1mh76605pp863lb'),
(347, '/utente/profilo', '2026-07-16 22:33:56', 'o02ddtnbk4c1mh76605pp863lb'),
(348, '/utente/profilo', '2026-07-16 22:44:36', 'o02ddtnbk4c1mh76605pp863lb'),
(349, '/gestioneProfiloPortfolio/eliminaOpera', '2026-07-16 22:44:38', 'o02ddtnbk4c1mh76605pp863lb'),
(350, '/utente/profilo', '2026-07-16 22:44:39', 'o02ddtnbk4c1mh76605pp863lb'),
(351, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-16 22:45:07', 'o02ddtnbk4c1mh76605pp863lb'),
(352, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-16 22:46:23', 'o02ddtnbk4c1mh76605pp863lb'),
(353, '/utente/profilo', '2026-07-16 22:46:23', 'o02ddtnbk4c1mh76605pp863lb'),
(354, '/utente/logout', '2026-07-16 22:46:27', 'o02ddtnbk4c1mh76605pp863lb'),
(355, '/utente/login', '2026-07-16 22:46:27', 'o02ddtnbk4c1mh76605pp863lb'),
(356, '/Utente/verifica', '2026-07-16 22:46:35', 'o02ddtnbk4c1mh76605pp863lb'),
(357, '/catalogo/esploraCatalogo', '2026-07-16 22:46:35', 'o02ddtnbk4c1mh76605pp863lb'),
(358, '/catalogo/visualizzaDettagliOpera/9', '2026-07-16 22:46:46', 'o02ddtnbk4c1mh76605pp863lb'),
(359, '/compravendita/avviaPropostaOfferta/9', '2026-07-16 22:47:01', 'o02ddtnbk4c1mh76605pp863lb'),
(360, '/catalogo/visualizzaDettagliOpera/9', '2026-07-16 22:47:03', 'o02ddtnbk4c1mh76605pp863lb'),
(361, '/utente/logout', '2026-07-16 22:47:06', 'o02ddtnbk4c1mh76605pp863lb'),
(362, '/utente/login', '2026-07-16 22:47:06', 'o02ddtnbk4c1mh76605pp863lb'),
(363, '/Utente/verifica', '2026-07-16 22:47:18', 'o02ddtnbk4c1mh76605pp863lb'),
(364, '/catalogo/esploraCatalogo', '2026-07-16 22:47:18', 'o02ddtnbk4c1mh76605pp863lb'),
(365, '/catalogo/visualizzaDettagliOpera/9', '2026-07-16 22:47:22', 'o02ddtnbk4c1mh76605pp863lb'),
(366, '/utente/profilo', '2026-07-16 22:47:25', 'o02ddtnbk4c1mh76605pp863lb'),
(367, '/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-16 22:47:28', 'o02ddtnbk4c1mh76605pp863lb'),
(368, '/utente/profilo', '2026-07-16 22:47:30', 'o02ddtnbk4c1mh76605pp863lb'),
(369, '/utente/storicoVendite', '2026-07-16 22:47:35', 'o02ddtnbk4c1mh76605pp863lb'),
(370, '/utente/logout', '2026-07-16 22:47:56', 'o02ddtnbk4c1mh76605pp863lb'),
(371, '/utente/login', '2026-07-16 22:47:56', 'o02ddtnbk4c1mh76605pp863lb'),
(372, '/Utente/verifica', '2026-07-16 22:48:07', 'o02ddtnbk4c1mh76605pp863lb'),
(373, '/Admin/dashboard', '2026-07-16 22:48:07', 'o02ddtnbk4c1mh76605pp863lb'),
(374, '/Admin/statistiche', '2026-07-16 22:48:11', 'o02ddtnbk4c1mh76605pp863lb'),
(375, '/Admin/statistiche', '2026-07-16 22:49:23', 'o02ddtnbk4c1mh76605pp863lb'),
(376, '/Admin/statistiche', '2026-07-16 22:49:26', 'o02ddtnbk4c1mh76605pp863lb'),
(377, '/Admin/statistiche', '2026-07-16 22:49:29', 'o02ddtnbk4c1mh76605pp863lb'),
(378, '/utente/logout', '2026-07-16 22:54:46', 'o02ddtnbk4c1mh76605pp863lb'),
(379, '/utente/login', '2026-07-16 22:54:46', 'o02ddtnbk4c1mh76605pp863lb'),
(380, '/Utente/verifica', '2026-07-16 22:54:56', 'o02ddtnbk4c1mh76605pp863lb'),
(381, '/catalogo/esploraCatalogo', '2026-07-16 22:54:56', 'o02ddtnbk4c1mh76605pp863lb'),
(382, '/utente/profilo', '2026-07-16 22:54:59', 'o02ddtnbk4c1mh76605pp863lb'),
(383, '/gestioneProfiloPortfolio/eliminaOpera', '2026-07-16 22:55:04', 'o02ddtnbk4c1mh76605pp863lb'),
(384, '/utente/profilo', '2026-07-16 22:55:04', 'o02ddtnbk4c1mh76605pp863lb'),
(385, '/utente/login', '2026-07-16 23:25:14', 'o02ddtnbk4c1mh76605pp863lb'),
(386, '/', '2026-07-17 11:19:24', 'drqhm43fidocd2jotfdsqvsp90'),
(387, '/catalogo/esploraCatalogo', '2026-07-17 11:19:27', 'drqhm43fidocd2jotfdsqvsp90'),
(388, '/utente/login', '2026-07-17 12:06:49', 'drqhm43fidocd2jotfdsqvsp90'),
(389, '/Utente/verifica', '2026-07-17 12:07:04', 'drqhm43fidocd2jotfdsqvsp90'),
(390, '/catalogo/esploraCatalogo', '2026-07-17 12:07:04', 'drqhm43fidocd2jotfdsqvsp90'),
(391, '/catalogo/visualizzaDettagliOpera/5', '2026-07-17 12:07:09', 'drqhm43fidocd2jotfdsqvsp90'),
(392, '/compravendita/avviaAcquisto/5', '2026-07-17 12:07:13', 'drqhm43fidocd2jotfdsqvsp90'),
(393, '/compravendita/confermaAcquisto/5', '2026-07-17 12:07:16', 'drqhm43fidocd2jotfdsqvsp90'),
(394, '/catalogo/esploraCatalogo', '2026-07-17 12:07:19', 'drqhm43fidocd2jotfdsqvsp90'),
(395, '/utente/logout', '2026-07-17 12:07:22', 'drqhm43fidocd2jotfdsqvsp90'),
(396, '/utente/login', '2026-07-17 12:07:22', 'drqhm43fidocd2jotfdsqvsp90'),
(397, '/Utente/verifica', '2026-07-17 12:07:36', 'drqhm43fidocd2jotfdsqvsp90'),
(398, '/catalogo/esploraCatalogo', '2026-07-17 12:07:36', 'drqhm43fidocd2jotfdsqvsp90'),
(399, '/utente/profilo', '2026-07-17 12:07:40', 'drqhm43fidocd2jotfdsqvsp90'),
(400, '/gestioneProfiloPortfolio/eliminaOpera', '2026-07-17 12:07:44', 'drqhm43fidocd2jotfdsqvsp90'),
(401, '/utente/profilo', '2026-07-17 12:07:44', 'drqhm43fidocd2jotfdsqvsp90'),
(402, '/utente/storicoVendite', '2026-07-17 12:07:57', 'drqhm43fidocd2jotfdsqvsp90'),
(403, '/utente/profilo', '2026-07-17 12:08:12', 'drqhm43fidocd2jotfdsqvsp90'),
(404, '/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-17 12:08:13', 'drqhm43fidocd2jotfdsqvsp90'),
(405, '/gestioneProfiloPortfolio/salvaOpera', '2026-07-17 12:09:34', 'drqhm43fidocd2jotfdsqvsp90'),
(406, '/utente/profilo', '2026-07-17 12:09:34', 'drqhm43fidocd2jotfdsqvsp90'),
(407, '/utente/logout', '2026-07-17 12:09:45', 'drqhm43fidocd2jotfdsqvsp90'),
(408, '/utente/login', '2026-07-17 12:09:45', 'drqhm43fidocd2jotfdsqvsp90'),
(409, '/Utente/verifica', '2026-07-17 12:09:57', 'drqhm43fidocd2jotfdsqvsp90'),
(410, '/Admin/dashboard', '2026-07-17 12:09:57', 'drqhm43fidocd2jotfdsqvsp90'),
(411, '/Admin/statistiche', '2026-07-17 12:10:00', 'drqhm43fidocd2jotfdsqvsp90'),
(412, '/Admin/dashboard', '2026-07-17 12:10:10', 'drqhm43fidocd2jotfdsqvsp90'),
(413, '/Admin/gestisciCategorie', '2026-07-17 12:10:17', 'drqhm43fidocd2jotfdsqvsp90'),
(414, '/Admin/dashboard', '2026-07-17 12:10:23', 'drqhm43fidocd2jotfdsqvsp90'),
(415, '/utente/logout', '2026-07-17 12:10:26', 'drqhm43fidocd2jotfdsqvsp90'),
(416, '/utente/login', '2026-07-17 12:10:26', 'drqhm43fidocd2jotfdsqvsp90'),
(417, '/catalogo/esploraCatalogo', '2026-07-17 12:12:10', 'drqhm43fidocd2jotfdsqvsp90'),
(418, '/', '2026-07-17 21:57:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(419, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 21:57:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(420, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 21:57:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(421, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 21:57:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(422, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 21:57:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(423, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:57:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(424, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 21:57:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(425, '/catalogo/filtraCatalogo', '2026-07-17 21:57:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(426, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:57:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(427, '/utente/login', '2026-07-17 21:57:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(428, '/utente/registrazione', '2026-07-17 21:57:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(429, '/utente/registrazione', '2026-07-17 21:57:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(430, '/', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(431, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(432, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(433, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(434, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(435, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(436, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 21:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(437, '/catalogo/filtraCatalogo', '2026-07-17 21:57:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(438, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:57:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(439, '/catalogo/visualizzaProfiloArtista/51', '2026-07-17 21:58:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(440, '/uploads/profilo/8d77e38bedd5931699cceaf7b8ad86fd.jpg', '2026-07-17 21:58:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(441, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 21:58:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(442, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 21:58:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(443, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:58:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(444, '/catalogo/visualizzaDettagliOpera/10', '2026-07-17 21:58:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(445, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:58:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(446, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 21:58:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(447, '/catalogo/visualizzaDettagliOpera/10', '2026-07-17 21:58:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(448, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:58:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(449, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 21:58:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(450, '/catalogo/visualizzaDettagliOpera/8', '2026-07-17 21:58:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(451, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 21:58:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(452, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 21:58:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(453, '/catalogo/visualizzaDettagliOpera/6', '2026-07-17 21:58:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(454, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 21:58:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(455, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:58:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(456, '/catalogo/filtraCatalogo', '2026-07-17 21:58:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(457, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 21:58:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(458, '/catalogo/visualizzaDettagliOpera/10', '2026-07-17 21:58:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(459, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 21:58:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(460, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 21:58:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(461, '/catalogo/filtraCatalogo', '2026-07-17 21:59:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(462, '/catalogo/filtraCatalogo', '2026-07-17 21:59:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(463, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 21:59:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(464, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 21:59:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(465, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 21:59:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(466, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 21:59:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(467, '/catalogo/filtraCatalogo', '2026-07-17 22:00:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(468, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:00:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(469, '/catalogo/filtraCatalogo', '2026-07-17 22:00:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(470, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:00:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(471, '/', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(472, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(473, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(474, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(475, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(476, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(477, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:00:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(478, '/utente/registrazione', '2026-07-17 22:00:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(479, '/utente/login', '2026-07-17 22:00:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(480, '/Utente/verifica', '2026-07-17 22:00:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(481, '/Admin/dashboard', '2026-07-17 22:00:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(482, '/Admin/statistiche', '2026-07-17 22:00:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(483, '/Admin/statistiche', '2026-07-17 22:00:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(484, '/', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(485, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(486, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(487, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(488, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(489, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(490, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:00:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(491, '/catalogo/filtraCatalogo', '2026-07-17 22:01:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(492, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:01:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(493, '/catalogo/visualizzaDettagliOpera/8', '2026-07-17 22:01:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(494, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:01:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(495, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 22:01:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(496, '/utente/logout', '2026-07-17 22:01:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(497, '/utente/login', '2026-07-17 22:01:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(498, '/', '2026-07-17 22:01:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(499, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:01:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(500, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:01:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(501, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:01:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(502, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:01:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(503, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:01:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(504, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:01:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(505, '/catalogo/filtraCatalogo', '2026-07-17 22:01:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(506, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:01:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(507, '/catalogo/visualizzaDettagliOpera/8', '2026-07-17 22:01:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(508, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 22:01:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(509, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:01:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(510, '/compravendita/avviaAcquisto/8', '2026-07-17 22:01:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(511, '/utente/login', '2026-07-17 22:01:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(512, '/Utente/verifica', '2026-07-17 22:01:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(513, '/catalogo/esploraCatalogo', '2026-07-17 22:01:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(514, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:01:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(515, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:01:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(516, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:01:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(517, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:01:34', 'm6svarsrpmtuhelnkp9gsggoq3');
INSERT INTO `visita` (`id`, `pagina`, `data`, `sessione`) VALUES
(518, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:01:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(519, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:01:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(520, '/catalogo/visualizzaDettagliOpera/10', '2026-07-17 22:01:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(521, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:01:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(522, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 22:01:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(523, '/catalogo/visualizzaDettagliOpera/8', '2026-07-17 22:01:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(524, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:01:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(525, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 22:01:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(526, '/catalogo/visualizzaDettagliOpera/7', '2026-07-17 22:01:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(527, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:01:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(528, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:01:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(529, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:01:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(530, '/catalogo/visualizzaProfiloArtista/50', '2026-07-17 22:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(531, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(532, '/uploads/profilo/a9c8fdd8f1f8ad4dc93f8175df28b852.jpeg', '2026-07-17 22:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(533, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(534, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(535, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(536, '/utente/logout', '2026-07-17 22:02:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(537, '/utente/login', '2026-07-17 22:02:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(538, '/Utente/verifica', '2026-07-17 22:02:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(539, '/catalogo/esploraCatalogo', '2026-07-17 22:02:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(540, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:02:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(541, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:02:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(542, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:02:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(543, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:02:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(544, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:02:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(545, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:02:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(546, '/catalogo/visualizzaDettagliOpera/10', '2026-07-17 22:02:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(547, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 22:02:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(548, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:02:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(549, '/compravendita/avviaAcquisto/10', '2026-07-17 22:02:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(550, '/catalogo/visualizzaProfiloArtista/51', '2026-07-17 22:03:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(551, '/uploads/profilo/8d77e38bedd5931699cceaf7b8ad86fd.jpg', '2026-07-17 22:03:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(552, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:03:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(553, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:03:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(554, '/uploads/opere/dd4deede48d9bbafedf25897cf65f6a0.jpg', '2026-07-17 22:03:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(555, '/utente/profilo', '2026-07-17 22:03:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(556, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:03:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(557, '/uploads/profilo/a9c8fdd8f1f8ad4dc93f8175df28b852.jpeg', '2026-07-17 22:03:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(558, '/uploads/profilo/6620fc67ef6eb7ad951e29714f49e0f7.jpeg', '2026-07-17 22:03:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(559, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:03:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(560, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:03:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(561, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:03:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(562, '/uploads/profilo/8d77e38bedd5931699cceaf7b8ad86fd.jpg', '2026-07-17 22:03:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(563, '/catalogo/visualizzaProfiloArtista/48', '2026-07-17 22:03:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(564, '/uploads/profilo/6620fc67ef6eb7ad951e29714f49e0f7.jpeg', '2026-07-17 22:03:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(565, '/catalogo/visualizzaDettagliOpera/3', '2026-07-17 22:03:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(566, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:03:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(567, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:03:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(568, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:03:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(569, '/', '2026-07-17 22:04:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(570, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:04:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(571, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:04:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(572, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:04:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(573, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:04:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(574, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:04:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(575, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:04:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(576, '/utente/profilo', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(577, '/uploads/profilo/a9c8fdd8f1f8ad4dc93f8175df28b852.jpeg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(578, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(579, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(580, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(581, '/uploads/profilo/6620fc67ef6eb7ad951e29714f49e0f7.jpeg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(582, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(583, '/uploads/profilo/8d77e38bedd5931699cceaf7b8ad86fd.jpg', '2026-07-17 22:04:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(584, '/utente/storicoVendite', '2026-07-17 22:04:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(585, '/', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(586, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(587, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(588, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(589, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(590, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(591, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:04:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(592, '/catalogo/filtraCatalogo', '2026-07-17 22:04:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(593, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:04:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(594, '/', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(595, '/uploads/opere/0d353fc9159dc56ac434d69ee16a4d4c.jpg', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(596, '/uploads/opere/bbd34bd10ff8cc9d3a959f49c7520cb7.jpg', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(597, '/uploads/opere/c3f40124a8cebe51d5ec56ab4a77e437.jpeg', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(598, '/uploads/opere/23ce175bb41809411a03f7192d326928.jpg', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(599, '/uploads/opere/c806a3c1b76e8c8858859de4503c519c.jpg', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(600, '/uploads/opere/36bfaf8371613fc3db56977ed9b26bbd.jpg', '2026-07-17 22:04:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(601, '/', '2026-07-17 22:13:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(602, '/utente/logout', '2026-07-17 22:13:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(603, '/utente/login', '2026-07-17 22:13:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(604, '/Utente/verifica', '2026-07-17 22:13:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(605, '/Admin/dashboard', '2026-07-17 22:13:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(606, '/Admin/statistiche', '2026-07-17 22:13:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(607, '/Admin/statistiche', '2026-07-17 22:13:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(608, '/Admin/dashboard', '2026-07-17 22:13:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(609, '/', '2026-07-17 22:27:44', 'm6svarsrpmtuhelnkp9gsggoq3');

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
-- Indici per le tabelle `offerta`
--
ALTER TABLE `offerta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOfferente` (`idOfferente`),
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
-- Indici per le tabelle `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

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
-- Indici per le tabelle `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `immagine`
--
ALTER TABLE `immagine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `offerta`
--
ALTER TABLE `offerta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `opera`
--
ALTER TABLE `opera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `provvedimento`
--
ALTER TABLE `provvedimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `tecnica`
--
ALTER TABLE `tecnica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT per la tabella `visita`
--
ALTER TABLE `visita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=610;

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
-- Limiti per la tabella `offerta`
--
ALTER TABLE `offerta`
  ADD CONSTRAINT `offerta_ibfk_1` FOREIGN KEY (`idOfferente`) REFERENCES `utente` (`id`),
  ADD CONSTRAINT `offerta_ibfk_2` FOREIGN KEY (`idOpera`) REFERENCES `opera` (`id`);

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
  ADD CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`idOpera`) REFERENCES `opera` (`id`) ON DELETE SET NULL;

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
