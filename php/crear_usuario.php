<?php 

require_once './php/functions.php';
require_once './php/conexion.php';

$error = false; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Chequea si se accedió por medio de POST


    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $con_password = $_POST["con_password"];

    $error = crearUsuario($usuario, $password, $con_password, $nombre, $apellidos, $email, 1, $cn);

    if(!$error){
        echo '<div class="alert alert-success">Usuario Agregado Correctamente.</div>';
    }


    
}