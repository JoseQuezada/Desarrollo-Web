<?php

error_reporting(1);

include_once './php/conexion.php';
include_once '../php/conexion.php';


class Proveedor
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    function relacionadoInsumo($id)
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from insumo where IDProveedor = {$id}");
        $html = "";

        if (mysqli_num_rows($proveedores) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function crearProveedor($empresa, $nombre, $apellidos, $direccion, $telefono, $email)
    {

        $error = true;

        // echo var_dump($cn);

        // validacion

        if ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } elseif ($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del proveedor* ";
        } elseif ($telefono == '' || $telefono == null) {
            $error = "*Debe llenar el campo telefono* ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "*Formato de email invalido* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "INSERT INTO proveedor VALUES(NULL, ?, ?, ?, ?, ?, ?);")) {


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

    public function listarProveedor()
    {
        $cn = $this->cn->conexion;


        $proveedores = $cn->query("SELECT * from Proveedor");
        $html = "";

        if (mysqli_num_rows($proveedores) > 0) {
            foreach ($proveedores as $proveedor)

                echo $this->generarTabla($proveedor);
        } else {
            echo "<tr><td colspan='8'>Proveedor No encontrado</td></tr>";
        }
    }

    function generarTabla($proveedor)
    {
        $html = '';

        $borrable = $this->relacionadoInsumo($proveedor['IDProveedor']);


        if ($borrable) {
            $html .= "<tr>
            <td>{$proveedor['IDProveedor']}</td>
            <td>{$proveedor['Empresa']}</td>
            <td>{$proveedor['Nombre']}</td>
            <td>{$proveedor['Apellidos']}</td>
            <td>{$proveedor['Dirección']}</td>
            <td>{$proveedor['Teléfono']}</td>
            <td>{$proveedor['Email']}</td>
            <td>
            <span class='d-inline-block' data-placement='left' tabindex='0' data-toggle='tooltip' title='Este proveedor esta relacionado a un insumo, por lo tanto no es posible eliminarlo a menos que se elimine el insumo relacionado'>
                <button class='btn btn-danger disabled' style='pointer-events: none;' type='button' disabled>Eliminar</button>
            </span>
            
            <a href='./ActualizarProveedor.php?IDProveedor={$proveedor['IDProveedor']}' class='btn btn-warning' > Actualizar </a>
            </td>
            </tr>";
        } else {

            $html .= "<tr>
        <td>{$proveedor['IDProveedor']}</td>
        <td>{$proveedor['Empresa']}</td>
        <td>{$proveedor['Nombre']}</td>
        <td>{$proveedor['Apellidos']}</td>
        <td>{$proveedor['Dirección']}</td>
        <td>{$proveedor['Teléfono']}</td>
        <td>{$proveedor['Email']}</td>
        <td>
        <a href='#' data-toggle='modal' data-target='#eliminarModal{$proveedor['IDProveedor']}' class='btn btn-danger' > Eliminar </a>
        <a href='./ActualizarProveedor.php?IDProveedor={$proveedor['IDProveedor']}' class='btn btn-warning' > Actualizar </a>
        
        <div class='modal fade' id='eliminarModal{$proveedor['IDProveedor']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
           <div class='modal-dialog' role='document'>
               <div class='modal-content'>
                   <div class='modal-header'>
                       <h5 class='modal-title' id='exampleModalLabel'>Eliminar proveedor</h5>
                       <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                       </button>
                   </div>
                   <div class='modal-body'>
                       <p> ¿Estas seguro que deseas eliminar al proveedor: '{$proveedor['Nombre']}'? esto será de forma permanente? </p>
                   </div>
                   <div class='modal-footer'>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                       <form method='post'>
                           <input type='hidden' name='idproveedor' value='{$proveedor['IDProveedor']}' />
                           <button type='submit' class='btn btn-danger'>Eliminar</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
    </div>
        </td>
        </tr>";
        }

        return $html;
    }

    public function buscarProveedor($nombre)
    {
        $cn = $this->cn->conexion;


        $proveedores = $cn->query("SELECT * from Proveedor where Nombre like '%{$nombre}%'");
        $html = "";

        if (mysqli_num_rows($proveedores) > 0) {
            foreach ($proveedores as $proveedor)

                echo $this->generarTabla($proveedor);
        } else {
            echo "<tr><td colspan='8'>Proveedor No encontrado</td></tr>";
        }
    }

    public function buscarProveedorId($id)
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from Proveedor where IDProveedor = {$id}");

        if (mysqli_num_rows($proveedores) > 0) {
            return mysqli_fetch_array($proveedores);
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

    public function proveedorSeleccionado($IDProveedor)
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from Proveedor");

        if (mysqli_num_rows($proveedores) > 0) {
            foreach ($proveedores as $proveedor)
                echo $this->generarComboSeleccionado($proveedor, $IDProveedor);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    function generarCombo($proveedor)
    {
        $html = '';
        $html = "<option value='{$proveedor['IDProveedor']}'>ID: {$proveedor['IDProveedor']} Nombre: {$proveedor['Nombre']} {$proveedor['Apellidos']} </option>";

        return $html;
    }


    function generarComboSeleccionado($proveedor, $IDProveedor)
    {
        $html = '';
        $html = "<option value='{$proveedor['IDProveedor']}'>ID: {$proveedor['IDProveedor']} Nombre: {$proveedor['Nombre']} {$proveedor['Apellidos']} </option>";

        if ($IDProveedor == $proveedor['IDProveedor']) {

            $html = "<option selected='selected' value='{$proveedor['IDProveedor']}'>ID: {$proveedor['IDProveedor']} Nombre: {$proveedor['Nombre']} {$proveedor['Apellidos']} </option>";
        }

        return $html;
    }

    public function eliminarproveedor($id)
    {
        $cn = $this->cn->conexion;
        $cn->query("DELETE FROM proveedor WHERE IDProveedor = {$id} ");

        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('Proveedor eliminado');</script>";
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function actualizarProveedor($id, $empresa, $nombre, $apellidos, $direccion, $telefono, $email)
    {
        $cn = $this->cn->conexion;
        $error = null;

        if ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } elseif ($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del proveedor* ";
        } elseif ($telefono == '' || $telefono == null) {
            $error = "*Debe llenar el campo telefono* ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "*Formato de email invalido* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "UPDATE proveedor SET empresa = ?, nombre = ?, apellidos = ?, Dirección = ?, Teléfono = ?, email = ? where IDProveedor = ? ")) {

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
