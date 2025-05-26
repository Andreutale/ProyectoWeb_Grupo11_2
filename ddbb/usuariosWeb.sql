-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2025 a las 13:37:51
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
-- Base de datos: `grupo_11`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosweb`
--

CREATE TABLE `usuariosWeb` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` int(20) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `token` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuariosweb`
--

INSERT INTO `usuariosWeb` (`id`, `nombre`, `apellidos`, `correo`, `telefono`, `contraseña`, `token`) VALUES
(1, 'Ferran', 'Sansaloni Prats', 'ferransansaloni@gmail.com', 2147483647, '$2y$10$oOl3dAYDLHrcmgsA5wfK.OUAJek7sgRVELY6nY7ajpS4/hf4/1h0C', 0),
(2, 'Raul', 'Sanabria', 'raul@gmail.com', 121212, '$2y$10$ETVYjcPeT0k/ImInT4q7Nu4P7wc5s94drgQDaQMmjHd3EWa8FFpFi', 0),
(4, 'Andreu', 'Aliaga', 'andreu@gmail.com', 1212, '$2y$10$G6GaX//MhLQZ./vS9kiEnO.BV1Dzmm6VKRHOPmomBDmEnk.jr48vG', 0),
(5, 'Javier', 'Acevedo', 'javier@gmail.com', 12313213, '$2y$10$7zYjDAbRIOqmHdCpNQHWUegHBhp4onnIO9uKbGWrJqNiO6gqOJRaG', 0),
(6, 'Joel', 'Garcia', 'joel@gmail.com', 123123, '$2y$10$gbgt3/IoTCukoUHwobQL7.wJw7SOb1K0Fpprf5vIatsgecMd4jyZS', 0),
(7, 'Ferran', 'Sansaloni', 'hola@gmail.com', 1231321, '$2y$10$ojFySO1JbHpjavKEwbhStePKikjH4.5TWM8apcj8lio07K.VBQ0pa', 90),
(8, 'Ferran', 'Sajkdfj', 'buenas@gmail.com', 123123, '$2y$10$jKQ7epeFnJv4Fa1H0dEypefFNpizMT/c3LTSU/AfJi0oKM1VKyMDu', 3),
(9, 'Antonio', 'Sanabria', 'antonio@gmail.com', 123123, '$2y$10$zZoryRICVCORivGnt/IL0ezp.ufI.asP54WdkWwlrkjf3ZU9oXvZW', 4),
(10, 'Miriam', 'Montalba', 'miriam@gmail.com', 2147483647, '$2y$10$qXlV3ANuZER0PNhyTa5XFuUpGqyYuZ/Z4nII17fXQrRcWIEbMAQYa', 5),
(11, 'Andeutale', 'Aliagatale', 'andreutale@tale.com', 123456789, '$2y$10$o6QcVV.pFCLwgqxCMU20ZeqiLBYfPNA24HLSUfg3JhxNvY/tF.Tl6', 5),
(12, 'julia', 'nose', 'julia@gmail.com', 123123, '$2y$10$wpwWbPf2mqa9bt8mdw0rpOlZRSlba2.bB0Am/rAMNIDXAMtjfDScK', 47),
(13, 'asdfasdf', 'Sansaloni1', 'ferran@gmail.com', 23123, '$2y$10$uoYWL5wzje6Ib/POfcC1hOMKbRPc1DjEfkbN3ZNVatc.xYRZmSWSO', 769);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuariosweb`
--
ALTER TABLE `usuariosWeb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuariosweb`
--
ALTER TABLE `usuariosWeb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
