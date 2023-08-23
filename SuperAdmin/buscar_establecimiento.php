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
    <title>Buscar Establecimiento</title>
    <style>
        /* Estilos para el formulario */
        .form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #1B9C85;
            color: #fff;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #ccc;
        }

        .results {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Buscar Establecimiento</h2>
    <div class="form-container">
        <form action="" method="GET">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Buscar</button>
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>

    <div class="results">
        <h3>Resultados de la búsqueda:</h3>
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
                if (isset($_GET['nombre'])) {
                    $nombre = $_GET['nombre'];
                    $consulta = "SELECT e.nombre, e.ubicacion, t.tipo 
                                 FROM establecimiento AS e
                                 INNER JOIN establecimiento_tipo AS t ON e.tipo_id = t.id
                                 WHERE e.nombre LIKE '%$nombre%'";
                    $resultado = mysqli_query($conexion, $consulta);
                    while ($establecimiento = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $establecimiento['nombre'] . "</td>";
                        echo "<td>" . $establecimiento['ubicacion'] . "</td>";
                        echo "<td>" . $establecimiento['tipo'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
