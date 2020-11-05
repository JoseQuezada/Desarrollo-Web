<?php

error_reporting(1);

include_once './php/conexion.php';
include_once '../php/conexion.php';


class Compra
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    function crearCompra($fecha, $descripcion, array $datosInsumos)
    {

        $error = true;
        if ($fecha == '' || $fecha == null) {
            $error = "*Debe llenar el campo de nombre* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } else {

            $cn = $this->cn->conexion;

            $cn = $this->cn->conexion;

            $total = 0;
            $idCompra = null;

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


                if ($stmt = mysqli_prepare($cn, "INSERT INTO Compra VALUES(NULL, ?, ?);")) {

                    mysqli_stmt_bind_param($stmt, 'sd', $fecha, $total);

                    mysqli_stmt_execute($stmt);


                    if (mysqli_stmt_affected_rows($stmt) > 0) {

                        $rs = mysqli_query($cn, "SELECT MAX(IDCompra) AS id FROM Compra");
                        if ($row = mysqli_fetch_row($rs)) {
                            $idCompra = trim($row[0]);


                            // antes
                            foreach ($datosInsumos as $dato) {
                                foreach ($dato as $idInsumo => $libras) {

                                    if ($rs = mysqli_query($cn, "SELECT * FROM Insumo WHERE IDInsumo = {$idInsumo}")) {

                                        if (mysqli_num_rows($rs) > 0) {

                                            $datosInsumo = mysqli_fetch_array($rs);
                                            $costoLibra = $datosInsumo['CostoLibra'];
                                            $subtotal = $costoLibra * $libras;

                                            $disponibilidadActual = $datosInsumo['Disponibilidad'];

                                            if ($stmt = mysqli_prepare($cn, "INSERT INTO Detalle_Compra VALUES(NULL, ?, ?, ?, ?, ?);")) {

                                                mysqli_stmt_bind_param($stmt, 'sddii', $descripcion, $libras, $subtotal, $idCompra, $idInsumo);

                                                mysqli_stmt_execute($stmt);


                                                if (mysqli_stmt_affected_rows($stmt) > 0) {

                                                    $disponibilidad = $disponibilidadActual + $libras;

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
                                            $error = "Id de producto no encontrada";
                                        }
                                    } else {
                                        $error = mysqli_error($cn);
                                    }
                                }
                            }
                        }
                    } else {
                        $error = mysqli_error($cn);;
                    }
                } else {
                    $error =  mysqli_stmt_error($stmt);
                }
            endif;
        }

        return $error;
    }

    public function buscarCompraId($id)
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from Compra where IDCompra = {$id}");

        if (mysqli_num_rows($proveedores) > 0) {
            return mysqli_fetch_array($proveedores);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }


    public function listarCompra()
    {
        $cn = $this->cn->conexion;


        $proveedores = $cn->query("SELECT C.IDCompra, C.Fecha, C.Total from Compra C ORDER BY IDCompra ASC");

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

        $html .= "<tr>
            <td>{$proveedor['IDCompra']}</td>
            <td>{$proveedor['Fecha']}</td>
            <td>{$proveedor['Total']}</td>
            <td>
            <a href='./detalleCompra.php?IDCompra={$proveedor['IDCompra']}' class='btn btn-info'> Ver detalles </a>
            <a href='#' data-toggle='modal' data-target='#eliminarModal{$proveedor['IDCompra']}' class='btn btn-danger' > Eliminar </a>

            <div class='modal fade' id='eliminarModal{$proveedor['IDCompra']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
           <div class='modal-dialog' role='document'>
               <div class='modal-content'>
                   <div class='modal-header'>
                       <h5 class='modal-title' id='exampleModalLabel'>Eliminar compra</h5>
                       <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                       </button>
                   </div>
                   <div class='modal-body'>
                       <p> ¿Estas seguro que deseas eliminar la compra con ID: '{$proveedor['IDCompra']}'? esto será de forma permanente? </p>
                   </div>
                   <div class='modal-footer'>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                       <form method='post'>
                           <input type='hidden' name='idCompra' value='{$proveedor['IDCompra']}' />
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

        $proveedores = $cn->query("SELECT * from detalle_compra where IDCompra = {$id} order by IDDetalleCompra asc limit 0, 1");

        if (mysqli_num_rows($proveedores) > 0) {
            return mysqli_fetch_array($proveedores);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function restoDatos($id)
    {
        $cn = $this->cn->conexion;

        $sql = "SELECT * from detalle_compra where IDCompra = {$id}";
        $result = mysqli_query($cn, $sql);
        $numero = mysqli_num_rows($result);
        $proveedores = $cn->query("SELECT * from detalle_compra where IDCompra = {$id} order by IDDetalleCompra asc limit 1, {$numero}");

        return $proveedores;
    }

    public function eliminarCompra($id)
    {

        $cn = $this->cn->conexion;
        $cn->query("DELETE FROM detalle_compra WHERE IDCompra = {$id} ");
        $cn->query("DELETE FROM Compra WHERE IDCompra = {$id} ");

        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('Proveedor eliminado');</script>";
        } else {

            echo mysqli_error($cn);

            // echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function actualizarCompra($id, $fecha, $descripcion)
    {
        $cn = $this->cn->conexion;
        $error = true;

        if ($fecha == '' || $fecha == null) {
            $error = "*Debe llenar el campo de fecha* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de descripcion* ";
        } else {


            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "UPDATE Compra SET fecha = ? where IDCompra = ? ")) {

                mysqli_stmt_bind_param($stmt, 'si', $fecha, $id);

                mysqli_stmt_execute($stmt);
            }


            if ($stmt = mysqli_prepare($cn, "UPDATE detalle_compra SET Descripción = ? where IDCompra = ? ")) {

                mysqli_stmt_bind_param($stmt, 'si', $descripcion, $id);

                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  "Hubo un error" . mysqli_stmt_error($stmt);
            }
        }

        return $error;
    }
}
