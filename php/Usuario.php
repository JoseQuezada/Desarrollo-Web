<?php

error_reporting(0);

include_once './php/conexion.php';
include_once '../php/conexion.php';

class Usuario
{

    public $cn;

    function __construct()
    {
        $this->cn = new Conexion();
    }

    public function listarUsuario()
    {
        $cn = $this->cn->conexion;


        $usuarios = $cn->query("SELECT * from usuarios U inner join perfil P on U.ID_TIPO = P.ID_TIPO");
        $html = "";

        if (mysqli_num_rows($usuarios) > 0) {
            foreach ($usuarios as $usuario)
                $html .= "<tr>
             <td>{$usuario['ID']}</td>
             <td>{$usuario['Usuario']}</td>
             <td>{$usuario['Nombre']}</td>
             <td>{$usuario['Apellidos']}</td>
             <td>{$usuario['Email']}</td>
             <td>{$usuario['Tipo']}</td>
             <td>
             <a href='#' data-toggle='modal' data-target='#exampleModal{$usuario['ID']}' class='btn btn-danger' > Eliminar </a>
             <a href='./ActualizarUsuario2.php?IDUsuario={$usuario['ID']}' class='btn btn-warning' > Actualizar </a>
             
             <div class='modal fade' id='exampleModal{$usuario['ID']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Eliminar Usuario</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <p> ¿Estas seguro que deseas eliminar al usuario: '{$usuario['Usuario']}'? esto será de forma permanente? </p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            <form method='post'>
                                <input type='hidden' name='idUsuario' value='{$usuario['ID']}' />
                                <button type='submit' class='btn btn-danger'>Sí</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>
             </td>
             </tr>";

            echo $html;
        } else {
            echo "<tr><td colspan='7'>Usuario No encontrado</td></tr>";
        }
    }

    public function buscarUsuarioID($id)
    {
        $cn = $this->cn->conexion;

        $datosUsuario = $cn->query("SELECT * from usuarios where id = {$id}");

        if (mysqli_num_rows($datosUsuario) > 0) {
            return mysqli_fetch_array($datosUsuario);
        } else {
            echo "<script>alert('Usuario no encontrado');</script>";
        }
    }


    public function buscarUsuario($username)
    {
        $cn = $this->cn->conexion;


        $usuarios = $cn->query("SELECT * from usuarios U inner join perfil P on U.ID_TIPO = P.ID_TIPO where usuario like '%{$username}%'");
        $html = "";

        if (mysqli_num_rows($usuarios) > 0) {
            foreach ($usuarios as $usuario)
                $html .= "<tr>
             <td>{$usuario['ID']}</td>
             <td>{$usuario['Usuario']}</td>
             <td>{$usuario['Nombre']}</td>
             <td>{$usuario['Apellidos']}</td>
             <td>{$usuario['Email']}</td>
             <td>{$usuario['Tipo']}</td>
             <td>
             <a href='#' data-toggle='modal' data-target='#exampleModal{$usuario['ID']}' class='btn btn-danger' > Eliminar </a>
             <a href='./ActualizarUsuario2.php?IDUsuario={$usuario['ID']}' class='btn btn-warning' > Actualizar </a>
             
             <div class='modal fade' id='exampleModal{$usuario['ID']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>Eliminar Usuario</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <p> ¿Estas seguro que deseas eliminar al usuario: '{$usuario['Usuario']}'? esto será de forma permanente? </p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            <form method='post'>
                                <input type='hidden' name='idUsuario' value='{$usuario['ID']}' />
                                <button type='submit' class='btn btn-danger'>Sí</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>
             </td>
             </tr>";

            echo $html;
        } else {
            echo "<tr><td colspan='7'>Usuario No encontrado</td></tr>";
        }
    }

