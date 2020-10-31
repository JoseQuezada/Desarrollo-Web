<?php
	
	require 'funcs/conexion.php';
	require 'funcs/funcs.php';
	
	$errors = array();

	if(!empty($_POST))
	{
		$nombre = $mysqli->real_escape_string($_POST['nombre']);
		$apellidos = $mysqli->real_escape_string($_POST['apellidos']);
		$usuario = $mysqli->real_escape_string($_POST['usuario']);
		$telefono = $mysqli->real_escape_string($_POST['telefono']);
		$email = $mysqli->real_escape_string($_POST['email']);
		$password = $mysqli->real_escape_string($_POST['password']);
		$con_password = $mysqli->real_escape_string($_POST['con_password']);
		//$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);
		$secret = '6LeDOtwZAAAAAEo-o0_Dqi2A8K5WTC8yJ9dhfSKN';

		$activo = 0;
		$tipo_usuario = 1;
		

		//if(!$captcha)
		//{
		//$errors[] = "Por favor verifique el captcha";
		//}
		if(isNull($nombre, $apellidos, $usuario, $telefono, $email, $password, $con_password))
		{
			$errors[] = "Los registros no pueden estar vacios";
		}
		if(!isEmail($email))
		{
			$errors[] = "La dirección de correo electrónico no es válida";
		}
		if(!validaPassword($password, $con_password))
		{
			$errors[] = "Las contraseñas ingresadas no coinciden";
		}
		if(usuarioExiste($usuario))
		{
			$errors[] = "El usuario $usuario ya existe";
		}
		if(emailExiste($email))
		{
			$errors[] = "El correo electrónico $email ya se encuentra registrado";
		}
		if(count($errors) == 0)
		{
			//$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?$secret&response=$captcha");
			//$arr = json_decode($response, TRUE);

			//if($arr['success'])
			//{
				$pass_hash = hashPassword($password);
				$token = generateToken();

				try
				{	
					$registro = registraUsuario($nombre, $apellidos, $usuario, $telefono, $email, $pass_hash, $activo, $token, $tipo_usuario);
					if($registro > 0)
					{
						$url = 'http://'.$_SERVER["SERVER_NAME"].'/login/sistema/activar.php?id='.$registro.'&val='.$token;
						$cuerpo = "Estimado $nombre: <br /><br /> Para continuar con el proceso de registro y activar su cuenta, es necesario que haga click en la siguiente liga <a href='$url'>Activar Cuenta</a>";
						if(enviarEmail($email, $nombre, $asunto, $cuerpo))
						{
							echo "Para terminar el proceso de reigstro siga la instrucciones que le hemos enviado a la direccion: $email";
							echo "<br><a href='index.php' >Iniciar Sesión</a>";
							exit;
						}
						else
						{
							$errors[] = "Error al enviar el Email";
						}
					}
					else
					{
					$errors[] = "Error al registrar el usuario";
					}
				}
				catch(Exception $e)
				{
					echo 'Ha habido una excepcion: ', $e->getMessage(),"\n";
				}
			//}
			//else
			//{
			//	$errors[] = 'Error al comprobar Captcha';
			///}
		}
	}
		
	
	
?>

<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registro de Usuarios</title>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"
      	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      	crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js" ></script>
		<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>
	
	<body>
		<div class="container">
			<div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Reg&iacute;strate</div>
						<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="index.php">Iniciar Sesi&oacute;n</a></div>
					</div>  
					
					<div class="panel-body" >
						
						<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							
							<div class="form-group">
								<label for="nombre" class="col-md-3 control-label">Nombre:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required >
								</div>
							</div>

							<div class="form-group">
								<label for="apellidos" class="col-md-3 control-label">Apellidos:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="<?php if(isset($apellidos)) echo $apellidos; ?>" required >
								</div>
							</div>
							
							<div class="form-group">
								<label for="usuario" class="col-md-3 control-label">Usuario:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" required>
								</div>
							</div>

							<div class="form-group">
								<label for="telefono" class="col-md-3 control-label">Teléfono:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="telefono" placeholder="Teléfono" value="<?php if(isset($telefono)) echo $telefono; ?>" required>
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="col-md-3 control-label">E-mail:</label>
								<div class="col-md-9">
									<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Contraseña:</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" placeholder="Contraseña" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="con_password" class="col-md-3 control-label">Confirmar Contraseña:</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="con_password" placeholder="Confirmar Contraseña" required>
								</div>
							</div>
							
							<script>
   								function onSubmit(token) {
     							document.getElementById("signupform").submit();
   														}
 							</script>

							<!--<div class="form-group">
								<label for="captcha" class="col-md-3 control-label"></label>
								<div class="g-recaptcha col-md-9" data-sitekey="6LeDOtwZAAAAAOLP8O8L-CI8PtjUowZYYBvEqSy9"></div>
							</div>-->
							
							<div class="form-group">                                      
								<div class="col-md-offset-5 col-md-9">
									<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar Usuario</button> 
								</div>
							</div>
						</form>
						<?php echo resultBlock($errors); ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>															