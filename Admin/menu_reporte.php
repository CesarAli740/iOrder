<?php
date_default_timezone_set('America/La_Paz');
require('fpdf/fpdf.php');
include '../includes/_db.php';

if (!$conexion) {
    die("La conexión falló: " . mysqli_connect_error());
}
session_start();
$establecimiento_id = $_SESSION['establecimiento'];

// Obtener la información del restaurante (en este caso, la ruta del logo)
$queryRestaurante = "SELECT nombre, logo FROM establecimiento WHERE id = $establecimiento_id"; // Ajusta el ID del restaurante según tu estructura de base de datos
$resultRestaurante = mysqli_query($conexion, $queryRestaurante);

if ($rowRestaurante = mysqli_fetch_assoc($resultRestaurante)) {
    $logoPath = '../SuperAdmin/' . $rowRestaurante['logo'];
    $nombreRestaurante = $rowRestaurante['nombre'];

    // Verificar si hay errores al cargar la imagen del logo
    if (!@getimagesize($logoPath)) {
        die("Error al cargar la imagen del logo.");
    }

    class PDF extends FPDF
    {
        // Propiedades para el logo, el nombre del restaurante y la hora de emisión
        public $logoPath;
        public $nombreRestaurante;
        public $horaEmision;  // Nueva propiedad para almacenar la hora de emisión

        // Constructor para inicializar las propiedades
        function __construct($logoPath, $nombreRestaurante)
        {
            parent::__construct();
            $this->logoPath = $logoPath;
            $this->nombreRestaurante = $nombreRestaurante;
            $this->horaEmision = date('Y-m-d H:i:s'); // Obtener la hora actual
        }

        function Header()
        {
            // Agregar el logo y el nombre del restaurante en el encabezado
            $this->Image($this->logoPath, 10, 10, 30);
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, 'Menu de ' . $this->nombreRestaurante, 0, 1, 'C');

            // Agregar la hora de emisión debajo del título
            $this->SetFont('Arial', 'I', 10);
            $this->Cell(0, 10, 'Hora de emision: ' . $this->horaEmision, 0, 1, 'C');

            // Línea separadora después del encabezado
            $this->Line(10, 45, 200, 45);
            $this->Ln(5); // Añadir espacio después de la línea
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF($logoPath, $nombreRestaurante);
    $pdf->AddPage();
    $pdf->Ln(20); // Salto de línea con una altura de 20 unidades

    // Cabecera de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, 'Nombre', 1);
    $pdf->Cell(30, 10, 'Tipo', 1);
    $pdf->Cell(30, 10, 'Precio', 1);
    $pdf->Cell(70, 10, 'Descripcion', 1);
    $pdf->Ln();

    // Obtener los datos de la base de datos organizados por tipo
    $queryMenu = "SELECT * FROM menu WHERE establecimiento_id = $establecimiento_id ORDER BY tipo";
    $resultMenu = mysqli_query($conexion, $queryMenu);

    if (mysqli_num_rows($resultMenu) > 0) {
        while ($row = mysqli_fetch_assoc($resultMenu)) {
            // Contenido de la tabla
            $pdf->Cell(60, 10, utf8_decode($row['nombre']), 1);
            $pdf->Cell(30, 10, utf8_decode($row['tipo']), 1);
            $pdf->Cell(30, 10, utf8_decode($row['precio']), 1);
            $pdf->Cell(70, 10, utf8_decode($row['descripcion']), 1);
            $pdf->Ln();
        }
    } else {
        echo "No se encontraron datos en la tabla de menú para el restaurante.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);

    // Generar y mostrar el PDF
    $pdf->Output();
} else {
    echo "No se encontró información del restaurante.";
}
