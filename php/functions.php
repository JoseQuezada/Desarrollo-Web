<?php


/* ===============================================================================
  Description:      Valida los datos de usuario
  Parameter(s):     $username - Nombre de usuario
                    $password - Contraseña de usuario
                    $cn - Variable de conexion
  Return Value(s):  Redirecciona enviando null o devuelve mensaje de error
===============================================================================*/

function iniciarSesion($username, $password, $cn)
{

    $error = null;


    if ($username == '' || $username == null) {
        $error = "*Debe escribir algo en el campo de usuario*";
    } elseif ($password == '' || $password == null) {
        $error = "*Debe escribir algo en el campo de contraseña*";
    } else {

        if ($stmt = mysqli_prepare($cn, "SELECT * FROM usuarios WHERE Usuario = ? ")) {

            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);

            echo $password;

            $result = mysqli_stmt_get_result($stmt);

            $numUsuarios = mysqli_num_rows($result);

            if ($numUsuarios > 0) {

                $counter = 0;

                while ($row = mysqli_fetch_array($result)) {
                    if (password_verify($password, $row['Password'])) {
                        session_start();

                        $_SESSION = $row;

                        unset($_SESSION['contraseña']);

                        $_SESSION['tipoUsuario'] = $row['ID_Tipo'];

                        header("Location: ./tablero.html");
                    } else {
                        $counter++;
                        if ($counter == $numUsuarios) {
                            $error = "Contraseña incorrecta*";
                        }
                    }
                }
            } else {
                $error = "Usuario incorrecto*";
            }
        }
    }

    return $error;
}


/* ===============================================================================
  Description:      Encripta contraseña
  Parameter(s):     $password - contraseña
  Return Value(s):  retorna hash de contraseña encriptada
===============================================================================*/

function encriptarContraseña($password)
{

    if (is_string($password)) {
        return $hash = password_hash($password, PASSWORD_BCRYPT);
    } else {
        return null;
    }
}

/* ===============================================================================
  Description:      Valida los datos para la creacion de un usuario de usuario
  Parameter(s):     variables de datos de usuario
                    $cn - Variable de conexion
  Return Value(s):  Redirecciona enviando null o devuelve mensaje de error
===============================================================================*/

function crearUsuario($username, $password, $passwordV,  $nombre, $apellidos, $email, $tipo, $cn)
{

    $error = true;

    // echo var_dump($cn);

    // validacion

    if ($username == '' || $username == null) {
        $error = "*Debe escribir el tipo de usuario en el campo de usuario* ";
    } elseif ($password == '' || $password == null) {
        $error = "*Debe escribir una contraseña en el campo de contraseña* ";
    } elseif ($passwordV == '' || $passwordV == null) {
        $error = "*Debe escribir la contraseña que ingreso en el campo contraseña* ";
    } elseif ($password != $passwordV) {
        $error = "*Las contraseñas no coiciden* ";
    } elseif ($nombre == '' || $nombre == null) {
        $error = "*Debe llenar el campo de nombres* ";
    } elseif ($apellidos == '' || $apellidos == null) {
        $error = "*Debe llenar el campo de apellidos* ";
    } elseif ($email == '' || $email == null) {
        $error = "*Debe escribir algo en el campo de email* ";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "*Formato de email invalido* ";
    } elseif (existeUsuario($username, $cn, false)) {
        $error = "*Usuario ya existente* ";
    } elseif (existeEmail($email, $cn, false)) {
        $error = "*Email en uso* ";
    } else {

        // codigo despues de validacion


        if ($stmt = mysqli_prepare($cn, "INSERT INTO usuarios VALUES(NULL, ?, ?, ?, ?, ?, ?)")) {

            $passwordEnc = encriptarContraseña($password);

            mysqli_stmt_bind_param($stmt, 'ssssss', $username, $passwordEnc, $nombre, $apellidos, $email, $tipo);

            mysqli_stmt_execute($stmt);
            
            echo '<div class="alert alert-success">Usuario disponible.</div>';
            

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $error = false;
                
            }

        }else{
                $error =  mysqli_stmt_error($stmt);
            }
    }



    return $error;
}


