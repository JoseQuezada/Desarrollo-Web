<?php 

require ('./Proveedor.php');

if(isset($_POST['proveedorBusqueda'])){
  $usuario = new Proveedor();
  $usuario -> buscarProveedor($_POST['proveedorBusqueda']);

}else{
    echo "<tr><td colspan='7'>Proveedor No encontrado</td></tr>";
}
