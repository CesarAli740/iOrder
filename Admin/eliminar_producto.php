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
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 11rem !important;
            margin: 1rem;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.7);
            border-radius: 1rem;
            color: white;
            text-align: center;
        }

        .container-form {
            display: flex;
            justify-content: space-around;
            align-items: stretch;
            flex-direction: column;
        }

        .container-form-child {
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-align: center;
        }

        .form-group {
            color: black;
            margin-bottom: 2rem;
            width: 25%;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 2rem;
            color: white;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 2rem;
            background-color: transparent;
            color: white;
        }

        .btn-success {
            background-color: #ea272d !important;
            color: white;
            margin-right: 1rem;
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-success:hover {
            background-color: #7d1518 !important;
        }

        .btn-secondary {
            background-color: #ccc !important;
            color: #333;
            margin-left: 1rem;
            text-decoration: none !important;
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-secondary:hover {
            background-color: #5f5f5f !important;
        }
        .h1-label{
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .p-label{
            font-size: 1.5rem;
            margin: 2.5rem;
        }
        p{
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
    </style>
</head>
<?php include '../NAVBARiorder/index.php'; ?>
<body>
    <div class="container">
        <h1 class="h1-label">Eliminar Producto</h1>
        <p class="p-label">¿Estás seguro de que quieres eliminar el siguiente producto?</p>
        <p><strong >Nombre:</strong> <?php echo $producto['nombre']; ?></p>
        <p><strong>Precio:</strong> $<?php echo $producto['precio']; ?></p>
        <p><strong>Tipo:</strong> <?php echo $producto['tipo']; ?></p>

        <form method="post" class="container-form">
            <div class="container-form-child">
                <input class="btn btn-success" type="submit" name="confirmar_eliminar" value="Confirmar Eliminar">
                <a href="menu.php" class="btn btn-secondary">Volver al Menú</a>
            </div>
        </form>
    </div>
</body>

</html>
