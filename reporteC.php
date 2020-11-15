<?php
require('./lib/fpdf/fpdf.php');
require('./php/Compra.php');


$id = $_GET["IDCompra"] ?? null;

$compra = new Compra();
$resultados = $compra->reporteCompra($id);


class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo

        // Arial bold 15
        $this->SetFont('Arial', 'B', 11);
        // Movernos a la derecha
        // Título

        global $id;
        global $compra;
        $resultados = $compra->reporteCompra($id);


        if ($id == null) {
            $this->Cell(60);

            $this->Cell(70, 10, 'Reporte de compras', 1, 0, 'C');
        } else {
            $this->Cell(50);

            $this->Cell(90, 10, "Reporte de Compra con ID: {$id}", 1, 1, 'C');

            $this->Ln(5);

            $row = mysqli_fetch_array($resultados);
            $this->Cell(90, 10, "Fecha " . utf8_decode($row["Fecha"]), 0, 0, 'J', 0);
        }

        // Salto de línea
        $this->Ln(10);
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


if ($resultados != null) {

    if ($id != null and !empty($id)) {

        $pdf->Cell(20, 10, utf8_decode('ID Insumo'), 1, 0, 'C', 0);
        $pdf->Cell(40, 10, utf8_decode('Insumo'), 1, 0, 'C', 0);
        $pdf->Cell(40, 10, utf8_decode('Proveedor'), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode('Libra compradas'), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode('Costo por libra'), 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode('Subtotal'), 1, 1, 'C', 0);

        // echo var_dump($resultados);

        while ($row = mysqli_fetch_array($resultados)) {

            $pdf->Cell(20, 10, utf8_decode($row['IDInsumo']), 1, 0, 'C', 0);
            $pdf->Cell(40, 10, utf8_decode($row['Descripcion']), 1, 0, 'C', 0);
            $pdf->Cell(40, 10, utf8_decode($row['Nombre'] . ' ' . $row['Apellidos']), 1, 0, 'C', 0);
            $pdf->Cell(30, 10, utf8_decode($row['Libras']), 1, 0, 'C', 0);
            $pdf->Cell(30, 10, utf8_decode($row['CostoLibra']), 1, 0, 'C', 0);
            $pdf->Cell(30, 10, utf8_decode($row['Sub_Total']) . '.00', 1, 1, 'C', 0);
        }

        $resultados = $compra->reporteCompra($id);
        $row = mysqli_fetch_array($resultados);

        $pdf->Cell(20, 10, '', 0, 0, 'C', 0);
        $pdf->Cell(40, 10, '', 0, 0, 'C', 0);
        $pdf->Cell(40, 10, '', 0, 0, 'C', 0);
        $pdf->Cell(30, 10, '', 0, 0, 'C', 0);
        $pdf->Cell(30, 10, 'Total', 1, 0, 'C', 0);
        $pdf->Cell(30, 10, utf8_decode($row["Total"]) . '.00', 1, 1, 'C', 0);
    } else {

        $pdf->Ln(10);

        $pdf->Cell(30, 10, utf8_decode('ID'), 1, 0, 'C', 0);
        $pdf->Cell(90, 10, utf8_decode('Fecha'), 1, 0, 'C', 0);
        $pdf->Cell(70, 10, utf8_decode('Total'), 1, 1, 'C', 0);

        while ($row = mysqli_fetch_assoc($resultados)) {
            $pdf->Cell(30, 10, utf8_decode($row['IDCompra']), 1, 0, 'C', 0);
            $pdf->Cell(90, 10, utf8_decode($row['Fecha']), 1, 0, 'C', 0);
            // Aqui se puede agregar el .00
            $pdf->Cell(70, 10, utf8_decode($row['Total']) . '.00', 1, 1, 'C', 0);
        }
    }
} else {
    $pdf->Cell(190, 10, utf8_decode("No se encotraron registros"), 1, 0, 'C', 0);
}

$pdf->Output();
