<?php

session_start();
$userId = $_SESSION['ID'] ?? null;

if ($userId == null || $userId == '') {
    echo "<script>
        alert('NO TIENE AUTORIZACION');
        window.location.href='./index.php';
        </script>";
}


