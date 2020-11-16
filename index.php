<?php

use function PHPSTORM_META\type;

require './php/login.php';


?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fondo.css">
    <script src="js/bootstrap.min.js"></script>

</head>

<body style="background-image: url(img/Gran.jpg); height:100vh; width: 100;">
    <div class="container">
        
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Iniciar Sesión</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="recupera.php"></a></div>
                </div>

                <div style="padding-top:30px" class="panel-body">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="loginform" class="form-horizontal" role="form" method="POST" autocomplete="off">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="usuario" type="text" class="form-control" value="<?php if (isset($username)) echo $username; ?>" name="username" value="" placeholder="Usuario" required>
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" value="<?php if (isset($password)) echo $password; ?>" type="password" class="form-control" name="password" placeholder="Contraseña" required>
                        </div>

                        <?php if (isset($error)) { ?>
                            <div class="form-group">
                                <div class="alert alert-danger" role="alert"><?php echo $error;  ?></div>
                            </div>
                        <?php } ?>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls text-center">
                                <button id="btn-login" type="submit" class="btn btn-success">Ingresar</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; SUPASA 2020</div>
                    <div>

                    </div>
                </div>
            </div>
        </footer>
</body>

</html>