    public function usuarioCombobox()
    {
        $cn = $this->cn->conexion;

        $proveedores = $cn->query("SELECT * from Perfil");

        if (mysqli_num_rows($proveedores) > 0) {
            foreach ($proveedores as $proveedor)
                echo $this->generarCombo($proveedor);
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    function generarCombo($usuario)
    {
        $html = '';
        $html = "<option value='{$usuario['ID_Tipo']}'>Rol: {$usuario['Tipo']}  </option>";

        return $html;
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
        $cn = $this->cn->conexion;

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

                            unset($_SESSION['Password']); 

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


    public function eliminarUsuario($id)
    {
        $cn = $this->cn->conexion;
        $cn->query("DELETE FROM usuarios WHERE ID = {$id} ");

        if (mysqli_affected_rows($cn) > 0) {
            echo "<script>alert('Usuario Eliminado');</script>";
        } else {
            echo "<script>alert('Hubo un error');</script>";
        }
    }

    public function existeUsuario($username, $mensaje)
    {
        $cn = $this->cn->conexion;
        $result = $cn->query('SELECT * FROM usuarios WHERE usuario = "' . strtolower($username) . '"');

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

    public function existeEmail($email, $mensaje)
    {

        $cn = $this->cn->conexion;
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
        $cn = $this->cn->conexion;
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
        } elseif ($this->existeUsuario($username, false)) {
            $error = "*Usuario ya existente* ";
        } elseif ($this->existeEmail($email, false)) {
            $error = "*Email en uso* ";
        } else {

            if ($stmt = mysqli_prepare($cn, "INSERT INTO usuarios VALUES(NULL, ?, ?, ?, ?, ?, ?)")) {



                $passwordEnc = $this->encriptarContraseña($password);

                mysqli_stmt_bind_param($stmt, 'ssssss', $username, $passwordEnc, $nombre, $apellidos, $email, $tipo);

                mysqli_stmt_execute($stmt);

                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $error = false;
                }
            } else {
                $error =  "Hubo un error";
            }
        }


        return $error;
    }

    public function actualizarUsuario($id, $username, $password, $passwordV,  $nombre, $apellidos, $email, $tipo)
    {
        $cn = $this->cn->conexion;
        $error = null;

        $cambioContraseña = false;        // validacion

        if ($username == '' || $username == null) {
            $error = "*Debe escribir el tipo de usuario en el campo de usuario* ";
        } elseif ($nombre == '' || $nombre == null) {
            $error = "*Debe llenar el campo de nombres* ";
        } elseif ($apellidos == '' || $apellidos == null) {
            $error = "*Debe llenar el campo de apellidos* ";
        } elseif ($email == '' || $email == null) {
            $error = "*Debe escribir algo en el campo de email* ";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "*Formato de email invalido* ";
        } elseif ($this->existeUsuario($username, false) and $username != $_SESSION['Usuario']) {
            $error = "*Usuario ya existente* ";
        } elseif ($this->existeEmail($email, false) and $email != $_SESSION['Email']) {
            $error = "*Email en uso* ";
        } else {

            if (!empty($password) or !empty($passwordV)) {
                if ($password == '' || $password == null) {
                    $error = "*Debe escribir una contraseña en el campo de contraseña* ";
                } elseif ($passwordV == '' || $passwordV == null) {
                    $error = "*Debe escribir la contraseña que ingreso en el campo contraseña* ";
                } elseif ($password != $passwordV) {
                    $error = "*Las contraseñas no coiciden* ";
                } else {
                    $cambioContraseña = true;        // validacion
                }
            }

            if ($cambioContraseña) {


                if ($stmt = mysqli_prepare($cn, "UPDATE usuarios SET Usuario = ?, Password = ?, Nombre = ?, Apellidos = ?, Email = ?, ID_TIPO = ? where ID = ?")) {

                    $passwordEnc = $this->encriptarContraseña($password);

                    mysqli_stmt_bind_param($stmt, 'ssssssi', $username, $passwordEnc, $nombre, $apellidos, $email, $tipo, $id);

                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $error = false;
                    }
                } else {
                    $error =  "Hubo un error";
                }
            } else {
 

                if ($stmt = mysqli_prepare($cn, "UPDATE usuarios SET Usuario = ?, Nombre = ?, Apellidos = ?, Email = ?, ID_TIPO = ? where ID = ?")) {

                    $passwordEnc = $this->encriptarContraseña($password);

                    mysqli_stmt_bind_param($stmt, 'sssssi', $username, $nombre, $apellidos, $email, $tipo, $id);

                    mysqli_stmt_execute($stmt);


                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $error = false;
                    }
                } else {
                    $error =  "Hubo un error";
                }
            }
        }


        return $error;
    }
}
