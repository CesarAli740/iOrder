<?php
include '../includes/_db.php';

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "SELECT * FROM reservas
        WHERE fecha_hora_reserva BETWEEN '$fecha_inicio' AND '$fecha_fin'";

$result = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<?php include '../NAVBARiorder/index.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Reservas</title>
    <style>
        body {
            margin-top: 200px;
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .container {
            margin: auto;
            margin-top: 200px;
            background-color: rgba(128, 128, 128, 0.7);
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
            width: 100%;
            max-width: 1400px;
            padding: 20px;
        }

        h2 {
            color: white;
            text-align: center;
            font-size: 50px;
            margin-bottom: 20px;
        }

        /* Estilos de la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: rgba(128, 128, 128, 0.5);
        }

        /* Estilos para el botón Volver */
        .volver-button {
            text-align: center;
            margin-top: 20px;
        }

        .volver-button a {
            text-decoration: none;
        }

        .volver-button button {
            background-color: #ea272d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <?php

    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h2>Reporte de Reservas</h2>";
        echo "<table>
                <tr>
                    <th>ID Reserva</th>
                    <th>Nombre del Cliente</th>
                    <th>Email del Cliente</th>
                    <th>Teléfono del Cliente</th>
                    <th>Fecha y Hora de la Reserva</th>
                    <th>Fecha y Hora de Creación</th>
                    <th>ID Mesa</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cliente_nombre']}</td>
                    <td>{$row['cliente_email']}</td>
                    <td>{$row['cliente_telefono']}</td>
                    <td>{$row['fecha_hora_reserva']}</td>
                    <td>{$row['fecha_creacion']}</td>
                    <td>{$row['mesa_id']}</td>
                </tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "No se encontraron reservas en el rango de fechas seleccionado.";
    }

    $conexion->close();
    ?>

    <!-- Botón Volver -->
    <div class="volver-button">
        <a href="reportes-reservas.php">
            <button>Volver</button>
        </a>
    </div>
</body>

</html>
