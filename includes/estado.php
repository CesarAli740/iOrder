<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    $conexion = mysqli_connect("localhost", "root", "", "CMIE");

    if (mysqli_connect_errno()) {
        echo "Error al conectar con la base de datos: " . mysqli_connect_error();
        exit();
    }

    $consulta = "UPDATE user SET estado = '$estado' WHERE id = '$id'";
    if (mysqli_query($conexion, $consulta)) {
        echo "Consulta ejecutada correctamente.";
    } else {
        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }
    mysqli_close($conexion);
}
