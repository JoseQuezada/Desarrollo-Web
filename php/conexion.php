<?php

	// Conexion Ale
	$servidor = "localhost";
	$usuario = "root";
	// $contraseña = "Deutschland78a";
	$base = "swpciac";
	$puerto = 3306;

	// Conexion Damian
	$contraseña = "";
	
	$cn = mysqli_connect($servidor, $usuario, $contraseña, $base, $puerto);


    if (!$cn) {
        $error = mysqli_connect_error();
		echo "<script>
        alert('Error en la conexión al servidor');
        window.location.href='../index.php';
        </script>";
        exit();
    }

?>