/* ===============================================================================
  Description:      Revisa si existe un usuario con el mismo nombre
  Parameter(s):     $username - nNombre de usuario
                    $cn - Variable de conexion
  Return Value(s):  
===============================================================================*/


function existeUsuario($username, $cn, $mensaje)
{
    $result = $cn->query(
        'SELECT * FROM usuarios WHERE usuario = "' . strtolower($username) . '"'
    );

    if ($result->num_rows > 0) {

        if ($mensaje) {
            echo '<div class="alert alert-danger">Nombre de usuario no disponible.</div>';
        }
        return true;
    } else {

        if ($mensaje) {
            echo '<div class="alert alert-success">Usuario disponible.</div>';
        }
        return false;
    }
}


/* ===============================================================================
  Description:      Revisa si existe un usuario con el mismo nombre
  Parameter(s):     $username - nNombre de usuario
                    $cn - Variable de conexion
  Return Value(s):  
===============================================================================*/


function existeEmail($email, $cn, $mensaje)
{
    $result = $cn->query("SELECT * FROM usuarios WHERE email = '{$email}'");

    if ($result->num_rows > 0) {

        if ($mensaje) {
            echo '<div class="alert alert-danger">Email en uso.</div>';
        }
        return true;
    } else {

        if ($mensaje) {
            echo '<div class="alert alert-success">Email disponible.</div>';
        }
        return false;
    }
}


// Funciones varias

function isEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function emailExiste($email, $mysqli)
{

    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();

    if ($num > 0) {
        return true;
    } else {
        return false;
    }
}

function getValor($campo, $campoWhere, $valor, $mysqli)
{

    $_campo = "";

    $stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;

    if ($num > 0) {
        $stmt->bind_result($_campo);
        $stmt->fetch();
        return $_campo;
    } else {
        return null;
    }
}

function generaTokenPass($user_id, $mysqli)
{

    $token = bin2hex(openssl_random_pseudo_bytes(64));

    $stmt = $mysqli->prepare("UPDATE usuarios SET Token=?, password_request=1 WHERE id = ?");
    $stmt->bind_param('ss', $token, $user_id);
    $stmt->execute();
    $stmt->close();

    return $token;
}

function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
    require_once './lib/PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl'; //Modificar
    $mail->Host = 'smtp.gmail.com'; //Modificar
    $mail->Port = 587; //Modificar
    
    $mail->Username = 'soporteJuventudDB@gmail.com'; //Modificar
    $mail->Password = 'juventud123'; //Modificar
    
    $mail->setFrom('soporteJuventudDB@gmail.com', 'soporteJuventudDB'); //Modificar
    $mail->addAddress($email, $nombre);
    
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    $mail->IsHTML(true);
    
    if($mail->send())
    return true;
    else
    return false;
}

function crearProveedor($empresa, $nombre, $apellidos, $direccion, $telefono, $email)
{

    $error = true;

    // echo var_dump($cn);

    // validacion

    if ($nombre == '' || $nombre == null) {
        $error = "*Debe llenar el campo de nombre* ";
    } elseif ($apellidos == '' || $apellidos == null) {
        $error = "*Debe llenar el campo de apellidos* ";
    }elseif($direccion == '' || $direccion == null) {
            $error = "*Debe escribir la direccion del proveedor* ";
    } elseif ($telefono == '' || $telefono == null) {
        $error = "*Debe llenar el campo telefono* ";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "*Formato de email invalido* ";
    } else {

        // codigo despues de validacion


        if ($stmt = mysqli_prepare($cn, "INSERT INTO proveedor VALUES(NULL, ?, ?, ?, ?, ?, ?)")) {


            mysqli_stmt_bind_param($stmt, 'ssssss', $empresa, $nombre, $apellidos, $direccion, $telefono, $email);

            mysqli_stmt_execute($stmt);
            

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $error = false;
            }

        }else{
                $error =  mysqli_stmt_error($stmt);
            }
    }



    return $error;
}