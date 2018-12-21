-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-11-2018 a las 13:47:52
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebas`
--
DROP DATABASE IF EXISTS `pruebas`;
CREATE DATABASE IF NOT EXISTS `pruebas` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `pruebas`;

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_role` varchar(10) COLLATE utf8_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(50) COLLATE utf8_bin UNIQUE NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` blob NOT NULL,
  `image` varchar(100) NULL,
  `user_role` int(11),
  PRIMARY KEY (`id`),
  CONSTRAINT role_fk FOREIGN KEY (user_role) REFERENCES user_roles(id)
) ENGINE=InnoDB;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_role`) VALUES
(1, 'ADMIN'), (2,'USER');






--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `email`, `password`, `image`, `user_role`) VALUES
(11, 'admin', 'admin', 'admin@admin.admin', '$2y$10$0Z4wWIuRYLsuEfmwLIP8v.0Eh0PLDnxBzYFAjxr2b9c3D9bWMK44a', 'images/1544294465Captura de pantalla de 2018-11-20 13-18-07.png', 1);








--
-- Metadatos
--
USE `phpmyadmin`;

--
-- Metadatos para la tabla users
--

--
-- Metadatos para la base de datos pruebas
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;