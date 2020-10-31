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

                        header("Location: ./index.html");
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
