<?php
    $mysqli = new mysqlo("localhost", "root", "Deutschland78a?","SWPCIAC");
    if(mysqli_connect_errno()){
		echo 'Conexion Fallida: ', mysqli_connect_error();
		exit();
	}
?>