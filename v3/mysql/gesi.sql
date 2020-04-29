-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-04-2020 a las 19:14:01
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gesi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_asignacion`
--

DROP TABLE IF EXISTS `gesi_asignacion`;
CREATE TABLE IF NOT EXISTS `gesi_asignacion` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `profesor` int(16) NOT NULL,
  `grupo` int(16) NOT NULL,
  `asignatura` int(16) NOT NULL,
  `horario` varchar(512) NOT NULL,
  `foro_principal` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_asignaturas`
--

DROP TABLE IF EXISTS `gesi_asignaturas`;
CREATE TABLE IF NOT EXISTS `gesi_asignaturas` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `curso_escolar` int(16) NOT NULL,
  `nombre_corto` varchar(256) NOT NULL,
  `nombre_completo` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_ejemplar_libro`
--

DROP TABLE IF EXISTS `gesi_ejemplar_libro`;
CREATE TABLE IF NOT EXISTS `gesi_ejemplar_libro` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `numero` int(16) NOT NULL,
  `libro` int(16) NOT NULL,
  `prestado` int(11) DEFAULT NULL,
  `fecha_alta_prestamo` int(11) DEFAULT NULL,
  `fecha_expiracion_prestamo` int(11) DEFAULT NULL,
  `reserva` int(11) DEFAULT NULL,
  `fecha_alta_reserva` int(11) DEFAULT NULL,
  `fecha_expiracion_reserva` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_eventos`
--

DROP TABLE IF EXISTS `gesi_eventos`;
CREATE TABLE IF NOT EXISTS `gesi_eventos` (
  `id` int(16) NOT NULL,
  `fecha` int(16) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `lugar` varchar(256) NOT NULL,
  `asignatura` int(16) DEFAULT NULL,
  `asignacion` int(16) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_foros`
--

DROP TABLE IF EXISTS `gesi_foros`;
CREATE TABLE IF NOT EXISTS `gesi_foros` (
  `id` int(16) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `asignacion` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_grupos`
--

DROP TABLE IF EXISTS `gesi_grupos`;
CREATE TABLE IF NOT EXISTS `gesi_grupos` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `curso_escolar` int(16) NOT NULL,
  `nombre_corto` varchar(256) NOT NULL,
  `nombre_completo` varchar(256) NOT NULL,
  `tutor` int(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_libros`
--

DROP TABLE IF EXISTS `gesi_libros`;
CREATE TABLE IF NOT EXISTS `gesi_libros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autor` varchar(256) NOT NULL,
  `titulo` varchar(256) NOT NULL,
  `asignatura` int(16) DEFAULT NULL,
  `isbn` int(32) NOT NULL,
  `editorial` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_mensajes_foros`
--

DROP TABLE IF EXISTS `gesi_mensajes_foros`;
CREATE TABLE IF NOT EXISTS `gesi_mensajes_foros` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `foro` int(16) NOT NULL,
  `padre` int(16) DEFAULT NULL,
  `usuario` int(16) NOT NULL,
  `contenido` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_mensajes_secretaria`
--

DROP TABLE IF EXISTS `gesi_mensajes_secretaria`;
CREATE TABLE IF NOT EXISTS `gesi_mensajes_secretaria` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `usuario` int(16) DEFAULT NULL,
  `from_nombre` varchar(256) DEFAULT NULL,
  `from_email` varchar(256) DEFAULT NULL,
  `from_telefono` int(16) DEFAULT NULL,
  `fecha` int(16) NOT NULL,
  `contenido` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_usuarios`
--

DROP TABLE IF EXISTS `gesi_usuarios`;
CREATE TABLE IF NOT EXISTS `gesi_usuarios` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `nif` varchar(256) NOT NULL,
  `rol` int(1) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `apellidos` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `fecha_nacimiento` int(16) NOT NULL,
  `numero_telefono` int(16) NOT NULL,
  `email` varchar(256) NOT NULL,
  `fecha_ultimo_acceso` int(16) DEFAULT NULL,
  `fecha_registro` int(16) NOT NULL,
  `grupo` int(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nif_nie` (`nif`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gesi_usuarios`
--

INSERT INTO `gesi_usuarios` (`id`, `nif`, `rol`, `nombre`, `apellidos`, `password`, `fecha_nacimiento`, `numero_telefono`, `email`, `fecha_ultimo_acceso`, `fecha_registro`, `grupo`) VALUES
(1, '00000001R', 1, 'María', 'Casas Ortuño', '$2y$10$hvALymDhxCnbWjlO5hkAl.aCsA9pSSVTcF4m/3cXfh7A/m8oFtiyu', 942796800, 612345678, 'marcasort@localhost', 1585846984, 1585699200, NULL),
(2, '00000002W', 2, 'Mariano', 'Sánchez González', '$2y$10$hvALymDhxCnbWjlO5hkAl.aCsA9pSSVTcF4m/3cXfh7A/m8oFtiyu', 942796800, 612345678, 'marsangon@localhost', 0, 1585699200, NULL),
(3, '00000003A', 3, 'Fernando', 'Martínez Perez', '$2y$10$hvALymDhxCnbWjlO5hkAl.aCsA9pSSVTcF4m/3cXfh7A/m8oFtiyu', 942796800, 612345678, 'fermarper@localhost', 1585847021, 1585699200, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
