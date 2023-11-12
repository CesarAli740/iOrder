<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo'])) {
    header('Location: ../includes/login.php');
    exit();
}

// Puedes personalizar el mensaje de confirmación según tus necesidades
$mensajeConfirmacion = "¡Gracias por realizar tu pedido! Tu pedido se ha registrado correctamente.";

// Puedes mostrar información adicional, como el número de pedido, detalles, etc.

// Puedes también incluir enlaces a otras partes de tu aplicación

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
</head>

<body>

    <h1>Confirmación de Pedido</h1>
    <p><?php echo $mensajeConfirmacion; ?></p>

    <!-- Puedes incluir más información o enlaces según tus necesidades -->

    <a href="menu.php">Volver al Menu</a>

</body>

</html>
