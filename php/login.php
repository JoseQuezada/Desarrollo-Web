<?php

require './php/Usuario.php';

$error; 


session_start();
session_regenerate_id(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {//Chequea si se accedió por medio de POST

    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = new Usuario();

    $error = $user -> iniciarSesion($username, $password);
    
}
