<?php

require('./Compra.php');

if (isset($_POST['IDCompra'])) {

  $insumo = new Compra();
  $insumo->compraReporteID($_POST['IDCompra']);

} else {

  echo "<tr><td colspan='7'>Insumo No encontrado</td></tr>";
}
