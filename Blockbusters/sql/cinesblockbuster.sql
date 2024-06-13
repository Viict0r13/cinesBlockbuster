-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-06-2024 a las 18:32:16
-- Versión del servidor: 8.0.32
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cinesblockbuster`
--
CREATE DATABASE IF NOT EXISTS `cinesblockbuster` DEFAULT CHARACTER SET utf8mb4;
USE `cinesblockbuster`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas` (
  `ID` int NOT NULL,
  `IDAPIPELICULA` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `IDSALA` int NOT NULL,
  `CORREO` varchar(255) NOT NULL,
  `BUTACA` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
  `FECHA` date NOT NULL,
  `VALIDADA` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`ID`, `IDAPIPELICULA`, `IDSALA`, `CORREO`, `BUTACA`, `FECHA`, `VALIDADA`) VALUES
(4, 'tt0167260', 3, 'admin@cinesblockbuster.com', '1-1', '2024-06-11', 0),
(5, 'tt0167260', 3, 'victorandres.ha@gmail.com', '1-1', '2024-06-12', 0),
(6, 'tt9243946', 2, 'admin@cinesblockbuster.com', '1-1', '2024-06-12', 0),
(7, 'tt9243946', 2, 'admin@cinesblockbuster.com', '2-8', '2024-06-12', 0),
(8, 'tt9243946', 2, 'admin@cinesblockbuster.com', '2-4', '2024-06-12', 0),
(9, 'tt9243946', 2, 'admin@cinesblockbuster.com', '1-6', '2024-06-12', 0),
(10, 'tt9243946', 2, 'admin@cinesblockbuster.com', '2-3', '2024-06-12', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

DROP TABLE IF EXISTS `peliculas`;
CREATE TABLE `peliculas` (
  `idApi` varchar(15) CHARACTER SET utf8mb4 NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`idApi`, `estado`) VALUES
('tt0167260', 'A'),
('tt0241527', 'I'),
('tt0462538', 'I'),
('tt1201607', 'I'),
('tt1490017', 'A'),
('tt9243946', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

DROP TABLE IF EXISTS `salas`;
CREATE TABLE `salas` (
  `ID` int NOT NULL,
  `IDPELICULA` varchar(20) CHARACTER SET utf8mb4 DEFAULT NULL,
  `AFORO` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`ID`, `IDPELICULA`, `AFORO`) VALUES
(1, 'tt1490017', 20),
(2, 'tt9243946', 20),
(3, 'tt0167260', 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `correo` varchar(50) NOT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `rol` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`correo`, `clave`, `rol`) VALUES
('admin@cinesblockbuster.com', '$2y$10$ssveQqr92lIqfyHNSWyvNuo6qwAHV9pslRPojKZ/QQzbV3093w7Dm', 'A'),
('victorandres.ha@gmail.com', '$2y$10$yfMPgxf6jYOg0R9jvQDZTOUj/GgOQKhNg0foKFM/AD6Fs/9Z.EV1e', 'U');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `IDAPIPELICULA` (`IDAPIPELICULA`),
  ADD KEY `entradas_ibfk_1` (`IDSALA`),
  ADD KEY `entradas_ibfk_2` (`CORREO`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`idApi`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `IDPELICULA` (`IDPELICULA`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`IDSALA`) REFERENCES `salas` (`ID`),
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`CORREO`) REFERENCES `usuarios` (`correo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `entradas_ibfk_3` FOREIGN KEY (`IDAPIPELICULA`) REFERENCES `peliculas` (`idApi`);

--
-- Filtros para la tabla `salas`
--
ALTER TABLE `salas`
  ADD CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`IDPELICULA`) REFERENCES `peliculas` (`idApi`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;


SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
