-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Lug 08, 2026 alle 14:20
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
  `stato_validazione` varchar(50) DEFAULT 'IN_ATTESA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `artista`
--

INSERT INTO `artista` (`idUtente`, `biografia`, `stileArtistico`, `carta_identita`, `stato_validazione`) VALUES
(18, 'buwswhbddddddddddddddhhsdhebdhejkxkwxmncbchrbvkedmjedn', 'impressionismo', '05_nascita_OOP (1).pdf', 'APPROVATO'),
(24, 'tommaso', 'njfvjvfjvfnj', '15_html.pdf', 'APPROVATO'),
(26, 'ednjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'njdejnjenjendjejdnejndjenjenjednenejdendjej', 'CD 2026.03.02.pdf', 'APPROVATO'),
(29, 'djjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'dejdjedjehdje', '10_step_progetto_6.pdf', 'APPROVATO'),
(31, 'dcbhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'cbdbdndbndcbn', '08_step_progetto_5 (1).pdf', 'APPROVATO'),
(32, 'shwshwghgshwghwgshwgshgshwhsghgwhgshghwgswxhjhjhjhhj', 'wshwghwgswh', '05_nascita_OOP (1).pdf', 'APPROVATO'),
(33, 'ehhegdhegdhedghdghegdhegdgdhedghegdhegheghdgedhdeed', 'dedbebdehhde', '25_step_progetto_7.pdf', 'APPROVATO'),
(35, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 'sssssssssssssssssssssssss', '10_step_progetto_6 (1).pdf', 'APPROVATO'),
(36, 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', 'fffffffffffffffffffffffffff', '07_ProgettoEsame_step_4 (1).pdf', 'APPROVATO'),
(37, 'yfjgcgcgcfgdfhfggggggggggggggggggggggggggggggggggggggggggggggggggggg', 'yfytjftftftfu', '07_ProgettoEsame_step_4 (1).pdf', 'IN_ATTESA'),
(39, 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 'ddddddddddddd', '2b74eea868fdd33d24357b10c4c94ad6.pdf', 'APPROVATO'),
(40, 'hdejjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 'evxegcgecge', '0821412f7521b2bb9c5ed239cb48add4.pdf', 'IN_ATTESA');

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
(1, 'carina', 3, '2026-07-01 17:06:43', 27, 2),
(2, 'eedddddddddddddddd', 3, '2026-07-01 17:07:28', 27, 1),
(3, 'carina', 4, '2026-07-01 17:16:59', 27, 1),
(4, 'bellissima', 5, '2026-07-01 17:21:37', 27, 2),
(5, 'ottimaaaaa', 5, '2026-07-01 17:22:02', 27, 2),
(6, 'bruttissima', 1, '2026-07-01 17:22:12', 27, 2),
(7, 'ottimaaaaa', 5, '2026-07-01 17:22:35', 27, 1),
(8, 'ci sta bella', 3, '2026-07-01 19:00:21', 24, 4),
(9, 'ci sta bella', 3, '2026-07-01 19:03:19', 24, 4),
(10, 'bellsiiimam', 4, '2026-07-01 19:16:09', 24, 4),
(11, 'nbnbnbnbbbnbn', 5, '2026-07-01 20:17:57', 27, 4),
(12, 'veramente bella', 5, '2026-07-04 21:15:19', 27, 8),
(13, 'veramente bella', 5, '2026-07-04 21:17:54', 27, 12),
(14, 'jdjedhjehdjehdjehj', 5, '2026-07-04 21:19:01', 27, 12),
(15, 'djejnjenje', 4, '2026-07-04 21:19:27', 27, 12),
(16, 'beòòòaaafrfr', 5, '2026-07-04 21:20:07', 27, 8),
(17, 'non male', 3, '2026-07-04 23:06:33', 27, 8),
(18, 'veramente veramente orrenda', 1, '2026-07-05 22:25:50', 27, 16),
(19, 'veramente orrenda', 1, '2026-07-05 22:26:12', 27, 16),
(20, 'bella bella bella', 5, '2026-07-05 22:29:31', 27, 13),
(21, 'bepllllllllalb', 4, '2026-07-05 22:29:43', 27, 13),
(24, 'buonabuoba', 3, '2026-07-07 22:09:41', 27, 8),
(25, 'bellissimaaaaa', 4, '2026-07-07 22:53:03', 29, 19);

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
(1, '2eeab85f9d9bcebb8d0e39569181261c.png', 3),
(2, '80ac27d3484f846f63792d6dbeda200a.png', 3),
(3, '7e4c2fee4b4212a55297f29b3ae9a14a.png', 3),
(4, 'cbd7f75afc32d66af53bf377535b3505.png', 3),
(5, 'c3b50ca057374be67a71a02da3c20089.png', 4),
(6, '6332e6779191db1d44eaf70839ae2604.png', 4),
(7, '7110425656c2cec9a50788755c45df56.png', 4),
(8, '11f1108208e95e555e0365f3c6617159.png', 4),
(9, 'a4d95c9dbdb491291fee01e4801f85db.png', 5),
(10, '1eb0ec6f18b02a7a59d886bd9d7e7653.png', 5),
(11, '0f36d157f19f429640c4805daacdd211.jpeg', 5),
(12, '9c7f633c8066cfdebcae9e67fec6f6c4.jpeg', 5),
(13, '149b676b8db374084eaf7b67e5b5b4ef.png', 6),
(14, 'c9fe5bc3e95ef13a5eebb3ed4dbdd9b7.png', 6),
(15, '77954c9d8f3391ad121ddbe25368191f.png', 6),
(16, 'f4763c9f4eb49bc28d934f1af228a608.png', 6),
(21, 'f305bdcaf10b54a75b3d09a37888c85c.webp', 8),
(22, '3271f9d4f59472e0f222863ae981c63f.png', 8),
(23, 'b74f4384bc2f4e54ec816e1c2b632ecd.jpeg', 8),
(24, 'b855434b4b2226a2bebc8b3faf43fb6e.png', 8),
(25, '16e3b2defd23c4900b710fa45863ec1b.webp', 9),
(26, '2f2b4fec988cf57b7bc8895287d82262.png', 9),
(27, 'f7ff82c658eec3ab29c8cafbeee35423.jpeg', 9),
(28, 'b29cae51d1f79bcbeaa1918832a344e3.png', 9),
(29, '8e877e052e9e501307568835937ae082.webp', 10),
(30, '25e35533e1294fb405dae21e0475466b.png', 10),
(31, '4641db753e7bb1c694fc0aaaf3c498f3.jpeg', 10),
(32, '34106451a2ae731749d30e816859f4c1.png', 10),
(33, '2199c0ad6374f6769774272739b3b527.jpeg', 11),
(34, '17e5ed97c38a44703bf42b1c2ff72bc9.webp', 11),
(35, '925726e3a1461e348913e4797628169b.png', 11),
(36, '2b11cc0a6985b9d3a6b80ed356be4502.jpeg', 11),
(37, '9415f8138d52ad162151d1809ced418b.png', 12),
(38, '541cf48bcc9ebe81f9ad109584e00044.png', 12),
(39, '5ed13adda3db42f2859548bd24a958da.png', 12),
(40, '59f839d3439ec61f2ed09077eb28a37a.png', 12),
(41, '32f87dc01c84ec0f7d08791495b377a5.png', 13),
(42, 'e3e1b9bff025d10f15c8afe5382b7f34.png', 13),
(43, '1a49598b08d527dde4077d9aa6b9137c.png', 13),
(44, '1c7385826b5640223291cc4c7e35cbdc.png', 13),
(45, 'e331afea8ef201362a2853ddc36da565.webp', 14),
(46, '4a5fe7f47fa70a02a7e0cf008b81b9c8.png', 14),
(47, 'a9bb39ae59ab6110a9c17d32bb872900.png', 14),
(48, '783092d6ace545c7d5030310b24afb9e.png', 14),
(53, '1d7a92873855c4001e4c23b431fed3fb.jpeg', 16),
(54, 'ebbc0a782f92094e780f50a4b641dd11.webp', 16),
(55, '382f04ec7d60c68b6f11bb74f39997ac.jpeg', 16),
(56, 'cef5058fbdb37da4c7c288e332718295.png', 16),
(57, '80a9a15413860e735ed61872c2de0b35.jpeg', 17),
(58, 'e6455a02f660c87fc2a1fe1ca28ad3e3.jpeg', 17),
(59, 'd5977d47a74497288749194b5f62d7cb.jpeg', 17),
(60, '2e06f2a9ce1e982e8cca8e0010edf74d.webp', 17),
(61, 'bee15987ff60687b598719537861f6d2.jpeg', 18),
(62, 'f7281769003a5640267330f9aeb2ee38.jpeg', 18),
(63, '1ab656bda5e9477263219aeb7eb9b032.jpeg', 18),
(64, 'a3dd6b71fc8f5fb347e16dd7e4d8574d.jpeg', 18),
(65, '6da4eacf04d13654dff0e209ff8375e3.jpeg', 19),
(66, '1c1a24ad3e34a84a0f8f4ed917bd9611.jpeg', 19),
(67, '1f24c84d8d54b9cb123d3a098c7eed60.jpeg', 19),
(68, 'ec10e059696e5abf48d70a835575fadc.jpeg', 19);

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

--
-- Dump dei dati per la tabella `offerta`
--

INSERT INTO `offerta` (`id`, `cifraProposta`, `nota`, `stato`, `dataOfferta`, `idOfferente`, `idOpera`) VALUES
(1, 1000.00, '', 'rifiutata', '2026-07-04 21:42:24', 27, 12),
(2, 1200.00, '', 'accettata', '2026-07-04 21:47:19', 27, 12),
(3, 350.00, '', 'rifiutata', '2026-07-04 21:56:37', 27, 13),
(4, 200.00, 'va bene?', 'accettata', '2026-07-04 23:21:07', 24, 14),
(5, 500.00, '', 'accettata', '2026-07-05 22:25:22', 27, 16),
(6, 300.00, '', 'accettata', '2026-07-06 23:24:45', 24, 18),
(7, 300.00, '', 'rifiutata', '2026-07-07 22:20:23', 27, 19);

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
(1, 'Paesaggio Toscano', 2023, '50x70 cm', 'Un bellissimo paesaggio della campagna toscana', 350.00, 'In esposizione', 18, 1, 1, 'Pittura', 'Olio su tela', 'in_vendita', 50.00, 70.00, 2.00, 'cm'),
(2, 'Alba sul Mare', 2024, '40x60 cm', 'Il sorgere del sole visto dalla riva', 280.00, 'In esposizione', 18, 1, 2, 'Pittura', 'Acquerello', 'in_vendita', 40.00, 60.00, 2.00, 'cm'),
(3, 'notte stellata', 2020, '32x20 cm', 'notte stellata', 0.00, 'In esposizione', 29, 1, 1, 'pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(4, 'notte stellata', 2020, '32x20 cm', 'sxbjnxjnxjsnjxnsjxnjsnxjsjxjs', 0.00, 'In esposizione', 29, 1, 1, 'pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(5, 'prima', 2015, '32x20 cm', 'bvbvbbvvb', 0.00, 'In esposizione', 29, 2, 1, 'scultura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(6, 'girasoli', 2000, '0.1x0.1 cm', 'uhcurhfjrhjfrhjfjrhfjrhjfrhjfhjrhfjrhfjrhfjrhjfh', 300.00, 'In esposizione', 24, 1, 1, 'pittura', 'olio su tela', 'Venduta', 0.10, 0.10, 0.10, 'cm'),
(8, 'secondaa', 2015, '32x20 cm', 'cfferf', 0.00, 'In esposizione', 24, 1, 1, 'pittura', 'olio su tela', 'pubblicata', 32.00, 20.00, 18.00, 'cm'),
(9, 'secondaa', 2015, '32x20 cm', 'swswswsws', 200.00, 'In esposizione', 24, 1, 1, 'pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(10, 'secondaa', 2015, '32x20 cm', 'edeededededed', 1000.00, 'In esposizione', 24, 1, 1, 'pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(11, 'secondaaa', 2015, '32x20 cm', 'dcdcecrc', 500.00, 'In esposizione', 29, 1, 1, 'pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(12, 'terza', 2005, '32x20 cm', 'terza opera', 1500.00, 'In esposizione', 24, 2, 1, 'scultura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(13, 'quarta', 2015, '32x20 cm', 'quarta opera', 300.00, 'In esposizione', 24, 3, 1, 'fotografia', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(14, 'quinta', 2005, '32x20 cm', 'fnjrjrfjrnjfnrfjrnfrfnjfrnjrjnf', 500.00, 'In esposizione', 29, 3, 1, 'fotografia', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(16, 'settima', 2008, '32x20 cm', 'hvhhcbdbchcbdhc', 600.00, 'In esposizione', 24, 1, 1, 'pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(17, 'settima', 2005, '32x20 cm', 'wjsjcjdehjehjdehjejdjehdjeh', 100.00, 'In esposizione', 29, 2, 1, 'Scultura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(18, 'settimaa', 2005, '32x20 cm', 'kjfrkfjrkfjkrjfkrjfkrf', 500.00, 'In esposizione', 29, 3, 1, 'Fotografia', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm'),
(19, 'settimaaa', 2005, '32x20 cm', 'hgxhgchdgchdgdghchd', 500.00, 'In esposizione', 24, 1, 1, 'Pittura', 'olio su tela', 'Venduta', 32.00, 20.00, 18.00, 'cm');

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
(16, 1),
(17, 1),
(18, 1),
(19, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `id` int(11) NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `idUtente` int(11) NOT NULL,
  `idOpera` int(11) NOT NULL,
  `tipo` enum('diretto','offerta') NOT NULL DEFAULT 'diretto'
  `indirizzo_spedizione` varchar(255) DEFAULT NULL,
  `metodo_pagamento` varchar(50) DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`id`, `data`, `idUtente`, `idOpera`, `tipo`) VALUES
(1, '2026-07-02 22:15:32', 29, 6, 'diretto'),
(2, '2026-07-02 22:20:31', 24, 5, 'diretto'),
(3, '2026-07-02 22:20:56', 24, 3, 'diretto'),
(4, '2026-07-02 22:22:03', 24, 4, 'diretto'),
(5, '2026-07-02 22:23:06', 27, 9, 'diretto'),
(6, '2026-07-02 22:30:03', 27, 10, 'diretto'),
(7, '2026-07-02 23:02:31', 27, 11, 'diretto'),
(8, '2026-07-04 22:04:26', 27, 13, 'diretto'),
(10, '2026-07-06 23:24:34', 24, 17, 'diretto'),
(11, '2026-07-06 23:25:02', 24, 18, 'offerta'),
(12, '2026-07-07 23:18:00', 27, 19, 'diretto');

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
(1, 'a@b', '5d3748873a1baa8b78e04e2765044798bbd483ebd827f610f2679e600ed560e9', '2026-07-07 22:26:04', 0),
(2, 'a@b', 'd614c471de69d7685af94a2f20f6b7ba5550a2011a5ba914dc414d3c11328b62', '2026-07-07 22:27:29', 0),
(3, 'a@b', 'c690852dfe5cb41b1a07e2c4a2f42c1a168a405cc1f4dca14a136bfe78e5dc3b', '2026-07-07 22:30:19', 0),
(4, 'a@b', '8dfc24e5f754bc08f022ce37791ae3639351d3b013d257a82969a53156e66671', '2026-07-07 22:37:37', 0),
(5, 'l@dz', '5d858a85e4b3d589df52a9aa9c9b6cb8a6b71a457d276bad5294744d335432a2', '2026-07-08 12:26:28', 0),
(6, 'l@dz', 'af8bbc4fb6d0875b220663d27634d30fad7d556bb19bbf9205a3ecaa1a9d03dd', '2026-07-08 12:51:56', 0),
(7, 'l@dz', 'c996343fcd2e31350fe534290a82c8976b214bd2332e43a3f514e6ee09638c0c', '2026-07-08 12:53:19', 0),
(8, 'l@dz', '61fa682f7c34593cb6f0cde597a9711610830d13bba8836cf89baa6083288dce', '2026-07-08 13:00:40', 0);

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
(1, 'temporaneo', '2026-07-01', '2026-07-02', '', 18),
(2, 'temporaneo', '2026-07-01', '2026-07-02', '', 18),
(3, 'temporaneo', '2026-07-01', '2026-07-02', '', 18);

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
(1, 'lkrlfkrkjfjrnjnjcnjcnrjnjrnjnjrnjr', '', '2026-06-30', 'Archiviata', 'Profilo', 18, 27),
(2, 'njsncjdnjdnjncjdncjdcnd', '', '2026-06-30', 'Archiviata', 'Opera', 18, 27),
(3, 'knkdcncdcdcdc', '', '2026-06-30', 'Archiviata', 'Profilo', 18, 27),
(4, 'n nmnn b', '', '2026-07-01', 'Archiviata', 'Commento', 18, 24),
(5, 'jswwwwwwwwwwwwwwwwwwwwwwwwwwwwww', '', '2026-07-01', 'Archiviata', 'Opera', 18, 27),
(6, 'nnm nbnbnbn', '', '2026-07-01', 'Archiviata', 'Profilo', 29, 27),
(7, 'jhjhjhjshsjhhsjh', '', '2026-07-05', 'Archiviata', 'Profilo', 24, 27),
(8, 'xs mssnxxsxs', '', '2026-07-05', 'Aperta', 'Commento', 24, 27);

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
(4, 'Fotografia digitale');

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
(1, 'Patrick', 'Ranchi', '2004-09-25', 'Viale San Domenico 43F', 'patrick', '+39 3807431148', 'ranchipatrick04@gmail.com', '$2y$10$631zDDBz1JCNkm2I9yCz5u7KR3mfjKG7Folm5vSnEVLQY62w/UirW', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(2, 'mario', 'rio', '2004-12-28', 'sssssssssss', 'ssss', '+39 8378908735', 'd@e', '$2y$10$kZu9LEUqJQqWf0XGeHZnHeKGj/H4umxMrMS6P1tjubbmAJ9v.CGsS', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(3, 'jdhejdbh', 'dgvdxghv', '2007-01-02', 'xssssssssss', 'xsssssssssssss', '+39 8378908736', 'h@s', '$2y$10$uDzS2pF6.VT8iLofUffyiOqRhTIHQQvUkFY4/4BF/1CtZ2tqfYCDS', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(4, 'bhbhbh', 'v   hbbh', '2002-07-12', 'jnjjnjnjjjj', 'vhhhb', '+39 8378908732', 'j@j', '$2y$10$pawP6jK/MXyMtlya8gYYieo.oajWJRbEX/ayLRy94W.XdIG1NnX1a', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(5, 'bhbhbi', 'v   hbbu', '2002-07-02', 'jnjjnjnjjjj', 'vhhhbn', '+39 8378908731', 'j@p', '$2y$10$8x4olnmLkAev7pMazijtrOYjpgUhS8c8nt/jw4U5cFp1f3VmExvkO', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(6, 'Mario', 'Rossi', '2007-10-04', 'via roma 15', 'mariorossi', '+39 3807431147', 'mariorossi@gmail.com', '$2y$10$yJhq.9uDp8JRR29HwTsmyuZ824hCuzaLK1/8olHFNqR51lzDzyivS', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(7, 'ma', 'el', '2006-02-08', 'dcdcdcdcdcd', 'dcdcdcd', '+39 3456789035', 'js@d', '$2y$10$nfZRs7d3IXZvzhjRQ72om.C/jtjVSN9FgHr5is/B.rkBwedCVJxU.', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(8, 'djdj', 'xssx', '2007-01-02', 'xsxsxsxsxs', 'xssxsx', '+39 3672836241', 'sxsx@d', '$2y$10$qW719E8aZihez0PjfaBQIeOZHdASCZPtUM1Cjb1QusNnAlsnaouDe', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(9, 'dcd', 'wssw', '2007-01-09', 'eddddddddddddddd', 'deeeeeeeeee', '+39 7625808532', 'ws@s', '$2y$10$6N9DDNAFygU52Qv5UDjOU.h6v.Y7Bk0d1VmTxeFYP9zgWyIOhYEMC', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(10, 'njxj', 'xnsjjxs', '2007-02-20', 'encneejje', 'dejndenj', '+39 5642976479', 'k@dj', '$2y$10$dRbT9BIJMP9ep4HqCmaPguSTSwuqGY9AOJD4db.UlCTjHcDbUTgIm', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(11, 'edefr', 'frfr', '2006-02-08', 'vgvgcfxdxdxd', 'hbvfcf', '+39 0874683624', 'fffr@f', '$2y$10$quuR9SfZNPuitXhAwjfmBeHmLnCswDVLGm/OCuGjHir.g6AVN.23S', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(12, 'jjj', 'xsjxs', '2006-02-22', 'x snx dbdbhd', 'jenjnxjen', '+39 8756785322', 'j@k', '$2y$10$LjfNLfbKI8EQaQhrmNZCKeweqncKU30IMFOji72Bzle6h0C4b/8.i', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(13, 'gyg', 'njdejd', '2005-02-23', 'deedededede', 'deeed', '+39 6546808642', 'd@d', '$2y$10$e0Dhkrnc8osRkCNxMtOVHOvafs9g6OqwOrkYRnqYoO2ZA/u6KuAY.', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(14, 'whwud', 'dhwdbhe', '2007-01-31', 'edefrfrfrf', 'rfrfr', '+39 1234567890', 'h@j', '$2y$10$tl.zmEluzgv/gxa1D4ZDX.CnAEcLLT8QJTVWBdcj0dn0jC4tUmB0.', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(15, 'cvcf', 'cddcd', '2006-01-18', 'hbrbfhbfhrbfh', 'hdhevgv', '+39 0987654321', 'dv@r', '$2y$10$KjGNxt6GV9w40WSKFpZxN.iZQu/ETE8cDbZwnaj8a0cQyYE1juQ9u', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(16, 'efnvfjv', 'cbhrb', '2005-12-27', 'rfbrhbfrhbrh', 'frbfrhfh', '+39 4628972536', 'bhrfh@d', '$2y$10$Xmq7yHbV/89xiAz8iF0Qu.Gcnx1EBuhNsviEENPYMFIipnwYFCoGi', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(17, 'iop', 'eyw', '2006-02-15', 'ygyxdsawse', 'bhhbhbh', '+39 0000000000', 'ue@d', '$2y$10$.tixR1Ux752PvWE.zsFzaeAYw/fZbrxto8mFJrcQk0d8WzBmO2iji', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(18, 'Galileo', 'Bianchi', '2005-01-20', 'via firenze', 'galbia', '+39 3475621140', 'g@b', '$2y$10$ZRoZ5.MsczdZtc5t7EO2iu5VFXCtzkZX40KayaSOd2VR7BMmX8r0u', NULL, 'Bannato', 'Utente registrato', '2026-07-05 23:01:40'),
(19, 'p', 'e', '2006-01-03', 'via rpmsde', 'ehdnjdrn', '+39 1111111111', 'p@e', '$2y$10$AhM6..WILLCUuLyLMTl7.u/ciHuE4MQh/3Ta1KHAUCEfTzAmeQxnW', NULL, 'Attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(22, 'Admin', 'Gallerist', '1990-01-01', 'Via Admin 1, Roma', 'admin', '+39 0000000000', 'admin@gallerist.it', '$2y$10$T4DkrsqDn6BqnaK/UFn/IuOUmEx4vwebvTBFA3GBpy5xzUjmwKeaq', NULL, 'attivo', 'Amministratore', '2026-07-05 23:01:40'),
(23, 'tommaso', 'uno', '2007-10-04', 'via san domenico', 'tommasouno', '+39 1209873456', 't@u', '$2y$10$0PhUqK01XUXfJN0Hy7JlzOm.oWgfz6/O4Uw7Yx0/Cw8lVyvssjoBy', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(24, 't', 'u', '2004-12-29', 'via san dom', 'tommasor', '+39 7863460954', 't@r', '$2y$10$sBgsylBQfFKQTop5fL8a6.PW1pjgxmx9mKZzaJwGLN7QozA6/JQi.', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(25, 'a', 'r', '2006-01-27', 'viale sand', 'angelicar', '+39 3547895432', 'a@r', '$2y$10$6VyAv7bT2ykoSdsHTtTi.ODYg2v5G1kTwxwaCWGHe4mappAcNjn9.', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(26, 'r', 'r', '2007-01-17', 'vialesannm', 'robertor', '+39 3387654378', 'r@r', '$2y$10$XYdJprygqkKbocP8p38nUuPKIY1k.qPOzjmEbE5hSUGsB6ICC2.r6', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(27, 'a', 'b', '2007-02-07', 'jxhxhjhdjehjd', 'angelobalint', '+39 1056826598', 'a@b', '$2y$10$6V5.NxwNNshlHgyIns/uEePmARPogtingWQoDtHEzDCZG.eYdTJuC', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(28, '', '', '2026-06-29', '', '', '', '', '$2y$10$80DHImbHqNF/sjBnOv8mVuU/Qk3JrV1F0So64mxqHwxX5Wba/9vZa', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(29, 'l', 'dz', '2006-06-09', 'ejehdejhdjehdj', 'lorenzodizio', '+39 6384792589', 'l@dz', '$2y$10$iWJz13c26XLiOTi8B7vVe.GQqOz3gLCvnlxEvhwmMjt4jSZaujBgW', '/Gallerist/uploads/profilo/ae9915a8d36277067d74d8243d28c6c3.jpeg', 'attivo', 'Artista', '2026-07-05 23:01:40'),
(30, 'krkjfkrjfk', 'jfkfkrjkf', '2006-01-04', 'fnvnmfvnfnmvmf', 'vfnmvnfv', '+39 3333333333', 'f@d', '$2y$10$x2JluzL6BTjeluQyr6O0guEYUHsDQS3t9FW.Xw74ZVeZZpX6yC3GC', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(31, 'v', 'v', '2006-01-31', 'vvvvvvvvvvvvvvvv', 'vvvvvvvvv', '+39 1294863875', 'v@v', '$2y$10$RkaNUCNpqIdeFJLGPI9V3Omg/HaAktGcKgqusq/erx2lockNHoMla', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(32, 'b', 'b', '2004-01-13', 'sxbhsxbbxnsbxns', 'hwhwghwg', '+39 7456892574', 'b@b', '$2y$10$QK/cpLaw49qhfmOx5IvFi.zmmVEQULkx0uztQ958GIIB/y1rfMW7q', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(33, 'gab', 'car', '2004-01-22', 'hjhjdcjdhjchdj', 'gabcar', '+39 3388394625', 'gab@car', '$2y$10$Xg.wr3NyecspEy/fgKQ72u8l7l22znITAV5ByCBZpDnKg8ihsmglW', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(34, 'n', 'n', '2006-06-06', 'bnnnnnnnnn', 'nnnnnn', '+39 4444444444', 'n@n', '$2y$10$sMXZrYPSmDMddaw1iMLcoOxiBZhF5DIywQd0F0pUGykU60vaLiQJi', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(35, 's', 's', '2005-02-09', 'ssssssssssss', 'sssssssssss', '+39 5555555555', 's@s', '$2y$10$pwlP5KbRnraW4mJ6oWJhcegMtmg5JqH3FAQw8ggeuzRMhKs.cBH1q', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(36, 'g', 'g', '2005-12-27', 'gggggggggggggg', 'gggggggggg', '+39 7549374582', 'g@g', '$2y$10$qQDlzJMpoOnrz5.m7EWI7u21ChXX6tWi3NTP1SiRVyKQHwuIxd2xO', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(37, 'l', 'p', '2006-05-09', 'jdjcjdhcdjhcdh', 'cdjhhjdhjc', '+39 7777777777', 'l@p', '$2y$10$yVGExgqOK5JfgRWLYU7osu.FOBmaeSHOQObvYMW7xroS5c/s8beIu', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(38, 't', 't', '2004-02-04', 'ttttttttttt', 'tttttttt', '+39 4572947563', 't@t', '$2y$10$GFWh2BCZ79Yk5Lb9FktmP.vUlxYadoSRnnQAoHlON.ZBPhLQkx3ey', NULL, 'attivo', 'Utente registrato', '2026-07-05 23:01:40'),
(39, 't', 's', '2006-06-07', 'tststststs', 'tststst', '+39 7344444444', 't@s', '$2y$10$im/g9p2PkXj3hyzPeGe4tOr0dcVwsCxKVqqcmDgf4p9hjB1FzncCS', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(40, 'q', 'w', '2006-01-03', 'hhdghgedheheedehdhegdh', 'edhbehdehgdeh', '+39 9999999999', 'q@w', '$2y$10$0.HHAIjkHE/Ytjyy77X1hOH/z.Mo2s9/LDCbFE023bkPFnFKMjUKy', NULL, 'attivo', 'Artista', '2026-07-05 23:01:40'),
(42, 'lorenzo', 'di zio', '2005-01-04', 'via roma 13', 'lorenzodizio1', '+39 1235642365', 'lorenzo@dizio.com', '$2y$10$HkA6KyxQ6nR1B73W1dMiROgHU.5fraSnoIftnc3G328NzkqjtIg1S', NULL, 'attivo', 'Utente registrato', '2026-07-08 12:01:44'),
(43, 'patrick', 'ranchi', '2006-02-09', 'via napoli 25', 'patrickranchi', '+39 3807431234', 'patrick@ranchi.com', '$2y$10$KNjLJrYhc3MzEjlAJJstrumoCmdhMIXcoowFsyhqkCvJh/VvY8qH2', '/Gallerist/uploads/profilo/15bff26ccb52d80e6d140aa972b260e7.jpeg', 'attivo', 'Utente registrato', '2026-07-08 12:03:34');

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
(1, '/Gallerist/utente/logout', '2026-07-04 22:19:00', NULL),
(2, '/Gallerist/utente/login', '2026-07-04 22:19:00', NULL),
(3, '/Gallerist/Utente/verifica', '2026-07-04 22:19:06', NULL),
(4, '/Gallerist/Admin/dashboard', '2026-07-04 22:19:06', NULL),
(5, '/Gallerist/Admin/mostraSegnalazione', '2026-07-04 22:19:11', NULL),
(6, '/Gallerist/Admin/mostraValidazione', '2026-07-04 22:19:15', NULL),
(7, '/Gallerist/Admin/gestisciCategorie', '2026-07-04 22:19:19', NULL),
(8, '/Gallerist/Admin/bannati', '2026-07-04 22:19:23', NULL),
(9, '/Gallerist/Admin/statistiche', '2026-07-04 22:19:27', NULL),
(10, '/Gallerist/Admin/statistiche', '2026-07-04 22:20:06', NULL),
(11, '/Gallerist/Admin/statistiche', '2026-07-04 22:20:10', NULL),
(12, '/Gallerist/utente/logout', '2026-07-04 22:21:33', NULL),
(13, '/Gallerist/utente/login', '2026-07-04 22:21:33', NULL),
(14, '/Gallerist/Utente/verifica', '2026-07-04 22:21:39', NULL),
(15, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 22:21:39', NULL),
(16, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 22:21:42', NULL),
(17, '/Gallerist/', '2026-07-04 22:21:45', NULL),
(18, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:21:47', NULL),
(19, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:21:55', NULL),
(20, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:21:58', NULL),
(21, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 22:21:59', NULL),
(22, '/Gallerist/utente/logout', '2026-07-04 22:22:07', NULL),
(23, '/Gallerist/utente/login', '2026-07-04 22:22:07', NULL),
(24, '/Gallerist/Utente/verifica', '2026-07-04 22:22:15', NULL),
(25, '/Gallerist/Admin/dashboard', '2026-07-04 22:22:16', NULL),
(26, '/Gallerist/Admin/statistiche', '2026-07-04 22:22:20', NULL),
(27, '/Gallerist/Admin/statistiche', '2026-07-04 22:22:22', NULL),
(28, '/Gallerist/Admin/statistiche', '2026-07-04 22:23:14', NULL),
(29, '/Gallerist/Admin/statistiche', '2026-07-04 22:25:41', NULL),
(30, '/Gallerist/Admin/statistiche', '2026-07-04 22:36:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(31, '/Gallerist/Admin/statistiche', '2026-07-04 22:36:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(32, '/Gallerist/Admin/statistiche', '2026-07-04 22:38:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(33, '/Gallerist/Admin/statistiche', '2026-07-04 22:38:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(34, '/Gallerist/Admin/statistiche', '2026-07-04 22:39:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(35, '/Gallerist/Admin/statistiche', '2026-07-04 22:43:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(36, '/Gallerist/Admin/statistiche', '2026-07-04 22:46:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(37, '/Gallerist/Admin/statistiche', '2026-07-04 22:47:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(38, '/Gallerist/Gallerist/Utente/verifica', '2026-07-04 22:53:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(39, '/Gallerist/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:53:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(40, '/Gallerist/Gallerist/utente/login', '2026-07-04 22:53:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(41, '/Gallerist/Admin/statistiche', '2026-07-04 22:56:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(42, '/Gallerist/', '2026-07-04 22:56:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(43, '/Gallerist/catalogo/filtraCatalogo', '2026-07-04 22:56:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(44, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 22:56:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(45, '/Gallerist/', '2026-07-04 22:56:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(46, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:57:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(47, '/Gallerist/', '2026-07-04 22:57:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(48, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:57:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(49, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-04 22:57:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(50, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-04 22:57:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(51, '/Gallerist/', '2026-07-04 22:57:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(52, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 22:57:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(53, '/Gallerist/utente/logout', '2026-07-04 22:57:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(54, '/Gallerist/utente/login', '2026-07-04 22:57:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(55, '/Gallerist/Admin/dashboard', '2026-07-04 22:57:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(56, '/Gallerist/Utente/login', '2026-07-04 22:57:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(57, '/Gallerist/Utente/verifica', '2026-07-04 22:57:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(58, '/Gallerist/Admin/dashboard', '2026-07-04 22:57:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(59, '/Gallerist/Admin/statistiche', '2026-07-04 22:57:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(60, '/Gallerist/Admin/statistiche', '2026-07-04 22:57:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(61, '/Gallerist/Admin/statistiche', '2026-07-04 22:57:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(62, '/Gallerist/utente/logout', '2026-07-04 22:58:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(63, '/Gallerist/utente/login', '2026-07-04 22:58:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(64, '/Gallerist/Utente/verifica', '2026-07-04 22:58:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(65, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 22:58:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(66, '/Gallerist/', '2026-07-04 22:58:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(67, '/Gallerist/catalogo/filtraCatalogo', '2026-07-04 22:58:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(68, '/Gallerist/', '2026-07-04 22:58:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(69, '/Gallerist/catalogo/filtraCatalogo', '2026-07-04 22:58:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(70, '/Gallerist/', '2026-07-04 22:58:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(71, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 22:58:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(72, '/Gallerist/', '2026-07-04 22:58:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(73, '/Gallerist/utente/logout', '2026-07-04 22:58:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(74, '/Gallerist/utente/login', '2026-07-04 22:58:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(75, '/Gallerist/Utente/verifica', '2026-07-04 22:59:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(76, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 22:59:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(77, '/Gallerist/utente/profilo', '2026-07-04 22:59:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(78, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-04 22:59:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(79, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-04 22:59:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(80, '/Gallerist/', '2026-07-04 23:05:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(81, '/Gallerist/utente/logout', '2026-07-04 23:06:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(82, '/Gallerist/utente/login', '2026-07-04 23:06:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(83, '/Gallerist/Utente/verifica', '2026-07-04 23:06:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(84, '/Gallerist/Utente/verifica', '2026-07-04 23:06:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(85, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 23:06:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(86, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 23:06:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(87, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-04 23:06:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(88, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 23:06:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(89, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 23:06:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(90, '/Gallerist/', '2026-07-04 23:06:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(91, '/Gallerist/catalogo/filtraCatalogo', '2026-07-04 23:06:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(92, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 23:06:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(93, '/Gallerist/', '2026-07-04 23:06:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(94, '/Gallerist/utente/logout', '2026-07-04 23:07:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(95, '/Gallerist/utente/login', '2026-07-04 23:07:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(96, '/Gallerist/Utente/verifica', '2026-07-04 23:07:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(97, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 23:07:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(98, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 23:07:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(99, '/Gallerist/', '2026-07-04 23:07:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(100, '/Gallerist/utente/profilo', '2026-07-04 23:07:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(101, '/Gallerist/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-04 23:07:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(102, '/Gallerist/utente/profilo', '2026-07-04 23:07:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(103, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-04 23:08:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(104, '/Gallerist/utente/logout', '2026-07-04 23:08:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(105, '/Gallerist/utente/login', '2026-07-04 23:08:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(106, '/Gallerist/Utente/verifica', '2026-07-04 23:08:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(107, '/Gallerist/Admin/dashboard', '2026-07-04 23:08:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(108, '/Gallerist/Admin/mostraValidazione', '2026-07-04 23:08:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(109, '/Gallerist/Admin/verificaArtista', '2026-07-04 23:08:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(110, '/Gallerist/Admin/dashboard', '2026-07-04 23:08:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(111, '/Gallerist/Admin/mostraSegnalazione', '2026-07-04 23:08:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(112, '/Gallerist/Admin/processaModerazione', '2026-07-04 23:08:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(113, '/Gallerist/Admin/dashboard', '2026-07-04 23:08:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(114, '/Gallerist/Admin/gestisciCategorie', '2026-07-04 23:08:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(115, '/Gallerist/Admin/tutteSegnalazioni', '2026-07-04 23:09:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(116, '/Gallerist/Admin/bannati', '2026-07-04 23:09:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(117, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(118, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(119, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(120, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(121, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(122, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(123, '/Gallerist/Admin/statistiche', '2026-07-04 23:09:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(124, '/Gallerist/Admin/dashboard', '2026-07-04 23:09:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(125, '/Gallerist/Admin/dashboard', '2026-07-04 23:10:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(126, '/Gallerist/', '2026-07-04 23:10:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(127, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 23:10:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(128, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-04 23:10:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(129, '/Gallerist/utente/logout', '2026-07-04 23:10:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(130, '/Gallerist/utente/login', '2026-07-04 23:10:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(131, '/Gallerist/utente/registrazione', '2026-07-04 23:10:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(132, '/Gallerist/utente/verificaRegistrazione', '2026-07-04 23:12:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(133, '/Gallerist/utente/verificaRegistrazione', '2026-07-04 23:12:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(134, '/Gallerist/utente/verificaRegistrazione', '2026-07-04 23:13:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(135, '/Gallerist/utente/registrazione', '2026-07-04 23:13:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(136, '/Gallerist/utente/login', '2026-07-04 23:13:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(137, '/Gallerist/Utente/verifica', '2026-07-04 23:13:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(138, '/Gallerist/Admin/dashboard', '2026-07-04 23:13:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(139, '/Gallerist/Admin/mostraValidazione', '2026-07-04 23:13:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(140, '/Gallerist/uploads/documenti/07_ProgettoEsame_step_4%20(1).pdf', '2026-07-04 23:13:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(141, '/Gallerist/uploads/documenti/07_ProgettoEsame_step_4%20(1).pdf', '2026-07-04 23:14:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(142, '/Gallerist/', '2026-07-04 23:14:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(143, '/Gallerist/utente/logout', '2026-07-04 23:14:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(144, '/Gallerist/utente/login', '2026-07-04 23:14:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(145, '/Gallerist/utente/registrazione', '2026-07-04 23:14:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(146, '/Gallerist/utente/verificaRegistrazione', '2026-07-04 23:16:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(147, '/Gallerist/utente/login', '2026-07-04 23:16:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(148, '/Gallerist/Utente/verifica', '2026-07-04 23:16:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(149, '/Gallerist/Admin/dashboard', '2026-07-04 23:16:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(150, '/Gallerist/Admin/mostraValidazione', '2026-07-04 23:16:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(151, '/Gallerist/Admin/mostraValidazione', '2026-07-04 23:16:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(152, '/Gallerist/Admin/dashboard', '2026-07-04 23:16:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(153, '/Gallerist/Admin/statistiche', '2026-07-04 23:16:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(154, '/Gallerist/Admin/statistiche', '2026-07-04 23:16:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(155, '/Gallerist/Gallerist/Admin/statistiche', '2026-07-04 23:17:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(156, '/Gallerist/Admin/dashboard', '2026-07-04 23:17:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(157, '/Gallerist/Admin/mostraValidazione', '2026-07-04 23:17:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(158, '/Gallerist/Admin/dashboard', '2026-07-04 23:17:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(159, '/Gallerist/', '2026-07-04 23:17:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(160, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 23:18:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(161, '/Gallerist/utente/logout', '2026-07-04 23:19:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(162, '/Gallerist/utente/login', '2026-07-04 23:19:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(163, '/Gallerist/Utente/verifica', '2026-07-04 23:19:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(164, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 23:19:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(165, '/Gallerist/utente/profilo', '2026-07-04 23:19:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(166, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-04 23:19:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(167, '/Gallerist/gestioneProfiloPortfolio/salvaOpera', '2026-07-04 23:20:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(168, '/Gallerist/utente/profilo', '2026-07-04 23:20:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(169, '/Gallerist/', '2026-07-04 23:20:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(170, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-04 23:20:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(171, '/Gallerist/catalogo/visualizzaDettagliOpera/14', '2026-07-04 23:20:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(172, '/Gallerist/utente/logout', '2026-07-04 23:20:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(173, '/Gallerist/utente/login', '2026-07-04 23:20:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(174, '/Gallerist/Utente/verifica', '2026-07-04 23:20:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(175, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 23:20:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(176, '/Gallerist/catalogo/visualizzaDettagliOpera/14', '2026-07-04 23:20:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(177, '/Gallerist/compravendita/avviaPropostaOfferta/14', '2026-07-04 23:21:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(178, '/Gallerist/catalogo/visualizzaDettagliOpera/14', '2026-07-04 23:21:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(179, '/Gallerist/utente/logout', '2026-07-04 23:21:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(180, '/Gallerist/utente/login', '2026-07-04 23:21:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(181, '/Gallerist/Utente/verifica', '2026-07-04 23:21:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(182, '/Gallerist/catalogo/esploraCatalogo', '2026-07-04 23:21:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(183, '/Gallerist/utente/profilo', '2026-07-04 23:21:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(184, '/Gallerist/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-04 23:21:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(185, '/Gallerist/utente/profilo', '2026-07-04 23:21:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(186, '/Gallerist/utente/logout', '2026-07-04 23:21:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(187, '/Gallerist/utente/login', '2026-07-04 23:21:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(188, '/Gallerist/Utente/verifica', '2026-07-04 23:21:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(189, '/Gallerist/Admin/dashboard', '2026-07-04 23:21:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(190, '/Gallerist/Admin/statistiche', '2026-07-04 23:21:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(191, '/Gallerist/Admin/statistiche', '2026-07-04 23:21:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(192, '/Gallerist/Admin/statistiche', '2026-07-04 23:21:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(193, '/Gallerist/Admin/statistiche', '2026-07-04 23:22:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(194, '/Gallerist/Admin/statistiche', '2026-07-05 21:39:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(195, '/Gallerist/index.php', '2026-07-05 21:41:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(196, '/Gallerist/catalogo/esploracatalogo', '2026-07-05 21:41:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(197, '/Gallerist/', '2026-07-05 21:41:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(198, '/Gallerist/catalogo/esploracatalogo', '2026-07-05 21:42:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(199, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 21:42:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(200, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 21:42:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(201, '/Gallerist/utente/logout', '2026-07-05 21:42:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(202, '/Gallerist/utente/login', '2026-07-05 21:42:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(203, '/Gallerist/Utente/verifica', '2026-07-05 21:43:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(204, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 21:43:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(205, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-05 21:43:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(206, '/Gallerist/utente/logout', '2026-07-05 21:45:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(207, '/Gallerist/utente/login', '2026-07-05 21:45:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(208, '/Gallerist/Utente/verifica', '2026-07-05 21:45:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(209, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 21:45:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(210, '/Gallerist/utente/profilo', '2026-07-05 21:45:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(211, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-05 21:45:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(212, '/Gallerist/gestioneProfiloPortfolio/salvaOpera', '2026-07-05 21:46:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(213, '/Gallerist/utente/profilo', '2026-07-05 21:46:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(214, '/Gallerist/utente/logout', '2026-07-05 21:46:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(215, '/Gallerist/utente/login', '2026-07-05 21:46:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(216, '/Gallerist/Utente/verifica', '2026-07-05 21:46:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(217, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 21:46:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(218, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 21:46:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(219, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 21:46:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(220, '/Gallerist/utente/profilo', '2026-07-05 21:47:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(221, '/Gallerist/utente/img/default-avatar.png', '2026-07-05 21:47:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(222, '/Gallerist/', '2026-07-05 21:47:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(223, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 21:47:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(224, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:47:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(225, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:49:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(226, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:49:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(227, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:51:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(228, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:53:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(229, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 21:54:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(230, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 21:54:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(231, '/Gallerist/', '2026-07-05 21:56:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(232, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 21:56:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(233, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 21:56:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(234, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 21:56:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(235, '/Gallerist/utente/profilo', '2026-07-05 21:56:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(236, '/Gallerist/utente/img/default-avatar.png', '2026-07-05 21:56:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(237, '/Gallerist/utente/logout', '2026-07-05 21:56:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(238, '/Gallerist/utente/login', '2026-07-05 21:56:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(239, '/Gallerist/Utente/verifica', '2026-07-05 21:56:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(240, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 21:56:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(241, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 21:56:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(242, '/Gallerist/utente/profilo', '2026-07-05 21:56:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(243, '/Gallerist/utente/profilo', '2026-07-05 21:57:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(244, '/Gallerist/', '2026-07-05 21:57:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(245, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-05 21:57:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(246, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:57:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(247, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-05 21:57:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(248, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 21:57:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(249, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 21:57:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(250, '/Gallerist/catalogo/filtraCatalogo', '2026-07-05 21:57:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(251, '/Gallerist/catalogo/filtraCatalogo', '2026-07-05 21:58:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(252, '/Gallerist/catalogo/filtraCatalogo', '2026-07-05 21:58:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(253, '/Gallerist/', '2026-07-05 21:58:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(254, '/Gallerist/utente/logout', '2026-07-05 21:58:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(255, '/Gallerist/utente/login', '2026-07-05 21:58:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(256, '/Gallerist/', '2026-07-05 21:58:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(257, '/Gallerist/utente/registrazione', '2026-07-05 22:01:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(258, '/Gallerist/utente/registrazione', '2026-07-05 22:01:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(259, '/Gallerist/utente/registrazione', '2026-07-05 22:08:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(260, '/Gallerist/', '2026-07-05 22:09:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(261, '/Gallerist/catalogo/esploracatalogo', '2026-07-05 22:09:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(262, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 22:09:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(263, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 22:09:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(264, '/Gallerist/', '2026-07-05 22:09:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(265, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 22:09:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(266, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 22:09:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(267, '/Gallerist/compravendita/avviaAcquisto/15', '2026-07-05 22:09:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(268, '/Gallerist/utente/login', '2026-07-05 22:09:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(269, '/Gallerist/compravendita/avviaPropostaOfferta/15', '2026-07-05 22:10:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(270, '/Gallerist/utente/login', '2026-07-05 22:10:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(271, '/Gallerist/', '2026-07-05 22:10:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(272, '/Gallerist/utente/login', '2026-07-05 22:10:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(273, '/Gallerist/Utente/verifica', '2026-07-05 22:10:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(274, '/Gallerist/Admin/dashboard', '2026-07-05 22:10:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(275, '/Gallerist/Admin/statistiche', '2026-07-05 22:13:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(276, '/Gallerist/Admin/statistiche', '2026-07-05 22:13:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(277, '/Gallerist/utente/logout', '2026-07-05 22:17:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(278, '/Gallerist/utente/login', '2026-07-05 22:17:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(279, '/Gallerist/', '2026-07-05 22:17:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(280, '/Gallerist/catalogo/esploracatalogo', '2026-07-05 22:18:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(281, '/Gallerist/catalogo/filtraCatalogo', '2026-07-05 22:18:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(282, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-05 22:18:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(283, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-05 22:18:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(284, '/Gallerist/utente/registrazione', '2026-07-05 22:19:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(285, '/Gallerist/utente/verificaRegistrazione', '2026-07-05 22:21:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(286, '/Gallerist/utente/login', '2026-07-05 22:21:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(287, '/Gallerist/Utente/verifica', '2026-07-05 22:21:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(288, '/Gallerist/Utente/verifica', '2026-07-05 22:21:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(289, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 22:21:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(290, '/Gallerist/utente/profilo', '2026-07-05 22:23:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(291, '/Gallerist/utente/img/default-avatar.png', '2026-07-05 22:23:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(292, '/Gallerist/', '2026-07-05 22:23:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(293, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 22:23:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(294, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 22:23:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(295, '/Gallerist/compravendita/avviaAcquisto/15', '2026-07-05 22:23:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(296, '/Gallerist/compravendita/confermaAcquisto/15', '2026-07-05 22:23:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(297, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 22:23:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(298, '/Gallerist/utente/logout', '2026-07-05 22:23:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(299, '/Gallerist/utente/login', '2026-07-05 22:23:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(300, '/Gallerist/Utente/verifica', '2026-07-05 22:24:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(301, '/Gallerist/Utente/verifica', '2026-07-05 22:24:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(302, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 22:24:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(303, '/Gallerist/utente/profilo', '2026-07-05 22:24:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(304, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-05 22:24:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(305, '/Gallerist/gestioneProfiloPortfolio/salvaOpera', '2026-07-05 22:25:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(306, '/Gallerist/utente/profilo', '2026-07-05 22:25:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(307, '/Gallerist/utente/profilo', '2026-07-05 22:25:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(308, '/Gallerist/utente/logout', '2026-07-05 22:25:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(309, '/Gallerist/utente/login', '2026-07-05 22:25:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(310, '/Gallerist/Utente/verifica', '2026-07-05 22:25:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(311, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 22:25:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(312, '/Gallerist/catalogo/visualizzaDettagliOpera/16', '2026-07-05 22:25:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(313, '/Gallerist/compravendita/avviaPropostaOfferta/16', '2026-07-05 22:25:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(314, '/Gallerist/catalogo/visualizzaDettagliOpera/16', '2026-07-05 22:25:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(315, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-05 22:25:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(316, '/Gallerist/catalogo/visualizzaDettagliOpera/16', '2026-07-05 22:25:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(317, '/Gallerist/catalogo/visualizzaDettagliOpera/16', '2026-07-05 22:25:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(318, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-05 22:26:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(319, '/Gallerist/catalogo/visualizzaDettagliOpera/16', '2026-07-05 22:26:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(320, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 22:26:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(321, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 22:26:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(322, '/Gallerist/gestioneInterazioni/inviaSegnalazione', '2026-07-05 22:26:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(323, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 22:26:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(324, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 22:26:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(325, '/Gallerist/catalogo/visualizzaDettagliOpera/16', '2026-07-05 22:29:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(326, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 22:29:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(327, '/Gallerist/catalogo/visualizzaDettagliOpera/13', '2026-07-05 22:29:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(328, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-05 22:29:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(329, '/Gallerist/catalogo/visualizzaDettagliOpera/13', '2026-07-05 22:29:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(330, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-05 22:29:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(331, '/Gallerist/catalogo/visualizzaDettagliOpera/13', '2026-07-05 22:29:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(332, '/Gallerist/catalogo/visualizzaDettagliOpera/13', '2026-07-05 22:29:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(333, '/Gallerist/catalogo/visualizzaDettagliOpera/13', '2026-07-05 22:29:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(334, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 22:31:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(335, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 22:31:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(336, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 22:31:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(337, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-05 22:31:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(338, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 22:31:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(339, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-05 22:31:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(340, '/Gallerist/catalogo/visualizzaDettagliOpera/15', '2026-07-05 22:31:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(341, '/Gallerist/utente/logout', '2026-07-05 22:31:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(342, '/Gallerist/utente/login', '2026-07-05 22:31:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(343, '/Gallerist/Utente/verifica', '2026-07-05 22:31:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(344, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 22:31:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(345, '/Gallerist/utente/profilo', '2026-07-05 22:32:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(346, '/Gallerist/utente/modificaNickname', '2026-07-05 22:32:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(347, '/Gallerist/utente/profilo', '2026-07-05 22:32:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(348, '/Gallerist/utente/modificaBiografia', '2026-07-05 22:33:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(349, '/Gallerist/utente/profilo', '2026-07-05 22:33:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(350, '/Gallerist/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-05 22:33:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(351, '/Gallerist/utente/profilo', '2026-07-05 22:33:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(352, '/Gallerist/utente/logout', '2026-07-05 22:34:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(353, '/Gallerist/utente/login', '2026-07-05 22:34:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(354, '/Gallerist/Utente/verifica', '2026-07-05 22:34:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(355, '/Gallerist/Admin/dashboard', '2026-07-05 22:34:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(356, '/Gallerist/Admin/mostraValidazione', '2026-07-05 22:35:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(357, '/Gallerist/uploads/documenti/07_ProgettoEsame_step_4%20(1).pdf', '2026-07-05 22:35:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(358, '/Gallerist/Admin/dashboard', '2026-07-05 22:35:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(359, '/Gallerist/Admin/mostraValidazione', '2026-07-05 22:35:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(360, '/Gallerist/Admin/dashboard', '2026-07-05 22:35:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(361, '/Gallerist/Admin/mostraValidazione', '2026-07-05 22:35:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(362, '/Gallerist/Admin/verificaArtista', '2026-07-05 22:35:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(363, '/Gallerist/Admin/dashboard', '2026-07-05 22:35:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(364, '/Gallerist/Admin/bannati', '2026-07-05 22:35:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(365, '/Gallerist/Admin/dashboard', '2026-07-05 22:35:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(366, '/Gallerist/Admin/tutteSegnalazioni', '2026-07-05 22:36:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(367, '/Gallerist/Admin/dashboard', '2026-07-05 22:36:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(368, '/Gallerist/Admin/mostraSegnalazione', '2026-07-05 22:36:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(369, '/Gallerist/Admin/mostraSegnalazione', '2026-07-05 22:36:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(370, '/Gallerist/Admin/dashboard', '2026-07-05 22:36:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(371, '/Gallerist/Admin/mostraSegnalazione', '2026-07-05 22:36:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(372, '/Gallerist/Admin/processaModerazione', '2026-07-05 22:37:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(373, '/Gallerist/Admin/dashboard', '2026-07-05 22:37:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(374, '/Gallerist/Admin/gestisciCategorie', '2026-07-05 22:37:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(375, '/Gallerist/Admin/gestisciCategorie', '2026-07-05 22:37:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(376, '/Gallerist/Admin/gestisciCategorie', '2026-07-05 22:37:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(377, '/Gallerist/Admin/eliminaCategoria', '2026-07-05 22:37:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(378, '/Gallerist/Admin/gestisciCategorie', '2026-07-05 22:37:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(379, '/Gallerist/Admin/dashboard', '2026-07-05 22:37:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(380, '/Gallerist/Admin/statistiche', '2026-07-05 22:37:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(381, '/Gallerist/Admin/statistiche', '2026-07-05 22:39:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(382, '/Gallerist/Admin/statistiche', '2026-07-05 22:40:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(383, '/Gallerist/Admin/statistiche', '2026-07-05 22:45:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(384, '/Gallerist/Admin/statistiche', '2026-07-05 22:45:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(385, '/Gallerist/Admin/statistiche', '2026-07-05 22:45:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(386, '/Gallerist/Admin/statistiche', '2026-07-05 22:51:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(387, '/Gallerist/Admin/statistiche', '2026-07-05 22:51:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(388, '/Gallerist/Admin/statistiche', '2026-07-05 22:52:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(389, '/Gallerist/Admin/statistiche', '2026-07-05 22:52:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(390, '/Gallerist/Admin/statistiche', '2026-07-05 22:57:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(391, '/Gallerist/Admin/statistiche', '2026-07-05 23:13:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(392, '/Gallerist/Admin/statistiche', '2026-07-05 23:13:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(393, '/Gallerist/Gallerist/utente/logout', '2026-07-05 23:13:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(394, '/Gallerist/utente/login', '2026-07-05 23:13:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(395, '/Gallerist/Admin/statistiche', '2026-07-05 23:15:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(396, '/Gallerist/Utente/login', '2026-07-05 23:15:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(397, '/Gallerist/utente/login', '2026-07-05 23:15:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(398, '/Gallerist/Utente/verifica', '2026-07-05 23:15:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(399, '/Gallerist/Admin/dashboard', '2026-07-05 23:15:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(400, '/Gallerist/Admin/statistiche', '2026-07-05 23:16:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(401, '/Gallerist/Admin/statistiche', '2026-07-05 23:16:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(402, '/Gallerist/utente/logout', '2026-07-05 23:17:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(403, '/Gallerist/utente/login', '2026-07-05 23:17:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(404, '/Gallerist/Utente/verifica', '2026-07-05 23:18:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(405, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:18:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(406, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 23:18:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(407, '/Gallerist/utente/profilo', '2026-07-05 23:18:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(408, '/Gallerist/utente/logout', '2026-07-05 23:19:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(409, '/Gallerist/utente/login', '2026-07-05 23:19:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(410, '/Gallerist/Utente/verifica', '2026-07-05 23:19:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(411, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:19:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(412, '/Gallerist/utente/profilo', '2026-07-05 23:20:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(413, '/Gallerist/utente/img/default-avatar.png', '2026-07-05 23:20:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(414, '/Gallerist/utente/logout', '2026-07-05 23:23:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(415, '/Gallerist/utente/login', '2026-07-05 23:23:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(416, '/Gallerist/Utente/verifica', '2026-07-05 23:23:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(417, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:23:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(418, '/Gallerist/utente/profilo', '2026-07-05 23:23:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(419, '/Gallerist/utente/logout', '2026-07-05 23:23:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(420, '/Gallerist/utente/login', '2026-07-05 23:23:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(421, '/Gallerist/Utente/verifica', '2026-07-05 23:24:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(422, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:24:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(423, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 23:24:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(424, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 23:24:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(425, '/Gallerist/catalogo/visualizzaDettagliOpera/6', '2026-07-05 23:24:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(426, '/Gallerist/', '2026-07-05 23:27:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(427, '/Gallerist/utente/logout', '2026-07-05 23:27:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(428, '/Gallerist/utente/login', '2026-07-05 23:27:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(429, '/Gallerist/Utente/verifica', '2026-07-05 23:27:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(430, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:27:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(431, '/Gallerist/utente/profilo', '2026-07-05 23:27:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(432, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-05 23:27:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(433, '/Gallerist/', '2026-07-05 23:31:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(434, '/Gallerist/catalogo/esploracatalogo', '2026-07-05 23:31:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(435, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-05 23:31:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(436, '/Gallerist/', '2026-07-05 23:32:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(437, '/Gallerist/catalogo/filtraCatalogo', '2026-07-05 23:32:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(438, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 23:32:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(439, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 23:32:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(440, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-05 23:32:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(441, '/Gallerist/catalogo/filtraCatalogo', '2026-07-05 23:34:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(442, '/Gallerist/', '2026-07-05 23:34:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(443, '/Gallerist/utente/logout', '2026-07-05 23:34:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(444, '/Gallerist/utente/login', '2026-07-05 23:34:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(445, '/Gallerist/Utente/verifica', '2026-07-05 23:35:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(446, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:35:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(447, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 23:35:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(448, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 23:35:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(449, '/Gallerist/gestioneInterazioni/inviaSegnalazione', '2026-07-05 23:35:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(450, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-05 23:35:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(451, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-05 23:35:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(452, '/Gallerist/utente/logout', '2026-07-05 23:35:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(453, '/Gallerist/utente/login', '2026-07-05 23:35:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(454, '/Gallerist/Utente/verifica', '2026-07-05 23:35:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(455, '/Gallerist/Admin/dashboard', '2026-07-05 23:35:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(456, '/Gallerist/Admin/mostraSegnalazione', '2026-07-05 23:35:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(457, '/Gallerist/utente/logout', '2026-07-05 23:39:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(458, '/Gallerist/utente/login', '2026-07-05 23:39:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(459, '/Gallerist/Utente/verifica', '2026-07-05 23:39:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(460, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:39:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(461, '/Gallerist/utente/profilo', '2026-07-05 23:39:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(462, '/Gallerist/utente/profilo', '2026-07-05 23:43:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(463, '/Gallerist/utente/cambiaFotoProfilo', '2026-07-05 23:43:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(464, '/Gallerist/utente/profilo', '2026-07-05 23:43:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(465, '/Gallerist/gestioneProfiloPortfolio/eliminaProfilo', '2026-07-05 23:44:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(466, '/Gallerist/', '2026-07-05 23:44:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(467, '/Gallerist/utente/login', '2026-07-05 23:44:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(468, '/Gallerist/Utente/verifica', '2026-07-05 23:44:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(469, '/Gallerist/Utente/verifica', '2026-07-05 23:44:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(470, '/Gallerist/Utente/verifica', '2026-07-05 23:45:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(471, '/Gallerist/catalogo/esploraCatalogo', '2026-07-05 23:45:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(472, '/Gallerist/utente/profilo', '2026-07-05 23:45:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(473, '/Gallerist/index.php', '2026-07-06 21:07:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(474, '/Gallerist/utente/logout', '2026-07-06 21:07:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(475, '/Gallerist/utente/login', '2026-07-06 21:07:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(476, '/Gallerist/Utente/verifica', '2026-07-06 21:07:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(477, '/Gallerist/Admin/dashboard', '2026-07-06 21:07:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(478, '/Gallerist/Utente/verifica', '2026-07-06 21:07:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(479, '/Gallerist/Admin/dashboard', '2026-07-06 21:07:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(480, '/Gallerist/Admin/tutteSegnalazioni', '2026-07-06 21:07:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(481, '/Gallerist/Admin/tutteSegnalazioni', '2026-07-06 21:09:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(482, '/Gallerist/Admin/dashboard', '2026-07-06 21:10:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(483, '/Gallerist/Admin/mostraSegnalazione', '2026-07-06 21:10:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(484, '/Gallerist/Admin/mostraSegnalazione', '2026-07-06 21:12:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(485, '/Gallerist/Admin/mostraSegnalazione', '2026-07-06 21:14:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(486, '/Gallerist/', '2026-07-06 21:16:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(487, '/Gallerist/Admin/dashboard', '2026-07-06 21:16:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(488, '/Gallerist/Admin/statistiche', '2026-07-06 21:16:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(489, '/Gallerist/Admin/statistiche', '2026-07-06 21:20:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(490, '/Gallerist/Admin/dashboard', '2026-07-06 21:21:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(491, '/Gallerist/Admin/mostraValidazione', '2026-07-06 21:21:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(492, '/Gallerist/Admin/mostraValidazione', '2026-07-06 21:21:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(493, '/Gallerist/Admin/mostraValidazione', '2026-07-06 21:22:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(494, '/Gallerist/Admin/mostraValidazione', '2026-07-06 21:28:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(495, '/Gallerist/Admin/mostraValidazione', '2026-07-06 21:31:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(496, '/Gallerist/', '2026-07-06 21:41:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(497, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:41:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(498, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:41:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(499, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-06 21:41:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(500, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 21:41:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(501, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 21:41:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(502, '/Gallerist/utente/logout', '2026-07-06 21:44:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(503, '/Gallerist/utente/login', '2026-07-06 21:44:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(504, '/Gallerist/Utente/verifica', '2026-07-06 21:44:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(505, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 21:44:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(506, '/Gallerist/utente/profilo', '2026-07-06 21:44:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(507, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-06 21:44:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(508, '/Gallerist/gestioneProfiloPortfolio/salvaOpera', '2026-07-06 21:46:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(509, '/Gallerist/utente/profilo', '2026-07-06 21:46:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(510, '/Gallerist/', '2026-07-06 21:46:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(511, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:46:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(512, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:49:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(513, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:51:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(514, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:51:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(515, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:51:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(516, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:51:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(517, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:51:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(518, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:57:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(519, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 21:57:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(520, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 21:57:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(521, '/Gallerist/utente/profilo', '2026-07-06 21:57:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(522, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-06 21:57:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(523, '/Gallerist/gestioneProfiloPortfolio/salvaOpera', '2026-07-06 21:58:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(524, '/Gallerist/utente/profilo', '2026-07-06 21:58:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(525, '/Gallerist/', '2026-07-06 21:58:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(526, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 21:58:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(527, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 21:58:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(528, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 21:58:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(529, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:58:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(530, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 21:58:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(531, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 21:58:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(532, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 21:58:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(533, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 21:59:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(534, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 22:00:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(535, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 22:00:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(536, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 22:02:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(537, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 22:04:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(538, '/Gallerist/catalogo/esploracatalogo', '2026-07-06 22:05:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(539, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:05:46', 'm6svarsrpmtuhelnkp9gsggoq3');
INSERT INTO `visita` (`id`, `pagina`, `data`, `sessione`) VALUES
(540, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:05:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(541, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:05:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(542, '/Gallerist/catalogo/visualizzaDettagliOpera/17', '2026-07-06 22:05:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(543, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:06:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(544, '/Gallerist/utente/profilo', '2026-07-06 22:14:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(545, '/Gallerist/utente/profilo', '2026-07-06 22:14:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(546, '/Gallerist/utente/cambiaFotoProfilo', '2026-07-06 22:15:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(547, '/Gallerist/utente/profilo', '2026-07-06 22:15:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(548, '/Gallerist/utente/profilo', '2026-07-06 22:16:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(549, '/Gallerist/', '2026-07-06 22:21:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(550, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:21:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(551, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:21:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(552, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:21:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(553, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-06 22:21:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(554, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-06 22:21:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(555, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-06 22:24:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(556, '/Gallerist/', '2026-07-06 22:24:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(557, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:24:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(558, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:24:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(559, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:24:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(560, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-06 22:24:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(561, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-06 22:24:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(562, '/Gallerist/catalogo/visualizzaDettagliOpera/17', '2026-07-06 22:24:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(563, '/Gallerist/', '2026-07-06 22:26:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(564, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:26:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(565, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:26:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(566, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:26:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(567, '/Gallerist/Catalogo/filtraCatalogo', '2026-07-06 22:26:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(568, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-06 22:26:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(569, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(570, '/Gallerist/uploads/1d7a92873855c4001e4c23b431fed3fb.jpeg', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(571, '/Gallerist/uploads/3789298afd8a5839413929c9e25a1c0b.png', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(572, '/Gallerist/uploads/32f87dc01c84ec0f7d08791495b377a5.png', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(573, '/Gallerist/uploads/9415f8138d52ad162151d1809ced418b.png', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(574, '/Gallerist/uploads/8e877e052e9e501307568835937ae082.webp', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(575, '/Gallerist/uploads/16e3b2defd23c4900b710fa45863ec1b.webp', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(576, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(577, '/Gallerist/uploads/149b676b8db374084eaf7b67e5b5b4ef.png', '2026-07-06 22:26:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(578, '/Gallerist/', '2026-07-06 22:29:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(579, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:29:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(580, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:29:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(581, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:29:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(582, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 22:29:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(583, '/Gallerist/', '2026-07-06 22:30:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(584, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:30:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(585, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:30:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(586, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:30:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(587, '/Gallerist/', '2026-07-06 22:30:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(588, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:30:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(589, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:30:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(590, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:30:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(591, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:30:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(592, '/Gallerist/', '2026-07-06 22:30:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(593, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:30:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(594, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:30:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(595, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:30:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(596, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:30:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(597, '/Gallerist/', '2026-07-06 22:30:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(598, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:30:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(599, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:30:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(600, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:30:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(601, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:30:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(602, '/Gallerist/', '2026-07-06 22:30:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(603, '/Gallerist/uploads/80a9a15413860e735ed61872c2de0b35.jpeg', '2026-07-06 22:30:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(604, '/Gallerist/uploads/bee15987ff60687b598719537861f6d2.jpeg', '2026-07-06 22:30:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(605, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:30:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(606, '/Gallerist/', '2026-07-06 22:31:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(607, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:33:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(608, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(609, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(610, '/Gallerist/uploads/1d7a92873855c4001e4c23b431fed3fb.jpeg', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(611, '/Gallerist/uploads/3789298afd8a5839413929c9e25a1c0b.png', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(612, '/Gallerist/uploads/9415f8138d52ad162151d1809ced418b.png', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(613, '/Gallerist/uploads/32f87dc01c84ec0f7d08791495b377a5.png', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(614, '/Gallerist/uploads/8e877e052e9e501307568835937ae082.webp', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(615, '/Gallerist/uploads/16e3b2defd23c4900b710fa45863ec1b.webp', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(616, '/Gallerist/uploads/f305bdcaf10b54a75b3d09a37888c85c.webp', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(617, '/Gallerist/uploads/149b676b8db374084eaf7b67e5b5b4ef.png', '2026-07-06 22:33:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(618, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-06 22:37:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(619, '/Gallerist/catalogo/visualizzaProfiloArtista/img/default-avatar.png', '2026-07-06 22:37:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(620, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-06 22:38:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(621, '/Gallerist/utente/profilo', '2026-07-06 22:39:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(622, '/Gallerist/utente/logout', '2026-07-06 22:39:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(623, '/Gallerist/utente/login', '2026-07-06 22:39:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(624, '/Gallerist/Utente/verifica', '2026-07-06 22:39:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(625, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 22:39:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(626, '/Gallerist/catalogo/visualizzaProfiloArtista/29', '2026-07-06 22:39:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(627, '/Gallerist/', '2026-07-06 22:46:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(628, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 22:46:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(629, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 22:46:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(630, '/Gallerist/', '2026-07-06 22:46:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(631, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 22:46:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(632, '/Gallerist/', '2026-07-06 22:46:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(633, '/Gallerist/', '2026-07-06 22:47:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(634, '/Gallerist/utente/profilo', '2026-07-06 23:02:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(635, '/Gallerist/utente/profilo', '2026-07-06 23:06:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(636, '/Gallerist/utente/storicoVendite', '2026-07-06 23:06:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(637, '/Gallerist/utente/storicoVendite', '2026-07-06 23:07:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(638, '/Gallerist/utente/storicoVendite', '2026-07-06 23:21:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(639, '/Gallerist/utente/storicoVendite', '2026-07-06 23:23:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(640, '/Gallerist/utente/logout', '2026-07-06 23:23:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(641, '/Gallerist/utente/login', '2026-07-06 23:23:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(642, '/Gallerist/Utente/verifica', '2026-07-06 23:23:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(643, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 23:23:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(644, '/Gallerist/catalogo/visualizzaDettagliOpera/17', '2026-07-06 23:23:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(645, '/Gallerist/utente/profilo', '2026-07-06 23:24:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(646, '/Gallerist/utente/storicoVendite', '2026-07-06 23:24:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(647, '/Gallerist/utente/logout', '2026-07-06 23:24:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(648, '/Gallerist/utente/login', '2026-07-06 23:24:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(649, '/Gallerist/Utente/verifica', '2026-07-06 23:24:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(650, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 23:24:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(651, '/Gallerist/catalogo/visualizzaDettagliOpera/17', '2026-07-06 23:24:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(652, '/Gallerist/compravendita/avviaAcquisto/17', '2026-07-06 23:24:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(653, '/Gallerist/compravendita/confermaAcquisto/17', '2026-07-06 23:24:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(654, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 23:24:36', 'm6svarsrpmtuhelnkp9gsggoq3'),
(655, '/Gallerist/catalogo/visualizzaDettagliOpera/18', '2026-07-06 23:24:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(656, '/Gallerist/compravendita/avviaPropostaOfferta/18', '2026-07-06 23:24:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(657, '/Gallerist/catalogo/visualizzaDettagliOpera/18', '2026-07-06 23:24:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(658, '/Gallerist/utente/logout', '2026-07-06 23:24:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(659, '/Gallerist/utente/login', '2026-07-06 23:24:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(660, '/Gallerist/Utente/verifica', '2026-07-06 23:24:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(661, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 23:24:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(662, '/Gallerist/utente/profilo', '2026-07-06 23:24:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(663, '/Gallerist/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-06 23:25:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(664, '/Gallerist/utente/profilo', '2026-07-06 23:25:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(665, '/Gallerist/utente/storicoVendite', '2026-07-06 23:25:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(666, '/Gallerist/utente/storicoVendite', '2026-07-06 23:25:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(667, '/Gallerist/', '2026-07-06 23:25:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(668, '/Gallerist/', '2026-07-06 23:31:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(669, '/Gallerist/catalogo/filtraCatalogo', '2026-07-06 23:31:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(670, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-06 23:31:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(671, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-06 23:36:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(672, '/Gallerist/utente/profilo', '2026-07-06 23:36:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(673, '/Gallerist/utente/storicoVendite', '2026-07-06 23:36:33', 'm6svarsrpmtuhelnkp9gsggoq3'),
(674, '/Gallerist/utente/profilo', '2026-07-06 23:36:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(675, '/Gallerist/utente/profilo', '2026-07-06 23:37:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(676, '/Gallerist/utente/logout', '2026-07-06 23:37:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(677, '/Gallerist/utente/login', '2026-07-06 23:37:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(678, '/Gallerist/Utente/verifica', '2026-07-06 23:37:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(679, '/Gallerist/catalogo/esploraCatalogo', '2026-07-06 23:37:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(680, '/Gallerist/utente/profilo', '2026-07-06 23:37:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(681, '/Gallerist/index.php', '2026-07-07 21:24:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(682, '/Gallerist/utente/logout', '2026-07-07 21:24:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(683, '/Gallerist/utente/login', '2026-07-07 21:24:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(684, '/Gallerist/Utente/verifica', '2026-07-07 21:25:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(685, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 21:25:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(686, '/Gallerist/utente/logout', '2026-07-07 21:25:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(687, '/Gallerist/utente/login', '2026-07-07 21:25:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(688, '/Gallerist/utente/registrazione', '2026-07-07 21:25:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(689, '/Gallerist/utente/login', '2026-07-07 21:25:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(690, '/Gallerist/utente/recuperoPassword', '2026-07-07 21:25:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(691, '/Gallerist/utente/recuperoPassword', '2026-07-07 21:25:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(692, '/Gallerist/utente/inviaLinkReset', '2026-07-07 21:26:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(693, '/Gallerist/utente/inviaLinkReset', '2026-07-07 21:27:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(694, '/Gallerist/utente/inviaLinkReset', '2026-07-07 21:30:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(695, '/Gallerist/utente/inviaLinkReset', '2026-07-07 21:37:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(696, '/Gallerist/utente/login', '2026-07-07 21:37:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(697, '/Gallerist/Utente/verifica', '2026-07-07 21:37:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(698, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 21:37:48', 'm6svarsrpmtuhelnkp9gsggoq3'),
(699, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 21:45:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(700, '/Gallerist/', '2026-07-07 21:53:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(701, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 21:53:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(702, '/Gallerist/', '2026-07-07 22:05:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(703, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:05:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(704, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 22:05:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(705, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:06:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(706, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 22:06:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(707, '/Gallerist/', '2026-07-07 22:06:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(708, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:06:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(709, '/Gallerist/', '2026-07-07 22:06:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(710, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 22:07:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(711, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:07:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(712, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-07 22:07:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(713, '/Gallerist/catalogo/visualizzaDettagliOpera/13', '2026-07-07 22:07:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(714, '/Gallerist/catalogo/visualizzaDettagliOpera/10', '2026-07-07 22:07:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(715, '/Gallerist/catalogo/visualizzaDettagliOpera/10', '2026-07-07 22:07:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(716, '/Gallerist/utente/profilo', '2026-07-07 22:08:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(717, '/Gallerist/', '2026-07-07 22:09:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(718, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 22:09:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(719, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:09:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(720, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-07 22:09:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(721, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:09:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(722, '/Gallerist/utente/logout', '2026-07-07 22:09:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(723, '/Gallerist/utente/login', '2026-07-07 22:09:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(724, '/Gallerist/Utente/verifica', '2026-07-07 22:09:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(725, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:09:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(726, '/Gallerist/utente/profilo', '2026-07-07 22:09:58', 'm6svarsrpmtuhelnkp9gsggoq3'),
(727, '/Gallerist/utente/profilo', '2026-07-07 22:17:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(728, '/Gallerist/gestioneProfiloPortfolio/mostraFormOpera', '2026-07-07 22:19:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(729, '/Gallerist/gestioneProfiloPortfolio/salvaOpera', '2026-07-07 22:19:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(730, '/Gallerist/utente/profilo', '2026-07-07 22:19:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(731, '/Gallerist/utente/logout', '2026-07-07 22:20:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(732, '/Gallerist/utente/login', '2026-07-07 22:20:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(733, '/Gallerist/Utente/verifica', '2026-07-07 22:20:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(734, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:20:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(735, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:20:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(736, '/Gallerist/compravendita/avviaPropostaOfferta/19', '2026-07-07 22:20:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(737, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:20:23', 'm6svarsrpmtuhelnkp9gsggoq3'),
(738, '/Gallerist/utente/logout', '2026-07-07 22:20:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(739, '/Gallerist/utente/login', '2026-07-07 22:20:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(740, '/Gallerist/Utente/verifica', '2026-07-07 22:20:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(741, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:20:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(742, '/Gallerist/utente/profilo', '2026-07-07 22:20:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(743, '/Gallerist/gestioneProfiloPortfolio/rispondiOfferta', '2026-07-07 22:20:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(744, '/Gallerist/utente/profilo', '2026-07-07 22:20:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(745, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:20:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(746, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:28:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(747, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-07 22:28:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(748, '/Gallerist/utente/profilo', '2026-07-07 22:28:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(749, '/Gallerist/catalogo/visualizzaProfiloArtista/27', '2026-07-07 22:28:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(750, '/Gallerist/catalogo/visualizzaProfiloArtista/27', '2026-07-07 22:28:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(751, '/Gallerist/catalogo/visualizzaProfiloArtista/27', '2026-07-07 22:32:29', 'm6svarsrpmtuhelnkp9gsggoq3'),
(752, '/Gallerist/utente/logout', '2026-07-07 22:32:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(753, '/Gallerist/utente/login', '2026-07-07 22:32:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(754, '/Gallerist/Utente/verifica', '2026-07-07 22:32:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(755, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:32:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(756, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-07 22:32:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(757, '/Gallerist/', '2026-07-07 22:33:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(758, '/Gallerist/utente/profilo', '2026-07-07 22:33:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(759, '/Gallerist/utente/profilo', '2026-07-07 22:42:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(760, '/Gallerist/utente/profilo', '2026-07-07 22:43:52', 'm6svarsrpmtuhelnkp9gsggoq3'),
(761, '/Gallerist/', '2026-07-07 22:44:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(762, '/Gallerist/utente/profilo', '2026-07-07 22:44:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(763, '/Gallerist/utente/logout', '2026-07-07 22:44:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(764, '/Gallerist/utente/login', '2026-07-07 22:44:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(765, '/Gallerist/', '2026-07-07 22:44:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(766, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:44:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(767, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-07 22:44:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(768, '/Gallerist/utente/login', '2026-07-07 22:44:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(769, '/Gallerist/Utente/verifica', '2026-07-07 22:44:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(770, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:45:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(771, '/Gallerist/catalogo/visualizzaProfiloArtista/24', '2026-07-07 22:45:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(772, '/Gallerist/utente/profilo', '2026-07-07 22:45:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(773, '/Gallerist/catalogo/visualizzaProfiloArtista/27', '2026-07-07 22:45:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(774, '/Gallerist/catalogo/visualizzaDettagliOpera/2', '2026-07-07 22:45:16', 'm6svarsrpmtuhelnkp9gsggoq3'),
(775, '/Gallerist/utente/logout', '2026-07-07 22:46:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(776, '/Gallerist/utente/login', '2026-07-07 22:46:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(777, '/Gallerist/Utente/verifica', '2026-07-07 22:46:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(778, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:46:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(779, '/Gallerist/utente/profilo', '2026-07-07 22:46:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(780, '/Gallerist/utente/profilo', '2026-07-07 22:50:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(781, '/Gallerist/catalogo/visualizzaDettagliOpera/2', '2026-07-07 22:50:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(782, '/Gallerist/utente/logout', '2026-07-07 22:50:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(783, '/Gallerist/utente/login', '2026-07-07 22:50:20', 'm6svarsrpmtuhelnkp9gsggoq3'),
(784, '/Gallerist/Utente/verifica', '2026-07-07 22:50:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(785, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:50:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(786, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:50:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(787, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:50:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(788, '/Gallerist/utente/profilo', '2026-07-07 22:50:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(789, '/Gallerist/catalogo/visualizzaProfiloArtista/27', '2026-07-07 22:50:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(790, '/Gallerist/gestioneProfiloPortfolio/eliminaOpera', '2026-07-07 22:51:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(791, '/Gallerist/utente/profilo', '2026-07-07 22:51:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(792, '/Gallerist/utente/storicoVendite', '2026-07-07 22:51:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(793, '/Gallerist/', '2026-07-07 22:51:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(794, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:52:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(795, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:52:04', 'm6svarsrpmtuhelnkp9gsggoq3'),
(796, '/Gallerist/utente/logout', '2026-07-07 22:52:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(797, '/Gallerist/utente/login', '2026-07-07 22:52:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(798, '/Gallerist/Utente/verifica', '2026-07-07 22:52:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(799, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:52:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(800, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:52:53', 'm6svarsrpmtuhelnkp9gsggoq3'),
(801, '/Gallerist/gestioneInterazioni/salvaRecensione', '2026-07-07 22:53:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(802, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:53:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(803, '/Gallerist/utente/logout', '2026-07-07 22:53:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(804, '/Gallerist/utente/login', '2026-07-07 22:53:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(805, '/Gallerist/Utente/verifica', '2026-07-07 22:53:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(806, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:53:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(807, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:53:22', 'm6svarsrpmtuhelnkp9gsggoq3'),
(808, '/Gallerist/utente/profilo', '2026-07-07 22:53:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(809, '/Gallerist/catalogo/visualizzaProfiloArtista/29', '2026-07-07 22:53:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(810, '/Gallerist/', '2026-07-07 22:53:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(811, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 22:53:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(812, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:53:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(813, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:56:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(814, '/Gallerist/catalogo/visualizzaProfiloArtista/29', '2026-07-07 22:56:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(815, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 22:56:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(816, '/Gallerist/catalogo/visualizzaProfiloArtista/27', '2026-07-07 22:56:46', 'm6svarsrpmtuhelnkp9gsggoq3'),
(817, '/Gallerist/utente/logout', '2026-07-07 22:56:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(818, '/Gallerist/utente/login', '2026-07-07 22:56:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(819, '/Gallerist/Utente/verifica', '2026-07-07 22:57:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(820, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 22:57:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(821, '/Gallerist/utente/profilo', '2026-07-07 22:57:09', 'm6svarsrpmtuhelnkp9gsggoq3'),
(822, '/Gallerist/', '2026-07-07 22:57:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(823, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 22:57:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(824, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:57:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(825, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:58:30', 'm6svarsrpmtuhelnkp9gsggoq3'),
(826, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:58:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(827, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:59:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(828, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 22:59:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(829, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 23:00:38', 'm6svarsrpmtuhelnkp9gsggoq3'),
(830, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:01:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(831, '/Gallerist/utente/profilo', '2026-07-07 23:01:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(832, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:01:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(833, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 23:01:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(834, '/Gallerist/catalogo/visualizzaDettagliOpera/8', '2026-07-07 23:01:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(835, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 23:01:32', 'm6svarsrpmtuhelnkp9gsggoq3'),
(836, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:01:35', 'm6svarsrpmtuhelnkp9gsggoq3'),
(837, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:01:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(838, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:06:01', 'm6svarsrpmtuhelnkp9gsggoq3'),
(839, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:06:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(840, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 23:06:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(841, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:06:12', 'm6svarsrpmtuhelnkp9gsggoq3'),
(842, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:12:10', 'm6svarsrpmtuhelnkp9gsggoq3'),
(843, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 23:12:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(844, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:12:18', 'm6svarsrpmtuhelnkp9gsggoq3'),
(845, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:12:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(846, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:13:15', 'm6svarsrpmtuhelnkp9gsggoq3'),
(847, '/Gallerist/', '2026-07-07 23:13:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(848, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 23:13:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(849, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 23:13:26', 'm6svarsrpmtuhelnkp9gsggoq3'),
(850, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:13:39', 'm6svarsrpmtuhelnkp9gsggoq3'),
(851, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:15:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(852, '/Gallerist/', '2026-07-07 23:15:59', 'm6svarsrpmtuhelnkp9gsggoq3'),
(853, '/Gallerist/catalogo/filtraCatalogo', '2026-07-07 23:16:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(854, '/Gallerist/catalogo/visualizzaDettagliOpera/19', '2026-07-07 23:16:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(855, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:16:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(856, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:17:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(857, '/Gallerist/compravendita/avviaAcquisto/19', '2026-07-07 23:17:49', 'm6svarsrpmtuhelnkp9gsggoq3'),
(858, '/Gallerist/compravendita/confermaAcquisto/19', '2026-07-07 23:18:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(859, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 23:18:02', 'm6svarsrpmtuhelnkp9gsggoq3'),
(860, '/Gallerist/utente/logout', '2026-07-07 23:18:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(861, '/Gallerist/utente/login', '2026-07-07 23:18:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(862, '/Gallerist/Utente/verifica', '2026-07-07 23:18:24', 'm6svarsrpmtuhelnkp9gsggoq3'),
(863, '/Gallerist/Admin/dashboard', '2026-07-07 23:18:25', 'm6svarsrpmtuhelnkp9gsggoq3'),
(864, '/Gallerist/Admin/mostraValidazione', '2026-07-07 23:18:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(865, '/Gallerist/Admin/mostraValidazione', '2026-07-07 23:19:00', 'm6svarsrpmtuhelnkp9gsggoq3'),
(866, '/Gallerist/Admin/dashboard', '2026-07-07 23:19:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(867, '/Gallerist/Admin/mostraValidazione', '2026-07-07 23:19:13', 'm6svarsrpmtuhelnkp9gsggoq3'),
(868, '/Gallerist/Admin/dashboard', '2026-07-07 23:19:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(869, '/Gallerist/Admin/mostraSegnalazione', '2026-07-07 23:19:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(870, '/Gallerist/Admin/statistiche', '2026-07-07 23:19:27', 'm6svarsrpmtuhelnkp9gsggoq3'),
(871, '/Gallerist/utente/logout', '2026-07-07 23:19:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(872, '/Gallerist/utente/login', '2026-07-07 23:19:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(873, '/Gallerist/Utente/verifica', '2026-07-07 23:19:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(874, '/Gallerist/catalogo/esploraCatalogo', '2026-07-07 23:19:41', 'm6svarsrpmtuhelnkp9gsggoq3'),
(875, '/Gallerist/utente/profilo', '2026-07-07 23:19:43', 'm6svarsrpmtuhelnkp9gsggoq3'),
(876, '/Gallerist/utente/storicoVendite', '2026-07-07 23:19:45', 'm6svarsrpmtuhelnkp9gsggoq3'),
(877, '/Gallerist/utente/login', '2026-07-08 11:25:51', 'm6svarsrpmtuhelnkp9gsggoq3'),
(878, '/Gallerist/', '2026-07-08 11:26:03', 'm6svarsrpmtuhelnkp9gsggoq3'),
(879, '/Gallerist/utente/login', '2026-07-08 11:26:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(880, '/Gallerist/Utente/verifica', '2026-07-08 11:26:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(881, '/Gallerist/catalogo/esploraCatalogo', '2026-07-08 11:26:14', 'm6svarsrpmtuhelnkp9gsggoq3'),
(882, '/Gallerist/utente/logout', '2026-07-08 11:26:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(883, '/Gallerist/utente/login', '2026-07-08 11:26:17', 'm6svarsrpmtuhelnkp9gsggoq3'),
(884, '/Gallerist/utente/recuperoPassword', '2026-07-08 11:26:21', 'm6svarsrpmtuhelnkp9gsggoq3'),
(885, '/Gallerist/utente/inviaLinkReset', '2026-07-08 11:26:28', 'm6svarsrpmtuhelnkp9gsggoq3'),
(886, '/Gallerist/index.php', '2026-07-08 11:51:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(887, '/Gallerist/utente/login', '2026-07-08 11:51:47', 'm6svarsrpmtuhelnkp9gsggoq3'),
(888, '/Gallerist/utente/recuperoPassword', '2026-07-08 11:51:50', 'm6svarsrpmtuhelnkp9gsggoq3'),
(889, '/Gallerist/utente/inviaLinkReset', '2026-07-08 11:51:56', 'm6svarsrpmtuhelnkp9gsggoq3'),
(890, '/Gallerist/utente/inviaLinkReset', '2026-07-08 11:53:19', 'm6svarsrpmtuhelnkp9gsggoq3'),
(891, '/Gallerist/utente/inviaLinkReset', '2026-07-08 12:00:40', 'm6svarsrpmtuhelnkp9gsggoq3'),
(892, '/Gallerist/utente/login', '2026-07-08 12:00:42', 'm6svarsrpmtuhelnkp9gsggoq3'),
(893, '/Gallerist/utente/registrazione', '2026-07-08 12:00:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(894, '/Gallerist/utente/verificaRegistrazione', '2026-07-08 12:01:44', 'm6svarsrpmtuhelnkp9gsggoq3'),
(895, '/Gallerist/utente/login', '2026-07-08 12:01:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(896, '/Gallerist/Utente/verifica', '2026-07-08 12:02:05', 'm6svarsrpmtuhelnkp9gsggoq3'),
(897, '/Gallerist/catalogo/esploraCatalogo', '2026-07-08 12:02:06', 'm6svarsrpmtuhelnkp9gsggoq3'),
(898, '/Gallerist/utente/profilo', '2026-07-08 12:02:08', 'm6svarsrpmtuhelnkp9gsggoq3'),
(899, '/Gallerist/utente/logout', '2026-07-08 12:02:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(900, '/Gallerist/utente/login', '2026-07-08 12:02:11', 'm6svarsrpmtuhelnkp9gsggoq3'),
(901, '/Gallerist/utente/registrazione', '2026-07-08 12:02:31', 'm6svarsrpmtuhelnkp9gsggoq3'),
(902, '/Gallerist/utente/verificaRegistrazione', '2026-07-08 12:03:34', 'm6svarsrpmtuhelnkp9gsggoq3'),
(903, '/Gallerist/utente/login', '2026-07-08 12:03:37', 'm6svarsrpmtuhelnkp9gsggoq3'),
(904, '/Gallerist/Utente/verifica', '2026-07-08 12:03:54', 'm6svarsrpmtuhelnkp9gsggoq3'),
(905, '/Gallerist/catalogo/esploraCatalogo', '2026-07-08 12:03:55', 'm6svarsrpmtuhelnkp9gsggoq3'),
(906, '/Gallerist/utente/profilo', '2026-07-08 12:03:57', 'm6svarsrpmtuhelnkp9gsggoq3'),
(907, '/Gallerist/utente/logout', '2026-07-08 12:04:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(908, '/Gallerist/utente/login', '2026-07-08 12:04:07', 'm6svarsrpmtuhelnkp9gsggoq3'),
(909, '/Gallerist/utente/registrazione', '2026-07-08 12:04:10', 'm6svarsrpmtuhelnkp9gsggoq3');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `immagine`
--
ALTER TABLE `immagine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT per la tabella `offerta`
--
ALTER TABLE `offerta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `opera`
--
ALTER TABLE `opera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `provvedimento`
--
ALTER TABLE `provvedimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `tecnica`
--
ALTER TABLE `tecnica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `visita`
--
ALTER TABLE `visita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=910;

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
