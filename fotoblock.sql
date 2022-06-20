-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Jan 2022 um 22:35
-- Server-Version: 10.1.35-MariaDB
-- PHP-Version: 7.1.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fotoblock`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `pk` int(11) NOT NULL,
  `fileEnding` varchar(5) NOT NULL DEFAULT 'jpeg',
  `likes` bigint(20) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `hash` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`pk`, `fileEnding`, `likes`, `active`, `hash`) VALUES
(1, 'jpeg', 2, 1, '29bd428a71fcca8bd97ee34dd2d79e81'),
(2, 'jpeg', 9, 1, '8a62a8df71d3a93b4e2086e8bb8b110c'),
(3, 'jpeg', 3, 1, 'd6073642c5af5ae47c0fdd0e1a32b63f'),
(4, 'jpeg', 0, 1, '416aa2449eb0ef8af6ab1870aff9dd16'),
(6, 'jpeg', 5, 1, '73dd105f45b57531f55c1242311e575c'),
(7, 'jpeg', 0, 1, '6a759d03fa22d8f1ef516fef1b67904d'),
(8, 'jpeg', 2, 1, '8e9aa1608d1df021099b1a2595bc6942'),
(9, 'jpeg', 0, 1, 'dd0a120ba80f442ac4272adb3c7eac67'),
(10, 'jpeg', 6, 1, '7a433f0891bf19e5c5508fc061bf1deb'),
(11, 'jpeg', 4, 1, '89d387f45ce0d6c9c5b4574dde8cabad'),
(12, 'jpeg', 0, 1, '703586780c76e4804c170ae99989e679'),
(13, 'jpeg', 1, 1, '1c53acde66b0b4e76823f06b966abf0a'),
(14, 'jpeg', 0, 1, '93f8d8f9365fc03070ec656a3aff086f'),
(15, 'jpeg', 0, 1, '1089afeb65d417955b009c49dd93dbac'),
(16, 'jpeg', 1, 1, '1eae23bd69dc16a00c7c77a812fd9834'),
(17, 'jpeg', 0, 1, '637a12a3c2a1b121b60e0543915d7444'),
(18, 'jpeg', 1, 1, 'c3d6c911e7cd93a6859b0f498c84857a'),
(19, 'jpeg', 1, 1, '5f7e21fafd4e58a897cd6283e9b60eef'),
(20, 'jpeg', 1, 1, '6a4d43e261514cd1753834d1a30b52fe'),
(21, 'jpeg', 0, 1, '8da24a53388b3b82dd8913c244aa8339'),
(22, 'jpeg', 0, 1, '1bc1538970d4e733de5e86c9a801e78c'),
(23, 'jpeg', 1, 1, '6da75427acdea4540b3abb9c2fb73fd2'),
(24, 'jpeg', 1, 1, 'eb79a73b6bb3da94a42f246154a15063'),
(25, 'jpg', 0, 1, '125eeea2ceb111fbfcb5188c2082a677'),
(26, 'jpeg', 0, 1, 'ae46102f348dbc3524733bdf4c43b0a4'),
(27, 'jpeg', 1, 1, '130b51b68c736c43f6811acf668c1b9d'),
(28, 'jpeg', 0, 1, '9f8825bb7ad4f31dfd429992209c26cc'),
(29, 'jpeg', 1, 1, 'ec8f14ff7361f8d3d4ea0856da0bf6c7'),
(30, 'jpeg', 1, 1, '027ad0351b857d65d0274095b1c4de39'),
(31, 'jpeg', 0, 1, 'e759b0fbad169dfbda325f35df8938a4'),
(32, 'jpeg', 0, 1, '4ac5a51b80ed67cf1e5d890a299cc415'),
(33, 'jpeg', 1, 1, 'b7a3756e5ff0e10ca6fa9288f499cb3a'),
(34, 'jpeg', 1, 1, '306e2b679630c8ff4bef96cdc209c00d'),
(35, 'jpeg', 1, 1, 'c48d1f53674bba40f649450837c2e4d3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE `login` (
  `pk` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL COMMENT 'hashed'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `login`
--

INSERT INTO `login` (`pk`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$9fvgzEN.IYi7HiO6KXty3O0YMrFDAG0VyOYRftoZFAJ3/lNiU3AhS');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`pk`);

--
-- Indizes für die Tabelle `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`pk`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT für Tabelle `login`
--
ALTER TABLE `login`
  MODIFY `pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
