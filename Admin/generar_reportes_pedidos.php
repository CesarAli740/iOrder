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
        WHERE pedidos.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
        ORDER BY pedidos.fecha";

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

    $currentDateTime = null;
    $total = 0;

    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h2>Reporte de Pedidos</h2>";
        echo "<table>
                <tr>
                    <th># Pedido</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Mesa</th>
                    <th></th>
                    <th>Producto</th>
                    <th></th>
                    <th>Cantidad</th>
                    <th></th>
                    <th>Precio Unitario</th>
                    <th></th>
                    <th>Precio Total</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $fechaActual = $row['fecha'];

            // Verificar si es la misma fecha y hora que la actual
            if ($fechaActual != $currentDateTime) {
                // Si no es la misma fecha y hora, imprimir una nueva fila
                if ($currentDateTime !== null) {
                    echo "<td colspan='7' style='white-space: nowrap;'><div>{$productos}</div></td>"; // Combina las celdas
                    echo "<td>Bs. {$total}</td>"; // Añadir total
                    echo "</tr><tr>"; // Nueva fila para mantener el formato de la tabla
                } else {
                    echo "<tr>"; // Inicia una nueva fila
                }

                echo "<td>{$row['id']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['usuario_correo']}</td>
                        <td>{$row['mesa_id']}</td>";

                $productos = "{$row['nombre_producto']}: {$row['cantidad']} x Bs. {$row['precio_producto']}";
                $total = $row['cantidad'] * $row['precio_producto'];
                $currentDateTime = $fechaActual;
            } else {
                // Si es la misma fecha y hora, agregar producto al string
                $productos .= "<br>{$row['nombre_producto']}: {$row['cantidad']} x Bs. {$row['precio_producto']}";
                $total += $row['cantidad'] * $row['precio_producto'];
            }
        }

        // Imprimir el total para la última fecha
        if ($currentDateTime !== null) {
            echo "<td colspan='7' style='white-space: nowrap;'><div>{$productos}</div></td>"; // Combina las celdas
            echo "<td>Bs. {$total}</td>"; // Añadir total
            echo "</tr>"; // Cierre de la última fila
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
