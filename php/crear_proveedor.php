<?php 

require './php/Proveedor.php';

$error = false; 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Chequea si se accedió por medio de POST


    $empresa = $_POST["empresa"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];

    $proveedor = new Proveedor();

    $error = $proveedor -> crearProveedor($empresa, $nombre, $apellidos, $direccion, $telefono, $email);

    if(!$error){
        echo "<script>alert('Ingresado correctamente');</script>";
    }else{
        echo "<script>alert('Ingresado asdasd');</script>";
        
    }


    
}