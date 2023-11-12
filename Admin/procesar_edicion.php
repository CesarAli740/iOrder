<?php
include '../includes/_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];

    // Puedes agregar más campos aquí según tu estructura de base de datos

    $query = "UPDATE menu SET nombre = '$nombre', precio = $precio, tipo = '$tipo' WHERE id = $producto_id";
    $result = $conexion->query($query);

    if ($result) {
        echo "¡Producto actualizado con éxito!";
        header("Location: menu.php");
    } else {
        echo "Error al actualizar el producto: " . $conexion->error;
    }
} else {
    echo "Acceso no permitido.";
}
?>
