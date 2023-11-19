<?php
include '../includes/_db.php';
require('fpdf/fpdf.php');

session_start();
$establecimiento_id = $_SESSION['establecimiento'];
// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener el nombre y el logo del establecimiento
$queryEstablecimiento = $conexion->query("SELECT nombre, logo FROM establecimiento WHERE id = $establecimiento_id");
$establecimientoData = $queryEstablecimiento->fetch_assoc();
$establecimiento = $establecimientoData['nombre'];
$logoPath = $establecimientoData['logo'];

// Procesar las fechas de la solicitud
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];

// Consulta para obtener los pedidos dentro del rango de fechas
$sql = "SELECT pedidos.*, detalles_pedido.*, menu.nombre as nombre_producto, menu.precio as precio_producto
        FROM pedidos
        JOIN detalles_pedido ON pedidos.id = detalles_pedido.pedido_id
        JOIN menu ON detalles_pedido.producto_id = menu.id
        WHERE pedidos.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";

$result = $conexion->query($sql);

// Generar el informe PDF con FPDF
class PDF extends FPDF {
    private $establecimiento;
    private $logoPath;

    function setEstablecimiento($nombre) {
        $this->establecimiento = $nombre;
    }

    function setLogo($path) {
        $this->logoPath = '../SuperAdmin/' . $path;
    }

    function Header() {
        // Agregar el logo
        if (!empty($this->logoPath) && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 10, 8, 33);
        }

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de Pedidos - ' . $this->establecimiento, 0, 1, 'C');
        $this->Cell(0, 10, 'Fecha del Reporte: ' . date('Y-m-d H:i:s'), 0, 1, 'C');
        $this->Ln(10); // Salto de línea
    }

    function Footer() {
        // Pie de página si es necesario
    }

    function TablaPedidos($header, $data) {
        // Anchuras personalizadas
        $widths = array(30, 50, 60, 20, 40, 30, 30);
    
        // Encabezado de la tabla
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($widths[$i], 10, $header[$i], 1);
        }
        $this->Ln();
    
        // Contenido de la tabla
        foreach ($data as $row) {
            for ($i = 0; $i < count($row); $i++) {
                $this->Cell($widths[$i], 10, $row[$i], 1);
            }
            $this->Ln();
        }
    }
}

$pdf = new PDF('L'); // 'L' indica orientación horizontal (landscape)
$pdf->setEstablecimiento($establecimiento); // Establecer el nombre del establecimiento
$pdf->setLogo($logoPath); // Establecer la ruta del logo
$pdf->AddPage();

// Encabezados de la tabla
$header = array('ID Pedido', 'Fecha', 'Producto', 'Cantidad', 'Precio', 'Total');

// Contenido de la tabla (extraer datos de la consulta SQL)
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        $row['id'],
        $row['fecha'],
        $row['nombre_producto'],
        $row['cantidad'],
        'Bs.' . number_format($row['precio_producto'], 2), // Formatear precio como moneda
        'Bs.' . number_format($row['cantidad'] * $row['precio_producto'], 2) // Total como moneda
    );
}

// Llamar al método para generar la tabla
$pdf->TablaPedidos($header, $data);

// Salida del PDF
$pdf->Output();
$conexion->close();
?>
