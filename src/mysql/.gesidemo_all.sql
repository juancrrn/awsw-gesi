-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 29, 2020 at 05:07 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gesidemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `gesi_asignaciones`
--

DROP TABLE IF EXISTS `gesi_asignaciones`;
CREATE TABLE IF NOT EXISTS `gesi_asignaciones` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `profesor` int(16) NOT NULL,
  `grupo` int(16) NOT NULL,
  `asignatura` int(16) NOT NULL,
  `horario` varchar(512) NOT NULL,
  `foro_principal` int(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_grupo_asignatura` (`grupo`,`asignatura`),
  UNIQUE KEY `unique_foro_principal` (`foro_principal`),
  KEY `profesor` (`profesor`),
  KEY `grupo` (`grupo`),
  KEY `asignatura` (`asignatura`),
  KEY `foro_principal` (`foro_principal`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_asignaciones`
--

INSERT INTO `gesi_asignaciones` (`id`, `profesor`, `grupo`, `asignatura`, `horario`, `foro_principal`) VALUES
(1, 5, 1, 1, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 1),
(2, 6, 1, 7, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 2),
(3, 7, 1, 13, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 3),
(4, 8, 1, 25, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 4),
(5, 9, 1, 19, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 5),
(6, 12, 1, 29, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 6),
(7, 15, 1, 33, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 7),
(8, 10, 1, 49, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 8),
(9, 26, 2, 2, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 9),
(10, 27, 2, 8, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 10),
(11, 28, 2, 14, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 11),
(12, 20, 2, 26, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 12),
(13, 21, 2, 20, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 13),
(14, 22, 2, 30, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 14),
(15, 23, 2, 34, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 15),
(16, 19, 2, 50, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 16),
(17, 5, 3, 3, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 17),
(18, 6, 3, 9, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 18),
(19, 7, 3, 15, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 19),
(20, 8, 3, 27, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 20),
(21, 9, 3, 21, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 21),
(22, 12, 3, 31, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 22),
(23, 15, 3, 35, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 23),
(24, 17, 3, 37, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 24),
(25, 10, 3, 51, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 25),
(26, 26, 4, 4, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 26),
(27, 27, 4, 10, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 27),
(28, 28, 4, 16, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 28),
(29, 20, 4, 28, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 29),
(30, 21, 4, 22, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 30),
(31, 22, 4, 32, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 31),
(32, 23, 4, 36, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 32),
(33, 24, 4, 38, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 33),
(34, 19, 4, 52, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 34),
(35, 5, 5, 5, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 35),
(36, 6, 5, 11, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 36),
(37, 7, 5, 17, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 37),
(38, 13, 5, 39, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 38),
(39, 9, 5, 23, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 39),
(40, 11, 5, 41, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 40),
(41, 14, 5, 43, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 41),
(42, 10, 5, 53, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 42),
(43, 5, 6, 5, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 43),
(44, 6, 6, 11, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 44),
(45, 7, 6, 17, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 45),
(46, 13, 6, 39, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 46),
(47, 9, 6, 23, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 47),
(48, 16, 6, 45, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 48),
(49, 18, 6, 47, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 49),
(50, 10, 6, 53, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 50),
(51, 26, 7, 6, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 51),
(52, 27, 7, 12, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 52),
(53, 28, 7, 18, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 53),
(54, 25, 7, 40, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 54),
(55, 21, 7, 24, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 55),
(56, 11, 7, 42, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 56),
(57, 14, 7, 44, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 57),
(58, 19, 7, 54, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 58),
(59, 26, 8, 6, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 59),
(60, 27, 8, 12, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 60),
(61, 28, 8, 18, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 61),
(62, 25, 8, 40, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 62),
(63, 21, 8, 24, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 63),
(64, 16, 8, 46, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 64),
(65, 18, 8, 48, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 65),
(66, 19, 8, 54, 'L 00:00 00:00; M 00:00 00:00; X 00:00 00:00; J 00:00 00:00; V 00:00 00:00;', 66);

-- --------------------------------------------------------

--
-- Table structure for table `gesi_asignaturas`
--

DROP TABLE IF EXISTS `gesi_asignaturas`;
CREATE TABLE IF NOT EXISTS `gesi_asignaturas` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nivel` int(1) NOT NULL,
  `curso_escolar` int(16) NOT NULL,
  `nombre_corto` varchar(256) NOT NULL,
  `nombre_completo` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_asignaturas`
--

INSERT INTO `gesi_asignaturas` (`id`, `nivel`, `curso_escolar`, `nombre_corto`, `nombre_completo`) VALUES
(1, 1, 2019, 'E1FR', 'Francés ESO 1'),
(2, 2, 2019, 'E2FR', 'Francés ESO 2'),
(3, 3, 2019, 'E3FR', 'Francés ESO 3'),
(4, 4, 2019, 'E4FR', 'Francés ESO 4'),
(5, 5, 2019, 'B1FR', 'Francés Bach. 1'),
(6, 6, 2019, 'B2FR', 'Francés Bach. 2'),
(7, 1, 2019, 'E1IN', 'Inglés ESO 1'),
(8, 2, 2019, 'E2IN', 'Inglés ESO 2'),
(9, 3, 2019, 'E3IN', 'Inglés ESO 3'),
(10, 4, 2019, 'E4IN', 'Inglés ESO 4'),
(11, 5, 2019, 'B1IN', 'Inglés Bach. 1'),
(12, 6, 2019, 'B2IN', 'Inglés Bach. 2'),
(13, 1, 2019, 'E1AL', 'Alemán ESO 1'),
(14, 2, 2019, 'E2AL', 'Alemán ESO 2'),
(15, 3, 2019, 'E3AL', 'Alemán ESO 3'),
(16, 4, 2019, 'E4AL', 'Alemán ESO 4'),
(17, 5, 2019, 'B1AL', 'Alemán Bach. 1'),
(18, 6, 2019, 'B2AL', 'Alemán Bach. 2'),
(19, 1, 2019, 'E1GH', 'Geografía e Historia ESO 1'),
(20, 2, 2019, 'E2GH', 'Geografía e Historia ESO 2'),
(21, 3, 2019, 'E3GH', 'Geografía e Historia ESO 3'),
(22, 4, 2019, 'E4GH', 'Geografía e Historia ESO 4'),
(23, 5, 2019, 'B1GH', 'Geografía e Historia Bach. 1'),
(24, 6, 2019, 'B2GH', 'Geografía e Historia Bach. 2'),
(25, 1, 2019, 'E1EF', 'Educación Física ESO 1'),
(26, 2, 2019, 'E2EF', 'Educación Física ESO 2'),
(27, 3, 2019, 'E3EF', 'Educación Física ESO 3'),
(28, 4, 2019, 'E4EF', 'Educación Física ESO 4'),
(29, 1, 2019, 'E1BG', 'Biología y Geología ESO 1'),
(30, 2, 2019, 'E2BG', 'Biología y Geología ESO 2'),
(31, 3, 2019, 'E3BG', 'Biología y Geología ESO 3'),
(32, 4, 2019, 'E4BG', 'Biología y Geología ESO 4'),
(33, 1, 2019, 'E1MA', 'Matemáticas ESO 1'),
(34, 2, 2019, 'E2MA', 'Matemáticas ESO 2'),
(35, 3, 2019, 'E3MA', 'Matemáticas ESO 3'),
(36, 4, 2019, 'E4MA', 'Matemáticas ESO 4'),
(37, 3, 2019, 'E3FQ', 'Física y Química ESO 3'),
(38, 4, 2019, 'E4FQ', 'Física y Química ESO 4'),
(39, 5, 2019, 'B1FI', 'Filosofía Bach. 1'),
(40, 6, 2019, 'B2FI', 'Filosofía Bach. 2'),
(41, 5, 2019, 'B1TE', 'Tecnología Bach. 1'),
(42, 6, 2019, 'B2TE', 'Tecnología Bach. 2'),
(43, 5, 2019, 'B1DT', 'Dibujo Técnico Bach. 1'),
(44, 6, 2019, 'B2DT', 'Dibujo Técnico Bach. 2'),
(45, 5, 2019, 'B1GL', 'Griego y Latín Bach. 1'),
(46, 6, 2019, 'B2GL', 'Griego y Latín Bach. 2'),
(47, 5, 2019, 'B1MU', 'Música Bach. 1'),
(48, 6, 2019, 'B2MU', 'Música Bach. 2'),
(49, 1, 2019, 'E1LC', 'Lengua castellana y Literatura ESO 1'),
(50, 2, 2019, 'E2LC', 'Lengua castellana y Literatura ESO 2'),
(51, 3, 2019, 'E3LC', 'Lengua castellana y Literatura ESO 3'),
(52, 4, 2019, 'E4LC', 'Lengua castellana y Literatura ESO 4'),
(53, 5, 2019, 'B1LC', 'Lengua castellana y Literatura Bach. 1'),
(54, 6, 2019, 'B2LC', 'Lengua castellana y Literatura Bach. 2');

-- --------------------------------------------------------

--
-- Table structure for table `gesi_ejemplar_libro`
--

DROP TABLE IF EXISTS `gesi_ejemplar_libro`;
CREATE TABLE IF NOT EXISTS `gesi_ejemplar_libro` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `numero` int(16) NOT NULL,
  `libro` int(16) NOT NULL,
  `prestado` tinyint(1) DEFAULT 0,
  `usuario_prestamo` int(16) DEFAULT NULL,
  `fecha_alta_prestamo` int(11) DEFAULT NULL,
  `fecha_expiracion_prestamo` int(11) DEFAULT NULL,
  `reserva` tinyint(1) DEFAULT 0,
  `usuario_reserva` int(16) DEFAULT NULL,
  `fecha_alta_reserva` int(11) DEFAULT NULL,
  `fecha_expiracion_reserva` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_numero_libro` (`numero`,`libro`) USING BTREE,
  KEY `libro` (`libro`),
  KEY `usuario_prestamo` (`usuario_prestamo`),
  KEY `usuario_reserva` (`usuario_reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_ejemplar_libro`
--

INSERT INTO `gesi_ejemplar_libro` (`id`, `numero`, `libro`, `prestado`, `usuario_prestamo`, `fecha_alta_prestamo`, `fecha_expiracion_prestamo`, `reserva`, `usuario_reserva`, `fecha_alta_reserva`, `fecha_expiracion_reserva`) VALUES
(1, 1, 1, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(2, 1, 2, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(3, 1, 3, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(4, 1, 4, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(5, 1, 5, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(6, 1, 6, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(7, 1, 7, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(8, 1, 8, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(9, 1, 9, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(10, 1, 10, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(11, 1, 11, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(12, 1, 12, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(13, 1, 13, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(14, 1, 14, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(15, 1, 15, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(16, 1, 16, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(17, 1, 17, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(18, 1, 18, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(19, 1, 19, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(20, 1, 20, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(21, 1, 21, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(22, 1, 22, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(23, 1, 23, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(24, 1, 24, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(25, 1, 25, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(26, 1, 26, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(27, 1, 27, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(28, 1, 28, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(29, 1, 29, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(30, 1, 30, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(31, 1, 31, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(32, 1, 32, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(33, 1, 33, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(34, 1, 34, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(35, 1, 35, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(36, 1, 36, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(37, 1, 37, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(38, 1, 38, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(39, 1, 39, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(40, 1, 40, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(41, 1, 41, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(42, 1, 42, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(43, 1, 43, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(44, 1, 44, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(45, 1, 45, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(46, 1, 46, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(47, 1, 47, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(48, 1, 48, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(49, 1, 49, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(50, 1, 50, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(51, 1, 51, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(52, 1, 52, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(53, 1, 53, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(54, 1, 54, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(55, 1, 55, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(56, 1, 56, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(57, 1, 57, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(58, 1, 58, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(59, 1, 59, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(60, 1, 60, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(61, 1, 61, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(62, 1, 62, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(63, 1, 63, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(64, 1, 64, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(65, 1, 65, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(66, 1, 66, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(67, 1, 67, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(68, 1, 68, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(69, 1, 69, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(70, 1, 70, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(71, 1, 71, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(72, 1, 72, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(73, 1, 73, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(74, 1, 74, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(75, 1, 75, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(76, 1, 76, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(77, 1, 77, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(78, 1, 78, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(79, 1, 79, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(80, 1, 80, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(81, 1, 81, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(82, 1, 82, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(83, 1, 83, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(84, 1, 84, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(85, 1, 85, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(86, 1, 86, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(87, 1, 87, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(88, 1, 88, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(89, 1, 89, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(90, 1, 90, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(91, 1, 91, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(92, 1, 92, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(93, 1, 93, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(94, 1, 94, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(95, 1, 95, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(96, 1, 96, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(97, 1, 97, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(98, 1, 98, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(99, 1, 99, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(100, 1, 100, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gesi_eventos`
--

DROP TABLE IF EXISTS `gesi_eventos`;
CREATE TABLE IF NOT EXISTS `gesi_eventos` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `lugar` varchar(256) NOT NULL,
  `asignatura` int(16) DEFAULT NULL,
  `asignacion` int(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `asignatura` (`asignatura`),
  KEY `asignacion` (`asignacion`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_eventos`
--

INSERT INTO `gesi_eventos` (`id`, `fecha`, `nombre`, `descripcion`, `lugar`, `asignatura`, `asignacion`) VALUES
(1, '2019-09-10 12:01:23', 'Bienvenida a la asignatura de Francés ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 1),
(2, '2019-09-06 12:37:21', 'Bienvenida a la asignatura de Inglés ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 2),
(3, '2019-09-03 20:23:16', 'Bienvenida a la asignatura de Alemán ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 3),
(4, '2019-09-16 04:03:02', 'Bienvenida a la asignatura de Educación Física ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 4),
(5, '2019-09-16 17:57:49', 'Bienvenida a la asignatura de Geografía e Historia ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 5),
(6, '2019-09-21 04:45:45', 'Bienvenida a la asignatura de Biología y Geología ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 6),
(7, '2019-09-10 02:03:05', 'Bienvenida a la asignatura de Matemáticas ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 7),
(8, '2019-09-14 04:34:33', 'Bienvenida a la asignatura de Lengua castellana y Literatura ESO 1 (Grupo A ESO 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 8),
(9, '2019-09-07 11:29:51', 'Bienvenida a la asignatura de Francés ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 9),
(10, '2019-09-08 01:53:52', 'Bienvenida a la asignatura de Inglés ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 10),
(11, '2019-09-06 16:04:09', 'Bienvenida a la asignatura de Alemán ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 11),
(12, '2019-09-12 03:10:26', 'Bienvenida a la asignatura de Educación Física ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 12),
(13, '2019-09-02 12:02:33', 'Bienvenida a la asignatura de Geografía e Historia ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 13),
(14, '2019-09-10 00:32:47', 'Bienvenida a la asignatura de Biología y Geología ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 14),
(15, '2019-09-29 09:27:37', 'Bienvenida a la asignatura de Matemáticas ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 15),
(16, '2019-09-12 16:16:11', 'Bienvenida a la asignatura de Lengua castellana y Literatura ESO 2 (Grupo A ESO 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 16),
(17, '2019-09-22 09:59:01', 'Bienvenida a la asignatura de Francés ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 17),
(18, '2019-09-21 15:48:45', 'Bienvenida a la asignatura de Inglés ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 18),
(19, '2019-09-28 05:35:31', 'Bienvenida a la asignatura de Alemán ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 19),
(20, '2019-09-19 12:21:00', 'Bienvenida a la asignatura de Educación Física ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 20),
(21, '2019-09-16 18:49:49', 'Bienvenida a la asignatura de Geografía e Historia ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 21),
(22, '2019-09-27 02:59:21', 'Bienvenida a la asignatura de Biología y Geología ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 22),
(23, '2019-09-03 06:37:48', 'Bienvenida a la asignatura de Matemáticas ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 23),
(24, '2019-09-25 22:33:46', 'Bienvenida a la asignatura de Física y Química ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 24),
(25, '2019-09-22 14:25:53', 'Bienvenida a la asignatura de Lengua castellana y Literatura ESO 3 (Grupo A ESO 3)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 25),
(26, '2019-09-26 16:29:29', 'Bienvenida a la asignatura de Francés ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 26),
(27, '2019-09-26 15:34:13', 'Bienvenida a la asignatura de Inglés ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 27),
(28, '2019-09-10 13:11:26', 'Bienvenida a la asignatura de Alemán ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 28),
(29, '2019-09-05 09:34:27', 'Bienvenida a la asignatura de Educación Física ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 29),
(30, '2019-09-21 07:29:30', 'Bienvenida a la asignatura de Geografía e Historia ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 30),
(31, '2019-09-12 22:22:33', 'Bienvenida a la asignatura de Biología y Geología ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 31),
(32, '2019-09-01 17:31:56', 'Bienvenida a la asignatura de Matemáticas ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 32),
(33, '2019-09-15 19:29:50', 'Bienvenida a la asignatura de Física y Química ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 33),
(34, '2019-09-27 05:54:10', 'Bienvenida a la asignatura de Lengua castellana y Literatura ESO 4 (Grupo A ESO 4)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 34),
(35, '2019-09-23 06:38:47', 'Bienvenida a la asignatura de Francés Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 35),
(36, '2019-09-18 01:03:11', 'Bienvenida a la asignatura de Inglés Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 36),
(37, '2019-09-04 09:06:54', 'Bienvenida a la asignatura de Alemán Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 37),
(38, '2019-09-11 18:06:37', 'Bienvenida a la asignatura de Filosofía Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 38),
(39, '2019-09-27 02:53:42', 'Bienvenida a la asignatura de Geografía e Historia Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 39),
(40, '2019-09-11 05:55:49', 'Bienvenida a la asignatura de Tecnología Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 40),
(41, '2019-09-15 02:06:34', 'Bienvenida a la asignatura de Dibujo Técnico Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 41),
(42, '2019-09-20 12:12:40', 'Bienvenida a la asignatura de Lengua castellana y Literatura Bach. 1 (Grupo A Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 42),
(43, '2019-09-28 23:53:11', 'Bienvenida a la asignatura de Francés Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 43),
(44, '2019-09-21 14:56:20', 'Bienvenida a la asignatura de Inglés Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 44),
(45, '2019-09-06 10:54:51', 'Bienvenida a la asignatura de Alemán Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 45),
(46, '2019-09-20 02:04:57', 'Bienvenida a la asignatura de Filosofía Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 46),
(47, '2019-09-20 18:52:07', 'Bienvenida a la asignatura de Geografía e Historia Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 47),
(48, '2019-09-06 17:51:13', 'Bienvenida a la asignatura de Griego y Latín Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 48),
(49, '2019-09-12 00:34:30', 'Bienvenida a la asignatura de Música Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 49),
(50, '2019-09-17 21:14:48', 'Bienvenida a la asignatura de Lengua castellana y Literatura Bach. 1 (Grupo B Bach. 1)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 50),
(51, '2019-09-28 02:59:47', 'Bienvenida a la asignatura de Francés Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 51),
(52, '2019-09-06 13:00:28', 'Bienvenida a la asignatura de Inglés Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 52),
(53, '2019-09-15 02:59:56', 'Bienvenida a la asignatura de Alemán Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 53),
(54, '2019-09-28 08:14:51', 'Bienvenida a la asignatura de Filosofía Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 54),
(55, '2019-09-05 08:15:28', 'Bienvenida a la asignatura de Geografía e Historia Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 55),
(56, '2019-09-21 08:57:09', 'Bienvenida a la asignatura de Tecnología Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 56),
(57, '2019-09-05 08:36:43', 'Bienvenida a la asignatura de Dibujo Técnico Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 57),
(58, '2019-09-23 00:01:35', 'Bienvenida a la asignatura de Lengua castellana y Literatura Bach. 2 (Grupo A Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 58),
(59, '2019-09-29 13:32:45', 'Bienvenida a la asignatura de Francés Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 59),
(60, '2019-09-03 09:15:21', 'Bienvenida a la asignatura de Inglés Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 60),
(61, '2019-09-12 11:43:10', 'Bienvenida a la asignatura de Alemán Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 61),
(62, '2019-09-05 22:40:50', 'Bienvenida a la asignatura de Filosofía Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 62),
(63, '2019-09-12 00:00:45', 'Bienvenida a la asignatura de Geografía e Historia Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 63),
(64, '2019-09-11 20:24:26', 'Bienvenida a la asignatura de Griego y Latín Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 64),
(65, '2019-09-15 14:53:23', 'Bienvenida a la asignatura de Música Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 65),
(66, '2019-09-14 00:53:49', 'Bienvenida a la asignatura de Lengua castellana y Literatura Bach. 2 (Grupo B Bach. 2)', 'Los profesores os damos la bienvenida a la asignatura y os presentamos cómo la desarrollaremos.', 'Aula del grupo', NULL, 66);

-- --------------------------------------------------------

--
-- Table structure for table `gesi_foros`
--

DROP TABLE IF EXISTS `gesi_foros`;
CREATE TABLE IF NOT EXISTS `gesi_foros` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_foros`
--

INSERT INTO `gesi_foros` (`id`, `nombre`) VALUES
(1, 'Foro Francés ESO 1 (Grupo A ESO 1)'),
(2, 'Foro Inglés ESO 1 (Grupo A ESO 1)'),
(3, 'Foro Alemán ESO 1 (Grupo A ESO 1)'),
(4, 'Foro Educación Física ESO 1 (Grupo A ESO 1)'),
(5, 'Foro Geografía e Historia ESO 1 (Grupo A ESO 1)'),
(6, 'Foro Biología y Geología ESO 1 (Grupo A ESO 1)'),
(7, 'Foro Matemáticas ESO 1 (Grupo A ESO 1)'),
(8, 'Foro Lengua castellana y Literatura ESO 1 (Grupo A ESO 1)'),
(9, 'Foro Francés ESO 2 (Grupo A ESO 2)'),
(10, 'Foro Inglés ESO 2 (Grupo A ESO 2)'),
(11, 'Foro Alemán ESO 2 (Grupo A ESO 2)'),
(12, 'Foro Educación Física ESO 2 (Grupo A ESO 2)'),
(13, 'Foro Geografía e Historia ESO 2 (Grupo A ESO 2)'),
(14, 'Foro Biología y Geología ESO 2 (Grupo A ESO 2)'),
(15, 'Foro Matemáticas ESO 2 (Grupo A ESO 2)'),
(16, 'Foro Lengua castellana y Literatura ESO 2 (Grupo A ESO 2)'),
(17, 'Foro Francés ESO 3 (Grupo A ESO 3)'),
(18, 'Foro Inglés ESO 3 (Grupo A ESO 3)'),
(19, 'Foro Alemán ESO 3 (Grupo A ESO 3)'),
(20, 'Foro Educación Física ESO 3 (Grupo A ESO 3)'),
(21, 'Foro Geografía e Historia ESO 3 (Grupo A ESO 3)'),
(22, 'Foro Biología y Geología ESO 3 (Grupo A ESO 3)'),
(23, 'Foro Matemáticas ESO 3 (Grupo A ESO 3)'),
(24, 'Foro Física y Química ESO 3 (Grupo A ESO 3)'),
(25, 'Foro Lengua castellana y Literatura ESO 3 (Grupo A ESO 3)'),
(26, 'Foro Francés ESO 4 (Grupo A ESO 4)'),
(27, 'Foro Inglés ESO 4 (Grupo A ESO 4)'),
(28, 'Foro Alemán ESO 4 (Grupo A ESO 4)'),
(29, 'Foro Educación Física ESO 4 (Grupo A ESO 4)'),
(30, 'Foro Geografía e Historia ESO 4 (Grupo A ESO 4)'),
(31, 'Foro Biología y Geología ESO 4 (Grupo A ESO 4)'),
(32, 'Foro Matemáticas ESO 4 (Grupo A ESO 4)'),
(33, 'Foro Física y Química ESO 4 (Grupo A ESO 4)'),
(34, 'Foro Lengua castellana y Literatura ESO 4 (Grupo A ESO 4)'),
(35, 'Foro Francés Bach. 1 (Grupo A Bach. 1)'),
(36, 'Foro Inglés Bach. 1 (Grupo A Bach. 1)'),
(37, 'Foro Alemán Bach. 1 (Grupo A Bach. 1)'),
(38, 'Foro Filosofía Bach. 1 (Grupo A Bach. 1)'),
(39, 'Foro Geografía e Historia Bach. 1 (Grupo A Bach. 1)'),
(40, 'Foro Tecnología Bach. 1 (Grupo A Bach. 1)'),
(41, 'Foro Dibujo Técnico Bach. 1 (Grupo A Bach. 1)'),
(42, 'Foro Lengua castellana y Literatura Bach. 1 (Grupo A Bach. 1)'),
(43, 'Foro Francés Bach. 1 (Grupo B Bach. 1)'),
(44, 'Foro Inglés Bach. 1 (Grupo B Bach. 1)'),
(45, 'Foro Alemán Bach. 1 (Grupo B Bach. 1)'),
(46, 'Foro Filosofía Bach. 1 (Grupo B Bach. 1)'),
(47, 'Foro Geografía e Historia Bach. 1 (Grupo B Bach. 1)'),
(48, 'Foro Griego y Latín Bach. 1 (Grupo B Bach. 1)'),
(49, 'Foro Música Bach. 1 (Grupo B Bach. 1)'),
(50, 'Foro Lengua castellana y Literatura Bach. 1 (Grupo B Bach. 1)'),
(51, 'Foro Francés Bach. 2 (Grupo A Bach. 2)'),
(52, 'Foro Inglés Bach. 2 (Grupo A Bach. 2)'),
(53, 'Foro Alemán Bach. 2 (Grupo A Bach. 2)'),
(54, 'Foro Filosofía Bach. 2 (Grupo A Bach. 2)'),
(55, 'Foro Geografía e Historia Bach. 2 (Grupo A Bach. 2)'),
(56, 'Foro Tecnología Bach. 2 (Grupo A Bach. 2)'),
(57, 'Foro Dibujo Técnico Bach. 2 (Grupo A Bach. 2)'),
(58, 'Foro Lengua castellana y Literatura Bach. 2 (Grupo A Bach. 2)'),
(59, 'Foro Francés Bach. 2 (Grupo B Bach. 2)'),
(60, 'Foro Inglés Bach. 2 (Grupo B Bach. 2)'),
(61, 'Foro Alemán Bach. 2 (Grupo B Bach. 2)'),
(62, 'Foro Filosofía Bach. 2 (Grupo B Bach. 2)'),
(63, 'Foro Geografía e Historia Bach. 2 (Grupo B Bach. 2)'),
(64, 'Foro Griego y Latín Bach. 2 (Grupo B Bach. 2)'),
(65, 'Foro Música Bach. 2 (Grupo B Bach. 2)'),
(66, 'Foro Lengua castellana y Literatura Bach. 2 (Grupo B Bach. 2)');

-- --------------------------------------------------------

--
-- Table structure for table `gesi_grupos`
--

DROP TABLE IF EXISTS `gesi_grupos`;
CREATE TABLE IF NOT EXISTS `gesi_grupos` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nivel` int(1) NOT NULL,
  `curso_escolar` int(16) NOT NULL,
  `nombre_corto` varchar(256) NOT NULL,
  `nombre_completo` varchar(256) NOT NULL,
  `tutor` int(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tutor` (`tutor`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_grupos`
--

INSERT INTO `gesi_grupos` (`id`, `nivel`, `curso_escolar`, `nombre_corto`, `nombre_completo`, `tutor`) VALUES
(1, 1, 2019, 'E1A', 'Grupo A ESO 1', 5),
(2, 2, 2019, 'E2A', 'Grupo A ESO 2', 26),
(3, 3, 2019, 'E3A', 'Grupo A ESO 3', 6),
(4, 4, 2019, 'E4A', 'Grupo A ESO 4', 27),
(5, 5, 2019, 'B1A', 'Grupo A Bach. 1', 11),
(6, 5, 2019, 'B1B', 'Grupo B Bach. 1', 14),
(7, 6, 2019, 'B1A', 'Grupo A Bach. 2', 16),
(8, 6, 2019, 'B1B', 'Grupo B Bach. 2', 18);

-- --------------------------------------------------------

--
-- Table structure for table `gesi_libros`
--

DROP TABLE IF EXISTS `gesi_libros`;
CREATE TABLE IF NOT EXISTS `gesi_libros` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `autor` varchar(256) NOT NULL,
  `titulo` varchar(256) NOT NULL,
  `asignatura` int(16) DEFAULT NULL,
  `isbn` varchar(13) NOT NULL,
  `editorial` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `asignatura` (`asignatura`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_libros`
--

INSERT INTO `gesi_libros` (`id`, `autor`, `titulo`, `asignatura`, `isbn`, `editorial`) VALUES
(1, 'Aurelie Chaudron', 'Stille nacht', 1, '9783195431112', 'Ferry, Rath and Murazik'),
(2, 'Constantino Butter', 'Cashback', 2, '9783980881524', 'OHara, DAmore and Effertz'),
(3, 'Mella Baudin', 'Sea Wolf, The', 3, '9783671377274', 'Koelpin-Towne'),
(4, 'Susy Hendriksen', 'Snow Walker, The', 4, '9783003559931', 'Heathcote-Ankunding'),
(5, 'Lissie Lote', 'Family Law (Derecho de familia)', 5, '9783985233100', 'Beer and Sons'),
(6, 'Flore Brigginshaw', 'Oceans Twelve', 6, '9783370423551', 'Mitchell, Jenkins and Pouros'),
(7, 'Olivier Czajkowska', 'Teachers', 7, '9783737698239', 'Jaskolski, Torphy and Willms'),
(8, 'Richardo Weiner', 'Weirdsville', 8, '9783652701101', 'Baumbach, Kassulke and Wuckert'),
(9, 'Norma Cardo', 'Last Winter, The', 9, '9783407765645', 'Yost-Howell'),
(10, 'Sheridan Berecloth', 'Secret of Santa Vittoria, The', 10, '9783829219733', 'Sauer, McClure and Windler'),
(11, 'Keriann Gerdts', 'Bad Moon', 11, '9783523496316', 'Langosh Inc'),
(12, 'Ronnie Ferreri', 'Sabretooth', 12, '9783592425859', 'Price-Hand'),
(13, 'Thalia Edwin', 'Glass Web, The', 13, '9783285062774', 'Mante-Bailey'),
(14, 'Storm Renad', 'When Evening Falls on Bucharest or Metabolism', 14, '9783151714291', 'Turner Inc'),
(15, 'Vanya Delgaty', 'Gunnin for That #1 Spot', 15, '9783751462572', 'Kunde Group'),
(16, 'Norma Pagett', 'Boy Meets Girl', 16, '9783630252448', 'Becker-McDermott'),
(17, 'Cris Ralestone', 'When the Last Sword is Drawn (Mibu gishi den)', 17, '9783751267054', 'Welch, Krajcik and Anderson'),
(18, 'Shelia Kelwick', 'Dead, The', 18, '9783723252300', 'Mills-DuBuque'),
(19, 'Maryjane Everly', 'Talladega Nights: The Ballad of Ricky Bobby', 19, '9783757088104', 'Cummerata Inc'),
(20, 'Jackson Gueny', 'Brothers on the Line', 20, '9783445815519', 'Block, Purdy and Abshire'),
(21, 'Corine Clampe', 'Misery', 21, '9783436522391', 'Johnston-Schimmel'),
(22, 'Maddie Addionisio', '20 Feet from Stardom (Twenty Feet from Stardom)', 22, '9783550629072', 'Schaefer, Sipes and Reilly'),
(23, 'Karney Delucia', 'Making Love', 23, '9783392122047', 'Medhurst and Sons'),
(24, 'Aube Clever', 'U2 3D', 24, '9783934418185', 'Schaefer, Kozey and Stoltenberg'),
(25, 'Vince Ranger', 'Tarantula', 25, '9783952340465', 'OConner, Langworth and Kreiger'),
(26, 'La verne Lefridge', 'Ski Party', 26, '9783436970158', 'Buckridge LLC'),
(27, 'Jareb Manchester', 'A Night in the Show', 27, '9783490127702', 'Osinski, Koch and Kerluke'),
(28, 'Halsy Snel', 'Graduate, The', 28, '9783820108928', 'Gaylord-Kemmer'),
(29, 'Valma Fairholme', 'Say It Isnt So', 29, '9783747807985', 'Zieme-Macejkovic'),
(30, 'Neal Gornar', 'Boys from Brazil, The', 30, '9783918115553', 'Marks-Mitchell'),
(31, 'Ryon Dohms', '16 Years of Alcohol', 31, '9783784545381', 'Sipes-Heathcote'),
(32, 'Alicea Keepe', 'Cant Buy Me Love', 32, '9783302793569', 'Metz Inc'),
(33, 'Trix Tembridge', 'Screamers', 33, '9783398736282', 'Larkin, Wolff and Upton'),
(34, 'Amory Gary', 'Land Before Time, The', 34, '9783569538180', 'Turner and Sons'),
(35, 'Suzanna Fisk', 'Disconnect', 35, '9783140590161', 'Jenkins, Terry and Bailey'),
(36, 'Devlen Berceros', 'Mysterious Mr. Moto', 36, '9783873994221', 'Mraz-Blanda'),
(37, 'Celestine Beddows', 'Perfect Blue', 37, '9783647917924', 'Wisozk Inc'),
(38, 'Henriette OScully', 'Outland', 38, '9783143055956', 'Maggio Inc'),
(39, 'Libby Duester', 'Children of Men', 39, '9783341255122', 'Sauer-Ankunding'),
(40, 'Fayre Thredder', 'Night to Remember, A', 40, '9783060550078', 'Hudson Group'),
(41, 'Antonia Sothern', 'Dating the Enemy', 41, '9783122458954', 'Bashirian Inc'),
(42, 'Mehetabel Briscoe', 'All Is Forgiven (Tout est pardonné)', 42, '9783698284398', 'Wolf LLC'),
(43, 'Ekaterina Bleakman', 'Mr. Denning Drives North', 43, '9783972072107', 'Beatty, Abshire and Schulist'),
(44, 'Nikkie Vedmore', 'Oliver Twist', 44, '9783711589657', 'Hoeger and Sons'),
(45, 'Guthrie O Dooley', 'E.T. the Extra-Terrestrial', 45, '9783313409521', 'Beahan-Pacocha'),
(46, 'Claudian Coysh', 'First Love (Primo Amore)', 46, '9783310576314', 'Schoen and Sons'),
(47, 'Dulcia Dalloway', 'Emperors New Groove, The', 47, '9783863321279', 'Little, Kuhic and Padberg'),
(48, 'Ameline Moakes', 'Buttcrack', 48, '9783850160606', 'Upton Group'),
(49, 'Gunner Pummery', 'Fuzz', 49, '9783813175747', 'Sawayn and Sons'),
(50, 'Wald Parmley', 'Demonic', 50, '9783902070591', 'Walker-Mosciski'),
(51, 'Rickey Towne', 'Quest for Camelot', 51, '9783774208840', 'Rolfson, Crooks and Vandervort'),
(52, 'Johan Woodson', 'My Brilliant Career', 52, '9783155324027', 'Denesik-Oberbrunner'),
(53, 'Lora Spellacy', 'Creep Van', 53, '9783974191628', 'Pfeffer LLC'),
(54, 'Layney Loader', 'Great McGinty, The', NULL, '9783723907272', 'Nolan Inc'),
(55, 'Kevon Rodson', 'Sabotage', NULL, '9783156342530', 'Dickinson-Langworth'),
(56, 'Anitra Lief', 'Broadway Damage', NULL, '9783513556817', 'Russel, Beier and Crooks'),
(57, 'Sancho Coil', 'Diamonds Are Forever', NULL, '9783319038625', 'Anderson-Harber'),
(58, 'Tobe Doncaster', 'Patti Smith: Dream of Life', NULL, '9783941579616', 'Jacobs and Sons'),
(59, 'Rhianon Szepe', 'Home of the Brave', NULL, '9783981314780', 'Lueilwitz-Wilkinson'),
(60, 'Mirabel Slimings', 'City Slickers II: The Legend of Curlys Gold', NULL, '9783592070104', 'Schaefer-Schamberger'),
(61, 'Ulrica Keeton', 'Armed and Dangerous', NULL, '9783158571434', 'Schultz, Hodkiewicz and Waters'),
(62, 'Jock Durbyn', 'On_Line (a.k.a. On Line)', NULL, '9783874542871', 'Conroy and Sons'),
(63, 'Roxane Inmett', 'Captain America: The First Avenger', NULL, '9783352296005', 'Larkin-Brekke'),
(64, 'Ema Dowman', 'Beats Being Dead (Dreileben - Etwas Besseres als den Tod)', NULL, '9783447639362', 'Feeney Inc'),
(65, 'Lina Spur', 'Pick-up Artist, The', NULL, '9783151855043', 'Ebert, Emard and Ankunding'),
(66, 'Herve Bestwerthick', 'Maradona by Kusturica', NULL, '9783195545736', 'Blanda-Cummerata'),
(67, 'Shauna Brightling', 'Crude Oasis, The', NULL, '9783226434116', 'Cummings, Aufderhar and Stokes'),
(68, 'Laureen Arnison', 'Village People', NULL, '9783905736949', 'Zboncak, Hauck and Kautzer'),
(69, 'Noll Rykert', 'The UFO Incident', NULL, '9783252394519', 'Ferry, Roberts and Morissette'),
(70, 'Huntlee Muris', 'Chinese Take-Out (Chinese Take-Away) (Un cuento chino)', NULL, '9783645274588', 'Smith, Reilly and West'),
(71, 'Hendrika Grissett', 'Tough Guys', NULL, '9783480816563', 'Kshlerin-Kohler'),
(72, 'Humfried Sutcliffe', 'Cherry Tree Lane', NULL, '9783830493091', 'Schulist LLC'),
(73, 'Ruthy Prynne', 'Life of Aleksis Kivi, The (Aleksis Kiven elämä)', NULL, '9783905049530', 'Terry-Mayer'),
(74, 'Leoline Gostall', 'Kiss Me Goodbye', NULL, '9783524637766', 'Farrell-Ullrich'),
(75, 'Avrom Domenichini', 'Magnificent Obsession', NULL, '9783167758864', 'Powlowski LLC'),
(76, 'Andriette McGill', 'Family Life', NULL, '9783180157287', 'Jaskolski, Ziemann and Harris'),
(77, 'Alaster Searl', 'Ugly, The', NULL, '9783178861928', 'Hagenes Group'),
(78, 'Thorvald Ainslie', 'Good Men, Good Women (Hao nan hao nu)', NULL, '9783606910354', 'Nolan LLC'),
(79, 'Aretha Dallaway', 'Vehicle 19', NULL, '9783491015946', 'Howe-Little'),
(80, 'Roz Duffus', 'Living til the End', NULL, '9783048963546', 'Christiansen, Anderson and Bednar'),
(81, 'Koo Velez', 'Moebius Redux: A Life in Pictures', NULL, '9783237892584', 'Jaskolski, Wilkinson and Cassin'),
(82, 'Jacky Mc Coughan', 'Kickboxer', NULL, '9783459637007', 'Legros, Abbott and Bogan'),
(83, 'Stanley Bonnar', 'Ride', NULL, '9783230575146', 'Borer and Sons'),
(84, 'Dur Primo', 'Looking for Palladin', NULL, '9783648666381', 'Walsh, Gibson and McDermott'),
(85, 'Margarethe Tift', 'Forgotten', NULL, '9783446775023', 'Johns, Beahan and Hane'),
(86, 'Harlin Koppes', 'Public Eye, The (Follow Me!)', NULL, '9783228325904', 'Hammes LLC'),
(87, 'Hogan Stode', 'Emergency Escape, The (Wyjscie awaryjne)', NULL, '9783950044456', 'Doyle, Runolfsdottir and Zulauf'),
(88, 'Lancelot Pieracci', 'Swedish Auto', NULL, '9783802577268', 'Labadie, Daniel and Hettinger'),
(89, 'Iain Blackleech', 'Bill Hicks: Relentless', NULL, '9783439917458', 'Kilback, Reynolds and Abbott'),
(90, 'Merlina Lahive', 'Lady, The', NULL, '9783918348411', 'Krajcik LLC'),
(91, 'Bertina Kinge', 'East of Eden', NULL, '9783804637225', 'Ryan-Wehner'),
(92, 'Agathe Ritch', 'Stars Look Down, The', NULL, '9783359769969', 'Ortiz-Dooley'),
(93, 'Rosalinde Stobbs', 'Cat Returns, The (Neko no ongaeshi)', NULL, '9783515866128', 'Parisian and Sons'),
(94, 'Dillie Springell', 'Charlie St. Cloud', NULL, '9783148371521', 'Cassin, Ledner and Lowe'),
(95, 'Gannie Kimmerling', 'Petulia', NULL, '9783079241492', 'Johns and Sons'),
(96, 'Caprice Douthwaite', 'But Forever in My Mind', NULL, '9783325662786', 'Jacobi-Ritchie'),
(97, 'Far January 1st', 'Life After People', NULL, '9783637053193', 'Hayes-Runolfsdottir'),
(98, 'Erhart Vellacott', 'Bloodfist', NULL, '9783152281326', 'Bailey, Flatley and Zemlak'),
(99, 'Roxy McLeary', 'Apollo 13: To the Edge and Back', NULL, '9783311756442', 'Schroeder and Sons'),
(100, 'Constantia Pease', 'Supporting Characters', NULL, '9783520906098', 'Cummings, McLaughlin and Greenfelder');

-- --------------------------------------------------------

--
-- Table structure for table `gesi_mensajes_foros`
--

DROP TABLE IF EXISTS `gesi_mensajes_foros`;
CREATE TABLE IF NOT EXISTS `gesi_mensajes_foros` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `foro` int(16) NOT NULL,
  `padre` int(16) DEFAULT NULL,
  `usuario` int(16) NOT NULL,
  `fecha` datetime NOT NULL,
  `contenido` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foro` (`foro`),
  KEY `padre` (`padre`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_mensajes_foros`
--

INSERT INTO `gesi_mensajes_foros` (`id`, `foro`, `padre`, `usuario`, `fecha`, `contenido`) VALUES
(1, 1, NULL, 5, '2019-09-10 12:01:23', '¡Hola!\nOs doy la bienvenida al foro de Francés ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(2, 2, NULL, 6, '2019-09-06 12:37:21', '¡Hola!\nOs doy la bienvenida al foro de Inglés ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(3, 3, NULL, 7, '2019-09-03 20:23:16', '¡Hola!\nOs doy la bienvenida al foro de Alemán ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(4, 4, NULL, 8, '2019-09-16 04:03:02', '¡Hola!\nOs doy la bienvenida al foro de Educación Física ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(5, 5, NULL, 9, '2019-09-16 17:57:49', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(6, 6, NULL, 12, '2019-09-21 04:45:45', '¡Hola!\nOs doy la bienvenida al foro de Biología y Geología ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(7, 7, NULL, 15, '2019-09-10 02:03:05', '¡Hola!\nOs doy la bienvenida al foro de Matemáticas ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(8, 8, NULL, 10, '2019-09-14 04:34:33', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura ESO 1 (Grupo A ESO 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(9, 9, NULL, 26, '2019-09-07 11:29:51', '¡Hola!\nOs doy la bienvenida al foro de Francés ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(10, 10, NULL, 27, '2019-09-08 01:53:52', '¡Hola!\nOs doy la bienvenida al foro de Inglés ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(11, 11, NULL, 28, '2019-09-06 16:04:09', '¡Hola!\nOs doy la bienvenida al foro de Alemán ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(12, 12, NULL, 20, '2019-09-12 03:10:26', '¡Hola!\nOs doy la bienvenida al foro de Educación Física ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(13, 13, NULL, 21, '2019-09-02 12:02:33', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(14, 14, NULL, 22, '2019-09-10 00:32:47', '¡Hola!\nOs doy la bienvenida al foro de Biología y Geología ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(15, 15, NULL, 23, '2019-09-29 09:27:37', '¡Hola!\nOs doy la bienvenida al foro de Matemáticas ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(16, 16, NULL, 19, '2019-09-12 16:16:11', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura ESO 2 (Grupo A ESO 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(17, 17, NULL, 5, '2019-09-22 09:59:01', '¡Hola!\nOs doy la bienvenida al foro de Francés ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(18, 18, NULL, 6, '2019-09-21 15:48:45', '¡Hola!\nOs doy la bienvenida al foro de Inglés ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(19, 19, NULL, 7, '2019-09-28 05:35:31', '¡Hola!\nOs doy la bienvenida al foro de Alemán ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(20, 20, NULL, 8, '2019-09-19 12:21:00', '¡Hola!\nOs doy la bienvenida al foro de Educación Física ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(21, 21, NULL, 9, '2019-09-16 18:49:49', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(22, 22, NULL, 12, '2019-09-27 02:59:21', '¡Hola!\nOs doy la bienvenida al foro de Biología y Geología ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(23, 23, NULL, 15, '2019-09-03 06:37:48', '¡Hola!\nOs doy la bienvenida al foro de Matemáticas ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(24, 24, NULL, 17, '2019-09-25 22:33:46', '¡Hola!\nOs doy la bienvenida al foro de Física y Química ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(25, 25, NULL, 10, '2019-09-22 14:25:53', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura ESO 3 (Grupo A ESO 3).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(26, 26, NULL, 26, '2019-09-26 16:29:29', '¡Hola!\nOs doy la bienvenida al foro de Francés ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(27, 27, NULL, 27, '2019-09-26 15:34:13', '¡Hola!\nOs doy la bienvenida al foro de Inglés ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(28, 28, NULL, 28, '2019-09-10 13:11:26', '¡Hola!\nOs doy la bienvenida al foro de Alemán ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(29, 29, NULL, 20, '2019-09-05 09:34:27', '¡Hola!\nOs doy la bienvenida al foro de Educación Física ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(30, 30, NULL, 21, '2019-09-21 07:29:30', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(31, 31, NULL, 22, '2019-09-12 22:22:33', '¡Hola!\nOs doy la bienvenida al foro de Biología y Geología ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(32, 32, NULL, 23, '2019-09-01 17:31:56', '¡Hola!\nOs doy la bienvenida al foro de Matemáticas ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(33, 33, NULL, 24, '2019-09-15 19:29:50', '¡Hola!\nOs doy la bienvenida al foro de Física y Química ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(34, 34, NULL, 19, '2019-09-27 05:54:10', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura ESO 4 (Grupo A ESO 4).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(35, 35, NULL, 5, '2019-09-23 06:38:47', '¡Hola!\nOs doy la bienvenida al foro de Francés Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(36, 36, NULL, 6, '2019-09-18 01:03:11', '¡Hola!\nOs doy la bienvenida al foro de Inglés Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(37, 37, NULL, 7, '2019-09-04 09:06:54', '¡Hola!\nOs doy la bienvenida al foro de Alemán Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(38, 38, NULL, 13, '2019-09-11 18:06:37', '¡Hola!\nOs doy la bienvenida al foro de Filosofía Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(39, 39, NULL, 9, '2019-09-27 02:53:42', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(40, 40, NULL, 11, '2019-09-11 05:55:49', '¡Hola!\nOs doy la bienvenida al foro de Tecnología Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(41, 41, NULL, 14, '2019-09-15 02:06:34', '¡Hola!\nOs doy la bienvenida al foro de Dibujo Técnico Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(42, 42, NULL, 10, '2019-09-20 12:12:40', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura Bach. 1 (Grupo A Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(43, 43, NULL, 5, '2019-09-28 23:53:11', '¡Hola!\nOs doy la bienvenida al foro de Francés Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(44, 44, NULL, 6, '2019-09-21 14:56:20', '¡Hola!\nOs doy la bienvenida al foro de Inglés Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(45, 45, NULL, 7, '2019-09-06 10:54:51', '¡Hola!\nOs doy la bienvenida al foro de Alemán Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(46, 46, NULL, 13, '2019-09-20 02:04:57', '¡Hola!\nOs doy la bienvenida al foro de Filosofía Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(47, 47, NULL, 9, '2019-09-20 18:52:07', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(48, 48, NULL, 16, '2019-09-06 17:51:13', '¡Hola!\nOs doy la bienvenida al foro de Griego y Latín Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(49, 49, NULL, 18, '2019-09-12 00:34:30', '¡Hola!\nOs doy la bienvenida al foro de Música Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(50, 50, NULL, 10, '2019-09-17 21:14:48', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura Bach. 1 (Grupo B Bach. 1).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(51, 51, NULL, 26, '2019-09-28 02:59:47', '¡Hola!\nOs doy la bienvenida al foro de Francés Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(52, 52, NULL, 27, '2019-09-06 13:00:28', '¡Hola!\nOs doy la bienvenida al foro de Inglés Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(53, 53, NULL, 28, '2019-09-15 02:59:56', '¡Hola!\nOs doy la bienvenida al foro de Alemán Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(54, 54, NULL, 25, '2019-09-28 08:14:51', '¡Hola!\nOs doy la bienvenida al foro de Filosofía Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(55, 55, NULL, 21, '2019-09-05 08:15:28', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(56, 56, NULL, 11, '2019-09-21 08:57:09', '¡Hola!\nOs doy la bienvenida al foro de Tecnología Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(57, 57, NULL, 14, '2019-09-05 08:36:43', '¡Hola!\nOs doy la bienvenida al foro de Dibujo Técnico Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(58, 58, NULL, 19, '2019-09-23 00:01:35', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura Bach. 2 (Grupo A Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(59, 59, NULL, 26, '2019-09-29 13:32:45', '¡Hola!\nOs doy la bienvenida al foro de Francés Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(60, 60, NULL, 27, '2019-09-03 09:15:21', '¡Hola!\nOs doy la bienvenida al foro de Inglés Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(61, 61, NULL, 28, '2019-09-12 11:43:10', '¡Hola!\nOs doy la bienvenida al foro de Alemán Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(62, 62, NULL, 25, '2019-09-05 22:40:50', '¡Hola!\nOs doy la bienvenida al foro de Filosofía Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(63, 63, NULL, 21, '2019-09-12 00:00:45', '¡Hola!\nOs doy la bienvenida al foro de Geografía e Historia Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(64, 64, NULL, 16, '2019-09-11 20:24:26', '¡Hola!\nOs doy la bienvenida al foro de Griego y Latín Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(65, 65, NULL, 18, '2019-09-15 14:53:23', '¡Hola!\nOs doy la bienvenida al foro de Música Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!'),
(66, 66, NULL, 19, '2019-09-14 00:53:49', '¡Hola!\nOs doy la bienvenida al foro de Lengua castellana y Literatura Bach. 2 (Grupo B Bach. 2).\nAquí pondré los recursos de la asignatura.\n¡Ánimo!');

-- --------------------------------------------------------

--
-- Table structure for table `gesi_mensajes_secretaria`
--

DROP TABLE IF EXISTS `gesi_mensajes_secretaria`;
CREATE TABLE IF NOT EXISTS `gesi_mensajes_secretaria` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `usuario` int(16) DEFAULT NULL,
  `from_nombre` varchar(256) DEFAULT NULL,
  `from_email` varchar(256) DEFAULT NULL,
  `from_telefono` varchar(32) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `contenido` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_mensajes_secretaria`
--

INSERT INTO `gesi_mensajes_secretaria` (`id`, `usuario`, `from_nombre`, `from_email`, `from_telefono`, `fecha`, `contenido`) VALUES
(1, 61, NULL, NULL, NULL, '2019-11-30 15:39:58', 'Team-oriented methodical open architecture'),
(2, 46, NULL, NULL, NULL, '2020-04-25 01:23:22', 'Profound client-driven knowledge base'),
(3, 50, NULL, NULL, NULL, '2019-05-03 10:32:46', 'De-engineered bandwidth-monitored productivity'),
(4, 56, NULL, NULL, NULL, '2020-03-26 10:53:41', 'Profit-focused 4th generation core'),
(5, 93, NULL, NULL, NULL, '2019-02-20 05:08:23', 'Optimized intermediate protocol'),
(6, 36, NULL, NULL, NULL, '2020-01-14 18:20:11', 'Devolved next generation initiative'),
(7, 55, NULL, NULL, NULL, '2019-06-21 00:51:21', 'De-engineered neutral orchestration'),
(8, 63, NULL, NULL, NULL, '2019-08-09 10:54:51', 'Team-oriented secondary Graphic Interface'),
(9, 30, NULL, NULL, NULL, '2019-11-03 21:28:47', 'Adaptive regional definition'),
(10, 58, NULL, NULL, NULL, '2020-02-24 02:38:11', 'Quality-focused client-server database'),
(11, 84, NULL, NULL, NULL, '2019-06-21 01:18:30', 'Switchable well-modulated utilisation'),
(12, 60, NULL, NULL, NULL, '2019-03-18 23:34:30', 'Persistent fault-tolerant portal'),
(13, 79, NULL, NULL, NULL, '2019-11-14 08:47:52', 'Cross-group zero tolerance process improvement'),
(14, 47, NULL, NULL, NULL, '2019-07-24 18:11:40', 'Optional next generation functionalities'),
(15, 31, NULL, NULL, NULL, '2019-03-25 01:07:37', 'Centralized asynchronous knowledge base'),
(16, 73, NULL, NULL, NULL, '2019-10-16 12:18:01', 'Quality-focused 6th generation firmware'),
(17, 48, NULL, NULL, NULL, '2020-03-18 02:24:36', 'Business-focused intermediate workforce'),
(18, 67, NULL, NULL, NULL, '2020-03-22 01:40:10', 'Sharable global capacity'),
(19, 94, NULL, NULL, NULL, '2019-07-02 19:06:20', 'Robust regional firmware'),
(20, 62, NULL, NULL, NULL, '2020-01-06 14:44:12', 'Synergized 24 hour archive'),
(21, 84, NULL, NULL, NULL, '2019-07-20 19:56:56', 'Synchronised optimizing software'),
(22, 65, NULL, NULL, NULL, '2019-02-25 18:06:49', 'User-centric reciprocal challenge'),
(23, 87, NULL, NULL, NULL, '2019-09-18 05:12:16', 'Synergized needs-based middleware'),
(24, 44, NULL, NULL, NULL, '2019-10-13 12:26:33', 'Re-engineered next generation process improvement'),
(25, 56, NULL, NULL, NULL, '2019-03-26 05:36:55', 'Object-based multi-state local area network'),
(26, 80, NULL, NULL, NULL, '2019-04-26 13:46:41', 'Versatile web-enabled leverage'),
(27, 95, NULL, NULL, NULL, '2019-04-21 08:27:10', 'Open-source 24 hour infrastructure'),
(28, 88, NULL, NULL, NULL, '2019-07-04 23:40:43', 'Assimilated disintermediate throughput'),
(29, 81, NULL, NULL, NULL, '2019-10-25 01:55:08', 'Focused 6th generation software'),
(30, 56, NULL, NULL, NULL, '2019-10-21 05:36:47', 'Ameliorated modular groupware'),
(31, 75, NULL, NULL, NULL, '2019-03-18 05:58:19', 'Managed modular matrices'),
(32, 51, NULL, NULL, NULL, '2019-08-26 15:17:44', 'Right-sized value-added firmware'),
(33, 56, NULL, NULL, NULL, '2019-08-20 03:28:17', 'Profound upward-trending concept'),
(34, 94, NULL, NULL, NULL, '2020-03-21 05:56:53', 'Right-sized incremental core'),
(35, 43, NULL, NULL, NULL, '2020-02-21 03:36:46', 'Reverse-engineered incremental analyzer'),
(36, 97, NULL, NULL, NULL, '2019-06-08 14:35:05', 'Networked encompassing open system'),
(37, 62, NULL, NULL, NULL, '2019-06-05 07:58:37', 'Extended systemic artificial intelligence'),
(38, 69, NULL, NULL, NULL, '2020-05-20 13:53:32', 'Multi-channelled 3rd generation function'),
(39, 86, NULL, NULL, NULL, '2020-03-01 03:14:40', 'Down-sized bandwidth-monitored concept'),
(40, 76, NULL, NULL, NULL, '2019-10-10 11:46:01', 'Virtual logistical budgetary management'),
(41, 90, NULL, NULL, NULL, '2019-07-23 06:19:09', 'Centralized scalable moderator'),
(42, 86, NULL, NULL, NULL, '2019-12-02 02:56:24', 'Polarised intangible benchmark'),
(43, 52, NULL, NULL, NULL, '2020-04-01 07:28:42', 'Right-sized optimal initiative'),
(44, 41, NULL, NULL, NULL, '2019-05-20 11:51:41', 'Horizontal local standardization'),
(45, 64, NULL, NULL, NULL, '2019-03-31 06:44:22', 'Extended client-driven archive'),
(46, 51, NULL, NULL, NULL, '2020-01-16 03:31:07', 'Organic didactic project'),
(47, 36, NULL, NULL, NULL, '2020-05-06 20:26:05', 'Total full-range application'),
(48, 86, NULL, NULL, NULL, '2019-09-28 08:25:16', 'Versatile web-enabled functionalities'),
(49, 50, NULL, NULL, NULL, '2019-09-24 04:22:14', 'Pre-emptive maximized functionalities'),
(50, 84, NULL, NULL, NULL, '2020-03-10 18:17:31', 'Vision-oriented value-added conglomeration'),
(51, 53, NULL, NULL, NULL, '2019-10-18 01:33:34', 'Diverse optimizing attitude'),
(52, 88, NULL, NULL, NULL, '2019-06-17 06:59:39', 'Sharable client-driven synergy'),
(53, 63, NULL, NULL, NULL, '2019-04-16 06:34:33', 'Streamlined zero tolerance knowledge user'),
(54, 58, NULL, NULL, NULL, '2019-09-30 21:24:22', 'Ameliorated executive service-desk'),
(55, 40, NULL, NULL, NULL, '2019-07-07 15:21:45', 'Re-engineered value-added intranet'),
(56, 75, NULL, NULL, NULL, '2020-05-29 05:28:46', 'Enhanced scalable budgetary management'),
(57, 84, NULL, NULL, NULL, '2019-09-06 02:25:12', 'De-engineered bandwidth-monitored toolset'),
(58, 33, NULL, NULL, NULL, '2020-02-12 07:48:03', 'Networked solution-oriented parallelism'),
(59, 30, NULL, NULL, NULL, '2019-11-10 16:19:36', 'Synergistic system-worthy product'),
(60, 74, NULL, NULL, NULL, '2019-11-05 03:19:30', 'Versatile fault-tolerant hardware'),
(61, 90, NULL, NULL, NULL, '2020-03-07 21:39:11', 'Switchable modular firmware'),
(62, 94, NULL, NULL, NULL, '2020-05-27 23:53:49', 'Assimilated radical collaboration'),
(63, 99, NULL, NULL, NULL, '2020-03-24 03:13:23', 'Enterprise-wide demand-driven methodology'),
(64, 58, NULL, NULL, NULL, '2019-09-29 17:01:36', 'Vision-oriented dedicated concept'),
(65, 78, NULL, NULL, NULL, '2020-04-18 15:00:06', 'Grass-roots interactive functionalities'),
(66, 68, NULL, NULL, NULL, '2020-01-05 12:10:34', 'Integrated motivating hierarchy'),
(67, 83, NULL, NULL, NULL, '2019-02-23 16:18:03', 'Expanded executive challenge'),
(68, 63, NULL, NULL, NULL, '2020-04-02 01:18:26', 'Adaptive high-level system engine'),
(69, 90, NULL, NULL, NULL, '2019-08-20 10:29:47', 'Robust logistical protocol'),
(70, 99, NULL, NULL, NULL, '2019-04-16 07:40:48', 'Networked exuding capacity'),
(71, 50, NULL, NULL, NULL, '2019-11-03 05:30:38', 'Reactive bifurcated workforce'),
(72, 65, NULL, NULL, NULL, '2020-05-16 10:19:35', 'Optimized asynchronous superstructure'),
(73, 58, NULL, NULL, NULL, '2020-05-20 21:13:48', 'Vision-oriented 5th generation software'),
(74, 84, NULL, NULL, NULL, '2019-03-18 01:23:54', 'Enterprise-wide national concept'),
(75, 61, NULL, NULL, NULL, '2019-09-19 02:33:41', 'Progressive real-time intranet'),
(76, 72, NULL, NULL, NULL, '2020-04-25 01:52:29', 'Optional multi-state knowledge base'),
(77, 32, NULL, NULL, NULL, '2019-08-25 18:53:41', 'Diverse national algorithm'),
(78, 83, NULL, NULL, NULL, '2019-11-06 00:26:26', 'Decentralized methodical ability'),
(79, 49, NULL, NULL, NULL, '2019-08-07 21:46:03', 'Switchable heuristic structure'),
(80, 53, NULL, NULL, NULL, '2019-11-03 15:07:35', 'Enterprise-wide secondary instruction set'),
(81, 98, NULL, NULL, NULL, '2019-10-08 23:09:09', 'Open-architected clear-thinking utilisation'),
(82, 70, NULL, NULL, NULL, '2019-09-19 13:12:18', 'Devolved incremental parallelism'),
(83, 51, NULL, NULL, NULL, '2019-03-31 10:55:23', 'Innovative explicit emulation'),
(84, 92, NULL, NULL, NULL, '2019-07-14 12:11:22', 'Enterprise-wide bandwidth-monitored conglomeration'),
(85, 55, NULL, NULL, NULL, '2019-10-31 23:50:19', 'Inverse incremental data-warehouse'),
(86, 47, NULL, NULL, NULL, '2019-07-08 23:24:28', 'Inverse demand-driven alliance'),
(87, 29, NULL, NULL, NULL, '2019-06-09 14:02:10', 'Customizable logistical capacity'),
(88, 96, NULL, NULL, NULL, '2020-04-22 03:46:09', 'Fully-configurable systematic core'),
(89, 90, NULL, NULL, NULL, '2019-11-04 10:25:58', 'Pre-emptive optimizing protocol'),
(90, 61, NULL, NULL, NULL, '2019-02-20 06:14:27', 'Progressive context-sensitive internet solution'),
(91, 53, NULL, NULL, NULL, '2020-03-28 07:49:20', 'Visionary bifurcated extranet'),
(92, 60, NULL, NULL, NULL, '2020-01-23 16:08:11', 'Fundamental methodical implementation'),
(93, 32, NULL, NULL, NULL, '2020-04-29 03:03:31', 'Reduced system-worthy access'),
(94, 50, NULL, NULL, NULL, '2019-08-08 05:15:48', 'Open-architected optimal analyzer'),
(95, 45, NULL, NULL, NULL, '2019-09-21 03:02:49', 'Organized fresh-thinking installation'),
(96, 80, NULL, NULL, NULL, '2019-06-17 16:57:26', 'Centralized responsive ability'),
(97, 29, NULL, NULL, NULL, '2019-12-22 07:27:52', 'Re-contextualized tertiary concept'),
(98, 51, NULL, NULL, NULL, '2019-11-28 20:53:40', 'Face to face eco-centric initiative'),
(99, 73, NULL, NULL, NULL, '2019-09-18 15:26:09', 'Virtual real-time core'),
(100, 30, NULL, NULL, NULL, '2019-04-19 04:16:37', 'Object-based bi-directional Graphical User Interface'),
(101, NULL, 'Leilah Banke', 'lbanke0@go.com', '772 158 6744', '2019-03-21 14:50:49', 'Customizable analyzing installation'),
(102, NULL, 'Remy Caulket', 'rcaulket1@google.com.au', '795 302 8790', '2019-09-21 19:21:51', 'Realigned next generation solution'),
(103, NULL, 'Calla Simcock', 'csimcock2@dot.gov', '534 228 5256', '2019-11-21 10:08:31', 'Phased didactic access'),
(104, NULL, 'Beverlee Fitt', 'bfitt3@accuweather.com', '317 818 1875', '2019-04-19 18:04:17', 'Integrated multimedia process improvement'),
(105, NULL, 'Sascha McTrustam', 'smctrustam4@huffingtonpost.com', '319 806 9748', '2020-05-03 23:30:39', 'Organic full-range support'),
(106, NULL, 'Florina Ciccottini', 'fciccottini5@youtube.com', '150 224 6444', '2019-02-04 00:41:21', 'Expanded dynamic array'),
(107, NULL, 'Cal Bottrill', 'cbottrill6@kickstarter.com', '246 446 2494', '2019-05-05 17:02:35', 'Visionary coherent protocol'),
(108, NULL, 'Barbe Gascoine', 'bgascoine7@apple.com', '148 648 2661', '2019-02-15 18:56:48', 'Synergistic coherent hub'),
(109, NULL, 'Haywood Raeside', 'hraeside8@chicagotribune.com', '301 738 0760', '2019-06-04 03:27:12', 'Down-sized actuating ability'),
(110, NULL, 'Claudette Delagua', 'cdelagua9@miibeian.gov.cn', '908 549 0958', '2019-08-17 14:06:13', 'Managed background encryption'),
(111, NULL, 'Burl Potteril', 'bpotterila@php.net', '721 380 6009', '2019-07-11 05:52:15', 'Balanced coherent task-force'),
(112, NULL, 'Anders Lockwood', 'alockwoodb@oracle.com', '274 701 8334', '2019-04-04 20:11:09', 'Fundamental upward-trending functionalities'),
(113, NULL, 'Thia Leif', 'tleifc@naver.com', '947 908 9185', '2020-03-26 16:42:50', 'Advanced heuristic matrix'),
(114, NULL, 'Lonnie Pountney', 'lpountneyd@twitter.com', '179 652 1657', '2019-07-01 08:29:15', 'Quality-focused secondary adapter'),
(115, NULL, 'Dewey McGrotty', 'dmcgrottye@4shared.com', '867 688 7781', '2019-05-08 18:12:41', 'Digitized static Graphical User Interface'),
(116, NULL, 'Effie Brookes', 'ebrookesf@blinklist.com', '685 253 1655', '2020-01-11 06:35:01', 'Configurable impactful access'),
(117, NULL, 'Lyle Tothe', 'ltotheg@utexas.edu', '476 771 6123', '2019-06-20 08:56:34', 'Quality-focused context-sensitive initiative'),
(118, NULL, 'Helaina McGettrick', 'hmcgettrickh@t-online.de', '220 978 4613', '2019-03-28 20:24:20', 'Down-sized holistic product'),
(119, NULL, 'Augy Clifford', 'acliffordi@soup.io', '746 717 3652', '2019-02-28 00:38:12', 'Profound background core'),
(120, NULL, 'Domeniga Embra', 'dembraj@sina.com.cn', '112 743 6005', '2020-03-23 15:41:02', 'Compatible actuating local area network'),
(121, NULL, 'Verina Barriball', 'vbarriballk@go.com', '735 564 7289', '2019-07-02 11:56:21', 'Optimized systemic product'),
(122, NULL, 'Allianora Meys', 'ameysl@independent.co.uk', '650 879 0222', '2019-09-22 16:51:02', 'Multi-tiered encompassing infrastructure'),
(123, NULL, 'Jenny Ottewell', 'jottewellm@ehow.com', '693 281 4789', '2019-12-16 14:37:01', 'Configurable next generation task-force'),
(124, NULL, 'Byrom Shepperd', 'bshepperdn@washingtonpost.com', '917 438 7541', '2020-02-12 01:32:04', 'Switchable multimedia artificial intelligence'),
(125, NULL, 'Wolfgang Drew-Clifton', 'wdrewcliftono@china.com.cn', '913 933 4036', '2019-03-31 00:42:20', 'Persistent value-added function'),
(126, NULL, 'Gabbey Farndell', 'gfarndellp@newsvine.com', '755 647 2618', '2020-04-03 10:30:54', 'Optional non-volatile toolset'),
(127, NULL, 'Rennie O\'Leahy', 'roleahyq@360.cn', '308 102 1494', '2019-02-16 15:35:03', 'Devolved local alliance'),
(128, NULL, 'Enrico Batrim', 'ebatrimr@technorati.com', '278 533 5300', '2019-02-17 13:59:49', 'Configurable bifurcated product'),
(129, NULL, 'Kellyann Reddell', 'kreddells@seattletimes.com', '250 763 6344', '2019-09-24 06:21:13', 'Integrated hybrid benchmark'),
(130, NULL, 'Rossie Inglesent', 'ringlesentt@e-recht24.de', '329 778 7637', '2019-04-20 16:12:15', 'Persevering bifurcated challenge'),
(131, NULL, 'Thorndike Duerden', 'tduerdenu@about.com', '502 552 8063', '2019-12-21 03:26:24', 'Multi-layered holistic portal'),
(132, NULL, 'Abie Deddum', 'adeddumv@skype.com', '679 937 0630', '2019-07-31 18:07:57', 'Upgradable asynchronous middleware'),
(133, NULL, 'Zonnya Bartolini', 'zbartoliniw@house.gov', '941 120 2613', '2019-05-03 10:03:32', 'Profound methodical artificial intelligence'),
(134, NULL, 'Nobe Lesmonde', 'nlesmondex@va.gov', '411 141 1309', '2020-02-04 07:40:11', 'Digitized 6th generation firmware'),
(135, NULL, 'Kort Windebank', 'kwindebanky@virginia.edu', '238 364 7664', '2019-05-29 11:56:44', 'Up-sized tangible hierarchy'),
(136, NULL, 'Mycah Keirl', 'mkeirlz@bravesites.com', '153 327 2082', '2019-12-12 13:35:37', 'Phased 24 hour internet solution'),
(137, NULL, 'Steffane Stebbing', 'sstebbing10@yellowpages.com', '534 561 8660', '2020-05-04 09:48:06', 'Grass-roots clear-thinking conglomeration'),
(138, NULL, 'Terrill Colbeck', 'tcolbeck11@over-blog.com', '672 221 2960', '2020-02-07 08:21:38', 'Up-sized real-time Graphic Interface'),
(139, NULL, 'Alyosha Kobieriecki', 'akobieriecki12@bluehost.com', '859 402 7130', '2020-05-18 18:53:19', 'Innovative cohesive orchestration'),
(140, NULL, 'Ainslie Chimienti', 'achimienti13@eepurl.com', '388 596 3274', '2019-11-30 12:37:16', 'Synergized scalable hierarchy');

-- --------------------------------------------------------

--
-- Table structure for table `gesi_usuarios`
--

DROP TABLE IF EXISTS `gesi_usuarios`;
CREATE TABLE IF NOT EXISTS `gesi_usuarios` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nif` varchar(256) NOT NULL,
  `rol` int(1) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `apellidos` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `numero_telefono` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `fecha_ultimo_acceso` datetime DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `grupo` int(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nif_nie` (`nif`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gesi_usuarios`
--

INSERT INTO `gesi_usuarios` (`id`, `nif`, `rol`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `numero_telefono`, `email`, `fecha_ultimo_acceso`, `fecha_registro`, `grupo`) VALUES
(1, '40565712Z', 3, 'Jenny', 'Emerson Trevino', '$2y$10$hvALymDhxCnbWjlO5hkAl.aCsA9pSSVTcF4m/3cXfh7A/m8oFtiyu', '1555-11-17', '612345678', 'jenny.emersontrevino@email.invalid', '2020-05-27 19:45:51', '2020-05-27 16:04:59', NULL),
(2, '06213239L', 3, 'Brynn', 'Cox Baker', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1997-04-18', '972716831', 'brynn.coxbaker@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(3, '66032825D', 3, 'Irma', 'Nixon Floyd', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-10-02', '552167628', 'irma.nixonfloyd@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(4, '94830874B', 3, 'Ima', 'Cooke Trujillo', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-02-18', '284083290', 'ima.cooketrujillo@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(5, '21467053A', 2, 'Reuben', 'James Mayo', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-06-24', '232067986', 'reuben.jamesmayo@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(6, '80352376J', 2, 'Lenore', 'Koch Sweeney', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-02-23', '180292707', 'lenore.kochsweeney@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(7, '23242053R', 2, 'Katell', 'Hunt Mayo', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1996-08-14', '371217033', 'katell.huntmayo@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(8, '97183776J', 2, 'Abbot', 'Kane Mckee', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1995-03-05', '089738863', 'abbot.kanemckee@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(9, '67977135Z', 2, 'Francis', 'Calhoun Hernandez', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-06-17', '825971512', 'francis.calhounhernandez@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(10, '88780375F', 2, 'Eleanor', 'Dalton Cole', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1996-12-13', '978632241', 'eleanor.daltoncole@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(11, '49526324X', 2, 'Rhonda', 'Chandler Vincent', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-08-05', '309586425', 'rhonda.chandlervincent@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(12, '10990542S', 2, 'September', 'Fry Black', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-10-01', '430175195', 'september.fryblack@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(13, '29606868A', 2, 'Zia', 'Farmer Duke', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-12-17', '661249591', 'zia.farmerduke@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(14, '13118010Y', 2, 'Ina', 'Sweet Aguilar', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1995-12-13', '136547414', 'ina.sweetaguilar@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(15, '86635323G', 2, 'Omar', 'Delgado Barton', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-04-27', '717724070', 'omar.delgadobarton@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(16, '02832674V', 2, 'Yvette', 'Schwartz Mueller', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-02-16', '831425028', 'yvette.schwartzmueller@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(17, '29485554Z', 2, 'Vielka', 'Walls Lang', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2004-08-12', '974296510', 'vielka.wallslang@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(18, '26614904V', 2, 'Brett', 'Odom Brown', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1995-10-04', '433614841', 'brett.odombrown@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(19, '09240056J', 2, 'Catherine', 'Wynn Gray', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-08-27', '238530628', 'catherine.wynngray@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(20, '26429272H', 2, 'Felix', 'Duffy Hayes', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-10-03', '675732955', 'felix.duffyhayes@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(21, '19111471N', 2, 'Emerald', 'Thomas Suarez', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-03-11', '757414607', 'emerald.thomassuarez@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(22, '91720004Y', 2, 'Abel', 'Garza Bonner', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-02-12', '477886706', 'abel.garzabonner@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(23, '00448690Y', 2, 'Zeus', 'Emerson Reilly', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1998-02-14', '484838772', 'zeus.emersonreilly@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(24, '08235669J', 2, 'Carolyn', 'Mclean Kelly', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1998-01-07', '028188846', 'carolyn.mcleankelly@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(25, '08683419E', 2, 'Blair', 'Gonzalez Head', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-04-23', '233127411', 'blair.gonzalezhead@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(26, '42541795Y', 2, 'Mufutau', 'Ochoa Mills', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-08-19', '705790939', 'mufutau.ochoamills@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(27, '13343498W', 2, 'Maya', 'George Berry', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-09-07', '524584303', 'maya.georgeberry@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(28, '48412979A', 2, 'David', 'Richmond Rasmussen', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-11-03', '076511032', 'david.richmondrasmussen@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(29, '85993374P', 1, 'Brendan', 'Lowe Collins', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1997-12-10', '896669170', 'brendan.lowecollins@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(30, '66784074D', 1, 'Amal', 'Sexton Leblanc', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-10-31', '370035678', 'amal.sextonleblanc@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(31, '22397307E', 1, 'Seth', 'Merritt Hogan', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-01-11', '703389131', 'seth.merritthogan@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(32, '31906673S', 1, 'Hermione', 'Gill Mcgowan', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-10-16', '424147501', 'hermione.gillmcgowan@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(33, '59912132F', 1, 'Kaseem', 'Barker Fernandez', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2004-01-27', '578743292', 'kaseem.barkerfernandez@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(34, '17516850G', 1, 'Ryder', 'Wiggins Ballard', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-10-21', '390751153', 'ryder.wigginsballard@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(35, '46065148N', 1, 'Uta', 'Tucker Vaughan', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-04-01', '326315323', 'uta.tuckervaughan@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(36, '48390223V', 1, 'Farrah', 'Mcgee Stevens', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-09-10', '199891370', 'farrah.mcgeestevens@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(37, '39420538X', 1, 'Christopher', 'Leblanc Pittman', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-11-02', '259852221', 'christopher.leblancpittman@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(38, '01733208C', 1, 'Meredith', 'Manning Anthony', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1996-07-23', '817892438', 'meredith.manninganthony@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(39, '74219189Y', 1, 'Serina', 'Bruce Solis', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-08-05', '668550911', 'serina.brucesolis@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(40, '04901381N', 1, 'Katell', 'Leach Eaton', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-06-07', '497824457', 'katell.leacheaton@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(41, '00442084R', 1, 'Rhiannon', 'Good Sparks', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-06-21', '266872766', 'rhiannon.goodsparks@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(42, '93914091P', 1, 'Charissa', 'Morgan Trevino', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2004-06-11', '801513726', 'charissa.morgantrevino@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(43, '23292395L', 1, 'Indira', 'Ayers Payne', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-10-16', '499523770', 'indira.ayerspayne@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(44, '55189159S', 1, 'Axel', 'Dennis Gardner', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1998-04-30', '097814101', 'axel.dennisgardner@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(45, '38469431E', 1, 'Cecilia', 'Swanson Henry', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-03-24', '048984194', 'cecilia.swansonhenry@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(46, '35051008C', 1, 'Lila', 'Cantrell Love', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-12-19', '400076958', 'lila.cantrelllove@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(47, '55062350M', 1, 'Bree', 'Rollins Griffith', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-01-26', '359945069', 'bree.rollinsgriffith@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(48, '18253087B', 1, 'Samantha', 'Gill Snider', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-01-07', '755154030', 'samantha.gillsnider@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(49, '18293732S', 1, 'Elliott', 'Wilkinson Schwartz', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-01-19', '951466631', 'elliott.wilkinsonschwartz@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(50, '44323735K', 1, 'Macey', 'Blevins Fleming', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1998-09-29', '451561020', 'macey.blevinsfleming@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(51, '13492780Z', 1, 'Sigourney', 'King Bright', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-11-19', '279800845', 'sigourney.kingbright@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(52, '89772793K', 1, 'Reuben', 'Cote Maxwell', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2004-04-04', '469275613', 'reuben.cotemaxwell@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(53, '26448923G', 1, 'Jaquelyn', 'Ramirez Roberts', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-10-10', '498825545', 'jaquelyn.ramirezroberts@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(54, '21578628M', 1, 'Elton', 'Sykes Doyle', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1997-09-04', '228239059', 'elton.sykesdoyle@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(55, '94638985B', 1, 'Amery', 'Mcmillan Morris', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-01-15', '470806430', 'amery.mcmillanmorris@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(56, '39024408D', 1, 'Carissa', 'Bonner Santos', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-10-09', '197942290', 'carissa.bonnersantos@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(57, '06646496W', 1, 'Arthur', 'Lynch Dawson', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-12-02', '743939418', 'arthur.lynchdawson@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(58, '01420085L', 1, 'Prescott', 'Collins Wall', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-12-29', '612516447', 'prescott.collinswall@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(59, '53632830G', 1, 'Victor', 'Hooper Pickett', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-06-05', '511728896', 'victor.hooperpickett@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(60, '86419143R', 1, 'Hayes', 'Garrison Knowles', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-04-05', '869373765', 'hayes.garrisonknowles@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(61, '10884840K', 1, 'Evan', 'Kinney Leonard', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-10-30', '190843824', 'evan.kinneyleonard@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(62, '23274195N', 1, 'Deanna', 'Hewitt Dyer', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-07-04', '693446812', 'deanna.hewittdyer@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(63, '02571894B', 1, 'Fay', 'Tran Herring', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-09-30', '332471400', 'fay.tranherring@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(64, '54406830P', 1, 'Alfonso', 'Hodges Gallegos', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-05-20', '371209097', 'alfonso.hodgesgallegos@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(65, '32585214X', 1, 'Heidi', 'Simon Nichols', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-09-29', '124114403', 'heidi.simonnichols@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(66, '62045803Z', 1, 'Uriel', 'Mathis Leonard', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-02-28', '763398591', 'uriel.mathisleonard@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(67, '44043704S', 1, 'Kevin', 'Slater Bradley', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-08-25', '676752936', 'kevin.slaterbradley@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(68, '36367913Z', 1, 'Wing', 'Hampton Horn', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1996-02-21', '590115796', 'wing.hamptonhorn@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(69, '67424662R', 1, 'Cameran', 'Ballard Briggs', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-12-23', '005957937', 'cameran.ballardbriggs@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(70, '12955546Z', 1, 'Amber', 'Bruce Bond', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-10-28', '700691239', 'amber.brucebond@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(71, '38210281J', 1, 'Samson', 'Massey Sullivan', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2004-09-27', '322064687', 'samson.masseysullivan@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(72, '29108908Q', 1, 'Callum', 'Holland Holder', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-11-26', '761573324', 'callum.hollandholder@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(73, '40849471E', 1, 'Lionel', 'Golden Guerra', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1993-06-17', '486002149', 'lionel.goldenguerra@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(74, '37068015L', 1, 'Neil', 'Lucas Dillon', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-12-05', '944131313', 'neil.lucasdillon@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(75, '94004103K', 1, 'Jin', 'Lindsay Hurst', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-06-18', '841554109', 'jin.lindsayhurst@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(76, '13430995F', 1, 'Alexa', 'Holman Woodard', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-10-25', '364814432', 'alexa.holmanwoodard@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(77, '41009935S', 1, 'Naomi', 'Weaver Gomez', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-09-29', '633026517', 'naomi.weavergomez@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(78, '34993899C', 1, 'Fay', 'Sawyer Hill', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-01-19', '708197182', 'fay.sawyerhill@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(79, '34380227B', 1, 'Upton', 'Conway Thornton', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-10-07', '026525261', 'upton.conwaythornton@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(80, '73959118L', 1, 'Allegra', 'Quinn Cruz', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-07-27', '532231136', 'allegra.quinncruz@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(81, '07151138R', 1, 'Bell', 'Kirkland Adams', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-10-04', '892073268', 'bell.kirklandadams@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(82, '72865558V', 1, 'Hanae', 'Ferguson Ingram', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-04-17', '139763303', 'hanae.fergusoningram@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(83, '15439588X', 1, 'Neville', 'Bryan Baldwin', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-09-28', '576637318', 'neville.bryanbaldwin@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(84, '03703076F', 1, 'Steel', 'Harrell Horn', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2000-04-08', '645032606', 'steel.harrellhorn@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(85, '34308105V', 1, 'Justina', 'Frazier Berg', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-06-25', '568724661', 'justina.frazierberg@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(86, '04702953M', 1, 'Xandra', 'Hayden Grimes', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1995-07-07', '578114524', 'xandra.haydengrimes@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(87, '18638485K', 1, 'Rhiannon', 'Carpenter Rutledge', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1998-03-14', '322777296', 'rhiannon.carpenterrutledge@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(88, '95860777C', 1, 'Daria', 'Moore Dudley', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-09-23', '203997886', 'daria.mooredudley@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(89, '74391957K', 1, 'Shelby', 'Craft Goff', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2005-10-06', '935786111', 'shelby.craftgoff@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(90, '55818762Q', 1, 'Mercedes', 'Moss Russo', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-01-01', '449241195', 'mercedes.mossrusso@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(91, '01706578R', 1, 'Keane', 'Massey Zamora', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-09-28', '099174611', 'keane.masseyzamora@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(92, '61956895R', 1, 'Pearl', 'Mays Kim', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1999-08-27', '653765303', 'pearl.mayskim@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(93, '95745830G', 1, 'Louis', 'Yates Gay', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2003-12-20', '412656659', 'louis.yatesgay@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(94, '35138990G', 1, 'Kamal', 'Harris Gould', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2002-03-01', '356332932', 'kamal.harrisgould@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(95, '78860275Z', 1, 'Ebony', 'Fox Porter', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1997-09-17', '376105824', 'ebony.foxporter@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(96, '29377124Y', 1, 'Xandra', 'Pittman Williams', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1994-12-03', '049013626', 'xandra.pittmanwilliams@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(97, '87974064F', 1, 'Sopoline', 'Hanson Carpenter', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2001-07-02', '049490469', 'sopoline.hansoncarpenter@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(98, '54767205L', 1, 'Neil', 'Hurley Perry', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '2004-07-29', '501163074', 'neil.hurleyperry@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(99, '87501711M', 1, 'Serena', 'Gilbert Potts', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1995-12-30', '230706449', 'serena.gilbertpotts@email.invalid', NULL, '2020-05-27 00:00:00', NULL),
(100, '12672046N', 1, 'Blossom', 'Hutchinson Decker', '$PDH8978t2GGzMzYgr0RmU.M83ih7VtRSIA.C.PWf.emHi4wkoZsVq', '1996-06-14', '054144217', 'blossom.hutchinsondecker@email.invalid', NULL, '2020-05-27 00:00:00', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gesi_asignaciones`
--
ALTER TABLE `gesi_asignaciones`
  ADD CONSTRAINT `gesi_asignaciones_fk_asignatura` FOREIGN KEY (`asignatura`) REFERENCES `gesi_asignaturas` (`id`),
  ADD CONSTRAINT `gesi_asignaciones_fk_foro_principal` FOREIGN KEY (`foro_principal`) REFERENCES `gesi_foros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_asignaciones_fk_grupo` FOREIGN KEY (`grupo`) REFERENCES `gesi_grupos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_asignaciones_fk_profesor` FOREIGN KEY (`profesor`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gesi_ejemplar_libro`
--
ALTER TABLE `gesi_ejemplar_libro`
  ADD CONSTRAINT `gesi_ejemplar_libro_fk_libro` FOREIGN KEY (`libro`) REFERENCES `gesi_libros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_ejemplar_libro_fk_usuario_prestamo` FOREIGN KEY (`usuario_prestamo`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_ejemplar_libro_fk_usuario_reserva` FOREIGN KEY (`usuario_reserva`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gesi_eventos`
--
ALTER TABLE `gesi_eventos`
  ADD CONSTRAINT `gesi_eventos_fk_asignacion` FOREIGN KEY (`asignacion`) REFERENCES `gesi_asignaciones` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_eventos_fk_asignatura` FOREIGN KEY (`asignatura`) REFERENCES `gesi_asignaturas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gesi_grupos`
--
ALTER TABLE `gesi_grupos`
  ADD CONSTRAINT `gesi_grupos_fk_tutor` FOREIGN KEY (`tutor`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gesi_libros`
--
ALTER TABLE `gesi_libros`
  ADD CONSTRAINT `gesi_libros_fk_asignatura` FOREIGN KEY (`asignatura`) REFERENCES `gesi_asignaturas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gesi_mensajes_foros`
--
ALTER TABLE `gesi_mensajes_foros`
  ADD CONSTRAINT `gesi_mensajes_foros_fk_foro` FOREIGN KEY (`foro`) REFERENCES `gesi_foros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_mensajes_foros_fk_padre` FOREIGN KEY (`padre`) REFERENCES `gesi_mensajes_foros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_mensajes_foros_fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `gesi_mensajes_secretaria`
--
ALTER TABLE `gesi_mensajes_secretaria`
  ADD CONSTRAINT `gesi_mensajes_secretaria_fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `gesi_usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
