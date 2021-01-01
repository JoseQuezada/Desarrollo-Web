<?php

error_reporting(1);

include_once './php/conexion.php';
include_once '../php/conexion.php';


class Venta
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    function crearVenta($fecha, $IDCliente, $tipo, $descripcion, array $datosInsumos)
    {

        $error = true;
        if ($fecha == '' || $fecha == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } else {

            $cn = $this->cn->conexion;

            $total = 0;
            $idVenta = null;
            $error2 = true;

            foreach ($datosInsumos as $dato) {
                foreach ($dato as $idInsumo => $libras) {
                    if ($rs = mysqli_query($cn, "SELECT * FROM Insumo WHERE IDInsumo = {$idInsumo}")) {

                        if (mysqli_num_rows($rs) > 0) {

                            $datosInsumo = mysqli_fetch_array($rs);
                            $costoLibra = $datosInsumo['CostoLibra'];
                            $subtotal = $costoLibra * $libras;
                            $total += $subtotal;

                            $error2 = false;
                        } else {
                            $error2 = true;
                            $error = "Id de producto no encontrada";
                        }
                    } else {
                        $error = mysqli_error($cn);
                    }
                }
            }

            if (!$error2) :

                if ($stmt = mysqli_prepare($cn, "INSERT INTO Venta VALUES(NULL, ?, ?, ?, ?);")) {

                    mysqli_stmt_bind_param($stmt, 'sdis', $fecha, $total, $IDCliente, $tipo);

                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_affected_rows($stmt) > 0) {

                        $rs = mysqli_query($cn, "SELECT MAX(IDVenta) AS id FROM Venta");
                        if ($row = mysqli_fetch_row($rs)) {
                            $idVenta = trim($row[0]);

                            // antes
                            foreach ($datosInsumos as $dato) {
                                foreach ($dato as $idInsumo => $libras) {

                                    if ($rs = mysqli_query($cn, "SELECT * FROM Insumo WHERE IDInsumo = {$idInsumo}")) {

                                        if (mysqli_num_rows($rs) > 0) {

                                            $datosInsumo = mysqli_fetch_array($rs);
                                            $costoLibra = $datosInsumo['CostoLibra'];
                                            $subtotal = $costoLibra * $libras;

                                            $disponibilidadActual = $datosInsumo['Disponibilidad'];

                                            if ($disponibilidadActual >= $libras) {

                                                if ($stmt = mysqli_prepare($cn, "INSERT INTO detalleventa VALUES(NULL, ?, ?, ?, ?, ?);")) {

                                                    mysqli_stmt_bind_param($stmt, 'sddii', $descripcion, $libras, $subtotal, $idInsumo, $idVenta);

                                                    mysqli_stmt_execute($stmt);


                                                    if (mysqli_stmt_affected_rows($stmt) > 0) {

                                                        $disponibilidad = $disponibilidadActual - $libras;

                                                        if ($stmt = mysqli_prepare($cn, "UPDATE Insumo set Disponibilidad = ? WHERE IDInsumo = {$idInsumo}")) {

                                                            mysqli_stmt_bind_param($stmt, 'd', $disponibilidad);

                                                            mysqli_stmt_execute($stmt);

                                                            if (mysqli_stmt_affected_rows($stmt) > 0) {
                                                                $error = false;
                                                            }
                                                        }
                                                    } else {
                                                        $error =  mysqli_stmt_error($stmt);
                                                    }
                                                } else {
                                                    $error =  mysqli_stmt_error($stmt);
                                                }
                                            } else {
                                                $error = "No hay disponibilidad para la venta";
                                            }
                                        } else {
                                            $error = "Id de producto no encontrada";
                                        }
                                    } else {
                                        $error = mysqli_error($cn);
                                    }
                                }
                            }
                        }
                    } else {
                        $error = mysqli_stmt_error($stmt);
                    }
                } else {
                    $error =  mysqli_stmt_error($stmt);
                }
            endif;
        }

        return $error;
    }

    public function buscarVentaId($id)
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from Venta where IDVenta = {$id}");

        if (mysqli_num_rows($proveedores) > 0) {
            return mysqli_fetch_array($proveedores);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }


    public function listarVenta()
    {
        $cn = $this->cn->conexion;


        $proveedores = $cn->query("SELECT V.IDVenta, V.Fecha, V.IDCliente, C.Nombre, C.Apellidos, V.Tipo, V.Total from Venta V inner join Cliente C on V.IDCliente = C.IDCliente ORDER BY IDVenta ASC");

        if (mysqli_num_rows($proveedores) > 0) {

            foreach ($proveedores as $proveedor)
                echo $this->generarTabla($proveedor);
        } else {
            echo "<tr><td colspan='8'>Venta No encontrado</td></tr>";
        }
    }

    function generarTabla($proveedor)
    {
        $html = '';

        $html .= "<tr>
            <td>{$proveedor['IDVenta']}</td>
            <td>{$proveedor['Fecha']}</td>
            <td>ID: {$proveedor['IDCliente']} Nombre: {$proveedor['Nombre']} {$proveedor['Apellidos']}</td>
            <td>{$proveedor['Tipo']}</td>
            <td>{$proveedor['Total']}</td>
            <td>
            <a href='./detalleVenta.php?IDVenta={$proveedor['IDVenta']}' class='btn btn-info'> Ver detalles </a>
            <a href='#' data-toggle='modal' data-target='#eliminarModal{$proveedor['IDVenta']}' class='btn btn-danger' > Eliminar </a>

            <div class='modal fade' id='eliminarModal{$proveedor['IDVenta']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
           <div class='modal-dialog' role='document'>
               <div class='modal-content'>
                   <div class='modal-header'>
                       <h5 class='modal-title' id='exampleModalLabel'>Eliminar Venta</h5>
                       <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                       </button>
                   </div>
                   <div class='modal-body'>
                       <p> ¿Estas seguro que deseas eliminar la Venta con ID: '{$proveedor['IDVenta']}'? esto será de forma permanente? </p>
                   </div>
                   <div class='modal-footer'>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                       <form method='post'>
                           <input type='hidden' name='idVenta' value='{$proveedor['IDVenta']}' />
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

    public function primerosDatos($id)
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from detalleVenta where IDVenta = {$id} order by IDDetallVenta asc limit 0, 1");

        if (mysqli_num_rows($proveedores) > 0) {
            return mysqli_fetch_array($proveedores);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function restoDatos($id)
    {
        $cn = $this->cn->conexion;

        $sql = "SELECT * from detalleVenta where IDVenta = {$id}";
        $result = mysqli_query($cn, $sql);
        $numero = mysqli_num_rows($result);
        $proveedores = $cn->query("SELECT * from detalleVenta where IDVenta = {$id} order by IDDetallVenta asc limit 1, {$numero}");



        return $proveedores;
    }

    public function eliminarVenta($id)
    {

        $cn = $this->cn->conexion;
        $cn->query("DELETE FROM detalleVenta WHERE IDVenta = {$id} ");
        $cn->query("DELETE FROM Venta WHERE IDVenta = {$id} ");

        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('Venta eliminada');</script>";
        } else {

            echo mysqli_error($cn);

            // echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function actualizarVenta($id, $fecha, $IDCliente, $tipo, $descripcion)
    {
        $cn = $this->cn->conexion;
        $error = null;

        if ($fecha == '' || $fecha == null) {
            $error = "*Debe llenar el campo de fecha* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de descripcion* ";
        } else {


            $cn = $this->cn->conexion;


            if ($stmt = mysqli_prepare($cn, "UPDATE Venta SET fecha = ?, IDCliente = ?, Tipo = ? where IDVenta = ? ")) {

                $error = $fecha;

                mysqli_stmt_bind_param($stmt, 'sisi', $fecha, $IDCliente, $tipo, $id);

                mysqli_stmt_execute($stmt);
            } else {
                $error =  "Hubo un error" . mysqli_stmt_error($stmt);
            }


            if ($stmt = mysqli_prepare($cn, "UPDATE detalleVenta SET Descripcion = ? where IDVenta = ? ")) {


                mysqli_stmt_bind_param($stmt, 'si', $descripcion, $id);

                mysqli_stmt_execute($stmt);

                echo var_dump($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  "Hubo un error" . mysqli_stmt_error($stmt);
            }
        }

        return $error;
    }

    public function  ventaReporteID($id)
    {
        $cn = $this->cn->conexion;



        if (!empty($id)) {
            $insumoes = $cn->query("SELECT * from Venta V where IDVenta like '%{$id}%'");
            $html = "";

            if (mysqli_num_rows($insumoes) > 0) {
                foreach ($insumoes as $insumo)

                    echo $this->generarSeleccion($insumo);
            } else {
                echo "<tr><td colspan='7'>Venta No encontrada</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Venta No encontrada</td></tr>";
        }
    }

    public function reporteVenta($id)
    {
        $cn = $this->cn->conexion;


        if ($id != null) {
            $result = mysqli_query($cn, "SELECT * FROM Venta V inner join detalleventa D on V.IDVenta=D.IDVenta inner join Insumo I on D.IDInsumo = I.IDInsumo inner join Cliente C on  V.IDCliente = C.IDCliente where V.IDVenta like '%{$id}%' ");
        } else {
            $result = mysqli_query($cn, "SELECT * FROM Venta where IDVenta like '%{$id}%' ");
        }

        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return  null;
        }
    }

    function generarSeleccion($insumo)
    {
        $html = '';

        $html .= "<tr>
        <td>{$insumo['IDCompra']}</td>
        <td>{$insumo['Fecha']}</td>
        <td>{$insumo['Total']}</td>
        </tr>";

        return $html;
    }
}


