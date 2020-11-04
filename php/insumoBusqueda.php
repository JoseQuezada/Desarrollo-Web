<?php

require('./Insumo.php');



if (isset($_POST['insumoBusqueda'])) {

  $insumo = new Insumo();
  $insumo->buscarInsumo($_POST['insumoBusqueda']);
} else {

  echo "<tr><td colspan='7'>Insumo No encontrado</td></tr>";
}
