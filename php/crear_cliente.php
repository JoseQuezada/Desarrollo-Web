<?php 

require './php/Cliente.php';

$error = null; 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Chequea si se accedió por medio de POST


    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $dpi = $_POST["dpi"];
    $direccion = $_POST["direccion"];
    $municipio = $_POST["municipio"];
    $departamento = $_POST["departamento"];
    $telefono = $_POST["telefono"];
    $telefono2 = $_POST["telefono"];
    $nit = $_POST["nit"];
    $marcac = $_POST["marcac"];

    $cliente = new Cliente();

    $error = $cliente -> crearCliente($nombre, $apellidos, $dpi, $direccion, $municipio, $departamento, $telefono, $telefono2, $nit, $mercac);

    if(!$error){
        
    }else{
        echo "<script>alert('Ingresado asdasd');</script>";
        
    }


    
}