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


        $insumo = $cn->query("SELECT * from Insumo");
        $html = "";

        if (mysqli_num_rows($insumo) > 0) {
            foreach ($insumo as $insumo)

                echo $this->generarTabla($insumo);
        } else {
            echo "<tr><td colspan='8'>Insumo No encontrado</td></tr>";
        }
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
        <td>{$insumo['IDProveedor']}</td>
        <td>
        <a href='#' data-toggle='modal' data-target='#eliminarModal{$insumo['IDInsumo']}' class='btn btn-danger' > Eliminar </a>
        <a href='./ActualizarInsumo.php?IDInsumo={$insumo['IDInsumo']}' class='btn btn-warning' > Actualizar </a>
        
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
                       <p> ¿Estas seguro que deseas eliminar el insumo: '{$insumo['Descripcion']}'? esto será de forma permanente </p>
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

    public function buscarInsumo($codigo)
    {
        $cn = $this->cn->conexion;


        $insumos = $cn->query("SELECT * from Insumo where Codigo like '%{$codigo}%'");
        $html = "";

        if (mysqli_num_rows($insumos) > 0) {
            foreach ($insumos as $proveedor)

                echo $this->generarTabla($insumo);
        } else {
            echo "<tr><td colspan='8'>Insumo No encontrado</td></tr>";
        }
    }

    public function buscarInsumoId($id)
    {
        $cn = $this->cn->conexion;

        $insumos = $cn->query("SELECT * from Insumo where IDInsumo = {$id}");

        if (mysqli_num_rows($insumos) > 0) {
            return $insumos;
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function proveedorCombobox()
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from Proveedor");

        if (mysqli_num_rows($proveedores) > 0) {
            foreach ($proveedores as $proveedor)
                echo $this->generarCombo($proveedor);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    function generarCombo($proveedor){
        $html = '';
        $html = "<option value='{$proveedor['IDProveedor']}'>ID: {$proveedor['IDProveedor']} Nombre: {$proveedor['Nombre']} {$proveedor['Apellidos']} </option>";

        return $html;
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

    public function actualizarInsumo($id, $codigo, $descripcion, $disponibilidad, $costo, $proveedor)
    {
        $cn = $this->cn->conexion;
        $error = true;

        if ($codigo == '' || $codigo == null) {
            $error = "*Debe llenar el campo de codigo* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de descripcion* ";
        } elseif ($disponibilidad == '' || $disponibilidad == null) {
            $error = "*Debe escribir la direccion del proveedor* ";
        } elseif ($costo == '' || $costo == null) {
            $error = "*Debe llenar el campo costo* ";
        } 
        else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "UPDATE insumo SET codigo = ?, descripcion = ?, disponibilidad = ?, costolibra = ?, IDProveedor = ? where IDInsumo = ? ")) {

                mysqli_stmt_bind_param($stmt, 'ssddi', $codigo, $descripcion, $disponibilidad, $costo, $proveedor);

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
