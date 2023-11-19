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

// Variable para determinar si se ha realizado la búsqueda
$busqueda_realizada = false;
$resultado = null;

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $consulta = "SELECT *
                 FROM establecimiento AS e
                 INNER JOIN establecimiento_tipo AS t ON e.tipo_id = t.id
                 WHERE e.nombre LIKE '%$nombre%'";
    $resultado = mysqli_query($conexion, $consulta);
    
    // Si se encontraron resultados, establecer la variable de búsqueda a verdadero
    $busqueda_realizada = mysqli_num_rows($resultado) > 0;
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
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: rgba(128, 128, 128, 0.7);
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        margin: 50px auto; /* Ajusta el valor de margin-top según sea necesario */
        max-width: 80%;
        border: 1px solid white; /* Nuevo estilo para el borde */
        }

        h2 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: white;
            font-size:20px;
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
            padding: 10px 20px;
        }

        .btn-success {
            padding: 10px 20px;
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

        table {
            border-collapse: collapse;
            width: 80%;
            border: 1px solid #ccc;
            margin: auto;
            font-family: Arial, sans-serif;
            background-color: rgba(128, 128, 128, 0.7);
            margin-top: 20px; /* Ajuste de margen superior */
            border-radius: 10px;
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: transparent;
        }

        .results {
            margin-top: 20px; /* Ajuste de margen superior */
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
    <h2 style="margin-top: 10rem;">Buscar Establecimiento</h2>
    <div class="container">
        <form action="" method="GET">
            <div class="container-establecimiento" >
                <label for="nombre" class="form-label">Nombre Establecimiento:</label>
                <input type="text" id="nombre" name="nombre" class="form-control">
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>
        
        <?php
        // Verificar si se ha realizado una búsqueda antes de imprimir la tabla
        if ($busqueda_realizada) {
        ?>
        <div class="results">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Imprimir resultados de la búsqueda
                    while ($establecimiento = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $establecimiento['nombre'] . "</td>";
                        echo "<td>" . $establecimiento['tipo'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        }
        ?>
<div class="container-establecimiento" style="text-align: center; margin-top: 20px;">
    <button type="button" class="btn btn-success" onclick="window.location.href='index.php'">Regresar</button>
</div>


    </div>
</body>

</html>