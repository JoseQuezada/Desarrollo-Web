<?php
require('./lib/fpdf/fpdf.php');
require('./php/Insumo.php');


$id = $_GET["IDInsumo"] ?? null;

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        // Arial bold 15
        $this->SetFont('Arial', 'B', 11);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(70, 10, 'Reporte de insumos', 1, 0, 'C');
        // Salto de línea
        $this->Ln(20);

        $this->Cell(20, 10, utf8_decode('ID'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Codigo'), 1, 0, 'C', 0);
        $this->Cell(40, 10, utf8_decode('Descripcion'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Disponibilidad'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Costo por libra'), 1, 0, 'C', 0);
        $this->Cell(40, 10, utf8_decode('Proveedor'), 1, 1, 'C', 0);
    }
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode("Página") . '' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Tabla

$insumo = new Insumo();
$resultados = $insumo->reporteInsumo($id);

if ($resultados != null) {

    while ($row = mysqli_fetch_assoc($resultados)) {
        $pdf->Cell(20, 10, utf8_decode($row['IDInsumo']), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode($row['Codigo']), 1, 0, 'C', 0);
        $pdf->Cell(40, 10, utf8_decode($row['Descripcion']), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode($row['Disponibilidad']), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode($row['CostoLibra']), 1, 0, 'C', 0);
        $pdf->Cell(40, 10, utf8_decode($row['Nombre'] . ' ' . $row['Apellidos']), 1, 1, 'C', 0);
    }
} else {
    $pdf->Cell(190, 10, utf8_decode("No se encotraron registros"), 1, 0, 'C', 0);
}

$pdf->Output();
