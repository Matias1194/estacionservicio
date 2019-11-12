-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2019 a las 12:47:43
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `estacion_servicio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Playa', 1),
(2, 'Mercado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_cliente` int(11) UNSIGNED NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `cuit` bigint(20) UNSIGNED NOT NULL,
  `domicilio` varchar(50) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `id_tipo_cliente`, `razon_social`, `cuit`, `domicilio`, `telefono`, `email`, `fecha_creacion`, `habilitado`, `eliminado`) VALUES
(1, 1, 'Combustibles Uruguay', 30158593840, 'Las casas 123', '42424343', 'comburu@mail.com', '2019-09-11 01:57:28', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_proveedor` int(10) UNSIGNED NOT NULL,
  `id_tipo_comprobante` int(10) UNSIGNED NOT NULL,
  `numero_factura` int(11) UNSIGNED NOT NULL,
  `orden_compra_numero` int(11) UNSIGNED NOT NULL,
  `orden_compra_fecha` datetime NOT NULL,
  `gastos_envio` decimal(8,2) UNSIGNED NOT NULL,
  `gastos_envio_iva` decimal(8,2) UNSIGNED NOT NULL,
  `gastos_envio_impuestos` decimal(8,2) UNSIGNED NOT NULL,
  `importe_total` double(8,2) UNSIGNED NOT NULL,
  `detalle` varchar(200) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_proveedor`, `id_tipo_comprobante`, `numero_factura`, `orden_compra_numero`, `orden_compra_fecha`, `gastos_envio`, `gastos_envio_iva`, `gastos_envio_impuestos`, `importe_total`, `detalle`, `fecha_compra`, `eliminado`) VALUES
