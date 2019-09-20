-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2019 a las 01:37:36
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

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
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `id_tipo_cliente`, `razon_social`, `cuit`, `domicilio`, `telefono`, `email`, `fecha_creacion`, `habilitado`, `eliminado`) VALUES
(1, 2, 'Combustibles Uruguay', 30158593840, 'Las casas 123', '42424343', 'comburu@mail.com', '2019-09-11 01:57:28', 1, 0);

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
  `fecha_compra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_proveedor`, `id_tipo_comprobante`, `numero_factura`, `orden_compra_numero`, `orden_compra_fecha`, `gastos_envio`, `gastos_envio_iva`, `gastos_envio_impuestos`, `importe_total`, `detalle`, `fecha_compra`, `eliminado`) VALUES
(3, 1, 1, 1, 0, '2019-10-10 00:00:00', '0.00', '0.00', '0.00', 8000.00, 'ASD', '2019-09-20 19:56:50', 0),
(4, 3, 1, 36, 150, '2019-09-20 00:00:00', '30.00', '21.00', '13.50', 3500.00, 'Golosinas Septiembre', '2019-09-20 20:00:57', 0);

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
(5, 4, 10, 100, '35.00', '3500');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
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
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
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
(2, 1, 1),
(2, 2, 1),
(2, 3, 1),
(2, 4, 1),
(2, 8, 1),
(2, 9, 1),
(2, 10, 1),
(2, 11, 1),
(2, 15, 1),
(2, 16, 1),
(2, 17, 1),
(2, 18, 1),
(3, 1, 1),
(3, 2, 1),
(3, 3, 1),
(3, 4, 1),
(3, 8, 1),
(3, 9, 1),
(3, 10, 1),
(3, 11, 1),
(3, 19, 1),
(3, 20, 1),
(3, 21, 1),
(3, 22, 1),
(4, 23, 1),
(4, 24, 1),
(4, 25, 1),
(4, 26, 1),
(5, 23, 1),
(5, 24, 1),
(5, 25, 1),
(5, 26, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `descripcion`, `habilitado`) VALUES
(1, 'Consultar Listado Usuarios', 1),
(2, 'Consultar Detalles Usuario', 1),
(3, 'Crear Usuario', 1),
(4, 'Editar Usuario', 1),
(5, 'Eliminar Usuario', 1),
(6, 'Deshabilitar Usuario', 1),
(7, 'Habilitar Usuario', 1),
(8, 'Consultar Listado Productos', 1),
(9, 'Consultar Detalles Producto', 1),
(10, 'Crear Producto', 1),
(11, 'Editar Producto', 1),
(12, 'Eliminar Producto', 1),
(13, 'Deshabilitar Producto', 1),
(14, 'Habilitar Producto', 1),
(15, 'Consultar Stock Playa', 1),
(16, 'Consultar Pedidos a Proveedor Playa', 1),
(17, 'Consultar Entrada de Stock Playa', 1),
(18, 'Consultar Movimientos Playa', 1),
(19, 'Consultar Stock Mercado', 1),
(20, 'Consultar Pedidos a Proveedor Mercado', 1),
(21, 'Consultar Entrada de Stock Mercado', 1),
(22, 'Consultar Movimientos Mercado', 1),
(23, 'Consultar Caja', 1),
(24, 'Registrar Venta', 1),
(25, 'Imprimir Factura', 1),
(26, 'Cerrar Caja', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_tipo_producto` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_tipo_producto`, `descripcion`, `fecha_registro`, `habilitado`, `eliminado`) VALUES
(1, 1, 'Eco de los Andes 500ml', '2019-06-08 23:20:20', 1, 0),
(2, 1, 'Manaos Cola 1lt ', '2019-06-08 23:20:58', 1, 0),
(3, 2, 'Marlboro Box 20u', '2019-06-08 23:21:24', 1, 0),
(4, 2, 'Lucky Strike Limón 10u', '2019-06-08 23:22:00', 1, 0),
(5, 3, 'Bizcochitos Granix 180g', '2019-06-08 23:22:50', 0, 0),
(6, 3, 'Cachafaz Integral Chips 100g', '2019-06-08 23:25:01', 1, 0),
(7, 1, 'Kin Gasificada 1lt', '2019-06-08 23:52:53', 1, 0),
(8, 3, 'Sonrisas frambuesa pack x3', '2019-06-08 23:54:10', 1, 0),
(9, 4, 'La Merced Campo y Monte 500g', '2019-06-09 17:11:21', 1, 0),
(10, 3, 'Alfajor Jorgito Choco 100g', '2019-09-20 19:24:20', 1, 0);

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
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
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
  `unidades` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `id_producto`, `unidades`) VALUES
(1, 10, 100),
(2, 1, 0),
(3, 2, 10),
(4, 3, 50),
(5, 4, 0),
(6, 5, 0),
(7, 6, 0),
(8, 7, 0),
(9, 8, 0),
(10, 9, 0);

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
(1, 'Consumidor Final'),
(2, 'Responsable Inscripto'),
(3, 'Monotributista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_comprobantes`
--

CREATE TABLE `tipos_comprobantes` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
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
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
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
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
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
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `habilitado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras_detalles`
--
ALTER TABLE `compras_detalles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
