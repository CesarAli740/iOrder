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
    <?php include '../NAVBARiorder/index.php'; ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Establecimiento</title>
    <style>
        /* styles.css */

        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: row;
            margin-top: 70px;
            padding: 20px;
            width: 100%;
        }

        form {
            width: 100%;
        }

        h1,
        h2,
        h3 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        label {
            color: white;
        }

        .form-control {
            width: 20%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-success {
            background-color: #ea272d;
            color: white;
        }

        .btn-success:hover {
            background-color: #7d1518;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #5f5f5f;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 80%;
            border: 1px solid #ccc;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: transparent;
        }

        /* styles.css */

        /* ... tus estilos generales ... */

        /* Estilos para las secciones abiertas al hacer clic en los botones */

        .section-title {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        /*ESTILOS DE HEADER SEARCH */
        .etiqueta {
            font-weight: bold;
            margin-right: 1rem;
        }

        .campo-texto {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 15rem;
            margin-right: 1rem;
        }

        .container-establecimiento {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 4rem;
        }
    </style>

</head>

<body>
    <h2>Buscar Establecimiento</h2>
    <div class="container">
        <form action="" method="GET">
            <div class="container-establecimiento">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control">
                <button type="submit" class="btn btn-success">Buscar</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Cancelar</button>

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