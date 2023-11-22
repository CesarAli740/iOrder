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

// Consulta para obtener las reservas del día actual para una mesa y establecimiento específicos
$sql = "SELECT reservas.*, mesas.establecimiento_id 
        FROM reservas 
        INNER JOIN mesas ON reservas.mesa_id = mesas.id
        WHERE reservas.fecha_hora_reserva LIKE '$fecha_actual%' 
        AND mesas.establecimiento_id  = $establecimiento";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas del Día</title>
    <style>
        body {
            
            margin-top: 50px;
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            margin-top: 40px;
            color: white;
            text-align: center;
            font-size: 50px;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
        }

        th, td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: rgba(128, 128, 128, 0.5);
        }

        /* Estilo para el botón Volver */
        .volver-button {
            margin-top: 20px;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #ea272d;
        }

        button:hover {
            background-color: #7d1518;
        }
    </style>
</head>
<?php include '../NAVBARiorder/index.php'; ?>
<br><br><br><br><br><br><br>
<body>
    <h2>Reservas del Día</h2>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID Reserva</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Fecha Reserva</th>
                    <th>Mesa</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cliente_nombre']}</td>
                    <td>{$row['cliente_email']}</td>
                    <td>{$row['cliente_telefono']}</td>
                    <td>{$row['fecha_hora_reserva']}</td>
                    <td>{$row['mesa_id']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No hay reservas para el día actual.";
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
