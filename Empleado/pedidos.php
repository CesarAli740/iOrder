<?php
include '../includes/_db.php';

session_start();
$establecimiento = $_SESSION['establecimiento'];

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
date_default_timezone_set('America/La_Paz');

$fecha_actual = date('Y-m-d');

// Consulta para obtener los pedidos del día actual para un establecimiento específico
$sql = "SELECT pedidos.*, detalles_pedido.*, menu.nombre as nombre_producto, menu.precio, mesas.id as id_mesa
        FROM pedidos
        JOIN detalles_pedido ON pedidos.id = detalles_pedido.pedido_id
        JOIN menu ON detalles_pedido.producto_id = menu.id
        JOIN mesas ON pedidos.mesa_id = mesas.id
        WHERE pedidos.fecha LIKE '$fecha_actual%' 
        AND menu.establecimiento_id = $establecimiento";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos del Día</title>
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
            margin-top: 100px;
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
            background-color: rgba(128, 128, 128, 0.7);
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
<?php include '../NAVBARiorder/index.php'; ?>
<br><br><br><br><br><br><br><br>
<body>
    <?php
    if ($result->num_rows > 0) {
        echo "<div class='container'>";
        echo "<h2>Pedidos del Día</h2>";
        echo "<table>
                <tr>
                    <th>Fecha</th>
                    <th>Mesa</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['fecha']}</td>
                    <td>{$row['id_mesa']}</td>
                    <td>{$row['nombre_producto']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>{$row['precio']}</td>
                </tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "No hay pedidos para el día actual.";
    }
    ?>

    <!-- Botón Volver -->
    <div class="volver-button">
    <a href="index.php">
        <button>Volver</button>
    </a>
</div>
</body>
</html>

<?php
$conexion->close();
?>