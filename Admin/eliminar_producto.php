<?php
// Conexión a la base de datos
include '../includes/_db.php';

// Verificar si se ha proporcionado un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar la base de datos para obtener información del producto
    $query = "SELECT * FROM menu WHERE id = $id";
    $result = $conexion->query($query);

    if ($result && $result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Eliminar el producto si se confirma
        if (isset($_POST['confirmar_eliminar'])) {
            $queryEliminar = "DELETE FROM menu WHERE id = $id";
            $resultadoEliminar = $conexion->query($queryEliminar);

            if ($resultadoEliminar) {
                // Redireccionar después de la eliminación
                header("Location: menu.php");
                exit();
            } else {
                echo "Error al eliminar el producto: " . $conexion->error;
            }
        }
    } else {
        echo "No se encontró ningún producto con ese ID.";
        exit();
    }
} else {
    echo "ID de producto no válido.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Eliminar Producto</h1>
    <p>¿Estás seguro de que quieres eliminar el siguiente producto?</p>
    <p><strong>Nombre:</strong> <?php echo $producto['nombre']; ?></p>
    <p><strong>Precio:</strong> $<?php echo $producto['precio']; ?></p>
    <p><strong>Tipo:</strong> <?php echo $producto['tipo']; ?></p>

    <form method="post">
        <input type="submit" name="confirmar_eliminar" value="Confirmar Eliminar">
    </form>

    <a href="menu.php">Volver al Menú</a>
</body>

</html>
