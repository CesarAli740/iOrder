<?php
session_start();
include '../includes/_db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo'])) {
    header('Location: ../includes/login.php');
    exit();
}

// Obtener el ID del establecimiento del usuario
$establecimiento = $_SESSION['establecimiento'];

// Verificar si el carrito está vacío
if (empty($_SESSION['carrito'])) {
    // Redirigir a alguna página indicando que el carrito está vacío
    header('Location: pagina_carrito_vacio.php');
    exit();
}

// Obtener información del carrito
$carrito = $_SESSION['carrito'];

// Obtener el ID de la mesa seleccionada
$mesa_id = $_POST['id_mesa'];

// Iniciar una transacción para asegurar la consistencia en la base de datos
$conexion->begin_transaction();

try {
    // Crear un nuevo registro de pedido con el ID de la mesa
    $queryPedido = "INSERT INTO pedidos (establecimiento_id, usuario_correo, fecha, mesa_id) 
                    VALUES ('$establecimiento', '{$_SESSION['correo']}', NOW(), '$mesa_id')";

    if ($conexion->query($queryPedido)) {
        // Obtener el ID del pedido recién insertado
        $idPedido = $conexion->insert_id;

        // Recorrer los elementos en el carrito y registrarlos en la tabla de detalles del pedido
        foreach ($carrito as $producto) {
            $idProducto = $producto['id'];
            $cantidad = $producto['cantidad'];

            $queryDetallePedido = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad) 
                                  VALUES ('$idPedido', '$idProducto', '$cantidad')";

            $conexion->query($queryDetallePedido);
        }

        // Commit para confirmar la transacción
        $conexion->commit();

        // Limpiar el carrito después de completar el pedido
        unset($_SESSION['carrito']);

        // Redirigir a la página de confirmación
        header('Location: confirmacion_pedido.php');
        exit();
    } else {
        // Si hay algún error en la inserción, hacer un rollback y redirigir a una página de error
        $conexion->rollback();
        header('Location: error_pedido.php');
        exit();
    }
} catch (Exception $e) {
    // Manejar cualquier excepción que pueda ocurrir
    $conexion->rollback();
    echo "Error al procesar el pedido: " . $e->getMessage();
}
?>
