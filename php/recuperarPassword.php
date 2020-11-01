<?php

require('./php/conexion.php');
require('./php/functions.php');

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Chequea si se accedió por medio de POST

    $email = $cn ->real_escape_string($_POST["email"]);

    if (!isEmail($email)) {
        $errors[] = "Debe ser un correo electronico valido";
    }

    if (emailExiste($email, $cn)) {

        $user_id = getValor('id', 'email', $email, $cn);
        $nombre = getValor('usuario', 'email', $email, $cn);

        $token = generaTokenPass($user_id, $cn);

        $url = "http://{$_SERVER['SERVER_NAME']}/cambia_pass.php?user_id={$user_id}&token={$token}";

        $asunto = "Recuperacion Contraseña - SUPASA";
        $cuerpo = "Hola $nombre: <br><br> Se ha realizado una solicitud para reiniciar contraseña, para ello, dirigite al siguiente link <a href='$url'> $url </a>";


        if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {

            echo "hemos enviado correo";
            exit;

        }else{
            $errors[] = "error al enviar email";
        }

    }else{
        $errors[] = "Email no existe";

    }

}
