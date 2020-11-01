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

        $query = mysqli_query($cn, "SELECT * FROM usuarios");
        echo mysqli_num_rows($query);

        if ($stmt = mysqli_prepare($cn, "SELECT * FROM usuarios WHERE Usuario = ? ")) {

            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);



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
        $error = "*Debe escribir algo en el campo de usuario* ";
    } elseif ($password == '' || $password == null) {
        $error = "*Debe escribir algo en el campo de contraseña* ";
    } elseif ($passwordV == '' || $passwordV == null) {
        $error = "*Debe escribir algo en el campo de confirmar contraseña* ";
    } elseif ($password != $passwordV) {
        $error = "*Las contraseñas no coiciden* ";
    } elseif ($nombre == '' || $nombre == null) {
        $error = "*Debe escribir algo en el campo de nombres* ";
    } elseif ($apellidos == '' || $apellidos == null) {
        $error = "*Debe escribir algo en el campo de apellidos* ";
    } elseif ($email == '' || $email == null) {
        $error = "*Debe escribir algo en el campo de email* ";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "*Formato de email invalido* ";
    } elseif (existeUsuario($username, $cn, false)) {
        $error = "*Usuario ya existente* ";
    } else {

        // codigo despues de validacion


        if ($stmt = mysqli_prepare($cn, "INSERT INTO usuarios VALUES(NULL, ?, ?, ?, ?, ?, ?)")) {

            $passwordEnc = encriptarContraseña($password);

            mysqli_stmt_bind_param($stmt, 'ssssss', $username, $passwordEnc, $nombre, $apellidos, $email, $tipo);

            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $error = false;
            }
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
