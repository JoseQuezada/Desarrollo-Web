<?php

    session_start();

    if (isset($_SESSION['ID'])) {
        session_destroy();
        session_unset();

        $_SESSION = [];
        echo "<script>
        alert('Sesión cerrada');
        window.location.href='./index.php';
        </script>";
    }else{
        echo "<script>
        alert('No hay ninguna sesión abierta');
        </script>"; 
    }

    
    

?>