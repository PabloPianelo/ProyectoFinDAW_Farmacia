-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2024 a las 10:44:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medicina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `codigo_nacional` varchar(50) NOT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `laboratorio` varchar(100) DEFAULT NULL,
  `unidades` int(11) DEFAULT NULL,
  `estado` enum('activo','anulado') DEFAULT 'activo',
  `presentacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`codigo_nacional`, `nombre_producto`, `laboratorio`, `unidades`, `estado`, `presentacion`) VALUES
('4745', 'Paracetamol 500 mg', 'Farmacias ABC', 100, 'activo', 1),
('5236', 'Ibuprofeno 200 mg', 'Laboratorios XYZ', 200, 'activo', 1),
('54321', 'Amoxicilina 500 mg', 'Laboratorios XYZ', 80, 'activo', 2),
('67890', 'Omeprazol 20 mg', 'Laboratorios XYZ', 50, 'activo', 1),
('8569', 'Loratadina 10 mg', 'MedicaPro', 400, 'activo', 1),
('ABC123', 'Ibuprofeno', 'Laboratorio XYZ', 100, 'activo', 2),
('﻿12345', 'Paracetamol 500 mg', 'Farmacias ABC', 100, 'activo', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono_fijo` varchar(20) DEFAULT NULL,
  `telefono_movil` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `DNI`, `nombre`, `apellidos`, `fecha_nacimiento`, `telefono_fijo`, `telefono_movil`, `correo_electronico`) VALUES
(1, '12345678A', 'Juan', 'García', '1990-05-15', '123456789', '987654321', 'juan.garcia@example.com'),
(3, '12377678A', 'Ana', 'Alonso', '2024-04-04', '545646546', '545646546', 'Ana@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_presentacion`
--

CREATE TABLE `tipo_presentacion` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `largo` float DEFAULT NULL,
  `ancho` float DEFAULT NULL,
  `alto` float DEFAULT NULL,
  `cantidad_alto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_presentacion`
--

INSERT INTO `tipo_presentacion` (`codigo`, `nombre`, `largo`, `ancho`, `alto`, `cantidad_alto`) VALUES
(1, 'pastilla', 1, 5.2, 2, 3),
(2, 'pastilla pequeña', 2, 2.2, 3, 4),
(3, 'sobre', 40, 50, 5, 2),
(4, 'pastilla grande', 10, 10, 5.5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tomas_tratamiento`
--

CREATE TABLE `tomas_tratamiento` (
  `codigo_toma` int(11) NOT NULL,
  `codigo_tratamiento` int(11) DEFAULT NULL,
  `dia_toma` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') DEFAULT NULL,
  `hora_toma` enum('mañana','mediodia','noche') DEFAULT NULL,
  `codigo_medicamento` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tomas_tratamiento`
--

INSERT INTO `tomas_tratamiento` (`codigo_toma`, `codigo_tratamiento`, `dia_toma`, `hora_toma`, `codigo_medicamento`, `cantidad`) VALUES
(68, 5, 'Lunes', 'noche', '67890', 2),
(69, 5, 'Miércoles', 'noche', '67890', 2),
(236, 10, 'Lunes', 'noche', '54321', 2),
(237, 10, 'Miércoles', 'noche', '54321', 2),
(238, 10, 'Lunes', 'noche', '﻿12345', 1),
(239, 10, 'Jueves', 'mediodia', '67890', 2),
(240, 3, 'Sábado', 'mediodia', '4745', 1),
(241, 11, 'Martes', 'mediodia', '5236', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamiento`
--

CREATE TABLE `tratamiento` (
  `codigo_tratamiento` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `dias_realizacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tratamiento`
--

INSERT INTO `tratamiento` (`codigo_tratamiento`, `id_paciente`, `fecha_inicio`, `dias_realizacion`) VALUES
(3, 1, '2024-05-15', 12),
(5, 1, '2024-05-15', 6),
(6, 1, '2024-05-17', 7),
(10, 3, '2024-05-16', 12),
(11, 1, '2024-05-19', 15),
(12, 1, '2024-05-21', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `contraseña` varchar(200) NOT NULL,
  `perfil` enum('administrador','dependiente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `contraseña`, `perfil`) VALUES
(2, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'administrador'),
(4, 'pepe', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'dependiente'),
(5, 'Ana', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'dependiente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`codigo_nacional`),
  ADD KEY `presentacion` (`presentacion`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `tipo_presentacion`
--
ALTER TABLE `tipo_presentacion`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tomas_tratamiento`
--
ALTER TABLE `tomas_tratamiento`
  ADD PRIMARY KEY (`codigo_toma`),
  ADD KEY `codigo_tratamiento` (`codigo_tratamiento`),
  ADD KEY `codigo_medicamento` (`codigo_medicamento`);

--
-- Indices de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD PRIMARY KEY (`codigo_tratamiento`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_presentacion`
--
ALTER TABLE `tipo_presentacion`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tomas_tratamiento`
--
ALTER TABLE `tomas_tratamiento`
  MODIFY `codigo_toma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT de la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  MODIFY `codigo_tratamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`presentacion`) REFERENCES `tipo_presentacion` (`codigo`);

--
-- Filtros para la tabla `tomas_tratamiento`
--
ALTER TABLE `tomas_tratamiento`
  ADD CONSTRAINT `tomas_tratamiento_ibfk_1` FOREIGN KEY (`codigo_tratamiento`) REFERENCES `tratamiento` (`codigo_tratamiento`),
  ADD CONSTRAINT `tomas_tratamiento_ibfk_2` FOREIGN KEY (`codigo_medicamento`) REFERENCES `medicamento` (`codigo_nacional`);

--
-- Filtros para la tabla `tratamiento`
--
ALTER TABLE `tratamiento`
  ADD CONSTRAINT `tratamiento_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
