<?php

require('./Formula.php');



if (isset($_POST['formulaBusqueda'])) {

  $formula = new Formula();
  $formula->buscarFormula($_POST['formulaBusqueda']);
} else {

  echo "<tr><td colspan='7'>Insumo No encontrado</td></tr>";
}
