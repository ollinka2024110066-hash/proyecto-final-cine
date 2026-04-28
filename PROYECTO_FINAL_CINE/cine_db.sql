-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2026 at 08:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cine_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `boletos`
--

CREATE TABLE `boletos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `funcion_id` int(11) DEFAULT NULL,
  `asiento` varchar(10) DEFAULT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_compra` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boletos`
--

INSERT INTO `boletos` (`id`, `cliente_id`, `funcion_id`, `asiento`, `fecha_compra`, `id_compra`) VALUES
(1, 1, 1, 'A1', '2026-04-22 20:18:28', NULL),
(2, 1, 1, 'A2', '2026-04-26 22:42:25', NULL),
(3, 1, 1, 'A3', '2026-04-26 23:27:51', NULL),
(4, 1, 1, '1', '2026-04-27 00:10:52', NULL),
(5, 1, 1, 'C7', '2026-04-27 00:13:31', NULL),
(6, 1, 1, 'B6', '2026-04-27 00:35:37', NULL),
(7, 1, 1, 'B9', '2026-04-27 00:35:37', NULL),
(8, 1, 1, 'B7', '2026-04-27 00:41:09', NULL),
(9, 1, 1, 'B8', '2026-04-27 00:41:09', NULL),
(10, 1, 1, 'A4', '2026-04-28 00:36:34', NULL),
(11, 1, 1, 'H3', '2026-04-28 01:30:25', NULL),
(12, 1, 1, 'B3', '2026-04-28 01:33:25', NULL),
(13, 1, 1, 'A5', '2026-04-28 01:34:30', NULL),
(14, 1, 6, 'C5', '2026-04-28 15:10:53', NULL),
(15, 1, 6, 'C6', '2026-04-28 15:10:53', NULL),
(16, 1, 6, 'A1', '2026-04-28 15:16:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `funciones`
--

CREATE TABLE `funciones` (
  `id_compra` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `pelicula_id` int(11) DEFAULT NULL,
  `sala_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funciones`
--

INSERT INTO `funciones` (`id_compra`, `id`, `pelicula_id`, `sala_id`, `fecha`, `hora`, `precio`) VALUES
('', 1, 1, 2, '2026-04-22', '16:00:00', 80.00),
('', 3, 1, 6, '2026-04-22', '20:00:00', 80.00),
('', 4, 6, 11, '2026-05-10', '22:00:00', 100.00),
('', 6, 9, 12, '2026-04-24', '22:00:00', 280.00);

-- --------------------------------------------------------

--
-- Table structure for table `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `clasificacion` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `genero`, `duracion`, `clasificacion`) VALUES
(1, 'AVATAR', 'Acciön', 180, 'B'),
(2, 'EL DIABLO VISTE A LA MODA', 'Comedia', 119, 'B'),
(3, 'INTENSAMENTE 2', 'Animación', 96, 'A'),
(4, 'DEADPOOL Y WOLVERINE', 'Acción', 127, 'C'),
(5, 'KUNG FU PANDA 4', 'Animación', 94, 'A'),
(6, 'LA MONJA 2', 'Terror', 110, 'B15'),
(7, 'BARBIE', 'Comedia', 114, 'B'),
(9, 'TERROR EN SILENT HILL', 'Terror', 125, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salas`
--

INSERT INTO `salas` (`id`, `nombre`, `capacidad`) VALUES
(1, 'SALA 1 ', 80),
(2, 'SALA 2 ', 80),
(4, 'SALA 3 ', 50),
(6, 'SALA 5', 80),
(7, 'SALA 6', 90),
(8, 'SALA 7', 100),
(9, 'SALA 8 ', 110),
(10, 'SALA 9 ', 120),
(11, 'SALA 10 ', 130),
(12, 'SALA 4 VIP ', 30),
(14, 'SALA 11', 80);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('admin','cliente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`) VALUES
(1, 'Administrador', 'admin@cine.com', '123456', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boletos`
--
ALTER TABLE `boletos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funcion_id` (`funcion_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indexes for table `funciones`
--
ALTER TABLE `funciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelicula_id` (`pelicula_id`),
  ADD KEY `sala_id` (`sala_id`);

--
-- Indexes for table `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boletos`
--
ALTER TABLE `boletos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `funciones`
--
ALTER TABLE `funciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salas`
--
ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boletos`
--
ALTER TABLE `boletos`
  ADD CONSTRAINT `boletos_ibfk_1` FOREIGN KEY (`funcion_id`) REFERENCES `funciones` (`id`),
  ADD CONSTRAINT `boletos_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `funciones`
--
ALTER TABLE `funciones`
  ADD CONSTRAINT `funciones_ibfk_1` FOREIGN KEY (`pelicula_id`) REFERENCES `peliculas` (`id`),
  ADD CONSTRAINT `funciones_ibfk_2` FOREIGN KEY (`sala_id`) REFERENCES `salas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
