-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2024 a las 09:11:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `neuro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `fecha_create` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_carpeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpetas`
--

CREATE TABLE `carpetas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_create` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_archivos`
--

CREATE TABLE `detalle_archivos` (
  `id` int(11) NOT NULL,
  `fecha_add` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `correo` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_carpeta` int(11) NOT NULL,
  `id_archivo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `perfil` varchar(100) DEFAULT NULL,
  `clave` varchar(200) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `telefono`, `direccion`, `perfil`, `clave`, `token`, `fecha`, `estado`, `rol`) VALUES
(1, 'Álvaro', 'Medina', 'medinamomparler@gmail.com', '602024110', 'Valencia', 'NULL', '$2y$10$U1uPsIRpcGWYHiklnp7N4..M/9rdTC1z8tqlIkWoU91PiOndE0/Sy', 'NULL', '2024-05-09 16:23:12', 2, 1),
(2, 'Jose', 'Andrés', 'jose@gmail.com', '602024112', 'Cancún', NULL, '$2y$10$U1uPsIRpcGWYHiklnp7N4..M/9rdTC1z8tqlIkWoU91PiOndE0/Sy', NULL, '2024-05-09 17:39:12', 1, 0),
(3, 'Álvaro', 'Medina', 'alvacamole87@gmail.com', '602024119', 'Valencia', NULL, '$2y$10$U1uPsIRpcGWYHiklnp7N4..M/9rdTC1z8tqlIkWoU91PiOndE0/Sy', NULL, '2024-05-09 20:31:50', 1, 2),
(4, 'Jose', 'Aristides', 'josearistides@gmail.com', '41245125', 'Caldea', NULL, '$2y$10$oQPTN5yJEX/TQc96b50O8u8SqFqfQKboyiqYDF.m73N1j/m15aYRy', NULL, '2024-05-09 16:12:12', 1, 2),
(5, 'Javier', 'Domiguez', 'javi12@gmail.com', '667676674', 'Elche', NULL, '$2y$10$2T84lu9FLXnR8ZFlGhaFJ.znWCNLAPgOWJhFvXyyvmcLt60VQX92W', NULL, '2024-05-09 17:32:20', 1, 2),
(6, 'Miguel', 'Andrés', 'miguelandres@gmail.com', '602024115', 'Cancún', NULL, '$2y$10$g.4rcVoGebPuXGtUB7B0n.oFISfSXxLnS9dajq2uqgsnSnAMz0cIy', NULL, '2024-05-09 18:04:50', 1, 2),
(7, 'Miguel', 'Trujillo', 'asmonjol@gmail.com', '4234324', 'USA', NULL, '$2y$10$bMedxN2VHMso9SxqpZdUCu8r9dRszNibFLEoD1d5KU//ZDmyzk59q', NULL, '2024-05-09 18:02:10', 1, 2),
(8, 'Perez', 'Reverte', 'perez@gmail.com', '443212321', 'España', NULL, '$2y$10$O1AEiEYhBD4/9smS26/UY.I46Q4qiV4aYWfMH/D0hAgrNFuJo4h4W', NULL, '2024-05-09 18:00:16', 1, 2),
(9, 'Federico', 'Garcia Lorca', 'lorca@gmail.com', '4324235', 'Sevilla', NULL, '$2y$10$.XH1EBo186RBsJ9b2VV8.Ov9dfOc1H9VW9ksepPbrYxHbYFjm2QKO', NULL, '2024-05-09 18:01:04', 1, 2),
(10, 'Javier', 'Balilla', 'balilla@gmail.com', '602021111', 'Valencia', NULL, '$2y$10$vg//eZCGGA2Bmw7C7azpSugYxcOJ2khvr19XZONeFGV6TKim8F1Am', NULL, '2024-05-09 18:03:46', 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carpeta` (`id_carpeta`);

--
-- Indices de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_archivos`
--
ALTER TABLE `detalle_archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_archivo` (`id_archivo`),
  ADD KEY `id_carpeta` (`id_carpeta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_archivos`
--
ALTER TABLE `detalle_archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`id_carpeta`) REFERENCES `carpetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD CONSTRAINT `carpetas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_archivos`
--
ALTER TABLE `detalle_archivos`
  ADD CONSTRAINT `detalle_archivos_ibfk_1` FOREIGN KEY (`id_archivo`) REFERENCES `archivos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_archivos_ibfk_2` FOREIGN KEY (`id_carpeta`) REFERENCES `carpetas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_archivos_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
