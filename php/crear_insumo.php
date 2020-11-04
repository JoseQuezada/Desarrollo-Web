<?php 

require './php/Insumos.php';

$error = false; 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Chequea si se accedió por medio de POST


    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $disponibilidad = $_POST["disponibilidad"];
    $costo = $_POST["costo"];

    $proveedor = new Proveedor();

    $error = $proveedor -> crearInsumo($codigo, $descripcion, $disponibilidad, $costo, 1);

    if(!$error){
        echo "<script>alert('Ingresado correctamente');</script>";
    }else{
        echo "<script>alert('Ingresado asdasd');</script>";
        
    }


    
}