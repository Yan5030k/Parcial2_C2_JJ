-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-04-2026 a las 23:25:21
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
-- Base de datos: `xiaomi_sv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hogar_inteligente`
--

CREATE TABLE `hogar_inteligente` (
  `id_dispositivo` int(11) NOT NULL,
  `nombre_equipo` varchar(100) NOT NULL,
  `categoria_hogar` varchar(50) NOT NULL,
  `garantia_meses` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hogar_inteligente`
--

INSERT INTO `hogar_inteligente` (`id_dispositivo`, `nombre_equipo`, `categoria_hogar`, `garantia_meses`, `observaciones`) VALUES
(1, 'Mi Robot Vacuum S10', 'Limpieza', 12, 'Navegación láser LDS'),
(2, 'Xiaomi Smart Pet Feeder', 'Mascotas', 6, NULL),
(3, 'Mi Smart Air Fryer', 'Cocina', 12, 'Capacidad 3.5L con OLED'),
(4, 'Xiaomi Mi Body Composition Scale 2', 'Salud', 6, 'Mide 13 puntos de datos corporales'),
(5, 'Xiaomi Smart Camera C400', 'Seguridad', 12, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `smartphones`
--

CREATE TABLE `smartphones` (
  `id_celular` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `especificaciones_adicionales` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `smartphones`
--

INSERT INTO `smartphones` (`id_celular`, `modelo`, `serie`, `precio`, `especificaciones_adicionales`) VALUES
(1, 'Xiaomi 14 Ultra', 'Serie 14', 1199.99, 'Cámara Leica de última generación'),
(2, 'Redmi Note 13', 'Serie Note', 250.00, NULL),
(3, 'Poco F6 Pro', 'Serie Poco', 550.00, 'Carga rápida 120W'),
(4, 'Xiaomi 13T', 'Serie T', 480.00, NULL),
(5, 'Redmi A3', 'Serie A', 110.00, 'Pantalla 90Hz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_completo`, `username`, `password`, `rol`) VALUES
(1, 'Administrador UGB', 'admin', 'admin123', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hogar_inteligente`
--
ALTER TABLE `hogar_inteligente`
  ADD PRIMARY KEY (`id_dispositivo`);

--
-- Indices de la tabla `smartphones`
--
ALTER TABLE `smartphones`
  ADD PRIMARY KEY (`id_celular`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hogar_inteligente`
--
ALTER TABLE `hogar_inteligente`
  MODIFY `id_dispositivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `smartphones`
--
ALTER TABLE `smartphones`
  MODIFY `id_celular` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
