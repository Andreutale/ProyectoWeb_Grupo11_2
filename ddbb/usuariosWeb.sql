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
-- Base de datos: grupo_11
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla usuariosweb
--

CREATE TABLE if not exists usuariosWeb (
                             id int(11) NOT NULL,
                             nombre varchar(20) NOT NULL,
                             apellidos varchar(50) NOT NULL,
                             correo varchar(100) NOT NULL,
                             telefono int(20) NOT NULL,
                             contraseña varchar(255) NOT NULL,
                             token int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla usuariosweb
--

-- AÑADIR USUARIOS PREDETERMINADOS (INSERT)

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla usuariosweb
--
-- ALTER TABLE usuariosWeb
--    ADD PRIMARY KEY (id),
--    ADD UNIQUE KEY correo (correo);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla usuariosweb
--
ALTER TABLE usuariosWeb
    MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;


--
-- Estructura de tabla para la tabla archivosModulo
--

CREATE TABLE archivosmodulo (
                             id int(11) NOT NULL,
                             id_autor int(11) NOT NULL,
                             nombre varchar(255) NOT NULL,
                             fecha timestamp NOT NULL DEFAULT current_timestamp(),
                             tipo varchar(100) NOT NULL,
                             datos longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla archivosmodulo
--
ALTER TABLE archivosmodulo
    ADD PRIMARY KEY (id),
    ADD KEY fk_id_autor (id_autor);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla archivosmodulo
--
ALTER TABLE archivosmodulo
    MODIFY id int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla archivosmodulo
--
ALTER TABLE archivosmodulo
    ADD CONSTRAINT fk_id_autor FOREIGN KEY (id_autor) REFERENCES usuariosweb (id);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;