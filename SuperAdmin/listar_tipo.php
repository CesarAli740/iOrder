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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tipos de Establecimiento</title>
</head>
<body>
    <h1>Listado de Tipos de Establecimiento</h1>
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
</body>
</html>
</html>
