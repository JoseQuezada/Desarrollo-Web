<?php 

require ('./Usuario.php');

if(isset($_POST['usuarioBusqueda'])){
  $usuario = new Usuario();
  $usuario -> buscarUsuario($_POST['usuarioBusqueda']);

}else{
    echo "<tr><td colspan='7'>Usuario No encontrado</td></tr>";
}
