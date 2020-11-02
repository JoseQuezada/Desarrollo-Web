<?php 

require_once('./conexion.php');
require_once('./functions.php');


sleep(1);
if (isset($_POST)) {
    $email = (string)$_POST['email'];
 
    existeEmail($email, $cn, true);
    
}