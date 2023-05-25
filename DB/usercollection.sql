-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 25, 2023 alle 21:04
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

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `usercollection`
--
ALTER TABLE `usercollection`
  ADD PRIMARY KEY (`idManga`,`idUtente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
