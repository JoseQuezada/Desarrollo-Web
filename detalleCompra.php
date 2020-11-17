<?php

require_once('./php/Compra.php');

$IDCompra = $_GET['IDCompra'] ?? null;


echo $IDCompra;

if ($IDCompra != null) {

    $compra = new Compra();

    $datosCompra = $compra->buscarCompraId($IDCompra);

    $fecha = $datosCompra['Fecha'];
    $total = $datosCompra['Total'];


    $primerosDatos = $compra->primerosDatos($IDCompra);

    $primerInsumo = $primerosDatos['IDInsumo'];
    $primerLibra = $primerosDatos['Libras'];
    $primerDetalle = $primerosDatos['IDDetalleCompra'];
    $descripcion = $primerosDatos['Descripción'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Chequea si se accedió por medio de POST


        $fecha = $_POST["fecha"];
        $descripcion = $_POST["desripcion"];

        $compra = new Compra();
        $error = $compra->actualizarCompra($IDCompra, $fecha, $descripcion);


        if (!$error) {
            
        }
    }
} else {
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Panel de Control</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <?php

    require('./templates/barraNavegacionTablero.php');

    ?>

    <div id="layoutSidenav_content">

        <!-- Desde este main hasta que termina se deben pegar los formularios para futuras plantillas -->
        <!-- Importante que se actualicen los controles, sobretodo de hrefs -->

        <main>
            <!------------------------------A partir de aqui van los formluarios---------------------------------------------------------------------------------------------------------------------->
            <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
            <script src="js/bootstrap.min.js"></script>

            <!-- librerias -->
            <link rel="stylesheet" href="./lib/strength.css">
            <script src="./lib/strength.min.js"></script>
            <div class="container-fluid">
                <h1 class="mt-4">Actualizar/visualizar Compra</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Datos de la Compra</li>
                </ol>

                <div class="panel panel-info">
                    <div class="panel-heading">


                        <div class="panel-body">

                            <form id="signupform" class="form-horizontal" role="form" method="POST" autocomplete="off">

                                <?php if (isset($error)) {
                                    # code...
                                    if ($error == true) { ?>

                                        <div id="signupalert" class="alert alert-danger">
                                            <p>Error:</p>
                                            <span><?php echo $error; ?></span>
                                        </div>
                                <?php }
                                } ?>

                                <div class="form-group">
                                    <label for="nombre" class="col-md-3 control-label">Fecha:</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="fecha" placeholder="Fecha" value="<?php if (isset($fecha)) echo $fecha; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nombre" class="col-md-3 control-label">Descripción:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="desripcion" placeholder="Descripción" value="<?php if (isset($descripcion)) echo $descripcion; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <strong class="col-md-3 control-p">Insumos:</strong>
                                    <div class="col-md-9">
                                        <div class="field_wrapper">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>ID Insumo</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p>Libras</p>
                                                </div>
                                            </div>

                                            <div>

                                                <input readonly type="text" placeholder="ID del insumo" name="idInsumos[]" value="<?php if (isset($primerInsumo)) echo $primerInsumo; ?>" />
                                                <input readonly type="number" step="0.01" min="0" placeholder="Libras compradas" name="librasCompradas[]" value="<?php if (isset($primerLibra)) echo $primerLibra; ?>" />
                                                <input readonly type="hidden" name="idDetalle[]" value="<?php echo $primerDetalle; ?>" />

                                                <?php

                                                $compra = new Compra();

                                                $restoDatosInsumos = $compra->restoDatos($IDCompra);

                                                // echo var_dump($restoDatosInsumos);

                                                if (mysqli_num_rows($restoDatosInsumos) > 0) {

                                                    foreach ($restoDatosInsumos as $dato) {

                                                ?>

                                                        <div>

                                                            <input readonly type="hidden" name="idDetalle[]" value="<?php echo $dato['IDDetalleCompra']; ?>" />

                                                            <input readonly type="text" placeholder="ID del insumo" name="idInsumos[]" value="<?php echo $dato['IDCompra']; ?>" />

                                                            <input readonly type="number" step="0.01" min="0" placeholder="Libras compradas" name="librasCompradas[]" value="<?php echo $dato['Libras']; ?>" />
                                                        </div>

                                                <?php }
                                                } else {
                                                    echo "<hr><h5> No se encontraron mas Insumos </h5><hr>";
                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-offset-5 col-md-9">
                                    <?php if (isset($error)) {
                                        # code...
                                        if ($error == false) { ?>

                                        <div class="alert alert-success" role="alert">
                                            Datos Actualizados <a href="#" class="alert-link"></a>
                                        </div>
                                    
                                                
                                            </div>
                                    <?php }
                                    } ?>
                                        <button id="btn-signup" type="submit" class="btn btn-warning"><i class="icon-hand-right"></i>Actualizar Compra</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <script>
                        $(document).ready(function($) {

                            $("#insumoBusqueda").keyup(function() {
                                var parametros = "insumoBusqueda=" + $(this).val()
                                $.ajax({
                                    data: parametros,
                                    url: './php/seleccionInsumos.php',
                                    type: 'post',
                                    beforeSend: function() {},
                                    success: function(response) {
                                        $("#resultados-insumo").html(response);
                                    },
                                    error: function() {
                                        alert("error")
                                    }
                                });
                            })

                            var addButton = $('.add_button'); //Add button selector
                            var wrapper = $('.field_wrapper'); //Input field wrapper
                            var fieldHTML = '<div><input type="text" placeholder="ID del insumo" name="idInsumos[]" value="" /> <input type="number" step="0.01" min="0" placeholder="Libras compradas" name="librasCompradas[]" value="" /><a href="javascript:void(0);" class="remove_button" title="Remove field"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM6.854 6.146a.5.5 0 1 0-.708.708L7.293 8 6.146 9.146a.5.5 0 1 0 .708.708L8 8.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 8l1.147-1.146a.5.5 0 0 0-.708-.708L8 7.293 6.854 6.146z"/></svg></a></div>'; //New input field html 
                            $(addButton).click(function() { //Once add button is clicked
                                $(wrapper).append(fieldHTML); // Add field html
                            });
                            $(wrapper).on('click', '.remove_button', function(e) { //Once remove button is clicked
                                e.preventDefault();
                                $(this).parent('div').remove(); //Remove field html
                            });

                        });
                    </script>
                    <!-----------------A partir de aqui debes terminar de colocar los formularios------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SUPASA 2020</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>