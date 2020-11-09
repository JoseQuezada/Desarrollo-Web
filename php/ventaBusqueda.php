<?php 

require ('./Venta.php');

if(isset($_POST['usuarioBusqueda'])){
  $usuario = new Venta();
  // $usuario -> buscarVenta($_POST['usuarioBusqueda']);

}else{
    echo "<tr><td colspan='7'>Usuario No encontrado</td></tr>";
}
