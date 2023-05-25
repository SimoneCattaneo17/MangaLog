-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 25, 2023 alle 21:03
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mangalog`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `usercollection`
--

CREATE TABLE `usercollection` (
  `idManga` varchar(255) NOT NULL,
  `idUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `usercollection`
--

INSERT INTO `usercollection` (`idManga`, `idUtente`) VALUES
('02860cdf-1020-40f1-a23f-2025d80f6290', 8),
('246f7bf2-d53e-4be5-a704-7921e74b2c57', 10),
('48576942-725b-4f1d-8e01-c4c0a5cd19df', 8),
('6b1eb93e-473a-4ab3-9922-1a66d2a29a4a', 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pswd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pswd`) VALUES
(7, 'simone', 'cattaneo.simone1708@gmail.com', '47eb752bac1c08c75e30d9624b3e58b7'),
(8, 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3'),
(9, 'giacomo', 'giacomo@giacomo.it', 'dcc4ed45e6d3fb1c13044163a464b44a'),
(10, 'edo', 'edo@edo.it', 'd2d612f72e42577991f4a5936cecbcc0'),
(11, 'nasa', 'nasa@nasa.it', '230c5c9d495e3bf392ef2b8098e51921'),
(12, 'ciccio', 'ciccio@ciccio.com', '27b4b5b01b0d1fcab2046369720ff75e'),
(13, 'mile', 'mile@mile.it', 'ea08e678edbf8892b8d67fc36f4a3bf9');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `usercollection`
--
ALTER TABLE `usercollection`
  ADD PRIMARY KEY (`idManga`,`idUtente`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
