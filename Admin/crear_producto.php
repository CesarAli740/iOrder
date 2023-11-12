<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$validar = isset($_SESSION['correo']) ? $_SESSION['correo'] : '';
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if ($rol != '2') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
include '../NAVBARiorder/index.php';
?>
<br><br><br><br><br><br><br>
<?php


// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_producto'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $imagen = $_FILES['imagen'];

    if ($imagen['error'] !== 0) {
        echo "Se ha producido un error al subir la imagen.";
    } else {
        $nombreArchivo = $imagen['name'];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        $nombreUnico = uniqid() . '.' . $extension;

        $rutaDestino = 'menu/' . $nombreUnico;

        move_uploaded_file($imagen['tmp_name'], $rutaDestino);

        $query = "INSERT INTO menu (nombre, precio, tipo, imagen, establecimiento_id) VALUES ('$nombre', $precio, '$tipo', '$nombreUnico', '$establecimiento')"; // Asigna el establecimiento_id según tu lógica

        if (mysqli_query($conexion, $query)) {
            echo "Producto creado exitosamente.";
        } else {
            echo "Error al crear el producto: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
</head>

<body>
    <h1>Crear Producto</h1>
    <form action="crear_producto.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" required>
        <label for="tipo">Tipo:</label>
<select name="tipo" required>
    <option value="comida">Comida</option>
    <option value="bebida">Bebida</option>
    <option value="otro">Otro</option>
</select>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" accept="image/*" required>

        <input type="submit" name="crear_producto" value="Crear Producto">
    </form>
</body>

</html>
