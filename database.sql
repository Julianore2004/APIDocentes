-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2025 a las 04:16:52
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
(1, 'Redes e Internet', 'Teoría', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(2, 'Redes e Internet', 'Práctica', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(3, 'Arquitectura de Computadoras', 'Teoría', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(4, 'Arquitectura de Computadoras', 'Práctica', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(5, 'Anatomía y Fisiología', 'Teoría', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(6, 'Enfermería Básica', 'Teoría', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(7, 'Enfermería Básica', 'Práctica', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(8, 'Primeros Auxilios', 'Teoría', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(9, 'Primeros Auxilios', 'Práctica', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(10, 'Procesos de Producción Alimentaria', 'Teoría', 2, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(11, 'Procesos de Producción Alimentaria', 'Práctica', 2, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(12, 'Control de Calidad', 'Teoría', 2, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(13, 'Control de Calidad', 'Práctica', 2, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(14, 'Agronomía', 'Teoría', 3, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(15, 'Agronomía', 'Práctica', 3, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(16, 'Manejo de Suelos', 'Teoría', 3, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(17, 'Manejo de Suelos', 'Práctica', 3, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(18, 'Mecánica Automotriz', 'Teoría', 4, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(19, 'Mecánica Automotriz', 'Práctica', 4, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(20, 'Electrónica Automotriz', 'Teoría', 4, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(21, 'Electrónica Automotriz', 'Práctica', 4, '2025-09-05 14:07:30', '2025-09-05 14:07:30');

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
(1, 'Kevin Vlaes', 'Bando Gomez', '', '', 'Redes e Internet, Diagramación digital, Gestión de sitios web, JavaScript, PHP, Python', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(2, 'Jorge Luis', 'Jara Diaz', NULL, NULL, 'Arquitectura de Computadoras, Análisis y diseño de sistemas, Administración BD, Marketing digital', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(3, 'Christian', 'Alegria Ñaccha', NULL, NULL, 'Introducción BD, Diseño de interfaces, Programación móvil', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(4, 'Juan Carlos', 'Torres Lozano', NULL, NULL, 'Fundamentos de programación, Pruebas de software', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(5, 'Andy', 'Cconovilca Ayala', NULL, NULL, 'Aplicaciones en internet', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(6, 'Anibal', 'Yucra Curo', NULL, NULL, 'Programación web, Diseño de soluciones web, Inglés', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(7, 'Bill Ulises', 'Ochoa Medina', '3123sdc@gmail.com', '12341553', 'Oportunidades de negocios, Desarrollo de Software, Análisis de Sistemas, Arquitectura de Software, Redes de Computadoras', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(8, 'Alfonso Alvaro', 'Moreno Marquez', '', '', 'Comunicación oral, Solución de problemas, Desarrollo de Software, Node.js, Redes de Computadoras, Inteligencia Artificial, Machine Learning', 5, '2025-09-04 13:28:39', '2025-09-05 14:14:40'),
(10, 'María Elena', 'González Pérez', '', '', 'Anatomía y fisiología, Enfermería básica, Primeros auxilios', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(11, 'Carlos Alberto', 'Mendoza Rojas', '', '', 'Microbiología, Farmacología, Cuidados intensivos', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(12, 'Ana Sofía', 'Ramírez López', '', '', 'Nutrición y dietética, Salud pública', 1, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(13, 'Luis Miguel', 'Torres Sánchez', '', '', 'Procesos de producción alimentaria, Control de calidad', 2, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(14, 'Laura Andrea', 'Díaz Martínez', '', '', 'Tecnología de alimentos, Conservación de alimentos', 2, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(15, 'Pedro Antonio', 'Gómez Castro', '', '', 'Agronomía, Manejo de suelos, Cultivos', 3, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(16, 'Marta Cecilia', 'Vargas Silva', '', '', 'Zootecnia, Producción animal, Sanidad animal', 3, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(17, 'Ricardo Jesús', 'Flores Mendoza', '', '', 'Mecánica automotriz, Electrónica automotriz, Diagnóstico de fallas', 4, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(18, 'Javier Eduardo', 'Pérez García', '', '', 'Sistemas de inyección, Mantenimiento preventivo', 4, '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(19, 'wefx', 'sxxa', '3123sdc@gmail.com', '123123', 'Desarrollo de Software, Análisis de Sistemas, Redes de Computadoras', NULL, '2025-09-05 14:24:23', '2025-09-05 14:24:23'),
(20, 'Alfonso Alvaro', 'wfewfwef', '3123sdc@gmail.com', '123123', 'Desarrollo de Software, Análisis de Sistemas, Arquitectura de Software', NULL, '2025-09-05 14:53:37', '2025-09-05 14:54:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_curso`
--

CREATE TABLE `docente_curso` (
  `id_docente` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id_horario`, `id_docente`, `id_curso`, `dia`, `hora_inicio`, `hora_fin`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Lunes', '08:00:00', '08:45:00', '2025-09-04 13:28:39', '2025-09-04 13:28:39'),
(2, 1, 2, 'Lunes', '08:45:00', '09:30:00', '2025-09-04 13:28:39', '2025-09-04 13:28:39'),
(3, 2, 3, 'Lunes', '08:00:00', '08:45:00', '2025-09-04 13:28:39', '2025-09-04 13:28:39'),
(4, 2, 4, 'Lunes', '08:45:00', '09:30:00', '2025-09-04 13:28:39', '2025-09-04 13:28:39'),
(5, 10, 5, 'Lunes', '08:00:00', '09:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(6, 10, 6, 'Lunes', '09:30:00', '11:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(7, 11, 7, 'Martes', '08:00:00', '09:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(8, 11, 8, 'Martes', '09:30:00', '11:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(9, 13, 10, 'Miércoles', '08:00:00', '09:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(10, 13, 11, 'Miércoles', '09:30:00', '11:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(11, 14, 12, 'Jueves', '08:00:00', '09:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(12, 14, 13, 'Jueves', '09:30:00', '11:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(13, 15, 14, 'Viernes', '08:00:00', '09:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(14, 15, 15, 'Viernes', '09:30:00', '11:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(15, 16, 16, 'Lunes', '13:00:00', '14:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(16, 16, 17, 'Lunes', '14:30:00', '16:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(17, 17, 18, 'Martes', '13:00:00', '14:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(18, 17, 19, 'Martes', '14:30:00', '16:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(19, 18, 20, 'Miércoles', '13:00:00', '14:30:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30'),
(20, 18, 21, 'Miércoles', '14:30:00', '16:00:00', '2025-09-05 14:07:30', '2025-09-05 14:07:30');

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
(4, 'admin', '$2y$10$a4qsOmIrUcXN4ptudcU57uOQ7li/aLuuuRedYHOb1YoBnoRQsWgPi', 'Administrador General', 'admin', '2025-09-04 16:18:50', '2025-09-04 16:27:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`);

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
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

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
