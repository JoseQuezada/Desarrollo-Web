<?php

require('./php/validacionUsuario.php');
require('./php/Usuario.php');


$usuario = new Usuario();

$IDUsuario = $_GET["IDUsuario"] ?? null ;

$datos = $usuario->buscarUsuarioID($IDUsuario);

$id = $datos['ID'];
$usuario = $datos['Usuario'];
$nombre = $datos['Nombre'];
$apellidos = $datos['Apellidos'];
$email = $datos['Email'];

require('./php/actualizarUsuario.php');

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
                <!--------------------------------------A partir de aqui inician los formularios-------------------------------------------------------------------------------------------------------------------------------------------->


                <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
                <script src="js/bootstrap.min.js"></script>

                <!-- librerias -->
                <link rel="stylesheet" href="./lib/strength.css">
                <script src="./lib/strength.min.js"></script>
                <div class="container-fluid">
                    <h1 class="mt-4">Actualizar Usuario</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Datos del Usuario a Actualizar</li>
                    </ol>

                    <div class="panel panel-info">
                        <div class="panel-heading">

                            <div class="panel-body">

                                <form id="signupform" class="form-horizontal" role="form" method="POST" autocomplete="off">

                                    <?php if (isset($error)) {
                                        if ($error == true) { ?>

                                            <div id="signupalert" class="alert alert-danger">
                                                <p>Error:</p>
                                                <span><?php echo $error; ?></span>
                                            </div>
                                    <?php }
                                    } ?>

                                    <div class="form-group">
                                        <label for="nombre" class="col-md-3 control-label">Usuario:</label>
                                        <!--Este campo debe quedar ineditable-->
                                        <div class="col-md-9">
                                            <input  id="username" maxlength="50" type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if (isset($usuario)) echo $usuario; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div id="result-username"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="apellidos" class="col-md-3 control-label">Nombre:</label>
                                        <div class="col-md-9">
                                            <input type="text" maxlength="200" class="form-control" name="nombre" placeholder="Nombre" value="<?php if (isset($nombre)) echo $nombre; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="usuario" class="col-md-3 control-label">Apellidos:</label>
                                        <div class="col-md-9">
                                            <input type="text" maxlength="200" class="form-control" name="apellidos" placeholder="Apellidos" value="<?php if (isset($apellidos)) echo $apellidos; ?>" required>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label for="email" class="col-md-3 control-label">E-mail:</label>
                                        <div class="col-md-9">
                                            <input id="email" maxlength="200" type="email" class="form-control" name="email" placeholder="Email" value="<?php if (isset($email)) echo $email; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div id="result-email"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-3 control-label">Contraseña:</label>
                                        <div class="col-md-9">
                                            <input id="input_contraseña" maxlength="61" type="password" class="form-control" name="password" placeholder="Contraseña"><br>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="con_password" class="col-md-3 control-label">Confirmar Contraseña:</label>
                                        <div class="col-md-9">
                                            <input type="password" maxlength="61" class="form-control" name="con_password" placeholder="Confirmar Contraseña">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-5 col-md-9">
                                            <button id="btn-signup" type="submit" class="btn btn-sm btn-primary"><i class="icon-hand-right"></i>Actualizar</button>
                                            <button id="btn-signup" type="submit" class="btn btn-sm btn-danger"><i class="icon-hand-right"></i>Cancelar</button>
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
                            });
                        </script>

                        <!--------------------------------------------A partir de aqui debes terminar de colocar los formularios------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
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