<?php

declare(strict_types=1);
error_reporting(1);
include './php/conexion.php';
include '../php/conexion.php';


class Formula
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    function generarTabla($formula)
    {
        $html = '';

        $html .= "<tr>
        <td>{$formula['IDDetalleFormula']}</td>
        <td>{$formula['Código']}</td>
        <td>{$formula['Descripción']}</td>
        <td>{$formula['Costo']}</td>
        <td>{$formula['IDInsumo']}: {$formula['Descripcion']}</td>
        <td>
        <a href='#' data-toggle='modal' data-target='#eliminarModal{$formula['IDDetalleFormula']}' class='btn btn-danger' > Eliminar </a>
        <a href='./ActualizarFormula.php?IDDetalleFormula={$formula['IDDetalleFormula']}' class='btn btn-warning' > Actualizar </a>
        
        <div class='modal fade' id='eliminarModal{$formula['IDDetalleFormula']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
           <div class='modal-dialog' role='document'>
               <div class='modal-content'>
                   <div class='modal-header'>
                       <h5 class='modal-title' id='exampleModalLabel'>Eliminar Formula</h5>
                       <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                       </button>
                   </div>
                   <div class='modal-body'>
                       <p> ¿Esta seguro que desea eliminar la Fórmula: {$formula['Descripción']}? Esto será de forma permanente </p>
                   </div>
                   <div class='modal-footer'>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                       <form method='post'>
                           <input type='hidden' name='IDDetalleFormula' value='{$formula['IDDetalleFormula']}' />
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


    function generarSeleccion($formula)
    {
        $html = '';

        $html .= "<tr>
        <td>{$formula['IDDetalleFormula']}</td>
        <td>{$formula['Código']}</td>
        <td>{$formula['Descripción']}</td>
        <td>{$formula['Costo']}</td>
        <td>{$formula['IDInsumo']}: {$formula['Descripcion']}</td>
        </tr>"; //devuelve valores de una fila encontrada

        return $html;
    }

    function crearFormula($codigo, $descripcion, $costo, $datosInsumos)
    {

        $error = true;

        if ($codigo == '' || $codigo == null) {
            $error = "*Debe llenar el campo de código* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de descripcion* ";
            $error = "*Ingrese la disponibilidad del insumo* ";
        } elseif ($costo == '' || $costo == null) {
            $error = "*Ingrese el costo del insumo* ";
        } else {

            $cn = $this->cn->conexion;

            $total = 0;
            $idformula = null;
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
            
                    if ($stmt = mysqli_prepare($cn, "INSERT INTO DetalleFormula VALUES(NULL, ?, ?, ?);")) {
                        mysqli_stmt_bind_param($stmt, 'ssd', $codigo, $descripcion, $costo);
                        mysqli_stmt_execute($stmt);
                    }
                    if (mysqli_stmt_affected_rows($stmt) > 0) {

                        $rs = mysqli_query($cn, "SELECT MAX(IDDetalleFormula) AS id FROM DetalleFormula");
                        if ($row = mysqli_fetch_row($rs)) {
                            $IDDetalleFormula = trim($row[0]);

                            // antes
                            foreach ($datosInsumos as $dato) {
                                foreach ($dato as $idInsumo => $libras) {

                                    if ($rs = mysqli_query($cn, "SELECT * FROM Insumo WHERE IDInsumo = {$idInsumo}")) {

                                        if (mysqli_num_rows($rs) > 0) {

                                            $datosInsumo = mysqli_fetch_array($rs);
                                            $costoLibra = $datosInsumo['Costo'];
                                            $subtotal = $costoLibra * $libras;

                                            $disponibilidadActual = $datosInsumo['Disponibilidad'];

                                            foreach ($dato as $IDInsumo => $libras) {
                                                if ($stmt = mysqli_prepare($cn, "INSERT INTO Formula VALUES(NULL, ?, ?);")) {

                                                    mysqli_stmt_bind_param($stmt, 'ii', $IDInsumo, $IDDetalleFormula);

                                                    mysqli_stmt_execute($stmt);

                                                    if ($disponibilidadActual >= $libras) {

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
                                                        $error = "No hay disponibilidad de insumo para la Fórmula";
                                                    }
                                                } else {
                                                    $error = "ID de Producto No Encontrada";
                                                } //6to
                                            }  //5to
                                        } //4to
                                    } //3ero
                                } //2do
                            }  //Inicio
                        } else {
                            $error =  mysqli_stmt_error($stmt);
                        }
                    }
                    //Fin
                
            endif;
        }

        return $error;
    }

    public function listarFormula()
    {
        $cn = $this->cn->conexion;


        $formulas = $cn->query("SELECT F.IDDetalleFormula, F.Código, F.Descripción, F.Costo, I.IDInsumo, I.IDDetalleFormula, O.IDInsumo, O.Descripcion FROM DetalleFormula F INNER JOIN Formula I ON F.IDDetalleFormula = I.IDDetalleFormula INNER JOIN Insumo O ON I.IDInsumo = O.IDInsumo;");
        $html = "";

        if (mysqli_num_rows($formulas) > 0) {
            foreach ($formulas as $formula)  //genera fila por nuevo elemento

                echo $this->generarTabla($formula);
        } else {
            echo "<tr><td colspan='8'>Fórmula No Encontrada</td></tr>";
        }
    }

    public function reporteFormula($id)
    {
        $cn = $this->cn->conexion;
        //por procedimientos query
        $result = mysqli_query($cn, "SELECT * FROM Formula F inner join Insumo I on F.IDInsumo=I.IDInsumo where IDFormula like '%{$id}%' ");

        if (mysqli_num_rows($result) > 0) {
            return $result;
        } else {
            return  null;
        }
    }


    public function buscarFormulaSeleccion($nombre)
    {
        $cn = $this->cn->conexion;



        if (!empty($nombre)) {
            # code...
            $insumoes = $cn->query("SELECT * from DetalleFormula D INNER JOIN Formula F ON D.IDDetalleFormula = F.IDDetalleFormula INNER JOIN Insumo I ON F.IDInsumo = I.IDInsumo where D.Descripción like '%{$nombre}%'");
            $html = "";

            if (mysqli_num_rows($insumoes) > 0) {
                foreach ($insumoes as $insumo)

                    echo $this->generarSeleccion($insumo);
            } else {
                echo "<tr><td colspan='7'>Fórmula No encontrada</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Fórmula No encontrada</td></tr>";
        }
    }

    public function formulaReporteID($id)
    {
        $cn = $this->cn->conexion;



        if (!empty($id)) {
            $insumoes = $cn->query("SELECT * from Formula I inner join Insumo P on I.IDInsumo = P.IDInsumo where IDFormula like '%{$id}%'");
            $html = "";

            if (mysqli_num_rows($insumoes) > 0) {
                foreach ($insumoes as $insumo)

                    echo $this->generarSeleccion($insumo);
            } else {
                echo "<tr><td colspan='7'>Fórmula No encontrada</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Fórmula No encontrada</td></tr>";
        }
    }

    public function buscarFormula($nombre)
    {
        $cn = $this->cn->conexion;


        $insumoes = $cn->query("SELECT * FROM DetalleFormula F INNER JOIN Formula P on F.IDDetalleFormula = P.IDDetalleFormula WHERE Descripción LIKE '%{$nombre}%'");
        $html = "";

        if (mysqli_num_rows($insumoes) > 0) {
            foreach ($insumoes as $insumo)

                echo $this->generarTabla($insumo);
        } else {
            echo "<tr><td colspan='8'>Fórmula No encontrada</td></tr>";
        }
    }

    public function buscarFormulaId($id)
    {
        $cn = $this->cn->conexion;

        $insumoes = $cn->query("SELECT * from DetalleFormula where IDDetalleFormula = {$id}");

        if (mysqli_num_rows($insumoes) > 0) {
            return mysqli_fetch_array($insumoes);
        } else {
        ?>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.mixin({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al buscar la fórmula',
                })
            </script>
        <?php
        }
    }

    public function eliminarformula($id)
    {
        $cn = $this->cn->conexion;
        
        $datosInsumos = array();
        if ($rs = mysqli_query($cn, "SELECT * FROM Insumo I INNER JOIN Formula F ON I.IDInsumo = F.IDInsumo INNER JOIN DetalleFormula D ON F.IDDetalleFormula = D.IDDetalleFormula WHERE D.IDDetalleFormula = {$id};")) {
            foreach ($datosInsumos as $dato) {
                foreach ($dato as $IDInsumo => $libras) {
                    
                    
                    if (mysqli_num_rows($rs) > 0) {
                        
                        $datosInsumo = mysqli_fetch_array($rs);
                        
                        $disponibilidadActual = $datosInsumo['Disponibilidad'];
                        $IDInsumo = $datosInsumo['IDInsumo'];
                        
                        $cn->query("DELETE FROM Formula WHERE IDDetalleFormula = {$id} ");
                        $cn->query("DELETE FROM DetalleFormula WHERE IDDetalleFormula = {$id} "); 

                                    if (mysqli_affected_rows($cn) > 0) {

                                        $disponibilidad = $disponibilidadActual + $libras;

                                        if ($stmt = mysqli_prepare($cn, "UPDATE Insumo SET Disponibilidad = ? WHERE IDInsumo = {$IDInsumo}")) {

                                            mysqli_stmt_bind_param($stmt, 'd', $disponibilidad);

                                            mysqli_stmt_execute($stmt);

                                            if (mysqli_stmt_affected_rows($stmt) > 0) {
                                               
                                                ?>
                                                    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                    <script>
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Fórmula Eliminada',
                                                            text: 'Fórmula Eliminada Correctamente',
                                                        })
                                                    </script>
                                                <?php
                                            }
                                        }
                                    } else {

                                        echo  mysqli_error($cn);
                                        ?>
                                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            Swal.mixin({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Hubo un error al eliminar la Fórmula',
                                            })
                                        </script>
                                    <?php
                                    }
                               
                         //5to
                    } //4to
                } //3ero
            } //2do
        }  //Inicio
}

    public function actualizarFormula($id, $codigo, $descripcion, $costo)
    {
        $cn = $this->cn->conexion;
        $error = null;

        if ($codigo == '' || $codigo == null) {
            $error = "*Debe llenar el campo de codigo* ";
        } elseif ($descripcion == '' || $descripcion == null) {
            $error = "*Debe llenar el campo de descripcion* ";
            $error = "*Debe escribir la direccion del proveedor* ";
        } elseif ($costo == '' || $costo == null) {
            $error = "*Debe llenar el campo costo* ";
        } else {

            $cn = $this->cn->conexion;

            if ($stmt = mysqli_prepare($cn, "UPDATE DetalleFormula SET Código = ?, Descripción = ?, Costo = ? where IDDetalleFormula = ? ")) {

                mysqli_stmt_bind_param($stmt, 'ssddi', $codigo, $descripcion, $costo, $id);

                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  "Hubo un error" . mysqli_error($cn); //mysql prepare (myqli_error) y query (no se puedene pasar parametros)
            }
        }


        return $error;
    }



public function primerosDatos($id)
{
    $cn = $this->cn->conexion;

    $proveedores = $cn->query("SELECT * FROM Formula WHERE IDDetalleFormula = {$id} ORDER BY IDFormula ASC LIMIT 0, 1");
    
    if (mysqli_num_rows($proveedores) > 0) {
        return mysqli_fetch_array($proveedores);
    } else {
        echo "<script>alert('Hubo un error');</script>";
    }
}

public function restoDatos($id)
{
    $cn = $this->cn->conexion;
    
    $sql = "SELECT * FROM Formula WHERE IDDetalleFormula = {$id}";
    $result = mysqli_query($cn, $sql);
    $numero = mysqli_num_rows($result);
    $proveedores = $cn->query("SELECT * FROM Formula WHERE IDDetalleFormula = {$id} ORDER BY IDFormula ASC LIMIT 1, {$numero}");

    return $proveedores;
}
}