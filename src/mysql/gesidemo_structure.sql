-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: vm02.db.swarm.test
-- Tiempo de generación: 18-06-2020 a las 20:56:09
-- Versión del servidor: 10.4.12-MariaDB-1:10.4.12+maria~bionic
-- Versión de PHP: 7.4.1

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
-- Estructura de tabla para la tabla `gesi_asignaciones`
--

CREATE TABLE `gesi_asignaciones` (
  `id` int(16) NOT NULL,
  `profesor` int(16) NOT NULL,
  `grupo` int(16) NOT NULL,
  `asignatura` int(16) NOT NULL,
  `horario` varchar(512) NOT NULL,
  `foro_principal` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_asignaturas`
--

CREATE TABLE `gesi_asignaturas` (
  `id` int(16) NOT NULL,
  `nivel` int(1) NOT NULL,
  `curso_escolar` int(16) NOT NULL,
  `nombre_corto` varchar(256) NOT NULL,
  `nombre_completo` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_eventos`
--

CREATE TABLE `gesi_eventos` (
  `id` int(16) NOT NULL,
  `fecha` datetime NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `lugar` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_foros`
--

CREATE TABLE `gesi_foros` (
  `id` int(16) NOT NULL,
  `nombre` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_grupos`
--

CREATE TABLE `gesi_grupos` (
  `id` int(16) NOT NULL,
  `nivel` int(1) NOT NULL,
  `curso_escolar` int(16) NOT NULL,
  `nombre_corto` varchar(256) NOT NULL,
  `nombre_completo` varchar(256) NOT NULL,
  `tutor` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_mensajes_foros`
--

CREATE TABLE `gesi_mensajes_foros` (
  `id` int(16) NOT NULL,
  `foro` int(16) NOT NULL,
  `padre` int(16) DEFAULT NULL,
  `usuario` int(16) NOT NULL,
  `fecha` datetime NOT NULL,
  `contenido` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_mensajes_secretaria`
--

CREATE TABLE `gesi_mensajes_secretaria` (
  `id` int(16) NOT NULL,
  `usuario` int(16) DEFAULT NULL,
  `from_nombre` varchar(256) DEFAULT NULL,
  `from_email` varchar(256) DEFAULT NULL,
  `from_telefono` varchar(32) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `contenido` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gesi_usuarios`
--

CREATE TABLE `gesi_usuarios` (
  `id` int(16) NOT NULL,
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
  `grupo` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gesi_asignaciones`
--
ALTER TABLE `gesi_asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_grupo_asignatura` (`grupo`,`asignatura`),
  ADD UNIQUE KEY `unique_foro_principal` (`foro_principal`),
  ADD KEY `profesor` (`profesor`),
  ADD KEY `grupo` (`grupo`),
  ADD KEY `asignatura` (`asignatura`),
  ADD KEY `foro_principal` (`foro_principal`);

--
-- Indices de la tabla `gesi_asignaturas`
--
ALTER TABLE `gesi_asignaturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gesi_eventos`
--
ALTER TABLE `gesi_eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gesi_foros`
--
ALTER TABLE `gesi_foros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gesi_grupos`
--
ALTER TABLE `gesi_grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutor` (`tutor`);

--
-- Indices de la tabla `gesi_mensajes_foros`
--
ALTER TABLE `gesi_mensajes_foros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foro` (`foro`),
  ADD KEY `padre` (`padre`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `gesi_mensajes_secretaria`
--
ALTER TABLE `gesi_mensajes_secretaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `gesi_usuarios`
--
ALTER TABLE `gesi_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nif_nie` (`nif`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gesi_asignaciones`
--
ALTER TABLE `gesi_asignaciones`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_asignaturas`
--
ALTER TABLE `gesi_asignaturas`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_eventos`
--
ALTER TABLE `gesi_eventos`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_foros`
--
ALTER TABLE `gesi_foros`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_grupos`
--
ALTER TABLE `gesi_grupos`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_mensajes_foros`
--
ALTER TABLE `gesi_mensajes_foros`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_mensajes_secretaria`
--
ALTER TABLE `gesi_mensajes_secretaria`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gesi_usuarios`
--
ALTER TABLE `gesi_usuarios`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gesi_asignaciones`
--
ALTER TABLE `gesi_asignaciones`
  ADD CONSTRAINT `gesi_asignaciones_fk_asignatura` FOREIGN KEY (`asignatura`) REFERENCES `gesi_asignaturas` (`id`),
  ADD CONSTRAINT `gesi_asignaciones_fk_foro_principal` FOREIGN KEY (`foro_principal`) REFERENCES `gesi_foros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_asignaciones_fk_grupo` FOREIGN KEY (`grupo`) REFERENCES `gesi_grupos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_asignaciones_fk_profesor` FOREIGN KEY (`profesor`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `gesi_grupos`
--
ALTER TABLE `gesi_grupos`
  ADD CONSTRAINT `gesi_grupos_fk_tutor` FOREIGN KEY (`tutor`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `gesi_mensajes_foros`
--
ALTER TABLE `gesi_mensajes_foros`
  ADD CONSTRAINT `gesi_mensajes_foros_fk_foro` FOREIGN KEY (`foro`) REFERENCES `gesi_foros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_mensajes_foros_fk_padre` FOREIGN KEY (`padre`) REFERENCES `gesi_mensajes_foros` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gesi_mensajes_foros_fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `gesi_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `gesi_mensajes_secretaria`
--
ALTER TABLE `gesi_mensajes_secretaria`
  ADD CONSTRAINT `gesi_mensajes_secretaria_fk_usuario` FOREIGN KEY (`usuario`) REFERENCES `gesi_usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
