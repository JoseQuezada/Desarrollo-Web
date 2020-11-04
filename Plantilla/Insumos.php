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

    function generarTabla($insumo)
    {
        $html = '';

        $html .= "<tr>
        <td>{$insumo['IDInsumo']}</td>
        <td>{$insumo['Codigo']}</td>
        <td>{$insumo['Descripcion']}</td>
        <td>{$insumo['Disponibilidad']}</td>
        <td>{$insumo['CostoLibra']}</td>
        <td>{$insumo['IDProveedor']}: {$insumo['Nombre']} {$insumo['Apellidos']}</td>
        <td>
        <a href='#' data-toggle='modal' data-target='#eliminarModal{$insumo['IDInsumo']}' class='btn btn-danger' > Eliminar </a>
        <a href='./ActualizarInsumo.php?IDinsumo={$insumo['IDInsumo']}' class='btn btn-warning' > Actualizar </a>
        
        <div class='modal fade' id='eliminarModal{$insumo['IDInsumo']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
           <div class='modal-dialog' role='document'>
               <div class='modal-content'>
                   <div class='modal-header'>
                       <h5 class='modal-title' id='exampleModalLabel'>Eliminar insumo</h5>
                       <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                       </button>
                   </div>
                   <div class='modal-body'>
                       <p> ¿Estas seguro que deseas eliminar al insumo: '{$insumo['Codigo']}'? esto será de forma permanente? </p>
                   </div>
                   <div class='modal-footer'>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                       <form method='post'>
                           <input type='hidden' name='idinsumo' value='{$insumo['IDInsumo']}' />
                           <button type='submit' class='btn btn-danger'>Eliminar</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
    </div>
        </td>
        </tr>";

        return $html;
    }

    function crearInsumo($codigo, $descripcion, $disponibilidad, $costo, $idproveedor)
    {

        $error = true;

        // echo var_dump($cn);

        // validacion

        if ($codigo == '' || $codigo == null) {
            $error = "*Debe llenar el campo de codigo* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de descripcion* ";
        } elseif ($disponibilidad == '' || $disponibilidad == null) {
            $error = "*Ingrese la disponibilidad del insumo* ";
        } elseif ($costo == '' || $costo == null) {
            $error = "*Ingrese el costo del insumo* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "INSERT INTO insumo VALUES(NULL, ?, ?, ?, ?, ?);")) {


                mysqli_stmt_bind_param($stmt, 'ssddi', $codigo, $descripcion, $disponibilidad, $costo, $idproveedor);

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


        $insumoes = $cn->query("SELECT * from Insumo I inner join Proveedor P on I.IDProveedor = P.IDProveedor");
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


        $insumoes = $cn->query("SELECT * from Insumo inner join Proveedor P on I.IDProveedor = P.IDProveedor where Descripcion like '%{$nombre}%'");
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
                $error =  "Hubo un error" . mysqli_error($cn);
            }
        }


        return $error;
    }
}
