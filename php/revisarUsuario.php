<?php 

require('./Usuario.php');


sleep(1);
if (isset($_POST)) {
    $username = (string)$_POST['username'];
 
    $url = '';

    $user = new Usuario();

    $user -> existeUsuario($username, true);
    
}