(3, 1, 1, 1, 0, '2019-10-10 00:00:00', '0.00', '0.00', '0.00', 8000.00, 'ASD', '2019-09-20 19:56:50', 0),
(4, 3, 1, 36, 150, '2019-09-20 00:00:00', '30.00', '21.00', '13.50', 3500.00, 'Golosinas Septiembre', '2019-09-20 20:00:57', 0),
(5, 3, 1, 8, 9, '2019-09-24 00:00:00', '100.00', '21.00', '10.00', 9000.00, 'Compra de yerba', '2019-09-24 18:37:43', 0),
(6, 3, 1, 9, 9, '2019-09-24 00:00:00', '100.00', '21.00', '100.00', 2550.00, 'Agua mineral', '2019-09-24 19:19:30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras_detalles`
--

CREATE TABLE `compras_detalles` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_compra` bigint(20) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) UNSIGNED NOT NULL,
  `precio_unitario` decimal(8,2) UNSIGNED NOT NULL,
  `precio_total` decimal(8,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compras_detalles`
--

INSERT INTO `compras_detalles` (`id`, `id_compra`, `id_producto`, `cantidad`, `precio_unitario`, `precio_total`) VALUES
(3, 3, 2, 10, '50.00', '500'),
(4, 3, 3, 50, '150.00', '7500'),
(5, 4, 10, 100, '35.00', '3500'),
(6, 5, 11, 100, '90.00', '9000'),
(7, 6, 1, 50, '45.00', '2250'),
(8, 6, 2, 5, '60.00', '300');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Usuarios', 1),
(2, 'Permisos', 1),
(3, 'Caja', 1),
(4, 'Clientes', 1),
(5, 'Compras', 1),
(6, 'Productos', 1),
(7, 'Proveedores', 1),
(8, 'Stock', 1),
(9, 'Ventas', 1),
(10, 'Reportes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_caja`
--

CREATE TABLE `movimientos_caja` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_tipo_registro_caja` int(10) UNSIGNED NOT NULL,
  `entrada` decimal(8,2) UNSIGNED DEFAULT NULL,
  `salida` decimal(8,2) UNSIGNED DEFAULT NULL,
  `saldo` decimal(8,2) DEFAULT NULL,
  `id_pago` int(10) UNSIGNED DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimientos_caja`
--

INSERT INTO `movimientos_caja` (`id`, `id_tipo_registro_caja`, `entrada`, `salida`, `saldo`, `id_pago`, `fecha`, `id_usuario`) VALUES
(1, 1, NULL, NULL, '1000.00', 0, '2019-11-05 20:01:16', 3),
(2, 8, NULL, NULL, NULL, NULL, '2019-11-05 20:01:17', 3),
(3, 7, '140.00', NULL, '1140.00', 3, '2019-11-05 20:01:31', 3),
(4, 6, NULL, '50.00', '1090.00', NULL, '2019-11-05 20:01:43', 3),
(5, 5, '50.00', NULL, '1140.00', NULL, '2019-11-05 20:01:51', 3),
(6, 7, '140.00', NULL, '1280.00', 1, '2019-11-05 21:31:39', 3),
(7, 7, '56.00', NULL, '1336.00', 2, '2019-11-05 21:33:17', 3),
(8, 7, '28.00', NULL, '1364.00', 1, '2019-11-05 21:34:58', 3),
(9, 7, '56.00', NULL, '1420.00', 1, '2019-11-05 21:38:16', 3),
(10, 7, '110.00', NULL, '1530.00', 3, '2019-11-05 21:40:16', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Administrador', 1),
(2, 'Coordinador Playa', 1),
(3, 'Coordinador Mercado', 1),
(4, 'Playero', 1),
(5, 'Vendedor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles_permisos`
--

CREATE TABLE `perfiles_permisos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_perfil` int(11) UNSIGNED NOT NULL,
  `id_permiso` int(11) UNSIGNED NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `perfiles_permisos`
--

INSERT INTO `perfiles_permisos` (`id`, `id_perfil`, `id_permiso`, `habilitado`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 1, 5, 1),
(6, 1, 6, 1),
(7, 1, 7, 1),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 1, 11, 1),
(12, 1, 12, 1),
(13, 1, 13, 1),
(14, 1, 14, 1),
(15, 1, 15, 1),
(16, 1, 16, 1),
(17, 1, 17, 1),
(18, 1, 18, 1),
(19, 1, 19, 1),
(20, 1, 20, 1),
(21, 1, 21, 1),
(22, 1, 22, 1),
(23, 1, 23, 1),
(24, 1, 24, 1),
(25, 1, 25, 1),
(26, 1, 26, 1),
(27, 1, 27, 1),
(28, 1, 28, 1),
(29, 1, 29, 1),
(30, 1, 30, 1),
(31, 1, 31, 1),
(32, 1, 32, 1),
(33, 1, 33, 1),
(34, 1, 34, 1),
(35, 1, 35, 1),
(36, 1, 36, 1),
(37, 1, 37, 1),
(38, 1, 38, 1),
(39, 1, 39, 1),
(40, 1, 40, 1),
(41, 1, 41, 1),
(42, 1, 42, 1),
(43, 1, 43, 1),
(44, 1, 44, 1),
(45, 1, 45, 1),
(46, 1, 46, 1),
(47, 1, 47, 1),
(48, 1, 48, 1),
(49, 1, 49, 1),
(50, 1, 50, 1),
(51, 1, 51, 1),
(52, 1, 52, 1),
(53, 1, 53, 1),
(54, 1, 54, 1),
(55, 1, 55, 1),
(56, 1, 56, 1),
(57, 1, 57, 1),
(58, 1, 58, 1),
(59, 1, 59, 1),
(60, 1, 60, 1),
(61, 1, 61, 1),
(62, 1, 62, 1),
(63, 1, 63, 1),
(64, 1, 64, 1),
(65, 1, 65, 1),
(66, 1, 66, 1),
(67, 1, 67, 1),
(68, 1, 68, 1),
(69, 1, 69, 1),
(70, 1, 70, 1),
(71, 1, 71, 1),
(72, 1, 72, 1),
(73, 1, 73, 1),
(74, 1, 74, 1),
(75, 1, 75, 1),
(76, 1, 76, 1),
(77, 1, 77, 1),
(78, 1, 78, 1),
(79, 1, 79, 1),
(80, 1, 80, 1),
(81, 1, 81, 1),
(82, 1, 82, 1),
(83, 1, 83, 1),
(84, 1, 84, 1),
(85, 1, 85, 1),
(86, 1, 86, 1),
(87, 1, 87, 1),
(88, 1, 88, 1),
(89, 1, 89, 1),
(90, 1, 90, 1),
(91, 1, 91, 1),
(92, 1, 92, 1),
(93, 1, 93, 1),
(94, 1, 94, 1),
(95, 1, 95, 1),
(96, 1, 96, 1),
(97, 1, 97, 1),
(98, 1, 98, 1),
(99, 1, 99, 1),
(100, 1, 100, 1),
(101, 1, 101, 1),
(102, 1, 102, 1),
(103, 1, 103, 1),
(104, 1, 104, 1),
(105, 1, 105, 1),
(106, 1, 106, 1),
(107, 1, 107, 1),
(108, 1, 108, 1),
(109, 1, 109, 1),
(110, 1, 110, 1),
(111, 1, 111, 1),
(112, 1, 112, 1),
(113, 1, 113, 1),
(114, 1, 114, 1),
(115, 2, 1, 1),
(116, 2, 2, 1),
(117, 2, 3, 1),
(118, 2, 4, 1),
(119, 2, 5, 1),
(120, 2, 6, 1),
(121, 2, 7, 1),
(122, 2, 8, 1),
(123, 2, 9, 1),
(124, 2, 10, 0),
(125, 2, 11, 1),
(126, 2, 12, 1),
(127, 2, 13, 1),
(128, 2, 14, 1),
(129, 2, 15, 1),
(130, 2, 16, 1),
(131, 2, 17, 1),
(132, 2, 18, 1),
(133, 2, 19, 1),
(134, 2, 20, 1),
(135, 2, 21, 1),
(136, 2, 22, 1),
(137, 2, 23, 1),
(138, 2, 24, 1),
(139, 2, 25, 1),
(140, 2, 26, 1),
(141, 2, 27, 1),
(142, 2, 28, 1),
(143, 2, 29, 1),
(144, 2, 30, 1),
(145, 2, 31, 1),
(146, 2, 32, 1),
(147, 2, 33, 1),
(148, 2, 34, 1),
(149, 2, 35, 1),
(150, 2, 36, 1),
(151, 2, 37, 1),
(152, 2, 38, 1),
(153, 2, 39, 1),
(154, 2, 40, 1),
(155, 2, 41, 1),
(156, 2, 42, 1),
(157, 2, 43, 1),
(158, 2, 44, 1),
(159, 2, 45, 1),
(160, 2, 46, 1),
(161, 2, 47, 1),
(162, 2, 48, 1),
(163, 2, 49, 1),
(164, 2, 50, 1),
(165, 2, 51, 1),
(166, 2, 52, 1),
(167, 2, 53, 1),
(168, 2, 54, 1),
(169, 2, 55, 1),
(170, 2, 56, 1),
(171, 2, 57, 1),
(172, 3, 58, 1),
(173, 3, 59, 1),
(174, 3, 60, 1),
(175, 3, 61, 1),
(176, 3, 62, 1),
(177, 3, 63, 1),
(178, 3, 64, 1),
(179, 3, 65, 1),
(180, 3, 66, 1),
(181, 3, 67, 0),
(182, 3, 68, 1),
(183, 3, 69, 1),
(184, 3, 70, 1),
(185, 3, 71, 1),
(186, 3, 72, 1),
(187, 3, 73, 1),
(188, 3, 74, 1),
(189, 3, 75, 1),
(190, 3, 76, 1),
(191, 3, 77, 1),
(192, 3, 78, 1),
(193, 3, 79, 1),
(194, 3, 80, 1),
(195, 3, 81, 1),
(196, 3, 82, 1),
(197, 3, 83, 1),
(198, 3, 84, 1),
(199, 3, 85, 1),
(200, 3, 86, 1),
(201, 3, 87, 1),
(202, 3, 88, 1),
(203, 3, 89, 1),
(204, 3, 90, 1),
(205, 3, 91, 1),
(206, 3, 92, 1),
(207, 3, 93, 1),
(208, 3, 94, 1),
(209, 3, 95, 1),
(210, 3, 96, 1),
(211, 3, 97, 1),
(212, 3, 98, 1),
(213, 3, 99, 1),
(214, 3, 100, 1),
(215, 3, 101, 1),
(216, 3, 102, 1),
(217, 3, 103, 1),
(218, 3, 104, 1),
(219, 3, 105, 1),
(220, 3, 106, 1),
(221, 3, 107, 1),
(222, 3, 108, 1),
(223, 3, 109, 1),
(224, 3, 110, 1),
(225, 3, 111, 1),
(226, 3, 112, 1),
(227, 3, 113, 1),
(228, 3, 114, 1),
(229, 4, 1, 0),
(230, 4, 2, 0),
(231, 4, 3, 0),
(232, 4, 4, 0),
(233, 4, 5, 0),
(234, 4, 6, 0),
(235, 4, 7, 0),
(236, 4, 8, 0),
(237, 4, 9, 0),
(238, 4, 10, 0),
(239, 4, 11, 0),
(240, 4, 12, 0),
(241, 4, 13, 0),
(242, 4, 14, 0),
(243, 4, 15, 0),
(244, 4, 16, 0),
(245, 4, 17, 0),
(246, 4, 18, 0),
(247, 4, 19, 0),
(248, 4, 20, 0),
(249, 4, 21, 0),
(250, 4, 22, 0),
(251, 4, 23, 0),
(252, 4, 24, 0),
(253, 4, 25, 0),
(254, 4, 26, 0),
(255, 4, 27, 0),
(256, 4, 28, 0),
(257, 4, 29, 0),
(258, 4, 30, 0),
(259, 4, 31, 0),
(260, 4, 32, 0),
(261, 4, 33, 0),
(262, 4, 34, 0),
(263, 4, 35, 0),
(264, 4, 36, 0),
(265, 4, 37, 0),
(266, 4, 38, 0),
(267, 4, 39, 0),
(268, 4, 40, 0),
(269, 4, 41, 0),
(270, 4, 42, 0),
(271, 4, 43, 0),
(272, 4, 44, 1),
(273, 4, 45, 1),
(274, 4, 46, 1),
(275, 4, 47, 1),
(276, 4, 48, 1),
(277, 4, 49, 1),
(278, 4, 50, 0),
(279, 4, 51, 0),
(280, 4, 52, 1),
(281, 4, 53, 1),
(282, 4, 54, 0),
(283, 4, 55, 0),
(284, 4, 56, 0),
(285, 4, 57, 0),
(286, 5, 58, 0),
(287, 5, 59, 0),
(288, 5, 60, 0),
(289, 5, 61, 0),
(290, 5, 62, 0),
(291, 5, 63, 0),
(292, 5, 64, 0),
(293, 5, 65, 0),
(294, 5, 66, 0),
(295, 5, 67, 0),
(296, 5, 68, 0),
(297, 5, 69, 0),
(298, 5, 70, 0),
(299, 5, 71, 0),
(300, 5, 72, 0),
(301, 5, 73, 0),
(302, 5, 74, 0),
(303, 5, 75, 0),
(304, 5, 76, 0),
(305, 5, 77, 0),
(306, 5, 78, 0),
(307, 5, 79, 0),
(308, 5, 80, 0),
(309, 5, 81, 0),
(310, 5, 82, 0),
(311, 5, 83, 0),
(312, 5, 84, 0),
(313, 5, 85, 0),
(314, 5, 86, 0),
(315, 5, 87, 0),
(316, 5, 88, 0),
(317, 5, 89, 0),
(318, 5, 90, 0),
(319, 5, 91, 0),
(320, 5, 92, 0),
(321, 5, 93, 0),
(322, 5, 94, 0),
(323, 5, 95, 0),
(324, 5, 96, 0),
(325, 5, 97, 0),
(326, 5, 98, 0),
(327, 5, 99, 0),
(328, 5, 100, 0),
(329, 5, 101, 1),
(330, 5, 102, 1),
(331, 5, 103, 1),
(332, 5, 104, 1),
(333, 5, 105, 1),
(334, 5, 106, 1),
(335, 5, 107, 0),
(336, 5, 108, 0),
(337, 5, 109, 1),
(338, 5, 110, 1),
(339, 5, 111, 0),
(340, 5, 112, 0),
(341, 5, 113, 0),
(342, 5, 114, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_area` int(10) UNSIGNED NOT NULL,
  `id_modulo` int(10) UNSIGNED NOT NULL,
  `accion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `id_area`, `id_modulo`, `accion`, `habilitado`) VALUES
(1, 1, 1, 'listado', 1),
(2, 1, 1, 'detalles', 1),
(3, 1, 1, 'nuevo_buscar', 1),
(4, 1, 1, 'nuevo_confirmar', 1),
(5, 1, 1, 'editar_buscar', 1),
(6, 1, 1, 'editar_confirmar', 1),
(7, 1, 1, 'eliminar', 1),
(8, 1, 1, 'deshabilitar', 1),
(9, 1, 1, 'habilitar', 1),
(10, 1, 2, 'listado', 1),
(11, 1, 3, 'listado', 1),
(12, 1, 4, 'listado', 1),
(13, 1, 4, 'detalles', 1),
(14, 1, 4, 'nuevo_buscar', 1),
(15, 1, 4, 'nuevo_confirmar', 1),
(16, 1, 4, 'editar_buscar', 1),
(17, 1, 4, 'editar_confirmar', 1),
(18, 1, 4, 'eliminar', 1),
(19, 1, 4, 'deshabilitar', 1),
(20, 1, 4, 'habilitar', 1),
(21, 1, 5, 'listado', 1),
(22, 1, 5, 'detalles', 1),
(23, 1, 5, 'nuevo_buscar', 1),
(24, 1, 5, 'nuevo_confirmar', 1),
(25, 1, 5, 'editar_buscar', 1),
(26, 1, 5, 'editar_confirmar', 1),
(27, 1, 5, 'eliminar', 1),
(28, 1, 6, 'listado', 1),
(29, 1, 6, 'nuevo_buscar', 1),
(30, 1, 6, 'nuevo_confirmar', 1),
(31, 1, 6, 'editar_buscar', 1),
(32, 1, 6, 'editar_confirmar', 1),
(33, 1, 6, 'eliminar', 1),
(34, 1, 7, 'listado', 1),
(35, 1, 7, 'detalles', 1),
(36, 1, 7, 'nuevo_buscar', 1),
(37, 1, 7, 'nuevo_confirmar', 1),
(38, 1, 7, 'editar_buscar', 1),
(39, 1, 7, 'editar_confirmar', 1),
(40, 1, 7, 'eliminar', 1),
(41, 1, 7, 'deshabilitar', 1),
(42, 1, 7, 'habilitar', 1),
(43, 1, 8, 'listado', 1),
(44, 1, 9, 'abrir_caja', 1),
(45, 1, 9, 'cerrar_caja', 1),
(46, 1, 9, 'comenzar_turno', 1),
(47, 1, 9, 'finalizar_turno', 1),
(48, 1, 9, 'otros_buscar', 1),
(49, 1, 9, 'otros_confirmar', 1),
(50, 1, 9, 'listado', 1),
(51, 1, 9, 'detalles', 1),
(52, 1, 9, 'nuevo_buscar', 1),
(53, 1, 9, 'nuevo_confirmar', 1),
(54, 1, 9, 'editar_buscar', 1),
(55, 1, 9, 'editar_confirmar', 1),
(56, 1, 9, 'eliminar', 1),
(57, 1, 10, 'listado', 1),
(58, 2, 1, 'listado', 1),
(59, 2, 1, 'detalles', 1),
(60, 2, 1, 'nuevo_buscar', 1),
(61, 2, 1, 'nuevo_confirmar', 1),
(62, 2, 1, 'editar_buscar', 1),
(63, 2, 1, 'editar_confirmar', 1),
(64, 2, 1, 'eliminar', 1),
(65, 2, 1, 'deshabilitar', 1),
(66, 2, 1, 'habilitar', 1),
(67, 2, 2, 'listado', 1),
(68, 2, 3, 'listado', 1),
(69, 2, 4, 'listado', 1),
(70, 2, 4, 'detalles', 1),
(71, 2, 4, 'nuevo_buscar', 1),
(72, 2, 4, 'nuevo_confirmar', 1),
(73, 2, 4, 'editar_buscar', 1),
(74, 2, 4, 'editar_confirmar', 1),
(75, 2, 4, 'eliminar', 1),
(76, 2, 4, 'deshabilitar', 1),
(77, 2, 4, 'habilitar', 1),
(78, 2, 5, 'listado', 1),
(79, 2, 5, 'detalles', 1),
(80, 2, 5, 'nuevo_buscar', 1),
(81, 2, 5, 'nuevo_confirmar', 1),
(82, 2, 5, 'editar_buscar', 1),
(83, 2, 5, 'editar_confirmar', 1),
(84, 2, 5, 'eliminar', 1),
(85, 2, 6, 'listado', 1),
(86, 2, 6, 'nuevo_buscar', 1),
(87, 2, 6, 'nuevo_confirmar', 1),
(88, 2, 6, 'editar_buscar', 1),
(89, 2, 6, 'editar_confirmar', 1),
(90, 2, 6, 'eliminar', 1),
(91, 2, 7, 'listado', 1),
(92, 2, 7, 'detalles', 1),
(93, 2, 7, 'nuevo_buscar', 1),
(94, 2, 7, 'nuevo_confirmar', 1),
(95, 2, 7, 'editar_buscar', 1),
(96, 2, 7, 'editar_confirmar', 1),
(97, 2, 7, 'eliminar', 1),
(98, 2, 7, 'deshabilitar', 1),
(99, 2, 7, 'habilitar', 1),
(100, 2, 8, 'listado', 1),
(101, 2, 9, 'abrir_caja', 1),
(102, 2, 9, 'cerrar_caja', 1),
(103, 2, 9, 'comenzar_turno', 1),
(104, 2, 9, 'finalizar_turno', 1),
(105, 2, 9, 'otros_buscar', 1),
(106, 2, 9, 'otros_confirmar', 1),
(107, 2, 9, 'listado', 1),
(108, 2, 9, 'detalles', 1),
(109, 2, 9, 'nuevo_buscar', 1),
(110, 2, 9, 'nuevo_confirmar', 1),
(111, 2, 9, 'editar_buscar', 1),
(112, 2, 9, 'editar_confirmar', 1),
(113, 2, 9, 'eliminar', 1),
(114, 2, 10, 'listado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_clientes`
--

CREATE TABLE `playa_clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_cliente` int(11) UNSIGNED NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `cuit` bigint(20) UNSIGNED NOT NULL,
  `domicilio` varchar(50) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_compras`
--

CREATE TABLE `playa_compras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_proveedor` int(10) UNSIGNED NOT NULL,
  `id_tipo_comprobante` int(10) UNSIGNED NOT NULL,
  `numero_factura` int(11) UNSIGNED NOT NULL,
  `orden_compra_numero` int(11) UNSIGNED NOT NULL,
  `orden_compra_fecha` datetime NOT NULL,
  `gastos_envio` decimal(8,2) UNSIGNED NOT NULL,
  `gastos_envio_iva` decimal(8,2) UNSIGNED NOT NULL,
  `gastos_envio_impuestos` decimal(8,2) UNSIGNED NOT NULL,
  `importe_total` double(8,2) UNSIGNED NOT NULL,
  `detalle` varchar(200) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_compras_detalles`
--

CREATE TABLE `playa_compras_detalles` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_compra` bigint(20) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) UNSIGNED NOT NULL,
  `precio_unitario` decimal(8,2) UNSIGNED NOT NULL,
  `precio_total` decimal(8,0) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_movimientos_caja`
--

CREATE TABLE `playa_movimientos_caja` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_tipo_registro_caja` int(10) UNSIGNED NOT NULL,
  `entrada` decimal(8,2) UNSIGNED DEFAULT NULL,
  `salida` decimal(8,2) UNSIGNED DEFAULT NULL,
  `saldo` decimal(8,2) DEFAULT NULL,
  `id_pago` int(10) UNSIGNED DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_productos`
--

CREATE TABLE `playa_productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_tipo_producto` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `precio_unitario` decimal(8,2) UNSIGNED NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_proveedores`
--

CREATE TABLE `playa_proveedores` (
  `id` int(11) UNSIGNED NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `id_tipo_documento` int(11) UNSIGNED NOT NULL,
  `documento` bigint(11) UNSIGNED NOT NULL,
  `sucursal` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` int(11) UNSIGNED NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_stock`
--

CREATE TABLE `playa_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `unidades` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_tipos_productos`
--

CREATE TABLE `playa_tipos_productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_ventas`
--

CREATE TABLE `playa_ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `cuit` bigint(20) UNSIGNED DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_tipo_pago` int(10) UNSIGNED NOT NULL,
  `importe_total` double(8,2) UNSIGNED NOT NULL,
  `id_usuario_vendedor` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playa_ventas_detalles`
--

CREATE TABLE `playa_ventas_detalles` (
  `id` int(11) NOT NULL,
  `id_venta` bigint(20) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(8,2) NOT NULL,
  `precio_total` decimal(8,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_tipo_producto` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `precio_unitario` decimal(8,2) UNSIGNED NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_tipo_producto`, `descripcion`, `precio_unitario`, `fecha_registro`, `habilitado`, `eliminado`) VALUES
(1, 1, 'Eco de los Andes 500ml', '45.00', '2019-06-08 23:20:20', 1, 0),
(2, 1, 'Manaos Cola 1lt ', '10.00', '2019-06-08 23:20:58', 1, 0),
(3, 2, 'Marlboro Box 20u', '110.00', '2019-06-08 23:21:24', 1, 0),
(4, 2, 'Lucky Strike Limón 10u', '60.00', '2019-06-08 23:22:00', 1, 0),
(5, 3, 'Bizcochitos Granix 180g', '36.00', '2019-06-08 23:22:50', 0, 0),
(6, 3, 'Cachafaz Integral Chips 100g', '79.00', '2019-06-08 23:25:01', 1, 0),
(7, 1, 'Kin Gasificada 1lt', '38.00', '2019-06-08 23:52:53', 1, 0),
(8, 3, 'Sonrisas frambuesa pack x3', '90.00', '2019-06-08 23:54:10', 1, 0),
(9, 4, 'La Merced Campo y Monte 500g', '129.00', '2019-06-09 17:11:21', 1, 0),
(10, 3, 'Alfajor Jorgito Choco 100g', '28.00', '2019-09-20 19:24:20', 1, 0),
(11, 4, 'La Merced 500 gr', '132.00', '2019-09-24 18:34:45', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) UNSIGNED NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `id_tipo_documento` int(11) UNSIGNED NOT NULL,
  `documento` bigint(11) UNSIGNED NOT NULL,
  `sucursal` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` int(11) UNSIGNED NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `razon_social`, `id_tipo_documento`, `documento`, `sucursal`, `pais`, `provincia`, `localidad`, `calle`, `email`, `telefono`, `fecha_modificacion`, `fecha_creacion`, `habilitado`, `eliminado`) VALUES
(1, 'IrKombustibles.sg', 2, 3026555443, '23', 'Argentina', 'Buenos Aires', 'Zárate', 'Los muñones 3509', 'irkombustibles@irko.com', 42423322, '2019-09-05 16:58:52', '2019-09-05 16:22:51', 1, 0),
(2, 'Kyrabebidas', 0, 20253445442, '', '', '', '', '', 'kyrabebidas@yahoo.com', 42775445, NULL, '2019-09-05 16:22:51', 1, 1),
(3, 'Boca Golosinas', 2, 256789868958, '3', 'Argentina', 'Buenos Aires', 'CABA', 'Av. Lezama 2903', 'bombonera@hotmail.com', 34236789, '2019-09-05 17:00:16', '2019-09-05 16:22:51', 1, 0),
(4, 'Energía Sustentable S.A.', 2, 30230938499, '110', 'Argentina', 'La Pampa', 'Rodriguez', 'Av. Dependencia 1058', 'enersust@mail.com', 55283940, '2019-09-05 16:57:44', '2019-09-05 16:55:03', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_producto` int(10) UNSIGNED NOT NULL,
  `unidades` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `id_producto`, `unidades`) VALUES
(1, 10, 75),
(2, 1, 0),
(3, 2, 1),
(4, 3, 39),
(5, 4, 0),
(6, 5, 0),
(7, 6, 0),
(8, 7, 0),
(9, 8, 0),
(10, 9, 0),
(11, 11, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_clientes`
--

CREATE TABLE `tipos_clientes` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_clientes`
--

INSERT INTO `tipos_clientes` (`id`, `descripcion`) VALUES
(1, 'Frecuente'),
(2, 'De mostrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_comprobantes`
--

CREATE TABLE `tipos_comprobantes` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_comprobantes`
--

INSERT INTO `tipos_comprobantes` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Factura', 1),
(2, 'Nota de Crédito', 1),
(3, 'Nota de Débito', 1),
(4, 'Remito', 1),
(5, 'Factura y Remito', 1),
(6, 'Presupuesto', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_documentos`
--

CREATE TABLE `tipos_documentos` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_documentos`
--

INSERT INTO `tipos_documentos` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'CUIT', 1),
(2, 'CUIL', 1),
(3, 'LE', 1),
(4, 'LC', 1),
(5, 'DNI', 1),
(6, 'Pasaporte', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_pagos`
--

CREATE TABLE `tipos_pagos` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_pagos`
--

INSERT INTO `tipos_pagos` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Efectivo', 1),
(2, 'Tarjeta de Crédito', 1),
(3, 'Tarjeta de Débito', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_productos`
--

CREATE TABLE `tipos_productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_productos`
--

INSERT INTO `tipos_productos` (`id`, `descripcion`) VALUES
(1, 'Bebida'),
(2, 'Cigarrillos'),
(3, 'Galletitas'),
(4, 'Yerba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_registros_caja`
--

CREATE TABLE `tipos_registros_caja` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipos_registros_caja`
--

INSERT INTO `tipos_registros_caja` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Apertura de Caja', 1),
(3, 'Cierre de Caja', 1),
(5, 'Ingreso de Efectivo', 1),
(6, 'Egreso de Efectivo', 1),
(7, 'Venta', 1),
(8, 'Comienzo de Turno', 1),
(9, 'Fin de Turno', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_perfil` int(11) UNSIGNED NOT NULL,
  `id_tipo_documento` int(11) UNSIGNED NOT NULL,
  `documento` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT '123',
  `nombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_perfil`, `id_tipo_documento`, `documento`, `usuario`, `clave`, `nombres`, `apellidos`, `email`, `telefono`, `fecha_registro`, `habilitado`, `eliminado`) VALUES
(1, 1, 6, 393721512, 'ruben', 'ruben', 'Ruben', 'Molina', 'rubenmolina_cabj@hotmail.com', '45291477', '2019-06-08 14:40:06', 1, 0),
(2, 2, 2, 34262849, 'david', 'david', 'David', 'Bustamante', 'david@mail.com', '44442222', '2019-06-08 14:40:41', 1, 0),
(3, 5, 0, 0, 'mati', 'mati', 'Matias', 'Montiel', '', '', '2019-06-08 14:41:01', 1, 0),
(4, 1, 0, 0, 'irko', 'irko', 'Irko', 'Cat', '', '', '2019-06-08 19:27:33', 1, 0),
(5, 1, 0, 0, 'kyra', 'kyra', 'Kyra', 'Dog', '', '', '2019-06-08 19:27:57', 1, 0),
(6, 1, 2, 123123123, 'user', 'user', 'Usuario', 'Prueba', 'user@mail.com', '123123', '2019-09-06 19:03:30', 1, 1),
(7, 2, 5, 24526889, 'gerente', 'gerente', 'Ger', 'Ente', 'gerente@mail.com', '43456162', '2019-09-08 18:05:31', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `cuit` bigint(20) UNSIGNED DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_tipo_pago` int(10) UNSIGNED NOT NULL,
  `importe_total` double(8,2) UNSIGNED NOT NULL,
  `id_usuario_vendedor` int(11) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `razon_social`, `cuit`, `domicilio`, `telefono`, `email`, `id_tipo_pago`, `importe_total`, `id_usuario_vendedor`, `numero_factura`, `fecha_venta`) VALUES
(1, '', 0, '', '', '', 1, 450.00, 1, 1, '2019-09-24 20:33:25'),
(2, '', 0, '', '', '', 1, 250.00, 1, 1, '2019-09-24 20:34:25'),
(3, '', 0, '', '', '', 1, 250.00, 1, 1, '2019-09-24 20:35:40'),
(4, '', 0, '', '', '', 1, 5000.00, 1, 1, '2019-10-01 18:16:48'),
(5, '', 0, '', '', '', 1, 5000.00, 1, 1, '2019-10-01 18:28:41'),
(6, '', 0, '', '', '', 1, 5000.00, 1, 1, '2019-10-01 18:28:56'),
(7, '', 0, '', '', '', 1, 5000.00, 1, 1, '2019-10-01 18:29:14'),
(8, '', 0, '', '', '', 1, 100.00, 1, 1, '2019-10-01 19:17:36'),
(9, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:11:31'),
(10, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:16:16'),
(11, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:16:43'),
(12, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:17:14'),
(13, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:18:30'),
(14, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:19:08'),
(15, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:20:04'),
(16, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:20:24'),
(17, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:20:59'),
(18, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:21:29'),
(19, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:21:59'),
(20, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:22:44'),
(21, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:23:22'),
(22, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:24:03'),
(23, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:25:27'),
(24, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:27:11'),
(25, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:27:48'),
(26, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:28:27'),
(27, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:29:13'),
(28, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:29:47'),
(29, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:31:40'),
(30, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:32:03'),
(31, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:32:03'),
(32, '', 0, '', '', '', 1, 90.00, 1, 1, '2019-10-08 20:32:38'),
(33, '', 0, '', '', '', 1, 10.00, 1, 1, '2019-10-08 20:33:47'),
(34, '', 0, '', '', '', 1, 10.00, 1, 1, '2019-10-08 20:33:51'),
(35, '', 0, '', '', '', 1, 10.00, 1, 1, '2019-10-08 20:34:04'),
(36, '', 0, '', '', '', 1, 110.00, 1, 1, '2019-10-29 19:02:41'),
(37, '', 0, '', '', '', 1, 110.00, 1, 1, '2019-10-29 19:04:33'),
(38, '', 0, '', '', '', 1, 220.00, 1, 0, '2019-10-29 19:30:37'),
(39, '', 0, '', '', '', 1, 110.00, 1, 0, '2019-11-01 23:21:36'),
(40, '', 0, '', '', '', 2, 220.00, 3, 0, '2019-11-01 23:23:08'),
(41, '', 0, '', '', '', 1, 110.00, 3, 0, '2019-11-05 18:36:17'),
(42, '', 0, '', '', '', 1, 110.00, 3, 0, '2019-11-05 18:39:24'),
(43, '', 0, '', '', '', 1, 110.00, 3, 0, '2019-11-05 19:42:39'),
(44, '', 0, '', '', '', 2, 280.00, 3, 0, '2019-11-05 19:44:07'),
(45, '', 0, '', '', '', 3, 140.00, 3, 0, '2019-11-05 20:01:31'),
(46, NULL, NULL, NULL, NULL, NULL, 1, 140.00, 3, 0, '2019-11-05 21:31:39'),
(47, NULL, NULL, NULL, NULL, NULL, 2, 56.00, 3, 0, '2019-11-05 21:33:17'),
(48, NULL, NULL, NULL, NULL, NULL, 1, 28.00, 3, 0, '2019-11-05 21:34:58'),
(49, 'Combustibles Uruguay', 30158593840, 'Las casas 123', '42424343', 'comburu@mail.com', 1, 56.00, 3, 0, '2019-11-05 21:38:16'),
(50, 'Gonzalo Escudero', 2033333390, 'Las cascadas 6969', '44448888', 'creo@mail.com', 3, 110.00, 3, 0, '2019-11-05 21:40:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalles`
--

CREATE TABLE `ventas_detalles` (
  `id` int(11) NOT NULL,
  `id_venta` bigint(20) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(8,2) NOT NULL,
  `precio_total` decimal(8,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas_detalles`
--

INSERT INTO `ventas_detalles` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `precio_total`) VALUES
(1, 1, 1, 10, '45.00', '450'),
(2, 2, 2, 5, '50.00', '250'),
(3, 3, 2, 5, '50.00', '250'),
(4, 4, 2, 100, '50.00', '5000'),
(5, 5, 2, 100, '50.00', '5000'),
(6, 6, 2, 100, '50.00', '5000'),
(7, 7, 2, 100, '50.00', '5000'),
(8, 8, 1, 2, '45.00', '90'),
(9, 8, 2, 1, '10.00', '10'),
(10, 9, 1, 2, '45.00', '90'),
(11, 10, 1, 2, '45.00', '90'),
(12, 11, 1, 2, '45.00', '90'),
(13, 12, 1, 2, '45.00', '90'),
(14, 13, 1, 2, '45.00', '90'),
(15, 14, 1, 2, '45.00', '90'),
(16, 15, 1, 2, '45.00', '90'),
(17, 16, 1, 2, '45.00', '90'),
(18, 17, 1, 2, '45.00', '90'),
(19, 18, 1, 2, '45.00', '90'),
(20, 19, 1, 2, '45.00', '90'),
(21, 20, 1, 2, '45.00', '90'),
(22, 21, 1, 2, '45.00', '90'),
(23, 22, 1, 2, '45.00', '90'),
(24, 23, 1, 2, '45.00', '90'),
(25, 24, 1, 2, '45.00', '90'),
(26, 25, 1, 2, '45.00', '90'),
(27, 26, 1, 2, '45.00', '90'),
(28, 27, 1, 2, '45.00', '90'),
(29, 28, 1, 2, '45.00', '90'),
(30, 29, 1, 2, '45.00', '90'),
(31, 30, 1, 2, '45.00', '90'),
(32, 31, 1, 2, '45.00', '90'),
(33, 32, 1, 2, '45.00', '90'),
(34, 33, 2, 1, '10.00', '10'),
(35, 34, 2, 1, '10.00', '10'),
(36, 35, 2, 1, '10.00', '10'),
(37, 36, 3, 1, '110.00', '110'),
(38, 37, 3, 1, '110.00', '110'),
(39, 38, 3, 2, '110.00', '220'),
(40, 39, 3, 1, '110.00', '110'),
(41, 40, 3, 2, '110.00', '220'),
(42, 41, 3, 1, '110.00', '110'),
(43, 42, 3, 1, '110.00', '110'),
(44, 43, 3, 1, '110.00', '110'),
(45, 44, 10, 10, '28.00', '280'),
(46, 45, 10, 5, '28.00', '140'),
(47, 46, 10, 5, '28.00', '140'),
(48, 47, 10, 2, '28.00', '56'),
(49, 48, 10, 1, '28.00', '28'),
(50, 49, 10, 2, '28.00', '56'),
(51, 50, 3, 1, '110.00', '110');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras_detalles`
--
ALTER TABLE `compras_detalles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles_permisos`
--
ALTER TABLE `perfiles_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_clientes`
--
ALTER TABLE `playa_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_compras`
--
ALTER TABLE `playa_compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_compras_detalles`
--
ALTER TABLE `playa_compras_detalles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_movimientos_caja`
--
ALTER TABLE `playa_movimientos_caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_productos`
--
ALTER TABLE `playa_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_proveedores`
--
ALTER TABLE `playa_proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_stock`
--
ALTER TABLE `playa_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_tipos_productos`
--
ALTER TABLE `playa_tipos_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_ventas`
--
ALTER TABLE `playa_ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `playa_ventas_detalles`
--
ALTER TABLE `playa_ventas_detalles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_clientes`
--
ALTER TABLE `tipos_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_comprobantes`
--
ALTER TABLE `tipos_comprobantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_pagos`
--
ALTER TABLE `tipos_pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_productos`
--
ALTER TABLE `tipos_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_registros_caja`
--
ALTER TABLE `tipos_registros_caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compras_detalles`
--
ALTER TABLE `compras_detalles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `movimientos_caja`
--
ALTER TABLE `movimientos_caja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `perfiles_permisos`
--
ALTER TABLE `perfiles_permisos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `playa_clientes`
--
ALTER TABLE `playa_clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `playa_compras`
--
ALTER TABLE `playa_compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `playa_compras_detalles`
--
ALTER TABLE `playa_compras_detalles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `playa_movimientos_caja`
--
ALTER TABLE `playa_movimientos_caja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `playa_productos`
--
ALTER TABLE `playa_productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `playa_proveedores`
--
ALTER TABLE `playa_proveedores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `playa_stock`
--
ALTER TABLE `playa_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `playa_tipos_productos`
--
ALTER TABLE `playa_tipos_productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `playa_ventas`
--
ALTER TABLE `playa_ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `playa_ventas_detalles`
--
ALTER TABLE `playa_ventas_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipos_clientes`
--
ALTER TABLE `tipos_clientes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_comprobantes`
--
ALTER TABLE `tipos_comprobantes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipos_documentos`
--
ALTER TABLE `tipos_documentos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipos_pagos`
--
ALTER TABLE `tipos_pagos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_productos`
--
ALTER TABLE `tipos_productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipos_registros_caja`
--
ALTER TABLE `tipos_registros_caja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `ventas_detalles`
--
ALTER TABLE `ventas_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
