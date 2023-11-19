<?php
include '../includes/_db.php';

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "SELECT pedidos.*, detalles_pedido.*, menu.nombre as nombre_producto, menu.precio as precio_producto
        FROM pedidos
        JOIN detalles_pedido ON pedidos.id = detalles_pedido.pedido_id
        JOIN menu ON detalles_pedido.producto_id = menu.id
        WHERE pedidos.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";

$result = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<?php include '../NAVBARiorder/index.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pedidos</title>
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
    </style>
</head>

<body>
    <?php

    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h2>Reporte de Pedidos</h2>";
        echo "<table>
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Mesa</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $total = $row['cantidad'] * $row['precio_producto'];
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['usuario_correo']}</td>
                    <td>{$row['mesa_id']}</td>
                    <td>{$row['nombre_producto']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>Bs. {$row['precio_producto']}</td>
                    <td>Bs. {$total}</td>
                </tr>";
        }

        echo "</table>";
        echo "</div>";
      
    } else {
        echo "No se encontraron pedidos en el rango de fechas seleccionado.";
    }

    $conexion->close();
    ?>
</body>
<div style="text-align: center; margin-top: 20px;">
    <a href="reportes-pedidos.php">
        <button style="background-color: #ea272d; color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; text-transform: uppercase;">
            Volver
        </button>
    </a>
</div>
</html>
