<?php


require './php/Formula.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Chequea si se accedió por medio de POST


    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $costo = $_POST["costo"];
    $idInsumos = $_POST["idInsumos"];
    $librasCompradas = $_POST["librasCompradas"];

    $largoDatos = 0; 

    if (count($idInsumos) === count($librasCompradas)) {
        $largoDatos = count($idInsumos);
    }else{
        echo "<script>alert('Hubo un error');</script>";
        exit();
    }

    $infoInsumos = [];

    //echo var_dump($idInsumos);


    for ($i = 0; $i < $largoDatos; $i++) {
        $infoInsumos[] = [
            $idInsumos[$i] => $librasCompradas[$i]
        ];
    }


    $formula = new Formula();
    $error = $formula->crearFormula($codigo, $descripcion, $costo, $infoInsumos);

    echo var_dump($error);

    if(!$error){
        
    }



}
