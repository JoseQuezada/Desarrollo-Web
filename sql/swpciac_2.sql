-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2020 a las 01:28:23
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `swpciac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo`
--

CREATE TABLE `activo` (
  `IDActivo` int(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Descripción` varchar(800) NOT NULL,
  `Cantidad` int(10) NOT NULL,
  `Valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `IDAnimal` int(10) NOT NULL,
  `Tipo` varchar(60) NOT NULL,
  `Cantidad` int(6) NOT NULL,
  `Edad` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoría`
--

CREATE TABLE `categoría` (
  `IDCategoria` int(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Descripción` varchar(800) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `IDCliente` int(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellidos` varchar(200) NOT NULL,
  `DPI` int(13) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Departamento` varchar(100) DEFAULT NULL,
  `Municipio` varchar(100) DEFAULT NULL,
  `Teléfono` varchar(8) NOT NULL,
  `Telefono2` varchar(8) DEFAULT NULL,
  `Marca_Concentrado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `IDCompra` int(10) NOT NULL,
  `IDProveedor` int(10) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `IDDetalleCompra` int(10) NOT NULL,
  `Descripción` varchar(800) NOT NULL,
  `Cantidad` int(10) NOT NULL,
  `Sub_Total` float NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `IDCompra` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `IDDetalleVenta` int(10) NOT NULL,
  `Descripción` varchar(800) NOT NULL,
  `Cantidad` int(10) NOT NULL,
  `Sub_Total` float NOT NULL,
  `IDEmpleado` int(10) NOT NULL,
  `IDGerenteAdmon` int(10) NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `IDVenta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `IDInventario` int(10) NOT NULL,
  `IDProducto` int(10) NOT NULL,
  `IDPasivo` int(10) NOT NULL,
  `IDActivo` int(10) NOT NULL,
  `IDCompra` int(10) NOT NULL,
  `IDVenta` int(10) NOT NULL,
  `Balance` float NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `IDOrden` int(10) NOT NULL,
  `Column` int(10) DEFAULT NULL,
  `IDCliente` int(10) NOT NULL,
  `Descripción` varchar(800) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` float NOT NULL,
  `IDTipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasivo`
--

CREATE TABLE `pasivo` (
  `IDPasivo` int(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Descripción` varchar(800) NOT NULL,
  `Cantidad` int(10) NOT NULL,
  `Valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `ID_Tipo` int(10) NOT NULL,
  `Tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`ID_Tipo`, `Tipo`) VALUES
(1, 'Administrador'),
(2, 'Gerente general'),
(3, 'Gerente financiero'),
(4, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `IDProducto` int(10) NOT NULL,
  `Nombre` varchar(300) NOT NULL,
  `Descripción` varchar(800) NOT NULL,
  `Existencia` int(10) NOT NULL,
  `Precio` float NOT NULL,
  `Descuento` float DEFAULT NULL,
  `Edad` int(10) DEFAULT NULL,
  `IDProveedor` int(10) NOT NULL,
  `IDCategoria` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `IDProveedor` int(10) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellidos` varchar(255) NOT NULL,
  `Dirección` varchar(200) NOT NULL,
  `Teléfono` varchar(10) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Empresa` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(6) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Password` varchar(65) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Apellidos` varchar(200) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `ID_Tipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Usuario`, `Password`, `Nombre`, `Apellidos`, `Email`, `ID_Tipo`) VALUES
(1, 'Alejandro', '$2y$10$/zqrSxVR4SoD1kY/K.dgcem.2YzylCATOgRImmq7Bd6rccR85L0Au', 'Jose Alejandro', 'Quezada Afre', 'jose.quezadaafre@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `IDVenta` int(10) NOT NULL,
  `IDCliente` int(10) NOT NULL,
  `Fecha` date NOT NULL,
  `Total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activo`
--
ALTER TABLE `activo`
  ADD PRIMARY KEY (`IDActivo`);

--
-- Indices de la tabla `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`IDAnimal`),
  ADD KEY `FKAnimal836572` (`IDCliente`);

--
-- Indices de la tabla `categoría`
--
ALTER TABLE `categoría`
  ADD PRIMARY KEY (`IDCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IDCliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`IDCompra`),
  ADD KEY `FKCompra322851` (`IDProveedor`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`IDDetalleCompra`),
  ADD KEY `FKDetalle_Co214643` (`IDCompra`),
  ADD KEY `FKDetalle_Co202450` (`IDProducto`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`IDDetalleVenta`),
  ADD KEY `FKDetalle_Ve995294` (`IDVenta`),
  ADD KEY `FKDetalle_Ve970113` (`IDProducto`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`IDInventario`),
  ADD KEY `FKInventario745431` (`IDVenta`),
  ADD KEY `FKInventario207784` (`IDCompra`),
  ADD KEY `FKInventario623806` (`IDActivo`),
  ADD KEY `FKInventario941227` (`IDPasivo`),
  ADD KEY `FKInventario751613` (`IDProducto`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`IDOrden`),
  ADD KEY `FKOrden102832` (`IDCliente`);

--
-- Indices de la tabla `pasivo`
--
ALTER TABLE `pasivo`
  ADD PRIMARY KEY (`IDPasivo`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`ID_Tipo`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`IDProducto`),
  ADD KEY `FKProducto538890` (`IDCategoria`),
  ADD KEY `FKProducto151865` (`IDProveedor`);

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
-- AUTO_INCREMENT de la tabla `activo`
--
ALTER TABLE `activo`
  MODIFY `IDActivo` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `IDAnimal` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoría`
--
ALTER TABLE `categoría`
  MODIFY `IDCategoria` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IDCliente` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `IDCompra` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `IDDetalleCompra` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `IDDetalleVenta` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `IDInventario` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `IDOrden` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pasivo`
--
ALTER TABLE `pasivo`
  MODIFY `IDPasivo` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `ID_Tipo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `IDProducto` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `IDProveedor` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `IDVenta` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `FKAnimal836572` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`);

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `FKCompra322851` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `FKDetalle_Co202450` FOREIGN KEY (`IDProducto`) REFERENCES `producto` (`IDProducto`),
  ADD CONSTRAINT `FKDetalle_Co214643` FOREIGN KEY (`IDCompra`) REFERENCES `compra` (`IDCompra`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `FKDetalle_Ve970113` FOREIGN KEY (`IDProducto`) REFERENCES `producto` (`IDProducto`),
  ADD CONSTRAINT `FKDetalle_Ve995294` FOREIGN KEY (`IDVenta`) REFERENCES `venta` (`IDVenta`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `FKInventario207784` FOREIGN KEY (`IDCompra`) REFERENCES `compra` (`IDCompra`),
  ADD CONSTRAINT `FKInventario623806` FOREIGN KEY (`IDActivo`) REFERENCES `activo` (`IDActivo`),
  ADD CONSTRAINT `FKInventario745431` FOREIGN KEY (`IDVenta`) REFERENCES `venta` (`IDVenta`),
  ADD CONSTRAINT `FKInventario751613` FOREIGN KEY (`IDProducto`) REFERENCES `producto` (`IDProducto`),
  ADD CONSTRAINT `FKInventario941227` FOREIGN KEY (`IDPasivo`) REFERENCES `pasivo` (`IDPasivo`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `FKOrden102832` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FKProducto151865` FOREIGN KEY (`IDProveedor`) REFERENCES `proveedor` (`IDProveedor`),
  ADD CONSTRAINT `FKProducto538890` FOREIGN KEY (`IDCategoria`) REFERENCES `categoría` (`IDCategoria`);

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
