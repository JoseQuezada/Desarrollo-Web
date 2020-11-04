
drop database if exists swpciac;

create database swpciac;

use swpciac;

CREATE TABLE Animal (IDAnimal int(10) NOT NULL AUTO_INCREMENT, Tipo varchar(60) NOT NULL, Cantidad int(6) NOT NULL, Edad int(10) NOT NULL, IDCliente int(10) NOT NULL, PRIMARY KEY (IDAnimal));
CREATE TABLE Cliente (IDCliente int(10) NOT NULL AUTO_INCREMENT, Nombre varchar(200) NOT NULL, Apellidos varchar(200) NOT NULL, DPI int(13) NOT NULL, Direccion varchar(200) NOT NULL, Municipio varchar(100), Departamento varchar(100), Teléfono varchar(8) NOT NULL, Telefono2 varchar(8), NIT varchar(10) NOT NULL, Marca_Concentrado varchar(50), PRIMARY KEY (IDCliente));
CREATE TABLE Compra (IDCompra int(10) NOT NULL AUTO_INCREMENT, Fecha date NOT NULL, Total float NOT NULL, PRIMARY KEY (IDCompra));
CREATE TABLE Detalle_Compra (IDDetalleCompra int(10) NOT NULL AUTO_INCREMENT, Descripción varchar(800) NOT NULL, Libras float NOT NULL, Sub_Total float NOT NULL, IDCompra int(10) NOT NULL, IDInsumo int(11) NOT NULL, PRIMARY KEY (IDDetalleCompra));
CREATE TABLE DetalleVenta (IDDetallVenta int(11) NOT NULL AUTO_INCREMENT, Descripcion varchar(300) NOT NULL, Cantidad float NOT NULL, Sub_Total float NOT NULL, IDInsumo int(11) NOT NULL, IDVenta int(11) NOT NULL, PRIMARY KEY (IDDetallVenta));
CREATE TABLE Insumo (IDInsumo int(11) NOT NULL AUTO_INCREMENT, Codigo varchar(10) NOT NULL, Descripcion varchar(300) NOT NULL, Disponibilidad float NOT NULL, CostoLibra float NOT NULL, IDProveedor int(10) NOT NULL, PRIMARY KEY (IDInsumo));
CREATE TABLE Perfil (ID_Tipo int(10) NOT NULL AUTO_INCREMENT, Tipo varchar(50) NOT NULL, PRIMARY KEY (ID_Tipo));
CREATE TABLE Proveedor (IDProveedor int(10) NOT NULL AUTO_INCREMENT, Empresa varchar(100), Nombre varchar(200) NOT NULL, Apellidos varchar(255) NOT NULL, Dirección varchar(200) NOT NULL, Teléfono varchar(8) NOT NULL, Email varchar(100), PRIMARY KEY (IDProveedor));
CREATE TABLE Usuarios (ID int(6) NOT NULL AUTO_INCREMENT, Usuario varchar(50) NOT NULL UNIQUE, Password varchar(61) NOT NULL, Nombre varchar(200) NOT NULL, Apellidos varchar(200) NOT NULL, Email varchar(200) UNIQUE, ID_Tipo int(10) NOT NULL, PRIMARY KEY (ID));
CREATE TABLE Venta (IDVenta int(11) NOT NULL AUTO_INCREMENT, Fecha date NOT NULL, Total float NOT NULL, IDCliente int(10) NOT NULL, Tipo int(10) NOT NULL, PRIMARY KEY (IDVenta));
ALTER TABLE DetalleVenta ADD CONSTRAINT FKDetalleVen996676 FOREIGN KEY (IDVenta) REFERENCES Venta (IDVenta);
ALTER TABLE Venta ADD CONSTRAINT FKVenta15400 FOREIGN KEY (IDCliente) REFERENCES Cliente (IDCliente);
ALTER TABLE DetalleVenta ADD CONSTRAINT FKDetalleVen126596 FOREIGN KEY (IDInsumo) REFERENCES Insumo (IDInsumo);
ALTER TABLE Detalle_Compra ADD CONSTRAINT FKDetalle_Co652049 FOREIGN KEY (IDInsumo) REFERENCES Insumo (IDInsumo);
ALTER TABLE Insumo ADD CONSTRAINT FKInsumo357817 FOREIGN KEY (IDProveedor) REFERENCES Proveedor (IDProveedor);
ALTER TABLE Usuarios ADD CONSTRAINT FKUsuarios640391 FOREIGN KEY (ID_Tipo) REFERENCES Perfil (ID_Tipo);
ALTER TABLE Animal ADD CONSTRAINT FKAnimal836572 FOREIGN KEY (IDCliente) REFERENCES Cliente (IDCliente);
ALTER TABLE Detalle_Compra ADD CONSTRAINT FKDetalle_Co214643 FOREIGN KEY (IDCompra) REFERENCES Compra (IDCompra);

INSERT INTO `perfil` (`ID_Tipo`, `Tipo`) VALUES
(1, 'Administrador'),
(2, 'Gerente general'),
(3, 'Gerente financiero'),
(4, 'Usuario');


INSERT INTO `usuarios` VALUES
(1, 'Alejandro', '$2y$10$/zqrSxVR4SoD1kY/K.dgcem.2YzylCATOgRImmq7Bd6rccR85L0Au', 'Jose Alejandro', 'Quezada Afre', 'jose.quezadaafre@gmail.com', 1);

