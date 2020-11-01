<?php

require_once './php/crear_usuario.php';

?>

<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registro de Usuarios</title>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
	<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
	<script src="https://www.google.com/recaptcha/api.js"></script>

	<!-- librerias -->
	<link rel="stylesheet" href="./lib/strength.css">
	<script src="./lib/strength.min.js"></script>


</head>

<body>
	<div class="container">
		<div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Reg&iacute;strate</div>
					<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="index.php">Iniciar Sesi&oacute;n</a></div>
				</div>

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
								<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if (isset($email)) echo $email; ?>" required>
							</div>
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

						<!-- <div class="form-group">
								<label for="captcha" class="col-md-3 control-label"></label>
								<div class="g-recaptcha col-md-9" data-sitekey="6LeDOtwZAAAAAOLP8O8L-CI8PtjUowZYYBvEqSy9"></div>
							</div> -->

						<div class="form-group">
							<div class="col-md-offset-5 col-md-9">
								<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar Usuario</button>
							</div>
						</div>
					</form>
				</div>
			</div>
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

</body>

</html>