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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffb16c;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            background-color: #A35E23;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #77461b;
        }
        </style>
</head>

<body>
    <div class="container">
</head>

<body>

    <h1>Confirmación de Pedido</h1>
    <p><?php echo $mensajeConfirmacion; ?></p>

    <!-- Puedes incluir más información o enlaces según tus necesidades -->

    <a href="menu.php">Volver al Menu</a>

</body>

</html>
