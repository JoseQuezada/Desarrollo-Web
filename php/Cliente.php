<?php

error_reporting(1);

include_once './php/conexion.php';
include_once '../php/conexion.php';


class Cliente
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    function relacionadoCliente($id)
    {
        $cn = $this->cn->conexion;

        $clientes = $cn->query("SELECT * from cliente where IDCliente = {$id}");
        $html = "";

        if (mysqli_num_rows($clientes) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function crearCliente($nombre, $apellidos, $dpi, $direccion, $municipio, $departamento, $telefono, $telefono2, $nit, $marcac)
    {

        $error = true;

        // echo var_dump($cn);

        // validacion

        if ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        }elseif($dpi == '' || $dpi == null){
            $error = "*Debe escribir el dpi del cliente* ";
        } elseif ($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del direccion* ";
        }elseif($municipio == ''|| $municipio == null){
                $error = "Debe llenar el campo municipio";
        }elseif($departamento == '' || $departamento == null){
                $error = "Debe llenar el campo departamento";
        } elseif ($telefono == '' || $telefono == null) {
            $error = "*Debe llenar el campo telefono* ";
        } elseif ($nit == '' || $nit == null) {
            $error = "*Debe llenar el campo  nit* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "INSERT INTO cliente VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);")) {


                mysqli_stmt_bind_param($stmt, 'ssssssssss', $nombre, $apellidos, $dpi, $direccion, $municipio, $departamento, $telefono, $telefono2, $nit, $marcac);

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

    public function listarCliente()
    {
        $cn = $this->cn->conexion;


        $clientes = $cn->query("SELECT * from cliente");
        $html = "";

        if (mysqli_num_rows($clientes) > 0) {
            foreach ($clientes as $cliente)

                echo $this->generarTabla($cliente);
        } else {
            echo "<tr><td colspan='8'>Cliente No encontrado</td></tr>";
        }
    }

    function generarTabla($cliente)
    {
        $html = '';

        $borrable = $this->relacionadoInsumo($cliente['IDCliente']);


        if ($borrable) {
            $html .= "<tr>
            <td>{$cliente['IDCliente']}</td>
            <td>{$cliente['Nombre']}</td>
            <td>{$cliente['Apellidos']}</td>
            <td>{$cliente['DPI']}</td>
            <td>{$cliente['Dirección']}</td>
            <td>{$cliente['Municipio']}</td>
            <td>{$cliente['Departamento']}</td>
            <td>{$cliente['Telefono']}</td>
            <td>{$cliente['Telefono2']}</td>
            <td>{$cliente['NIT']}</td>
            <td>{$cliente['Marca_Concentrado']}</td>
            <td>
            <span class='d-inline-block' data-placement='left' tabindex='0' data-toggle='tooltip' title='Este cliente esta relacionado a un venta, por lo tanto no es posible eliminarlo a menos que se elimine el insumo relacionado'>
                <button class='btn btn-danger disabled' style='pointer-events: none;' type='button' disabled>Eliminar</button>
            </span>
            
            <a href='./ActualizarCliente.php?IDProveedor={$cliente['IDCliente']}' class='btn btn-warning' > Actualizar </a>
            </td>
            </tr>";
        } else {

            $html .= "<tr>
            <td>{$cliente['IDCliente']}</td>
            <td>{$cliente['Nombre']}</td>
            <td>{$cliente['Apellidos']}</td>
            <td>{$cliente['DPI']}</td>
            <td>{$cliente['Dirección']}</td>
            <td>{$cliente['Municipio']}</td>
            <td>{$cliente['Departamento']}</td>
            <td>{$cliente['Telefono']}</td>
            <td>{$cliente['Telefono2']}</td>
            <td>{$cliente['NIT']}</td>
            <td>{$cliente['Marca_Concentrado']}</td>
        <td>
        <a href='#' data-toggle='modal' data-target='#eliminarModal{$cliente['IDCliente']}' class='btn btn-danger' > Eliminar </a>
        <a href='./ActualizarCliente.php?IDClienter={$cliente['IDCliente']}' class='btn btn-warning' > Actualizar </a>
        
        <div class='modal fade' id='eliminarModal{$cliente['IDCliente']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
           <div class='modal-dialog' role='document'>
               <div class='modal-content'>
                   <div class='modal-header'>
                       <h5 class='modal-title' id='exampleModalLabel'>Eliminar cliente</h5>
                       <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                       </button>
                   </div>
                   <div class='modal-body'>
                       <p> ¿Estas seguro que deseas eliminar al cliente: '{$cliente['Nombre']}'? esto será de forma permanente? </p>
                   </div>
                   <div class='modal-footer'>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                       <form method='post'>
                           <input type='hidden' name='idcliente' value='{$cliente['IDCliente']}' />
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

    public function buscarCliente($nombre)
    {
        $cn = $this->cn->conexion;


        $clientes = $cn->query("SELECT * from Cliente where Nombre like '%{$nombre}%'");
        $html = "";

        if (mysqli_num_rows($clientes) > 0) {
            foreach ($clientes as $cliente)

                echo $this->generarTabla($cliente);
        } else {
            echo "<tr><td colspan='8'>Cliente No encontrado</td></tr>";
        }
    }

    public function buscarClienteId($id)
    {
        $cn = $this->cn->conexion;

        $clientes = $cn->query("SELECT * from Cliente where IDCliente = {$id}");

        if (mysqli_num_rows($clientes) > 0) {
            return mysqli_fetch_array($clientes);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function clienteCombobox()
    {
        $cn = $this->cn->conexion;

        $clientes = $cn->query("SELECT * from Cliente");

        if (mysqli_num_rows($clientes) > 0) {
            foreach ($clientes as $cliente)
                echo $this->generarCombo($cliente);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function clienteSeleccionado($IDCliente)
    {
        $cn = $this->cn->conexion;

        $clientes = $cn->query("SELECT * from Cliente");

        if (mysqli_num_rows($clientes) > 0) {
            foreach ($clientes as $cliente)
                echo $this->generarComboSeleccionado($cliente, $IDCliente);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    function generarCombo($cliente)
    {
        $html = '';
        $html = "<option value='{$cliente['IDClienteVenta']}'>ID: {$cliente['IDCliente']} Nombre: {$cliente['Nombre']} {$proveedor['Apellidos']} </option>";

        return $html;
    }


    function generarComboSeleccionado($cliente, $IDCliente)
    {
        $html = '';
        $html = "<option value='{$cliente['IDCliente']}'>ID: {$cliente['IDCliente']} Nombre: {$cliente['Nombre']} {$cliente['Apellidos']} </option>";

        if ($IDCliente == $cliente['IDCliente']) {

            $html = "<option selected='selected' value='{$cliente['IDCliente']}'>ID: {$cliente['IDCliente']} Nombre: {$cliente['Nombre']} {$cliente['Apellidos']} </option>";
        }

        return $html;
    }

    public function eliminarcliente($id)
    {
        $cn = $this->cn->conexion;
        $cn->query("DELETE FROM cliente WHERE IDCliente = {$id} ");

        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('Cliente eliminado');</script>";
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function actualizarCliente($id, $nombre, $apellidos, $dpi, $direccion, $municipio, $departamento, $telefono, $telefono2, $marcac)
    {
        $cn = $this->cn->conexion;
        $error = true;

        if ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
            }elseif($dpi == '' || $dpi == null){
            $error = "*Debe escribir el dpi del cliente* ";
        } elseif ($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del direccion* ";
        }elseif($municipio == ''|| $municipio == null){
                $error = "Debe llenar el campo municipio";
        }elseif($departamento == '' || $departamento == null){
                $error = "Debe llenar el campo departamento";
        } elseif ($telefono == '' || $telefono == null) {
            $error = "*Debe llenar el campo telefono* ";
        } elseif ($nit == '' || $nit == null) {
            $error = "*Debe llenar el campo  nit* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "UPDATE cliente SET nombre = ?, apellidos = ?, dpi = ?, direccion = ?, municipio = ?, departamento = ?, telefono = ?, telefono2 = ?, nit = ?, marca_concentrado = ? where IDCliente = ? ")) {

                mysqli_stmt_bind_param($stmt, 'ssssssssss' $nombre, $apellidos, $dpi, $direccion, $municipio, $departamento, $telefono, $telefono2, $nit, $marcac);

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
