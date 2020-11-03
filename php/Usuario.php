<?php

require_once './php/conexion.php';

class Usuario
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    private function encriptarContraseña($password)
    {
    
        if (is_string($password)) {
            return $hash = password_hash($password, PASSWORD_BCRYPT);
        } else {
            return null;
        }
    }

    public function iniciarSesion($username, $password)
    {

        $error = null;
        global $cn; 
        
        if ($username == '' || $username == null) {
            $error = "*Debe escribir algo en el campo de usuario*";
        } elseif ($password == '' || $password == null) {
            $error = "*Debe escribir algo en el campo de contraseña*";
        } else {

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

    
    public function existeUsuario($username, $mensaje)
    {
        global $cn;
        $result = $cn->query('SELECT * FROM usuarios WHERE usuario = "' . strtolower($username) . '"'
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

    private function existeEmail($email, $mensaje)
    {
        global $cn;
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

    public function crearUsuario($username, $password, $passwordV,  $nombre, $apellidos, $email, $tipo)
    {
        global $cn;
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
        } elseif ($this -> existeUsuario($username, false)) {
            $error = "*Usuario ya existente* ";
        } elseif ($this -> existeEmail($email, $cn, false)) {
            $error = "*Email en uso* ";
        } else {

            // codigo despues de validacion


            if ($stmt = mysqli_prepare($cn, "INSERT INTO usuarios VALUES(NULL, ?, ?, ?, ?, ?, ?)")) {

                $passwordEnc = $this ->encriptarContraseña($password);

                mysqli_stmt_bind_param($stmt, 'ssssss', $username, $passwordEnc, $nombre, $apellidos, $email, $tipo);

                mysqli_stmt_execute($stmt);


                echo " hoasdalsd aslkjdlkasjdlas";

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  mysqli_stmt_error($stmt);
            }
        }



        return $error;
    }



}
