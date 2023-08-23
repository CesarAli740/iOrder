<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if ($rol != '1') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Establecimientos</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Listado de Establecimientos</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta = "SELECT e.nombre, e.ubicacion, t.tipo 
                        FROM establecimiento AS e
                        INNER JOIN establecimiento_tipo AS t ON e.tipo_id = t.id";
            $resultado = mysqli_query($conexion, $consulta);
            while ($establecimiento = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $establecimiento['nombre'] . "</td>";
                echo "<td>" . $establecimiento['ubicacion'] . "</td>";
                echo "<td>" . $establecimiento['tipo'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
