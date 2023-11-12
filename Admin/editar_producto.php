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

// Obtener el ID del producto a editar
$producto_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Obtener los detalles del producto desde la base de datos
$query = "SELECT * FROM menu WHERE id = $producto_id";
$result = $conexion->query($query);

if ($result) {
    $producto = $result->fetch_assoc();
} else {
    // Manejar el caso en que el producto no se encuentre
    echo "Producto no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Producto</title>
    <!-- Agrega cualquier estilo adicional que necesites -->
</head>
<br><br><br><br><br><br><br><br>
<body>

    <h1>Editar Producto</h1>

    <form action="procesar_edicion.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

        <label for="precio">Precio:</label>
        <input type="text" name="precio" value="<?php echo $producto['precio']; ?>" required>

        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" value="<?php echo $producto['tipo']; ?>" required>

        <!-- Agrega otros campos según tus necesidades -->

        <button type="submit">Guardar Cambios</button>
    </form>

</body>

</html>
