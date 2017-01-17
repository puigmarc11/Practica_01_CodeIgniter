-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Temps de generació: 13-01-2017 a les 00:16:20
-- Versió del servidor: 5.7.11
-- Versió de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `bd_proves`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `comanda`
--

CREATE TABLE `comanda` (
  `id` int(11) NOT NULL,
  `taula` varchar(10) NOT NULL,
  `estat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `comanda`
--

INSERT INTO `comanda` (`id`, `taula`, `estat`) VALUES
(33, '1', 'tancada'),
(34, '2', 'oberta'),
(35, '3', 'oberta'),
(36, '5', 'oberta'),
(37, '1', 'oberta');

-- --------------------------------------------------------

--
-- Estructura de la taula `detall_comanda`
--

CREATE TABLE `detall_comanda` (
  `id` int(11) NOT NULL,
  `id_ordre` int(11) NOT NULL,
  `producte` varchar(15) NOT NULL,
  `quantitat` int(11) NOT NULL,
  `estat_prod` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `detall_comanda`
--

INSERT INTO `detall_comanda` (`id`, `id_ordre`, `producte`, `quantitat`, `estat_prod`) VALUES
(186, 60, 'p01', 3, 'cuinant'),
(187, 60, 'p05', 3, 'no_iniciat'),
(188, 60, 'p04', 1, 'cuinant'),
(189, 60, 'b02', 1, 'no_iniciat'),
(190, 60, 'b01', 1, 'no_iniciat'),
(191, 60, 'b02', 2, 'no_iniciat'),
(192, 61, 'p01', 1, 'no_iniciat'),
(193, 61, 'p02', 1, 'no_iniciat'),
(194, 61, 'p03', 1, 'no_iniciat'),
(195, 62, 'p01', 1, 'no_iniciat'),
(196, 62, 'p02', 1, 'no_iniciat'),
(197, 63, 'p03', 1, 'no_iniciat'),
(198, 63, 'p04', 1, 'no_iniciat'),
(199, 63, 'p02', 3, 'no_iniciat'),
(200, 62, 'p05', 5, 'no_iniciat'),
(201, 64, 'p05', 1, 'preparat'),
(202, 61, 'p04', 1, 'no_iniciat'),
(203, 61, 'p03', 3, 'no_iniciat'),
(204, 61, 'p01', 1, 'no_iniciat'),
(205, 61, 'p02', 2, 'no_iniciat'),
(206, 65, 'p03', 3, 'no_iniciat'),
(207, 65, 'p04', 1, 'no_iniciat');

-- --------------------------------------------------------

--
-- Estructura de la taula `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `taula` varchar(15) NOT NULL,
  `usuari` varchar(50) NOT NULL,
  `data` datetime NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `factura`
--

INSERT INTO `factura` (`id`, `taula`, `usuari`, `data`, `total`) VALUES
(11, '1', 'TEST', '2017-01-12 22:48:07', 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `ordre_comanda`
--

CREATE TABLE `ordre_comanda` (
  `id` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `ordre` int(11) NOT NULL,
  `estat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `ordre_comanda`
--

INSERT INTO `ordre_comanda` (`id`, `id_comanda`, `ordre`, `estat`) VALUES
(60, 33, 1, 'cuinant'),
(61, 33, 2, 'cua'),
(62, 34, 1, 'cua'),
(63, 35, 1, 'cua'),
(64, 36, 1, 'cua'),
(65, 37, 1, 'cua');

-- --------------------------------------------------------

--
-- Estructura de la taula `usuari`
--

CREATE TABLE `usuari` (
  `id` int(11) NOT NULL,
  `mail` text,
  `nom` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `camarer` varchar(1) NOT NULL,
  `cuiner` varchar(1) NOT NULL,
  `administrador` varchar(1) NOT NULL,
  `administrador_usuaris` varchar(1) NOT NULL,
  `actiu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `usuari`
--

INSERT INTO `usuari` (`id`, `mail`, `nom`, `password`, `camarer`, `cuiner`, `administrador`, `administrador_usuaris`, `actiu`) VALUES
(1, 'administrador@domini.local', 'Administrador', '12345', 'Y', 'Y', 'Y', 'Y', 1),
(13, 'camarer@domini.local', 'Camarer', '12345', 'Y', 'N', 'N', 'N', 1),
(14, 'cuiner@domini.local', 'cuiner', '12345', 'N', 'Y', 'N', 'N', 1),
(20, 'marcpuig123@gmail.com', 'marc', '12345', 'Y', 'Y', 'Y', 'N', 1);

--
-- Indexos per taules bolcades
--

--
-- Index de la taula `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `taula` (`taula`);

--
-- Index de la taula `detall_comanda`
--
ALTER TABLE `detall_comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comanda` (`id_ordre`);

--
-- Index de la taula `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`);

--
-- Index de la taula `ordre_comanda`
--
ALTER TABLE `ordre_comanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comanda` (`id_comanda`);

--
-- Index de la taula `usuari`
--
ALTER TABLE `usuari`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT per la taula `detall_comanda`
--
ALTER TABLE `detall_comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;
--
-- AUTO_INCREMENT per la taula `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT per la taula `ordre_comanda`
--
ALTER TABLE `ordre_comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT per la taula `usuari`
--
ALTER TABLE `usuari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Restriccions per taules bolcades
--

--
-- Restriccions per la taula `detall_comanda`
--
ALTER TABLE `detall_comanda`
  ADD CONSTRAINT `detall_comanda_ibfk_1` FOREIGN KEY (`id_ordre`) REFERENCES `ordre_comanda` (`id`);

--
-- Restriccions per la taula `ordre_comanda`
--
ALTER TABLE `ordre_comanda`
  ADD CONSTRAINT `ordre_comanda_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comanda` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
