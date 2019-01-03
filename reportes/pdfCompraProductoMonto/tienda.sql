-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2015 a las 19:01:24
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id_prod` int(11) NOT NULL AUTO_INCREMENT,
  `nomb_prod` varchar(100) NOT NULL,
  `tipo_prod` varchar(50) NOT NULL,
  `precio_unit` float NOT NULL,
  `precio_dist` float NOT NULL,
  `fecha_reg` date NOT NULL,
  PRIMARY KEY (`id_prod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_prod`, `nomb_prod`, `tipo_prod`, `precio_unit`, `precio_dist`, `fecha_reg`) VALUES
(1, 'Atun', 'Enlatado', 6, 5, '2011-05-01'),
(2, 'Aceite', 'Otro', 8, 7, '2012-09-11'),
(3, 'Detergente', 'Otro', 3, 2, '2013-11-20'),
(4, 'Gaseosa', 'Envasado', 5, 4, '2015-03-20'),
(5, 'Pasta Dental', 'Otro', 6, 3, '2015-05-24'),
(6, 'Botella de Agua Mineral', 'Otro', 3, 2, '2015-05-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_venta` date NOT NULL,
  `monto_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_venta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `fecha_venta`, `monto_venta`) VALUES
(1, '2014-01-15', '3623.00'),
(2, '2014-02-13', '2011.30'),
(3, '2014-03-11', '1550.55'),
(4, '2014-04-22', '3655.50'),
(5, '2014-05-22', '4211.20'),
(6, '2014-06-14', '2854.20'),
(7, '2014-07-30', '3114.20'),
(8, '2014-08-16', '2600.20'),
(9, '2014-09-23', '3010.90'),
(10, '2014-10-02', '1411.10'),
(11, '2014-11-20', '6633.00'),
(12, '2014-12-12', '5442.20'),
(13, '2015-01-20', '3522.40'),
(14, '2015-02-22', '6748.20'),
(15, '2015-03-11', '7000.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
