-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2019 a las 03:09:55
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

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
(1, 'Mercado', 1),
(2, 'Playa', 1);

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
(2, 'Caja', 1),
(3, 'Clientes', 1),
(4, 'Compras', 1),
(5, 'Productos', 1),
(6, 'Proveedores', 1),
(7, 'Stock', 1),
(8, 'Ventas', 1);

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
  `id_perfil` int(11) UNSIGNED NOT NULL,
  `id_permiso` int(11) UNSIGNED NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `perfiles_permisos`
--

INSERT INTO `perfiles_permisos` (`id_perfil`, `id_permiso`, `habilitado`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(1, 11, 1),
(1, 12, 1),
(1, 13, 1),
(1, 14, 1),
(1, 15, 1),
(1, 16, 1),
(1, 17, 1),
(1, 18, 1),
(1, 19, 1),
(1, 20, 1),
(1, 21, 1),
(1, 22, 1),
(1, 23, 1),
(1, 24, 1),
(1, 25, 1),
(1, 26, 1),
(1, 27, 1),
(1, 28, 1),
(1, 29, 1),
(1, 30, 1),
(1, 31, 1),
(1, 32, 1),
(1, 33, 1),
(1, 34, 1),
(1, 35, 1),
(1, 36, 1),
(1, 37, 1),
(1, 38, 1),
(1, 39, 1),
(1, 40, 1),
(1, 41, 1),
(1, 42, 1),
(1, 43, 1),
(1, 44, 1),
(1, 45, 1),
(1, 46, 1),
(1, 47, 1),
(1, 48, 1),
(1, 49, 1),
(1, 50, 1),
(1, 51, 1),
(1, 52, 1),
(1, 53, 1),
(1, 54, 1),
(1, 55, 1),
(1, 56, 1),
(1, 57, 1),
(1, 58, 1),
(1, 59, 1),
(1, 60, 1),
(1, 61, 1),
(1, 62, 1),
(1, 63, 1),
(1, 64, 1),
(1, 65, 1),
(1, 66, 1),
(1, 67, 1),
(1, 68, 1),
(1, 69, 1),
(1, 70, 1),
(1, 71, 1),
(1, 72, 1),
(1, 73, 1),
(1, 74, 1),
(1, 75, 1),
(1, 76, 1),
(1, 77, 1),
(1, 78, 1),
(1, 79, 1),
(1, 80, 1),
(1, 81, 1),
(1, 82, 1),
(1, 83, 1),
(1, 84, 1),
(1, 85, 1),
(1, 86, 1),
(1, 87, 1),
(1, 88, 1),
(1, 89, 1),
(1, 90, 1),
(1, 91, 1),
(1, 92, 1),
(1, 93, 1),
(1, 94, 1),
(1, 95, 1),
(1, 96, 1),
(1, 97, 1),
(1, 98, 1),
(1, 99, 1),
(1, 100, 1),
(1, 101, 1),
(2, 1, 0),
(2, 2, 0),
(2, 3, 0),
(2, 4, 0),
(2, 5, 0),
(2, 6, 0),
(2, 7, 0),
(2, 8, 0),
(2, 9, 0),
(2, 10, 0),
(2, 11, 0),
(2, 12, 0),
(2, 13, 0),
(2, 14, 0),
(2, 15, 0),
(2, 16, 0),
(2, 17, 0),
(2, 18, 0),
(2, 19, 0),
(2, 20, 0),
(2, 21, 0),
(2, 22, 0),
(2, 23, 0),
(2, 24, 0),
(2, 25, 0),
(2, 26, 0),
(2, 27, 0),
(2, 28, 0),
(2, 29, 0),
(2, 30, 0),
(2, 31, 0),
(2, 32, 0),
(2, 33, 0),
(2, 34, 0),
(2, 35, 0),
(2, 36, 0),
(2, 37, 0),
(2, 38, 0),
(2, 39, 0),
(2, 40, 0),
(2, 41, 0),
(2, 42, 0),
(2, 43, 0),
(2, 44, 0),
(2, 45, 0),
(2, 46, 0),
(2, 47, 0),
(2, 48, 0),
(2, 49, 0),
(2, 50, 0),
(2, 51, 0),
(2, 52, 0),
(2, 53, 0),
(2, 54, 0),
(2, 55, 0),
(2, 56, 1),
(2, 57, 1),
(2, 58, 1),
(2, 59, 1),
(2, 60, 1),
(2, 61, 1),
(2, 62, 1),
(2, 63, 1),
(2, 64, 1),
(2, 65, 1),
(2, 66, 1),
(2, 67, 1),
(2, 68, 1),
(2, 69, 1),
(2, 70, 1),
(2, 71, 1),
(2, 72, 1),
(2, 73, 1),
(2, 74, 1),
(2, 75, 1),
(2, 76, 1),
(2, 77, 1),
(2, 78, 1),
(2, 79, 1),
(2, 80, 1),
(2, 81, 1),
(2, 82, 1),
(2, 83, 1),
(2, 84, 1),
(2, 85, 1),
(2, 86, 1),
(2, 87, 1),
(2, 88, 1),
(2, 89, 1),
(2, 90, 1),
(2, 91, 1),
(2, 92, 1),
(2, 93, 1),
(2, 94, 1),
(2, 95, 1),
(2, 96, 1),
(2, 97, 1),
(2, 98, 1),
(2, 99, 1),
(2, 100, 1),
(2, 101, 1),
(3, 1, 0),
(3, 2, 0),
(3, 3, 0),
(3, 4, 0),
(3, 5, 0),
(3, 6, 0),
(3, 7, 0),
(3, 8, 0),
(3, 9, 0),
(3, 10, 1),
(3, 11, 1),
(3, 12, 1),
(3, 13, 1),
(3, 14, 1),
(3, 15, 1),
(3, 16, 1),
(3, 17, 1),
(3, 18, 1),
(3, 19, 1),
(3, 20, 1),
(3, 21, 1),
(3, 22, 1),
(3, 23, 1),
(3, 24, 1),
(3, 25, 1),
(3, 26, 1),
(3, 27, 1),
(3, 28, 1),
(3, 29, 1),
(3, 30, 1),
(3, 31, 1),
(3, 32, 1),
(3, 33, 1),
(3, 34, 1),
(3, 35, 1),
(3, 36, 1),
(3, 37, 1),
(3, 38, 1),
(3, 39, 1),
(3, 40, 1),
(3, 41, 1),
(3, 42, 1),
(3, 43, 1),
(3, 44, 1),
(3, 45, 1),
(3, 46, 1),
(3, 47, 1),
(3, 48, 1),
(3, 49, 1),
(3, 50, 1),
(3, 51, 1),
(3, 52, 1),
(3, 53, 1),
(3, 54, 1),
(3, 55, 1),
(3, 56, 0),
(3, 57, 0),
(3, 58, 0),
(3, 59, 0),
(3, 60, 0),
(3, 61, 0),
(3, 62, 0),
(3, 63, 0),
(3, 64, 0),
(3, 65, 0),
(3, 66, 0),
(3, 67, 0),
(3, 68, 0),
(3, 69, 0),
(3, 70, 0),
(3, 71, 0),
(3, 72, 0),
(3, 73, 0),
(3, 74, 0),
(3, 75, 0),
(3, 76, 0),
(3, 77, 0),
(3, 78, 0),
(3, 79, 0),
(3, 80, 0),
(3, 81, 0),
(3, 82, 0),
(3, 83, 0),
(3, 84, 0),
(3, 85, 0),
(3, 86, 0),
(3, 87, 0),
(3, 88, 0),
(3, 89, 0),
(3, 90, 0),
(3, 91, 0),
(3, 92, 0),
(3, 93, 0),
(3, 94, 0),
(3, 95, 0),
(3, 96, 0),
(3, 97, 0),
(3, 98, 0),
(3, 99, 0),
(3, 100, 0),
(3, 101, 0),
(4, 1, 0),
(4, 2, 0),
(4, 3, 0),
(4, 4, 0),
(4, 5, 0),
(4, 6, 0),
(4, 7, 0),
(4, 8, 0),
(4, 9, 0),
(4, 10, 0),
(4, 11, 0),
(4, 12, 0),
(4, 13, 0),
(4, 14, 0),
(4, 15, 0),
(4, 16, 0),
(4, 17, 0),
(4, 18, 0),
(4, 19, 0),
(4, 20, 0),
(4, 21, 0),
(4, 22, 0),
(4, 23, 0),
(4, 24, 0),
(4, 25, 0),
(4, 26, 0),
(4, 27, 0),
(4, 28, 0),
(4, 29, 0),
(4, 30, 0),
(4, 31, 0),
(4, 32, 0),
(4, 33, 0),
(4, 34, 0),
(4, 35, 0),
(4, 36, 0),
(4, 37, 0),
(4, 38, 0),
(4, 39, 0),
(4, 40, 0),
(4, 41, 0),
(4, 42, 0),
(4, 43, 0),
(4, 44, 0),
(4, 45, 0),
(4, 46, 0),
(4, 47, 0),
(4, 48, 0),
(4, 49, 0),
(4, 50, 0),
(4, 51, 0),
(4, 52, 0),
(4, 53, 0),
(4, 54, 0),
(4, 55, 0),
(4, 56, 0),
(4, 57, 0),
(4, 58, 0),
(4, 59, 0),
(4, 60, 0),
(4, 61, 0),
(4, 62, 0),
(4, 63, 0),
(4, 64, 0),
(4, 65, 0),
(4, 66, 0),
(4, 67, 0),
(4, 68, 0),
(4, 69, 0),
(4, 70, 0),
(4, 71, 0),
(4, 72, 0),
(4, 73, 0),
(4, 74, 0),
(4, 75, 0),
(4, 76, 0),
(4, 77, 0),
(4, 78, 0),
(4, 79, 0),
(4, 80, 0),
(4, 81, 0),
(4, 82, 0),
(4, 83, 0),
(4, 84, 0),
(4, 85, 0),
(4, 86, 0),
(4, 87, 0),
(4, 88, 0),
(4, 89, 1),
(4, 90, 1),
(4, 91, 1),
(4, 92, 1),
(4, 93, 1),
(4, 94, 1),
(4, 95, 0),
(4, 96, 0),
(4, 97, 1),
(4, 98, 1),
(4, 99, 0),
(4, 100, 0),
(4, 101, 0),
(5, 1, 0),
(5, 2, 0),
(5, 3, 0),
(5, 4, 0),
(5, 5, 0),
(5, 6, 0),
(5, 7, 0),
(5, 8, 0),
(5, 9, 0),
(5, 10, 0),
(5, 11, 0),
(5, 12, 0),
(5, 13, 0),
(5, 14, 0),
(5, 15, 0),
(5, 16, 0),
(5, 17, 0),
(5, 18, 0),
(5, 19, 0),
(5, 20, 0),
(5, 21, 0),
(5, 22, 0),
(5, 23, 0),
(5, 24, 0),
(5, 25, 0),
(5, 26, 0),
(5, 27, 0),
(5, 28, 0),
(5, 29, 0),
(5, 30, 0),
(5, 31, 0),
(5, 32, 0),
(5, 33, 0),
(5, 34, 0),
(5, 35, 0),
(5, 36, 0),
(5, 37, 0),
(5, 38, 0),
(5, 39, 0),
(5, 40, 0),
(5, 41, 0),
(5, 42, 0),
(5, 43, 1),
(5, 44, 1),
(5, 45, 1),
(5, 46, 1),
(5, 47, 1),
(5, 48, 1),
(5, 49, 0),
(5, 50, 0),
(5, 51, 1),
(5, 52, 1),
(5, 53, 0),
(5, 54, 0),
(5, 55, 0),
(5, 56, 0),
(5, 57, 0),
(5, 58, 0),
(5, 59, 0),
(5, 60, 0),
(5, 61, 0),
(5, 62, 0),
(5, 63, 0),
(5, 64, 0),
(5, 65, 0),
(5, 66, 0),
(5, 67, 0),
(5, 68, 0),
(5, 69, 0),
(5, 70, 0),
(5, 71, 0),
(5, 72, 0),
(5, 73, 0),
(5, 74, 0),
(5, 75, 0),
(5, 76, 0),
(5, 77, 0),
(5, 78, 0),
(5, 79, 0),
(5, 80, 0),
(5, 81, 0),
(5, 82, 0),
(5, 83, 0),
(5, 84, 0),
(5, 85, 0),
(5, 86, 0),
(5, 87, 0),
(5, 88, 0),
(5, 89, 0),
(5, 90, 0),
(5, 91, 0),
(5, 92, 0),
(5, 93, 0),
(5, 94, 0),
(5, 95, 0),
(5, 96, 0),
(5, 97, 0),
(5, 98, 0),
(5, 99, 0),
(5, 100, 0),
(5, 101, 0);

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
(1, 0, 1, 'listado', 1),
(2, 0, 1, 'detalles', 1),
(3, 0, 1, 'nuevo_buscar', 1),
(4, 0, 1, 'nuevo_confirmar', 1),
(5, 0, 1, 'editar_buscar', 1),
(6, 0, 1, 'editar_confirmar', 1),
(7, 0, 1, 'eliminar', 1),
(8, 0, 1, 'deshabilitar', 1),
(9, 0, 1, 'habilitar', 1),
(10, 1, 2, 'listado', 1),
(11, 1, 3, 'listado', 1),
(12, 1, 3, 'detalles', 1),
(13, 1, 3, 'nuevo_buscar', 1),
(14, 1, 3, 'nuevo_confirmar', 1),
(15, 1, 3, 'editar_buscar', 1),
(16, 1, 3, 'editar_confirmar', 1),
(17, 1, 3, 'eliminar', 1),
(18, 1, 3, 'deshabilitar', 1),
(19, 1, 3, 'habilitar', 1),
(20, 1, 4, 'listado', 1),
(21, 1, 4, 'detalles', 1),
(22, 1, 4, 'nuevo_buscar', 1),
(23, 1, 4, 'nuevo_confirmar', 1),
(24, 1, 4, 'editar_buscar', 1),
(25, 1, 4, 'editar_confirmar', 1),
(26, 1, 4, 'eliminar', 1),
(27, 1, 5, 'listado', 1),
(28, 1, 5, 'nuevo_buscar', 1),
(29, 1, 5, 'nuevo_confirmar', 1),
(30, 1, 5, 'editar_buscar', 1),
(31, 1, 5, 'editar_confirmar', 1),
(32, 1, 5, 'eliminar', 1),
(33, 1, 6, 'listado', 1),
(34, 1, 6, 'detalles', 1),
(35, 1, 6, 'nuevo_buscar', 1),
(36, 1, 6, 'nuevo_confirmar', 1),
(37, 1, 6, 'editar_buscar', 1),
(38, 1, 6, 'editar_confirmar', 1),
(39, 1, 6, 'eliminar', 1),
(40, 1, 6, 'deshabilitar', 1),
(41, 1, 6, 'habilitar', 1),
(42, 1, 7, 'listado', 1),
(43, 1, 8, 'abrir_caja', 1),
(44, 1, 8, 'cerrar_caja', 1),
(45, 1, 8, 'comenzar_turno', 1),
(46, 1, 8, 'finalizar_turno', 1),
(47, 1, 8, 'otros_buscar', 1),
(48, 1, 8, 'otros_confirmar', 1),
(49, 1, 8, 'listado', 1),
(50, 1, 8, 'detalles', 1),
(51, 1, 8, 'nuevo_buscar', 1),
(52, 1, 8, 'nuevo_confirmar', 1),
(53, 1, 8, 'editar_buscar', 1),
(54, 1, 8, 'editar_confirmar', 1),
(55, 1, 8, 'eliminar', 1),
(56, 2, 2, 'listado', 1),
(57, 2, 3, 'listado', 1),
(58, 2, 3, 'detalles', 1),
(59, 2, 3, 'nuevo_buscar', 1),
(60, 2, 3, 'nuevo_confirmar', 1),
(61, 2, 3, 'editar_buscar', 1),
(62, 2, 3, 'editar_confirmar', 1),
(63, 2, 3, 'eliminar', 1),
(64, 2, 3, 'deshabilitar', 1),
(65, 2, 3, 'habilitar', 1),
(66, 2, 4, 'listado', 1),
(67, 2, 4, 'detalles', 1),
(68, 2, 4, 'nuevo_buscar', 1),
(69, 2, 4, 'nuevo_confirmar', 1),
(70, 2, 4, 'editar_buscar', 1),
(71, 2, 4, 'editar_confirmar', 1),
(72, 2, 4, 'eliminar', 1),
(73, 2, 5, 'listado', 1),
(74, 2, 5, 'nuevo_buscar', 1),
(75, 2, 5, 'nuevo_confirmar', 1),
(76, 2, 5, 'editar_buscar', 1),
(77, 2, 5, 'editar_confirmar', 1),
(78, 2, 5, 'eliminar', 1),
(79, 2, 6, 'listado', 1),
(80, 2, 6, 'detalles', 1),
(81, 2, 6, 'nuevo_buscar', 1),
(82, 2, 6, 'nuevo_confirmar', 1),
(83, 2, 6, 'editar_buscar', 1),
(84, 2, 6, 'editar_confirmar', 1),
(85, 2, 6, 'eliminar', 1),
(86, 2, 6, 'deshabilitar', 1),
(87, 2, 6, 'habilitar', 1),
(88, 2, 7, 'listado', 1),
(89, 2, 8, 'abrir_caja', 1),
(90, 2, 8, 'cerrar_caja', 1),
(91, 2, 8, 'comenzar_turno', 1),
(92, 2, 8, 'finalizar_turno', 1),
(93, 2, 8, 'otros_buscar', 1),
(94, 2, 8, 'otros_confirmar', 1),
(95, 2, 8, 'listado', 1),
(96, 2, 8, 'detalles', 1),
(97, 2, 8, 'nuevo_buscar', 1),
(98, 2, 8, 'nuevo_confirmar', 1),
(99, 2, 8, 'editar_buscar', 1),
(100, 2, 8, 'editar_confirmar', 1),
(101, 2, 8, 'eliminar', 1);

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
  ADD PRIMARY KEY (`id_perfil`,`id_permiso`);

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
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

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
