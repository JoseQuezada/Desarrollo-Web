<?php 

require_once('./conexion.php');
require_once('./functions.php');


sleep(1);
if (isset($_POST)) {
    $username = (string)$_POST['username'];
 
    existeUsuario($username, $cn, true);
    
}