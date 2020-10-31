<?php

require_once './php/conexion.php';
require_once './php/functions.php';

$error; 


session_start();
session_regenerate_id(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {//Chequea si se accedió por medio de POST

    $username = $_POST["username"]; 
    $password = $_POST["password"];

    iniciarSesion($username, $password, $cn);
    
}
