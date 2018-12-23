-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-12-2018 a las 20:24:03
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
-- Estructura de tabla para la tabla `audidetalle_cobranza`
--

CREATE TABLE IF NOT EXISTS `audidetalle_cobranza` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_venta` double NOT NULL,
  `accion` varchar(250) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `audidetalle_cobranza`
--

INSERT INTO `audidetalle_cobranza` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`, `accion`) VALUES
(1, 71, 329, 5000, 30000, 'AGREGADO'),
(2, 71, 329, 5000, 25000, 'AGREGADO'),
(3, 71, 330, 10000, 80000, 'AGREGADO'),
(4, 3, 330, 10000, 70000, 'AGREGADO'),
(5, 4, 329, 5000, 20000, 'AGREGADO'),
(6, 0, 330, 5000, 65000, 'AGREGADO'),
(7, 0, 329, 5000, 15000, 'AGREGADO'),
(8, 0, 330, 5000, 60000, 'AGREGADO'),
(9, 0, 329, 5000, 10000, 'AGREGADO'),
(10, 0, 330, 5000, 55000, 'AGREGADO'),
(11, 0, 330, 5000, 50000, 'AGREGADO'),
(12, 9, 330, 5000, 45000, 'AGREGADO'),
(13, 10, 330, 5000, 40000, 'AGREGADO'),
(14, 10, 329, 5000, 5000, 'AGREGADO'),
(15, 11, 330, 10000, 30000, 'AGREGADO'),
(16, 11, 329, 5000, 0, 'AGREGADO'),
(17, 12, 330, 5000, 25000, 'AGREGADO'),
(18, 13, 273, 9408, 30000, 'AGREGADO'),
(19, 13, 331, 9500, 40000, 'AGREGADO'),
(20, 13, 331, 5000, 35000, 'AGREGADO'),
(21, 13, 273, 5000, 25000, 'AGREGADO'),
(22, 14, 332, 7000, 50000, 'AGREGADO'),
(23, 14, 330, 15000, 10000, 'AGREGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audidetalle_op`
--

CREATE TABLE IF NOT EXISTS `audidetalle_op` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_venta` double NOT NULL,
  `accion` varchar(250) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `audidetalle_op`
--

INSERT INTO `audidetalle_op` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`, `accion`) VALUES
(1, 1, 93, 50000, 300000, 'AGREGADO'),
(2, 1, 88, 50000, 1300000, 'AGREGADO'),
(3, 2, 93, 50000, 250000, 'AGREGADO'),
(4, 2, 88, 50000, 1250000, 'AGREGADO'),
(5, 3, 93, 50000, 200000, 'AGREGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobranza`
--

CREATE TABLE IF NOT EXISTS `cobranza` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` int(11) NOT NULL,
  `total_venta` int(11) NOT NULL,
  `estado_factura` int(11) NOT NULL,
  `accion` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `saldo_anterior` int(11) NOT NULL,
  `tipo_pago` int(11) NOT NULL,
  `numero_venta` int(11) NOT NULL,
  `efectivo` int(11) NOT NULL,
  `tarjeta` int(11) NOT NULL,
  `cheque` int(11) NOT NULL,
  `transferencia` int(11) NOT NULL,
  `cantidad_cobranza` int(11) NOT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `cobranza`
--

INSERT INTO `cobranza` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `total_venta`, `estado_factura`, `accion`, `fecha`, `saldo_anterior`, `tipo_pago`, `numero_venta`, `efectivo`, `tarjeta`, `cheque`, `transferencia`, `cantidad_cobranza`) VALUES
(1, 1, '2018-12-22 12:58:41', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 30000, 0, 329, 0, 0, 0, 0, 0),
(2, 2, '2018-12-22 13:04:28', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 25000, 0, 329, 0, 0, 0, 0, 0),
(3, 2, '2018-12-22 13:04:29', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 80000, 0, 330, 0, 0, 0, 0, 0),
(4, 3, '2018-12-22 13:09:47', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 70000, 0, 330, 0, 0, 0, 0, 0),
(5, 4, '2018-12-22 13:09:47', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 20000, 0, 329, 0, 0, 0, 0, 0),
(6, 5, '2018-12-22 13:11:24', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 65000, 0, 330, 0, 0, 0, 0, 0),
(7, 5, '2018-12-22 13:11:24', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 15000, 0, 329, 0, 0, 0, 0, 0),
(8, 6, '2018-12-22 13:15:06', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 60000, 0, 330, 0, 0, 0, 0, 0),
(9, 6, '2018-12-22 13:15:07', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 10000, 0, 329, 0, 0, 0, 0, 0),
(10, 7, '2018-12-22 13:19:31', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 55000, 0, 330, 0, 0, 0, 0, 0),
(11, 8, '2018-12-22 13:20:46', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 50000, 0, 330, 0, 0, 0, 0, 0),
(12, 9, '2018-12-22 13:22:19', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 45000, 0, 330, 0, 0, 0, 0, 0),
(13, 10, '2018-12-22 13:34:19', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 40000, 0, 330, 0, 0, 0, 0, 0),
(14, 10, '2018-12-22 13:34:19', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 5000, 0, 329, 0, 0, 0, 0, 0),
(15, 11, '2018-12-22 13:36:19', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 30000, 0, 330, 0, 0, 0, 0, 0),
(16, 11, '2018-12-22 13:36:19', 2, 1, 0, 35000, 0, 'AGREGADO', '2018-12-22', 0, 0, 329, 0, 0, 0, 0, 0),
(17, 12, '2018-12-22 13:38:51', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 25000, 0, 330, 0, 0, 0, 0, 0),
(18, 13, '2018-12-22 19:01:21', 5, 1, 0, 49500, 0, 'AGREGADO', '2018-12-22', 35000, 0, 331, 0, 0, 0, 0, 5000),
(19, 13, '2018-12-22 19:01:21', 5, 1, 0, 39450, 0, 'AGREGADO', '2018-12-22', 25000, 0, 273, 0, 0, 0, 0, 5000),
(20, 14, '2018-12-22 19:02:48', 2, 1, 0, 57000, 0, 'AGREGADO', '2018-12-22', 50000, 0, 332, 0, 0, 0, 0, 7000),
(21, 14, '2018-12-22 19:02:48', 2, 1, 0, 90000, 0, 'AGREGADO', '2018-12-22', 10000, 0, 330, 0, 0, 0, 0, 15000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cobranza`
--

CREATE TABLE IF NOT EXISTS `detalle_cobranza` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_venta` double NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `detalle_cobranza`
--

INSERT INTO `detalle_cobranza` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`, `fecha`) VALUES
(1, 71, 329, 5000, 25000, '2018-12-22'),
(2, 71, 330, 10000, 80000, '2018-12-22'),
(3, 3, 330, 10000, 70000, '2018-12-22'),
(4, 4, 329, 5000, 20000, '2018-12-22'),
(5, 0, 330, 5000, 65000, '2018-12-22'),
(6, 0, 329, 5000, 15000, '2018-12-22'),
(7, 0, 330, 5000, 60000, '2018-12-22'),
(8, 0, 329, 5000, 10000, '2018-12-22'),
(9, 0, 330, 5000, 55000, '2018-12-22'),
(10, 0, 330, 5000, 50000, '2018-12-22'),
(11, 9, 330, 5000, 45000, '2018-12-22'),
(12, 10, 330, 5000, 40000, '2018-12-22'),
(13, 10, 329, 5000, 5000, '2018-12-22'),
(14, 11, 330, 10000, 30000, '2018-12-22'),
(15, 11, 329, 5000, 0, '2018-12-22'),
(16, 12, 330, 5000, 25000, '2018-12-22'),
(17, 13, 273, 9408, 30000, '2018-12-22'),
(18, 13, 331, 9500, 40000, '2018-12-22'),
(19, 13, 331, 5000, 35000, '2018-12-22'),
(20, 13, 273, 5000, 25000, '2018-12-22'),
(21, 14, 332, 7000, 50000, '2018-12-22'),
(22, 14, 330, 15000, 10000, '2018-12-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_op`
--

CREATE TABLE IF NOT EXISTS `detalle_op` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `precio_venta` double NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `numero_cotizacion` (`numero_factura`,`id_producto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `detalle_op`
--

INSERT INTO `detalle_op` (`id_detalle`, `numero_factura`, `id_producto`, `cantidad`, `precio_venta`, `fecha`) VALUES
(1, 1, 93, 50000, 300000, '2018-12-22'),
(2, 1, 88, 50000, 1300000, '2018-12-22'),
(3, 2, 93, 50000, 250000, '2018-12-22'),
(4, 2, 88, 50000, 1250000, '2018-12-22'),
(5, 3, 93, 50000, 200000, '2018-12-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `op`
--

CREATE TABLE IF NOT EXISTS `op` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` int(11) NOT NULL,
  `total_venta` int(11) NOT NULL,
  `estado_factura` int(11) NOT NULL,
  `accion` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `saldo_anterior` int(11) NOT NULL,
  `tipo_pago` int(11) NOT NULL,
  `numero_venta` int(11) NOT NULL,
  `efectivo` int(11) NOT NULL,
  `tarjeta` int(11) NOT NULL,
  `cheque` int(11) NOT NULL,
  `transferencia` int(11) NOT NULL,
  `cantidad_op` int(11) NOT NULL,
  PRIMARY KEY (`id_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `op`
--

INSERT INTO `op` (`id_factura`, `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `total_venta`, `estado_factura`, `accion`, `fecha`, `saldo_anterior`, `tipo_pago`, `numero_venta`, `efectivo`, `tarjeta`, `cheque`, `transferencia`, `cantidad_op`) VALUES
(1, 1, '2018-12-22 15:34:48', 1, 1, 0, 350000, 0, 'AGREGADO', '2018-12-22', 300000, 0, 93, 0, 0, 0, 0, 50000),
(2, 1, '2018-12-22 15:34:48', 1, 1, 0, 1485000, 0, 'AGREGADO', '2018-12-22', 1300000, 0, 88, 0, 0, 0, 0, 185000),
(3, 2, '2018-12-22 16:01:52', 1, 1, 0, 350000, 0, 'AGREGADO', '2018-12-22', 250000, 0, 93, 0, 0, 0, 0, 0),
(4, 2, '2018-12-22 16:01:52', 1, 1, 0, 1485000, 0, 'AGREGADO', '2018-12-22', 1250000, 0, 88, 0, 0, 0, 0, 50000),
(5, 3, '2018-12-22 18:42:26', 1, 1, 0, 350000, 0, 'AGREGADO', '2018-12-22', 200000, 0, 93, 0, 0, 0, 0, 50000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
