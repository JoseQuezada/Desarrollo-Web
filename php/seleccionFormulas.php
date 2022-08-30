<?php

require('./Formula.php');



if (isset($_POST['insumoBusqueda'])) {

  $insumo = new Formula(); 
  $insumo->buscarFormulaSeleccion($_POST['insumoBusqueda']);
} else {

  echo "<tr><td colspan='7'>Fórmula No Encontrada</td></tr>";
}
