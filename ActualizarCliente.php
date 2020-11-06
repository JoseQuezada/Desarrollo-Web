<?php

require('./php/Cliente.php');

$IDCliente = $_GET['IDCliente'] ?? null;


echo $IDCLiente;

if ($IDCliente != null) {

    $cliente = new Cliente();

    $datosCliente = $Cliente->buscarClienteId($IDCliente);

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $dpi = $_POST["dpi"];
    $direccion = $_POST["direccion"];
    $municipio = $_POST["municipio"];
    $departamento = $_POST["departamento"];
    $telefono = $_POST["telefono"];
    $telefono2 = $_POST["telefono"];
    $nit = $_POST["nit"];
    $marcac = $_POST["marcac"];


} else {
    exit();
}


if (isset($_POST["btnActualizar"])) { //Chequea si se accedió por medio de POST

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $dpi = $_POST["dpi"];
    $direccion = $_POST["direccion"];
    $municipio = $_POST["municipio"];
    $departamento = $_POST["departamento"];
    $telefono = $_POST["telefono"];
    $telefono2 = $_POST["telefono"];
    $nit = $_POST["nit"];
    $marcac = $_POST["marcac"];

    $cliente = new Cliente();

    $error = $cliente->actualizarCliente($IDCliente, $nombre, $apellidos, $dpi, $direccion, $municipio, $telefono, $telefono2, $nit, $marcac);

    if (!$error) {
        echo "<script>alert('Actualizado correctamente');</script>";
    }
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
        <main>

            <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
            <script src="js/bootstrap.min.js"></script>

            <!-- librerias -->
            <link rel="stylesheet" href="./lib/strength.css">
            <script src="./lib/strength.min.js"></script>
            <div class="container-fluid">
                <h1 class="mt-4">Actualizar Datos de Clientes</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Datos del Cliente</li>
                </ol>

                <div class="panel panel-info">
                    <div class="panel-heading">


                        <div class="panel-body">

                            <form id="signupform" class="form-horizontal" role="form" method="POST" autocomplete="off">

                                <?php if ($error == true) { ?>

                                    <div id="signupalert" class="alert alert-danger">
                                        <p>Error:</p>
                                        <span><?php echo $error; ?></span>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label for="nombre" class="col-md-3 control-label">Empresa (opcional)</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="empresa" placeholder="Empresa" value="<?php if (isset($empresa)) echo $empresa; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nombre" class="col-md-3 control-label">Nombre:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if (isset($nombre)) echo $nombre; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="apellidos" class="col-md-3 control-label">Apellidos:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="<?php if (isset($apellidos)) echo $apellidos; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="usuario" class="col-md-3 control-label">Dirección:</label>
                                    <div class="col-md-9">
                                        <input id="direccion" type="text" class="form-control" name="direccion" placeholder="Dirección" value="<?php if (isset($direccion)) echo $direccion; ?>" required>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Teléfono:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="telefono" placeholder="Teléfono" value="<?php if (isset($telefono)) echo $telefono; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">E-Mail (Opcional)</label>
                                    <div class="col-md-9">
                                        <input id="EMail" type="text" class="form-control" name="email" placeholder="E-Mail" value="<?php if (isset($email)) echo $email; ?>" required><br>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-5 col-md-9">
                                        <button id="btn-signup" name="btnActualizar" type="submit" class="btn btn-sm btn-warning"><i class="icon-hand-right"></i>Actualizar</button>
                                        <a href="./ListarProveedor.php" class="btn btn-sm btn-secondary"><i class="icon-hand-right"></i>Cancelar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <script>
                        $(document).ready(function($) {

                            $('#input_contraseña').strength({
                                strengthClass: 'strength',
                                strengthMeterClass: 'strength_meter',
                                strengthButtonClass: 'button_strength',
                                strengthButtonText: '',
                                strengthButtonTextToggle: 'Ocultar Password'
                            });

                            $('#username').on('blur', function() {
                                $('#result-username').html('<img src="./img/loader.gif" />').fadeOut(1000);

                                var username = $(this).val();
                                var dataString = 'username=' + username;

                                $.ajax({
                                    type: "POST",
                                    url: "./php/revisarUsuario.php",
                                    data: dataString,
                                    success: function(data) {
                                        $('#result-username').fadeIn(1000).html(data);
                                    }
                                });
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