<?php 

require './php/Usuario.php';

$error = false; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Chequea si se accedió por medio de POST


    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $con_password = $_POST["con_password"];

    $user = new Usuario();

    $error = $user -> crearUsuario($usuario, $password, $con_password, $nombre, $apellidos, $email, 1);


    if(!$error){
        echo "<script>alert('Ingresado correctamente');</script>";
    }


    
}