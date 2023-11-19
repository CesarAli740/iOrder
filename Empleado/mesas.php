<?php
include '../includes/_db.php';

session_start();
$establecimiento = $_SESSION['establecimiento'];

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener los estados de las mesas para un establecimiento específico
$sql = "SELECT * FROM mesas WHERE establecimiento_id = $establecimiento";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Mesas</title>
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
            color: white;
            text-align: center;
            font-size: 50px;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        table {
            border-collapse: collapse;
            width: 60%;
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
            text-align: left;
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
<body>
    <h2>Estado de Mesas</h2>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID Mesa</th>
                    <th>Estado</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['estado']}</td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No hay mesas registradas para el establecimiento actual.";
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
