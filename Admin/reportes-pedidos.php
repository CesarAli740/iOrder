<?php
session_start();
error_reporting(0);
$validar = isset($_SESSION['correo']) ? $_SESSION['correo'] : '';
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if ($rol != '2') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}

include '../NAVBARiorder/index.php';
?>
<br><br><br><br><br><br><br><br>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pedidos</title>
    <style>
        .container {
            margin-top: 7rem !important;
            margin: 1rem;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.7);
            border-radius: 1rem;
            color: white;
        }

        .container-form {
            display: flex;
            justify-content: space-around;
            align-items: stretch;
            flex-direction: column;
        }

        .container-form-child {
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-align: center;
        }

        .form-group {
            color: black;
            margin-bottom: 2rem;
            width: 25%;
        }

        .form-label {
            margin-top: 10px;
            display: block;
            font-weight: bold;
            margin-bottom: 2rem;
            color: white;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 2rem;
        }

        .form-select {
            border-radius: 1rem;
            width: 11rem;
            height: 3rem;
            background-color: white;
            color: black;
            font-weight: bold;
        }

        button {
            background-color: #ea272d !important;
            color: white;
            margin-right: 1rem;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #7d1518 !important;
        }
        h1{
            color:white;
            font-size: 4rem;

        }
        h2{
            color: white;
            font-size: 2rem;
        }
    </style>
</head>
<body>
<center><h1>Reportes Pedidos</h1></center>
<div class="container">
    <h2>Filtrar por Fecha de pedido</h2>
    <form action="generar_reportes_pedidos.php" method="post" class="container-form">
        <div class="container-form-child">
            <div class="form-group">
                <label class="form-label" for="fecha_inicio">Fecha de inicio:</label>
                <input class="form-control" type="date" name="fecha_inicio" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="fecha_fin">Fecha de fin:</label>
                <input class="form-control" type="date" name="fecha_fin" required>
            </div>

            <button class="btn btn-success" type="submit">Generar Reporte</button>
            <button class="btn btn-secondary" type="button" onclick="generarPDF()">Generar PDF</button>
        </div>
    </form>
    </div>
    <script>
        function generarPDF() {
            window.location.href = 'generar_reporte_pedidos_pdf.php?' + 
                'fecha_inicio=' + document.getElementsByName('fecha_inicio')[0].value +
                '&fecha_fin=' + document.getElementsByName('fecha_fin')[0].value;
        }
    </script>
</body>
</html>
