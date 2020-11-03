<?php
require '../php/crear_usuario.php';
?>

<main>
    <!------------------------A partir de aqui inician los formularios-------------------------------------------------------------------------------------------------------------------------------------------->


    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>

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
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">SWPCIAC</a>
            <!--Hola estoy bien-->
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Ajustes</a>
                        <a class="dropdown-item" href="#">Actividad</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./cerrarSesion.php">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Usuario</div>
                            <a class="nav-link" href="tablero.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Panel de Control
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProvedores" aria-expanded="false" aria-controls="collapseProvedores">
                                <div class="sb-nav-link-icon"><i class="far fa-people-carry"></i></div>
                                Proveedores
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseProvedores" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="proveedor.php">Agregar</a>
                                </nav>
                            </div>
                            <div class="collapse" id="collapseProvedores" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-sidenav-light.html">Insumos</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInsumos" aria-expanded="false" aria-controls="collapseInsumos">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Inventario
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseInsumos" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="Midreccion.html">Insumos</a>
                                    <a class="nav-link" href="Midireccion.html">Compras</a>
                                    <a class="nav-link" href="Midireccion.html">Ventas</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Clientes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Agregar
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Listar
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Ordenes
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Reportes
                            </a>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Usuarios
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseUsuarios" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="registr.php">Agregar Usuario</a>

                                </nav>
                            </div>
                        </div>
                    </div>

                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <!--------------------------------------A partir de aqui inician los formularios-------------------------------------------------------------------------------------------------------------------------------------------->

                    <!-- librerias -->
                    <link rel="stylesheet" href="./lib/strength.css">
                    <script src="./lib/strength.min.js"></script>
                    <div class="container-fluid">
                        <h1 class="mt-4">Registro Usuario</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Datos del Usuario</li>
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
                                            <label for="usuario" class="col-md-3 control-label">Usuario:</label>
                                            <div class="col-md-9">
                                                <input id="username" type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if (isset($usuario)) echo $usuario; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div id="result-username"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="col-md-3 control-label">E-mail:</label>
                                            <div class="col-md-9">
                                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="<?php if (isset($email)) echo $email; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div id="result-email"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="col-md-3 control-label">Contraseña:</label>
                                            <div class="col-md-9">
                                                <input id="input_contraseña" type="password" class="form-control" name="password" placeholder="Contraseña" required><br>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="con_password" class="col-md-3 control-label">Confirmar Contraseña:</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="con_password" placeholder="Confirmar Contraseña" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-5 col-md-9">
                                                <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar Usuario</button>
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

                                    $('#email').on('blur', function() {
                                        $('#result-email').html('<img src="./img/loader.gif" />').fadeOut(1000);

                                        var username = $(this).val();
                                        var dataString = 'username=' + username;

                                        $.ajax({
                                            type: "POST",
                                            url: "./php/revisarEmail.php",
                                            data: dataString,
                                            success: function(data) {
                                                $('#result-email').fadeIn(1000).html(data);
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
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>