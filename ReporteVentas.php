<?php
//codigo php

//require('./php/Usuario.php');

//if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[''])) {

    

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
            <br>
<!------------------------------------------- Inicia Formulario---------------------------------------->
                    <div class="col-md-200 input-group">
                    <label for="PDF" class="col-lg-10"></label>
                        <div class="input-group-append">
                        <br>
                            <button class="btn btn-primary" type="button"><i class="fas fa-download"></i> Descargar PDF</button>
                        </div>
                    </div>
                    <br>
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                   Reporte de Ventas
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nombre Cliente</th>
                                    <th>Insumos</th>
                                    <th>Envío</th>
                                    <th>Quintales</th>
                                    <th>Costo</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            

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
        $(document).ready(function() {
            $("#usuarioBusqueda").keyup(function() {
                var parametros = "usuarioBusqueda=" + $(this).val()
                $.ajax({
                    data: parametros,
                    url: './php/usuarioBusqueda.php',
                    type: 'post',
                    beforeSend: function() {},
                    success: function(response) {
                        $("#resultados-usuario").html(response);
                    },
                    error: function() {
                        alert("error")
                    }
                });
            })
        })
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