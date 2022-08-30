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

<!------------------ Desde este main hasta que termina se deben pegar los formularios para futuras plantillas -->

        <main>
            <div class="container-fluid"  style="background-color:  #e3f2fd;;">
                <h1 class="mt-4">Panel de Control</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"></li>
                    <p><i class="fas fa-calendar-week"></i>  <span id="time"> </span> <i class="far fa-clock"></i></p> 
                    <script>
                        var datetime = new Date();
                        console.log(datetime);
                        document.getElementById("time").textContent = datetime;

                        `use strict`;
                        function refreshTime() {
                        const timeDisplay = document.getElementById("time");
                        const dateString = new Date().toLocaleString([],{
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                        });
                        const formattedString = dateString.replace(" , ", " - ");
                        timeDisplay.textContent = formattedString;
                                               }
                        setInterval(refreshTime, 1000);

                    </script>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4" style="background-image: url(img/Insumos.png);">
                            <div class="card-body" style="background-image: url(img/Insumo.png); height:100; width:100;">Insumos</div>
                            <img src="/img/Insumos.png" alt="">
                            <div class="card-footer d-flex align-items-center justify-content-between" style="background-color: goldenrod;">
                                <a class="small text-white stretched-link" href="ListarInsumo.php">Ver Detalles</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body" style="background-image: url(img/granjero.jpg); height: 66px; width: 100x;">Clientes</div>
                            <div class="card-footer d-flex align-items-center justify-content-between" style="background-color: dodgerblue;">
                                <a class="small text-white stretched-link" href="ListarCliente.php">Ver Detalles</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6"> 
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body" style="background-image: url(img/Venta.jpg); height: 66px; width: 100x;">Ventas</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="ListarVenta.php">Ver Detalles</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body" style="background-image: url(img/Compras.jpg); height: 65px; width: 100x;">Compras</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="ListarCompra.php">Ver Detalles</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                       
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
        </main>
        <!-- termina el main del formulario -->

        <?php

        require('./templates/footerTablero.php');

        ?>

        <!-- Esto dejarlo como esta -->

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