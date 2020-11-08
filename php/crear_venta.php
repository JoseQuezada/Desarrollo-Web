<?php


require './php/Venta.php';

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Chequea si se accedió por medio de POST


    $fecha = $_POST["fecha"];
    $IDCliente = $_POST["IDCliente"];
    $tipo = $_POST["tipo"];
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


    $venta = new Venta();
    $error = $venta->crearVenta($fecha, $IDCliente, $tipo, $descripcion, $infoInsumos);

    echo var_dump($error);

    if(!$error){
        echo "<script>alert('Ingresado correctamente');</script>";
    }



}
