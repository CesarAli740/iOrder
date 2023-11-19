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
    <title>Listado de Establecimientos</title>
    <style>
        body{
            
        }
    /* Estilos para la tabla */
    .table-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    table {
        margin: auto;
        margin-top: 50px;
        background-color: rgba(128, 128, 128, 0.7);
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: white; /* Cambia el color de texto a negro */
        width: 80%;
    }

    th, td {
        padding: 15px;
        border: 1px solid #ccc;
        text-align: center;
    }
    
    h1,
        h2,
        h3 {
            margin-top: 300px;
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .table-header{
            margin-top: -100px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 5rem;
        }
        .btn-success {
            background-color: #1B9C85;
        }

        .btn-secondary {
            margin-top: 300px;
            background-color: #ea272d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #7d1518;
        }
</style>



</head>

<body>
<div class="table-header">
            <h2 class="modal-title">Lista de Establecimientos</h2>
            <button onclick="window.location.href='./index.php'" type="button"class="btn btn-secondary">Volver</button>
        </div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Responsable</th>
                <th>Telefono</th>
                <th>Inicio de suscripción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta = "SELECT *
                        FROM establecimiento AS e
                        INNER JOIN establecimiento_tipo AS t ON e.tipo_id = t.id";
            $resultado = mysqli_query($conexion, $consulta);
            while ($establecimiento = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $establecimiento['nombre'] . "</td>";
                echo "<td>" . $establecimiento['tipo'] . "</td>";
                echo "<td>" . $establecimiento['responsable'] . "</td>";
                echo "<td>" . $establecimiento['tel_responsable'] . "</td>";
                echo "<td>" . $establecimiento['fecha_creacion'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
