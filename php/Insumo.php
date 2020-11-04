<?php

error_reporting(1);

include './php/conexion.php';
include '../php/conexion.php';


class Insumo
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    function crearInsumo($empresa, $nombre, $apellidos, $direccion, $telefono, $email)
    {

        $error = true;

        // echo var_dump($cn);

        // validacion

        if ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } elseif ($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del insumo* ";
        } elseif ($telefono == '' || $telefono == null) {
            $error = "*Debe llenar el campo telefono* ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "*Formato de email invalido* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "INSERT INTO insumo VALUES(NULL, ?, ?, ?, ?, ?, ?);")) {


                mysqli_stmt_bind_param($stmt, 'ssssss', $empresa, $nombre, $apellidos, $direccion, $telefono, $email);

                mysqli_stmt_execute($stmt);


                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  mysqli_stmt_error($stmt);
            }
        }



        return $error;
    }

    public function listarInsumo()
    {
        $cn = $this->cn->conexion;


        $insumoes = $cn->query("SELECT * from Insumo");
        $html = "";

        if (mysqli_num_rows($insumoes) > 0) {
            foreach ($insumoes as $insumo)

                echo $this->generarTabla($insumo);
        } else {
            echo "<tr><td colspan='8'>Insumo No encontrado</td></tr>";
        }
    }



    public function buscarInsumo($nombre)
    {
        $cn = $this->cn->conexion;


        $insumoes = $cn->query("SELECT * from Insumo where Nombre like '%{$nombre}%'");
        $html = "";

        if (mysqli_num_rows($insumoes) > 0) {
            foreach ($insumoes as $insumo)

                echo $this->generarTabla($insumo);
        } else {
            echo "<tr><td colspan='8'>Insumo No encontrado</td></tr>";
        }
    }

    public function buscarInsumoId($id)
    {
        $cn = $this->cn->conexion;

        $insumoes = $cn->query("SELECT * from Insumo where IDInsumo = {$id}");

        if (mysqli_num_rows($insumoes) > 0) {
            return mysqli_fetch_array($insumoes);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function eliminarinsumo($id)
    {
        $cn = $this->cn->conexion;
        $cn->query("DELETE FROM insumo WHERE IDInsumo = {$id} ");

        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('Insumo eliminado');</script>";
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function actualizarInsumo($id, $empresa, $nombre, $apellidos, $direccion, $telefono, $email)
    {
        $cn = $this->cn->conexion;
        $error = true;

        if ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } elseif ($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del insumo* ";
        } elseif ($telefono == '' || $telefono == null) {
            $error = "*Debe llenar el campo telefono* ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "*Formato de email invalido* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "UPDATE insumo SET empresa = ?, nombre = ?, apellidos = ?, Dirección = ?, Teléfono = ?, email = ? where IDInsumo = ? ")) {

                mysqli_stmt_bind_param($stmt, 'ssssssi', $empresa, $nombre, $apellidos, $direccion, $telefono, $email, $id);

                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  "Hubo un error".mysqli_error($cn);
            }
        }


        return $error;
    }
}
