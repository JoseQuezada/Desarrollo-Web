<?php 

require('./Usuario.php');


sleep(1);
if (isset($_POST)) {
    $email = $_POST['email'];
 
    $user = new Usuario();
    
    $user -> existeEmail($email, true);
    
}