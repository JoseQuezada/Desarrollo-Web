<?php

require('./Insumo.php');

if (isset($_POST['IDInsumo'])) {

  $insumo = new Insumo();
  $insumo->insumoReporteID($_POST['IDInsumo']);

} else {

  echo "<tr><td colspan='7'>Insumo No encontrado</td></tr>";
}
