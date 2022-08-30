<?php


 
function iniciarSesion($username, $password, $cn)
{

    $error = null;


    if ($username == '' || $username == null) {
        $error = "*Debe escribir un nombre de usuario en el campo de usuario*";
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

                        header("Location: ./tablero.php");
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



/* ===============================================================================
  Description:      Valida los datos para la creacion de un usuario de usuario
  Parameter(s):     variables de datos de usuario
                    $cn - Variable de conexion
  Return Value(s):  Redirecciona enviando null o devuelve mensaje de error
===============================================================================*/



/* ===============================================================================
  Description:      Revisa si existe un usuario con el mismo nombre
  Parameter(s):     $username - nNombre de usuario
                    $cn - Variable de conexion
  Return Value(s):  
===============================================================================*/


/* ===============================================================================
  Description:      Revisa si existe un usuario con el mismo nombre
  Parameter(s):     $username - nNombre de usuario
                    $cn - Variable de conexion
  Return Value(s):  
===============================================================================*/




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
		
    require './lib/PHPMailer/PHPMailerAutoload.php';
    
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

