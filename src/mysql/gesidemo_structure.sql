-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 16, 2020 at 03:35 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `gesi_foros`
--

DROP TABLE IF EXISTS `gesi_foros`;
CREATE TABLE IF NOT EXISTS `gesi_foros` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
