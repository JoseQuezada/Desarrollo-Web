<?php
//codigo php


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["IDInsumo"])) {

    $id = $_POST["IDInsumo"];
    echo "<script> window.location.href='./ReporteInsumos.php?IDInsumo={$id}'; </script>";

}

$id = $_GET["IDInsumo"] ?? null;

echo var_dump($id);


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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php

    require('./templates/barraNavegacionTablero.php');

    ?>

    <div id="layoutSidenav_content">
        <main>
            <!------------------------------------------- Inicia Formulario---------------------------------------->
            <br>
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Reporte de Insumos
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="<?php echo "reporteI.php?IDInsumo={$id}" ?>" allowfullscreen></iframe>
                        </div>
                    </table>
                </div>
            </div>
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Reporte personalizado
            </div>
            <form>
                <br>
                <div class="col-md-100 input-group">
                    <label for="buscar" class="col-lg-6">ID del Insumo:</label>
                    <input class="form-control" id="IDInsumo" name="IDInsumo" type="text" placeholder="Buscar insumo" aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                        <div>&nbsp;</div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Generar Reporte</button>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Disponibilidad</th>
                                    <th>Costo Libra</th>
                                    <th>Proveedor</th>
                                </tr>
                            </thead>
                            <tbody id="resultados-insumo">

                            </tbody>
                        </table>
                    </div>
                    <br>
            </form>

            <!-------------------------------------------- Finaliza Formulario------------------------------------------>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SUPASA 2020</div>
                    <div>

                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>

    <script>
        $(document).ready(function($) {

            $("#IDInsumo").keyup(function() {
                var parametros = "IDInsumo=" + $(this).val()

                $.ajax({
                    data: parametros,
                    url: './php/insumosReporte.php',
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

        });
    </script>


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