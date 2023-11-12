<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['producto_id'])) {
        $producto_id = $_POST['producto_id'];

        // Obtener el carrito actual de la sesión
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

        // Buscar el índice del producto en el carrito
        $index = array_search($producto_id, array_column($carrito, 'id'));

        // Si se encuentra el producto, eliminarlo del carrito
        if ($index !== false) {
            unset($carrito[$index]);
            // Reindexar el array para evitar índices no consecutivos
            $carrito = array_values($carrito);
            $_SESSION['carrito'] = $carrito;
        }
    }
}

// Redirigir de nuevo a la página del carrito
header('Location: ver_carrito.php');
exit();
?>
