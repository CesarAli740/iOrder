<?php
date_default_timezone_set('America/La_Paz');
require('./fpdf/fpdf.php');
include '../includes/_db.php';

session_start();
$establecimiento_id = $_SESSION['establecimiento'];
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];

// Obtener la hora de emisión
$hora_emision = date('Y-m-d H:i:s');

$sql = "SELECT pedidos.*, detalles_pedido.*, menu.nombre as nombre_producto, menu.precio as precio_producto
        FROM pedidos
        JOIN detalles_pedido ON pedidos.id = detalles_pedido.pedido_id
        JOIN menu ON detalles_pedido.producto_id = menu.id
        WHERE pedidos.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
        ORDER BY pedidos.fecha";

$result = $conexion->query($sql);

$queryEstablecimiento = $conexion->query("SELECT nombre, logo FROM establecimiento WHERE id = $establecimiento_id");
$establecimientoData = $queryEstablecimiento->fetch_assoc();
$establecimiento = $establecimientoData['nombre'];
$logoPath = '../SuperAdmin/' . $establecimientoData['logo'];

if ($result->num_rows > 0) {
    // Crear un objeto PDF con orientación horizontal
    $pdf = new FPDF('L', 'mm', 'Letter');
    $pdf->AddPage();
    // Configurar encabezado con logo
    $pdf->Image($logoPath, 10, 10, 30);
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte de Pedidos - ' . $establecimiento, 0, 1, 'C');

    // Agregar la hora de emisión debajo del título
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Hora de emision: ' . $hora_emision, 0, 1, 'C');

    $pdf->Ln(15);
    // Configurar la tabla
    $pdf->SetFont('Arial', 'B', 12);

    // Nuevas funciones para ajustar automáticamente el ancho de la celda
    function AutoCell($pdf, $w, $h, $text)
    {
        $width = $pdf->GetStringWidth($text);
        if ($width > $w) {
            while ($pdf->GetStringWidth($text) > $w - 2) {
                $text = substr($text, 0, -1);
            }
            $text .= '...';
        }
        $pdf->Cell($w, $h, $text);
    }

    $pdf->Cell(20, 10, '# Pedido', 1);
    $pdf->Cell(50, 10, 'Fecha', 1);
    $pdf->Cell(20, 10, 'Mesa', 1);
    $pdf->Cell(80, 10, 'Producto', 1);
    $pdf->Cell(20, 10, 'Cantidad', 1);
    $pdf->Cell(35, 10, 'Precio Unitario', 1);
    $pdf->Cell(35, 10, 'Precio Total', 1);

    // Resto del código para iterar sobre los resultados y agregar filas
    $currentDateTime = null;
    $total = 0;

    while ($row = $result->fetch_assoc()) {
        $pdf->Ln();

        $fechaActual = $row['fecha'];

        if ($fechaActual != $currentDateTime) {
            if ($currentDateTime !== null) {
                $pdf->Cell(225, 10, 'Total', 1);
                $pdf->Cell(35, 10, 'Bs. ' . number_format($total, 2), 1);
                $pdf->Ln();
            }

            $pdf->Cell(20, 10, $row['id'], 1);
            $pdf->Cell(50, 10, $row['fecha'], 1);
            $pdf->Cell(20, 10, $row['mesa_id'], 1);
            AutoCell($pdf, 80, 10, $row['nombre_producto']);
            $pdf->Cell(20, 10, $row['cantidad'], 1);
            $pdf->Cell(35, 10, 'Bs. ' . number_format($row['precio_producto'], 2), 1);

            $total = $row['cantidad'] * $row['precio_producto'];
            $pdf->Cell(35, 10, 'Bs. ' . number_format($total, 2), 1);

            $currentDateTime = $fechaActual;
        } else {
            $pdf->Cell(20);
            $pdf->Cell(50);
            $pdf->Cell(20);
            AutoCell($pdf, 80, 10, $row['nombre_producto']);
            $pdf->Cell(20, 10, $row['cantidad'], 1);
            $pdf->Cell(35, 10, 'Bs. ' . number_format($row['precio_producto'], 2), 1);

            $total += $row['cantidad'] * $row['precio_producto'];
            $pdf->Cell(35, 10, 'Bs. ' . number_format($total, 2), 1);
        }
    }

    // Salida del PDF
    $pdf->Output();
} else {
    echo "No se encontraron pedidos en el rango de fechas seleccionado.";
}

$conexion->close();
?>
