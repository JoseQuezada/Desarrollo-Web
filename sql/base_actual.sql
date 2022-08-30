-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2022 a las 06:48:24
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `swpcigc`
--
CREATE DATABASE swpcigc;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IDCliente` int(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellidos` varchar(200) NOT NULL,
  `DPI` varchar(15) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Municipio` varchar(100) NOT NULL,
  `Departamento` varchar(200) NOT NULL,
  `Telefono` varchar(50) NOT NULL,
  `Telefono2` varchar(50) DEFAULT NULL,
  `NIT` varchar(13) NOT NULL,
  `Marca_Concentrado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`IDCliente`, `Nombre`, `Apellidos`, `DPI`, `Direccion`, `Municipio`, `Departamento`, `Telefono`, `Telefono2`, `NIT`, `Marca_Concentrado`) VALUES
(1, 'José', 'Guillermo', '0000 00000 0000', 'Zona 1', 'Huehuetenango', 'Huehuetenango', '00000000', '00000000', '0000000000000', 'Ninguno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `IDCompra` int(10) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`IDCompra`, `Fecha`, `Total`) VALUES
(1, '2022-04-15', '500.00'),
(2, '2022-04-15', '2250.00'),
(4, '2022-04-25', '45.00'),
(5, '2022-04-26', '50.00'),
(6, '2022-04-26', '74.00'),
(7, '2022-06-21', '45.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleformula`
--

CREATE TABLE `detalleformula` (
  `IDDetalleFormula` int(10) NOT NULL,
  `Código` varchar(50) NOT NULL,
  `Descripción` varchar(255) NOT NULL,
  `Costo` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalleformula`
--

INSERT INTO `detalleformula` (`IDDetalleFormula`, `Código`, `Descripción`, `Costo`) VALUES
(20, 'F02', 'Pollo Pequeño', '99.00'),
(23, 'F03', 'Pollo de Engorde', '90.00'),
(24, 'F04', 'Pollo de engorde', '90.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `IDDetalleVenta` int(10) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Cantidad` float NOT NULL,
  `Sub_Total` decimal(7,2) NOT NULL,
  `IDFormula` int(10) NOT NULL,
  `IDVenta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`IDDetalleVenta`, `Descripcion`, `Cantidad`, `Sub_Total`, `IDFormula`, `IDVenta`) VALUES
(19, 'Venta', 1, '99.00', 25, 33),
(20, 'Venta', 1, '90.00', 25, 34),
(22, 'Venta de Pollo', 1, '99.00', 31, 38),
(23, 'Venta de Pollo ', 1, '99.00', 31, 39),
(24, 'Venta de pollo de engorde', 1, '90.00', 32, 40),
(25, 'Venta de pollo', 1, '90.00', 32, 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `IDDetalleCompra` int(10) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Libras` float NOT NULL,
  `Sub_Total` decimal(7,2) NOT NULL,
  `IDInsumo` int(10) NOT NULL,
  `IDCompra` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`IDDetalleCompra`, `Descripcion`, `Libras`, `Sub_Total`, `IDInsumo`, `IDCompra`) VALUES
(1, 'Compra de Soja', 10, '500.00', 1, 1),
(2, 'Compra de Avena', 50, '2250.00', 2, 2),
(4, 'Compra de Avena', 1, '45.00', 2, 4),
(5, 'Compra de Soja', 1, '50.00', 1, 5),
(6, 'Compra de Avena y Trigo', 1, '45.00', 2, 6),
(7, 'Compra de Avena y Trigo', 1, '29.00', 3, 6),
(8, 'Compra de avena', 1, '45.00', 2, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formula`
--

CREATE TABLE `formula` (
  `IDFormula` int(10) NOT NULL,
  `IDInsumo` int(10) NOT NULL,
  `IDDetalleFormula` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `formula`
--

INSERT INTO `formula` (`IDFormula`, `IDInsumo`, `IDDetalleFormula`) VALUES
(23, 1, 20),
(24, 2, 20),
(25, 3, 20),
(30, 1, 23),
(31, 2, 23),
(32, 2, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `IDInsumo` int(10) NOT NULL,
  `Codigo` varchar(20) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Disponibilidad` float NOT NULL,
  `CostoLibra` decimal(7,2) NOT NULL,
  `IDProveedor` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`IDInsumo`, `Codigo`, `Descripcion`, `Disponibilidad`, `CostoLibra`, `IDProveedor`) VALUES
(1, 'I-01', 'Soja', 17, '50.00', 1),
(2, 'I-02', 'Avena', 17, '45.00', 1),
(3, 'I-03', 'Trigo', 9, '29.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `ID_Tipo` int(10) NOT NULL,
  `Tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`ID_Tipo`, `Tipo`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `IDProveedor` int(10) NOT NULL,
  `Empresa` varchar(100) DEFAULT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Telefono` varchar(8) NOT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`IDProveedor`, `Empresa`, `Nombre`, `Apellidos`, `Direccion`, `Telefono`, `Email`) VALUES
(1, 'Supasa', 'José', 'Guillermo', 'Zona 1', '00000000', 'jguillermo@supasa.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(10) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Password` varchar(61) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `ID_Tipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Nombre`, `Apellidos`, `Email`, `ID_Tipo`) VALUES
(1, 'Alejandro', '$2y$10$/zqrSxVR4SoD1kY/K.dgcem.2YzylCATOgRImmq7Bd6rccR85L0Au', 'Jose Alejandro', 'Quezada Afre', 'jose.quezadaafre@gmail.com', 1),
(2, 'pipa', '$2y$10$uhN7VFq/eK0mqAsk9BcbN.9TAsFDCMUBBCvqOJFiMi2kTzXKZ/aPq', 'Damián', 'Peña Afre', 'pipa@gmail.com', 1),
(3, 'perez1', '$2y$10$INJobfvotisdTnhWEP0u5u0aut2QivNmWBYonY4OC0Ph.GaZx57M2', 'Juan', 'Perez', 'juan@gmail.com', 1),
(4, 'jgomez1', '$2y$10$JjXvQZiP1hm5PNJRk.cjSeExZEL6oMVPdNc8r66iBlMDmaH8JX5ea', 'Juan', 'Gomez', 'jgomez@gmail.com', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IDVenta` int(10) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` decimal(7,2) NOT NULL,
  `Tipo` varchar(7) NOT NULL,
  `IDCliente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`IDVenta`, `Fecha`, `Total`, `Tipo`, `IDCliente`) VALUES
(33, '2022-04-23', '99.00', 'Contado', 1),
(34, '2022-04-22', '90.00', 'Crédito', 1),
(36, '2022-04-27', '90.00', 'Crédito', 1),
(38, '2022-04-27', '99.00', 'Contado', 1),
(39, '2022-07-18', '99.00', 'Crédito', 1),
(40, '2022-08-03', '90.00', 'Contado', 1),
(41, '2022-08-04', '90.00', 'Crédito', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IDCliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`IDCompra`);

--
-- Indices de la tabla `detalleformula`
--
ALTER TABLE `detalleformula`
  ADD PRIMARY KEY (`IDDetalleFormula`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`IDDetalleVenta`),
  ADD KEY `FKDetalleVen996676` (`IDVenta`),
  ADD KEY `FKDetalleVen391274` (`IDFormula`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`IDDetalleCompra`),
  ADD KEY `FKDetalle_Co214643` (`IDCompra`),
  ADD KEY `FKDetalle_Co652049` (`IDInsumo`);

--
-- Indices de la tabla `formula`
--
ALTER TABLE `formula`
  ADD PRIMARY KEY (`IDFormula`),
  ADD KEY `FKFormula746735` (`IDDetalleFormula`),
  ADD KEY `FKFormula120814` (`IDInsumo`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`IDInsumo`),
  ADD KEY `FKInsumo357817` (`IDProveedor`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`ID_Tipo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`IDProveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Usuario` (`Usuario`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FKUsuarios640391` (`ID_Tipo`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`IDVenta`),
  ADD KEY `FKVenta15400` (`IDCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IDCliente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `IDCompra` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalleformula`
--
ALTER TABLE `detalleformula`
  MODIFY `IDDetalleFormula` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  MODIFY `IDDetalleVenta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `IDDetalleCompra` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `formula`
--
ALTER TABLE `formula`
  MODIFY `IDFormula` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `IDInsumo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `ID_Tipo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `IDProveedor` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IDVenta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `FKDetalleVen391274` FOREIGN KEY (`IDFormula`) REFERENCES `formula` (`IDFormula`),
  ADD CONSTRAINT `FKDetalleVen996676` FOREIGN KEY (`IDVenta`) REFERENCES `venta` (`IDVenta`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `FKDetalle_Co214643` FOREIGN KEY (`IDCompra`) REFERENCES `compra` (`IDCompra`),
  ADD CONSTRAINT `FKDetalle_Co652049` FOREIGN KEY (`IDInsumo`) REFERENCES `insumo` (`IDInsumo`);

--
-- Filtros para la tabla `formula`
--
ALTER TABLE `formula`
  ADD CONSTRAINT `FKFormula120814` FOREIGN KEY (`IDInsumo`) REFERENCES `insumo` (`IDInsumo`),
  ADD CONSTRAINT `FKFormula746735` FOREIGN KEY (`IDDetalleFormula`) REFERENCES `detalleformula` (`IDDetalleFormula`);

--
-- Filtros para la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD CONSTRAINT `FKInsumo357817` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FKUsuarios640391` FOREIGN KEY (`ID_Tipo`) REFERENCES `perfil` (`ID_Tipo`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `FKVenta15400` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


