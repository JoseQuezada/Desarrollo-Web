<?php 

require ('./Cliente.php');

if(isset($_POST['usuarioBusqueda'])){
  $usuario = new Cliente();
  $usuario -> buscarCliente($_POST['usuarioBusqueda']);

}else{
    echo "<tr><td colspan='7'>Cliente No encontrado</td></tr>";
}
