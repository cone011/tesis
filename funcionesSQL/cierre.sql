-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2019 a las 01:34:17
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tesis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre`
--

CREATE TABLE IF NOT EXISTS `cierre` (
  `id_cierre` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_cierre` int(11) NOT NULL,
  `factura_incial` int(11) NOT NULL,
  `factura_final` int(11) NOT NULL,
  `fecha_add` datetime NOT NULL,
  `cobranza_inicial` int(11) NOT NULL,
  `cobranza_final` int(11) NOT NULL,
  `compra_inicial` int(11) NOT NULL,
  `compra_final` int(11) NOT NULL,
  `op_inicial` int(11) NOT NULL,
  `op_final` int(11) NOT NULL,
  PRIMARY KEY (`id_cierre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `cierre`
--

INSERT INTO `cierre` (`id_cierre`, `codigo_cierre`, `factura_incial`, `factura_final`, `fecha_add`, `cobranza_inicial`, `cobranza_final`, `compra_inicial`, `compra_final`, `op_inicial`, `op_final`) VALUES
(2, 1, 1, 10, '2018-12-12 16:16:25', 1, 3, 1, 7, 1, 1),
(3, 3, 11, 60, '2018-12-12 21:42:40', 4, 6, 8, 10, 2, 3),
(4, 0, 61, 100, '2018-12-12 21:54:23', 7, 9, 11, 18, 4, 5),
(5, 0, 101, 109, '2018-12-15 01:09:23', 10, 13, 19, 21, 6, 6),
(6, 0, 110, 156, '2018-12-17 12:44:20', 14, 17, 22, 25, 7, 7),
(7, 0, 157, 180, '2018-12-28 15:55:05', 18, 19, 26, 28, 8, 8),
(8, 0, 181, 190, '2018-12-28 17:12:38', 20, 22, 29, 32, 9, 9),
(9, 0, 191, 200, '2018-12-28 20:04:58', 23, 24, 33, 40, 10, 10),
(10, 0, 201, 401, '2018-12-31 01:55:10', 25, 36, 41, 128, 11, 11);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
