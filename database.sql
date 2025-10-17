-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-10-2025 a las 15:06:11
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `instituto_api_docentes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Enfermería Técnica', 'Formación en cuidados de enfermería y atención primaria en salud.', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(2, 'Industrias Alimentarias', 'Formación en procesos de producción, conservación y control de calidad de alimentos.', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(3, 'Producción Agropecuaria', 'Formación en técnicas de producción agrícola y pecuaria.', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(4, 'Mecatrónica Automotriz', 'Formación en mantenimiento, diagnóstico y reparación de sistemas mecánicos, eléctricos y electrónicos de vehículos.', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(5, 'Diseño y Programación Web', 'Formación en diseño y desarrollo de aplicaciones web y móviles.', '2025-09-05 14:07:30', '2025-09-05 14:07:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_api`
--

CREATE TABLE `client_api` (
  `id` int(11) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `client_api`
--

INSERT INTO `client_api` (`id`, `ruc`, `razon_social`, `telefono`, `correo`, `fecha_registro`, `estado`) VALUES
(1, '123214134', '314314', '214144', 'asfsas@gmail.com', '2025-09-19 09:42:44', 1),
(2, '123231312', '3123123', '12321', '3213213@GMAIL.COM', '2025-09-19 09:53:25', 1),
(3, '32143124', '12412431', '14134341', '3123sdc@gmail.com', '2025-09-19 10:11:19', 1),
(4, '32143124', 'ALEXIA', '123123', '3123sdc@gmail.com', '2025-10-03 08:49:52', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `count_request`
--

CREATE TABLE `count_request` (
  `id` int(11) NOT NULL,
  `id_token` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo` enum('Teoría','Práctica') NOT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nombre`, `tipo`, `id_carrera`, `created_at`, `updated_at`) VALUES
(22, 'Topografía Agrícola', 'Teoría', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(23, 'Topografía Agrícola', 'Práctica', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(24, 'Comunicación Oral', 'Teoría', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(25, 'Mecanización Agrícola', 'Teoría', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(26, 'Mecanización Agrícola', 'Práctica', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(27, 'Manejo y Conservación de Suelos', 'Teoría', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(28, 'Manejo y Conservación de Suelos', 'Práctica', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(29, 'Instalaciones Agropecuarias', 'Teoría', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(30, 'Instalaciones Agropecuarias', 'Práctica', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(31, 'Operación de Sistemas de Riego', 'Teoría', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(32, 'Operación de Sistemas de Riego', 'Práctica', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(33, 'Seguridad y Salud en el Trabajo', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(34, 'Seguridad y Salud en el Trabajo', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(35, 'Aplicaciones en Internet', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(36, 'Aplicaciones en Internet', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(37, 'Asistencia en Inmunizaciones', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(38, 'Asistencia en Inmunizaciones', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(39, 'Promoción de la Salud', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(40, 'Promoción de la Salud', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(41, 'Salud Comunitaria', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(42, 'Salud Comunitaria', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(43, 'Comunicación Oral', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(44, 'Comunicación Oral', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(45, 'Educación para la Salud', 'Teoría', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(46, 'Educación para la Salud', 'Práctica', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(47, 'Mantenimiento Preventivo de la Suspensión, Dirección y Frenos', 'Teoría', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(48, 'Mantenimiento Preventivo de la Suspensión, Dirección y Frenos', 'Práctica', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(49, 'Mecánica de Taller y Metrología Automotriz', 'Teoría', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(50, 'Mecánica de Taller y Metrología Automotriz', 'Práctica', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(51, 'Mantenimiento Automotriz', 'Teoría', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(52, 'Mantenimiento Automotriz', 'Práctica', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(53, 'Aplicaciones en Internet', 'Teoría', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(54, 'Aplicaciones en Internet', 'Práctica', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(55, 'Seguridad Laboral', 'Teoría', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(56, 'Seguridad Laboral', 'Práctica', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(57, 'Almacenamiento de Materias Primas e Insumos', 'Teoría', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(58, 'Almacenamiento de Materias Primas e Insumos', 'Práctica', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(59, 'Recepción de Materias Primas e Insumos', 'Teoría', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(60, 'Recepción de Materias Primas e Insumos', 'Práctica', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(61, 'Buenas Prácticas de Manufactura', 'Teoría', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(62, 'Maquinaria y Equipos en la Recepción y Clasificación de la Materia Prima', 'Teoría', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(63, 'Maquinaria y Equipos en la Recepción y Clasificación de la Materia Prima', 'Práctica', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(64, 'Química Aplicada', 'Teoría', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(65, 'Química Aplicada', 'Práctica', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(66, 'Redes e Internet', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(67, 'Redes e Internet', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(68, 'Arquitectura de Computadoras', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(69, 'Arquitectura de Computadoras', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(70, 'Introducción a Base de Datos', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(71, 'Introducción a Base de Datos', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(72, 'Fundamentos de Programación', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(73, 'Fundamentos de Programación', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(74, 'Análisis y Diseño de Sistemas', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(75, 'Análisis y Diseño de Sistemas', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(76, 'Comunicación Oral', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(77, 'Comunicación Oral', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(78, 'Aplicaciones en Internet', 'Teoría', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(79, 'Aplicaciones en Internet', 'Práctica', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id_docente` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(120) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `especialidad` varchar(150) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id_docente`, `nombres`, `apellidos`, `correo`, `telefono`, `especialidad`, `id_carrera`, `created_at`, `updated_at`) VALUES
(23, 'Angel Alejandro', 'Salazar', NULL, NULL, 'Topografía Agrícola', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(24, 'Kevin', '', NULL, NULL, 'Comunicación Oral', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(25, 'Ferrer', 'Antezana Ccatamayo', NULL, NULL, 'Mecanización Agrícola, Manejo y Conservación de Suelos', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(26, 'Luz', 'Antezana Cesar', NULL, NULL, 'Instalaciones Agropecuarias', 3, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(27, 'Ketty Shirly', 'Cárdenas Pérez', NULL, NULL, 'Seguridad y Salud en el Trabajo', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(28, 'Billy', 'Ochoa Medina', NULL, NULL, 'Aplicaciones en Internet', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(29, 'Ida R.', 'Huamán Barzola', NULL, NULL, 'Asistencia en Inmunizaciones, Promoción de la Salud, Salud Comunitaria', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(30, 'Ismael', 'Lira Huamán', NULL, NULL, 'Educación para la Salud', 1, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(31, 'Joel', 'Andia Ovallle', NULL, NULL, 'Mantenimiento Preventivo de la Suspensión, Dirección y Frenos', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(32, 'Remigio', 'Rondinel Ochante', NULL, NULL, 'Comunicación Oral', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(33, 'José Luis', 'Vilchez Molina', NULL, NULL, 'Mecánica de Taller y Metrología Automotriz', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(34, 'Daniel', 'Palomino Gonzales', NULL, NULL, 'Mantenimiento Automotriz', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(35, 'Erik Anddy', 'Cronovifica Ayala', NULL, NULL, 'Aplicaciones en Internet', 4, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(36, 'Gerson Uriel', 'Taype Mucha', NULL, NULL, 'Almacenamiento de Materias Primas e Insumos', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(37, 'Bret Oliver', 'Matos Lope', NULL, NULL, 'Recepción de Materias Primas e Insumos', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(38, 'Yude Katia', 'Paucarhuanca Yarihuaman', NULL, NULL, 'Química Aplicada', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(39, 'Kike Saduth', 'Pacconcca Perez', NULL, NULL, 'Maquinaria y Equipos en la Recepción y Clasificación de la Materia Prima', 2, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(40, 'Kevin Vlaes', 'Bando Gomez', NULL, NULL, 'Redes e Internet, Diagramación Digital, Gestión de Sitios Web', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(41, 'Jorge Luis', 'Jara Diaz', NULL, NULL, 'Arquitectura de Computadoras, Análisis y Diseño de Sistemas, Administración de Base de Datos', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(42, 'Christian', 'Alegria Ñaccha', NULL, NULL, 'Introducción a Base de Datos, Diseño de Interfaces, Programación Móvil', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(43, 'Juan Carlos', 'Torres Lozano', NULL, NULL, 'Fundamentos de Programación, Pruebas de Software', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(44, 'Andy', 'Cconovilca Ayala', NULL, NULL, 'Aplicaciones en Internet', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(45, 'Anibal', 'Yucra Curo', NULL, NULL, 'Programación de Aplicaciones Web, Diseño de Soluciones Web, Inglés', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(46, 'Bill Ulises', 'Ochoa Medina', NULL, NULL, 'Oportunidades de Negocios, Desarrollo de Software, Análisis de Sistemas', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12'),
(47, 'Alfonso Alvaro', 'Moreno Marquez', NULL, NULL, 'Comunicación Oral, Solución de Problemas, Desarrollo de Software', 5, '2025-09-18 13:40:12', '2025-09-18 13:40:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_curso`
--

CREATE TABLE `docente_curso` (
  `id_docente` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `docente_curso`
--

INSERT INTO `docente_curso` (`id_docente`, `id_curso`) VALUES
(23, 22),
(23, 23),
(25, 25),
(25, 26),
(27, 33),
(27, 34),
(31, 47),
(31, 48),
(36, 57),
(36, 58),
(40, 66),
(40, 67);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `dia` enum('Lunes','Martes','Miércoles','Jueves','Viernes') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_api`
--

CREATE TABLE `tokens_api` (
  `id` int(11) NOT NULL,
  `id_client_api` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tokens_api`
--

INSERT INTO `tokens_api` (`id`, `id_client_api`, `token`, `fecha_registro`, `estado`) VALUES
(10, 2, '589e4cf1e5c2024e8d74d482b4bad2df-20251003-02', '2025-10-03 08:48:40', 1),
(11, 4, '710602c970c9f224d6f041b2984b2a0d-20251003-04', '2025-10-03 08:49:59', 1),
(12, 4, 'a69e9f2a3850558dfd439bf27d27ede9-20251003-04', '2025-10-03 09:10:29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_completo` varchar(120) NOT NULL,
  `rol` enum('admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `password`, `nombre_completo`, `rol`, `created_at`, `updated_at`) VALUES
(4, 'admin', '$2y$10$a4qsOmIrUcXN4ptudcU57uOQ7li/aLuuuRedYHOb1YoBnoRQsWgPi', 'Administrador General', 'admin', '2025-09-04 16:18:50', '2025-09-04 16:27:16'),
(5, 'julian', '$2y$10$c4ciki.RcE21wQp3VQp7eOIgSHU6hpTMNhNEUkpDYWF8axQJdfq9.', 'julian', 'admin', '2025-09-08 13:35:39', '2025-09-08 13:35:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `client_api`
--
ALTER TABLE `client_api`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `count_request`
--
ALTER TABLE `count_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_token` (`id_token`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `fk_cursos_carreras` (`id_carrera`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id_docente`),
  ADD KEY `fk_docentes_carreras` (`id_carrera`);

--
-- Indices de la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  ADD PRIMARY KEY (`id_docente`,`id_curso`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `tokens_api`
--
ALTER TABLE `tokens_api`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client_api` (`id_client_api`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `client_api`
--
ALTER TABLE `client_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `count_request`
--
ALTER TABLE `count_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tokens_api`
--
ALTER TABLE `tokens_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `count_request`
--
ALTER TABLE `count_request`
  ADD CONSTRAINT `count_request_ibfk_1` FOREIGN KEY (`id_token`) REFERENCES `tokens_api` (`id`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `fk_cursos_carreras` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`) ON DELETE SET NULL;

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `fk_docentes_carreras` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`) ON DELETE SET NULL;

--
-- Filtros para la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  ADD CONSTRAINT `docente_curso_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id_docente`) ON DELETE CASCADE,
  ADD CONSTRAINT `docente_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id_docente`) ON DELETE CASCADE,
  ADD CONSTRAINT `horarios_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tokens_api`
--
ALTER TABLE `tokens_api`
  ADD CONSTRAINT `tokens_api_ibfk_1` FOREIGN KEY (`id_client_api`) REFERENCES `client_api` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


APIDOCENTES:
/APIDOCENTES
│── /config
│    └── database.php
│
│── /controllers
│    └── AuthController.php
│    └── DocenteController.php
│
│── /models
│    └── Usuario.php
│    └── Docente.php
│
│── /views
│    ├── include/
│    │     ├── header.php
│    │     └── footer.php
│    ├── login.php
│    ├── dashboard.php
│    ├── docentes_list.php
│    └── docente_form.php
│
│── /public
│    └── index.php
│    └── css/
│    └── js/
│
└── index.php
└── .htaccess


-- ================================
