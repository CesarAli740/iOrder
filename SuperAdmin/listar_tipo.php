<?php

session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if($rol != '1'){
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tipos de Establecimiento</title>
    <style>
        body {
            background-color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 200px;
        }

        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        table {
            margin: auto;
        margin-top: 120px;
        background-color: transparent;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: white; /* Cambia el color de texto a negro */
        width: 100%;
    }

    th, td {
        padding: 15px;
        border: 1px solid #ccc;
        text-align: center;
    }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Listado de Tipos de Establecimiento</h1>
    </div>
    <div class="table-container">
        <table>
            <tr>
                <th>Tipo</th>
                <!-- Agrega más encabezados si es necesario -->
            </tr>
            <?php
            $SQL = "SELECT * FROM establecimiento_tipo";
            $result = mysqli_query($conexion, $SQL);

            if ($result->num_rows > 0) {
                while ($fila = mysqli_fetch_array($result)) {
            ?>
                    <tr>
                        <td><?php echo $fila['tipo']; ?></td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr class="text-center">
                    <td colspan="2">No existen registros</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
