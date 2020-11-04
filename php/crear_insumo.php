<?php 

require './php/Insumo.php';

$error = false; 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Chequea si se accedió por medio de POST

    $iDProveedor = $_POST["iDProveedor"];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $disponibilidad = $_POST["disponibilidad"];
    $costo = $_POST["costo"];

    $insumo = new Insumo();

    $error = $insumo -> crearInsumo($codigo, $descripcion, $disponibilidad, $costo, $iDProveedor);

    if(!$error){
        echo "<script>alert('Ingresado correctamente');</script>";
    }else{
        echo "<script>alert('Ingresado asdasd');</script>";
        
    }


    
}