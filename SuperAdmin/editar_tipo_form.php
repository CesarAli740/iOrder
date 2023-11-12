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
?><?php
include('../includes/_db.php');

$consulta = "SELECT id, tipo FROM establecimiento_tipo";
$resultado = mysqli_query($conexion, $consulta);
$establecimientos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Establecimientos</title>
    <style>
        body {
            background-color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #1B9C85;
            text-align: center;
            font-size: 50px;
            margin-top: 50px;
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

        a {
            text-decoration: none;
            color: #1B9C85;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Lista de Establecimientos</h1>
    <table>
        <thead>
            <tr>
                <th>Establecimiento</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($establecimientos as $establecimiento) { ?>
                <tr>
                    <td><?php echo $establecimiento['tipo']; ?></td>
                    <td>
                        <a href="editar_tipo_action.php?id=<?php echo $establecimiento['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>