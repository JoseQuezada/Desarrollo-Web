<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>

<!-- librerias -->
<link rel="stylesheet" href="./lib/strength.css">
<script src="./lib/strength.min.js"></script>
<div class="container-fluid">
    <h1 class="mt-4">Registro Proveedores</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Datos del Proveedor</li>
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
                            <input type="text" class="form-control" name="empresa" placeholder="Empresa" value="<?php if (isset($nombre)) echo $nombre; ?>" required>
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
                            <input type="text" class="form-control" name="telefono" placeholder="Teléfono" value="<?php if (isset($email)) echo $email; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">E-Mail (Opcional)</label>
                        <div class="col-md-9">
                            <input id="EMail" type="text" class="form-control" name="email" placeholder="E-Mail" required><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-5 col-md-9">
                            <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar Proveedor</button>
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