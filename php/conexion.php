<?php


	// Conexion Ale
	$servidor = "localhost";
	$usuario = "root";
	// $contraseña = "Deutschland78a";
	$base = "swpciac";

	// Conexion Damian
	$contraseña = "";
	
	$cn = mysqli_connect($servidor, $usuario, $contraseña, $base, 3306);


    if (!$cn) {
        $error = mysqli_connect_error();
        echo " <script> alert('Hubo un error en la conexion al servidor, {$error}'); </script>";
        exit();
    }

?>