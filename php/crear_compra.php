<?php


require './php/Compra.php';

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Chequea si se accedió por medio de POST


    $fecha = $_POST["fecha"];
    $descripcion = $_POST["desripcion"];
    $idInsumos = $_POST["idInsumos"];
    $librasCompradas = $_POST["librasCompradas"];
    $largoDatos = 0; 

    if (count($idInsumos) == count($librasCompradas)) {
        $largoDatos = count($idInsumos);
    }else{
        echo "<script>alert('Hubo un error');</script>";
        exit();
    }

    $infoInsumos = [];

    // echo var_dump($idInsumos);


    for ($i = 0; $i < $largoDatos; $i++) {
        $infoInsumos[] = [
            $idInsumos[$i] => $librasCompradas[$i]
        ];
    }

    echo var_dump($infoInsumos);

    $compra = new Compra();
    $error = $compra->crearCompra($fecha, $descripcion, $infoInsumos);

    // $error = $proveedor -> crearProveedor($empresa, $nombre, $apellidos, $direccion, $telefono, $email);

    if(!$error){
        echo "<script>alert('Ingresado correctamente');</script>";
    }



}
