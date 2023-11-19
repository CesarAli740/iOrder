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

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_producto'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion']; // Nuevo campo
    $imagen = $_FILES['imagen'];

    if ($imagen['error'] !== 0) {
        echo "Se ha producido un error al subir la imagen.";
    } else {
        $nombreArchivo = $imagen['name'];
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        // Verificar la extensión del archivo
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "bmp", "tiff", "webp", "svg", "ico"];

        if (!in_array(strtolower($extension), $allowed_extensions)) {
            echo "Por favor, seleccione un archivo de imagen válido.";
        } else {
            $nombreUnico = uniqid() . '.' . $extension;

            $rutaDestino = 'menu/' . str_replace(' ', '_', $nombreUnico);

            move_uploaded_file($imagen['tmp_name'], $rutaDestino);

            // Consulta preparada para evitar inyección SQL
            $query = "INSERT INTO menu (nombre, precio, tipo, descripcion, imagen, establecimiento_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $query);
            mysqli_stmt_bind_param($stmt, "sdsiss", $nombre, $precio, $tipo, $descripcion, $nombreUnico, $establecimiento);

            if (mysqli_stmt_execute($stmt)) {
                echo "Producto creado exitosamente.";
            } else {
                echo "Error al crear el producto: " . mysqli_error($conexion);
            }

            mysqli_stmt_close($stmt);
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
    <style>
        .container {
            margin-top: 9rem !important;
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
            margin-top: 10px;
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
            color: black;
        }
        .form-control-image{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
            color: white;
        }

        .form-select {
            border-radius: 1rem;
            width: 11rem;
            height: 3rem;
            background-color: white;
            color: black;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .btn-success {
            background-color: #ea272d !important;
            color: white;
            margin-right: 1rem;
        }

        .btn-success:hover {
            background-color: #7d1518 !important;
        }

        .btn-secondary {
            background-color: #ccc !important;
            color: #333;
            margin-left: 1rem;
            text-decoration: none !important;
        }

        .btn-secondary:hover {
            background-color: #5f5f5f !important;
        }

        .image-preview {
            margin-top: 10px;
            text-align: center;
        }

        .image-preview {
            text-align: center;
            width: 100%;
            height: 15rem;
            border-radius: 2rem;
            padding: .5rem;
            margin-bottom: 3rem;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
        }

        .form-group label {
            color: white;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Crear Producto</h1>
        <form action="crear_producto.php" method="post" enctype="multipart/form-data">
            <div class="container-form">
                <div class="container-form-child">
                    <div class="form-group">
                        <label class="form-label" for="nombre">Nombre:</label>
                        <input class="form-control" type="text" name="nombre" required>

                        <label class="form-label" for="precio">Precio:</label>
                        <input class="form-control" type="number" name="precio" required>

                        <label for="tipo">Tipo:</label>
                        <select class="form-select" name="tipo" required>
                            <option value="comida">Comida</option>
                            <option value="bebida">Bebida</option>
                            <option value="otro">Otro</option>
                        </select>

                        <label class="form-label" for="descripcion">Descripción:</label>
                        <input class="form-control" type="text" name="descripcion" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="imagen">Imagen:</label>
                        <input class="form-control-image" type="file" name="imagen" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .webp, .svg, .ico" required>
                        <div class="image-preview" id="imagePreview">
                            <img src="#" alt="Vista previa de la imagen">
                        </div>

                        <input class="btn btn-success" type="submit" name="crear_producto" value="Crear Producto">
                        <a href="menu.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>

        <script>
            const inputImage = document.querySelector('input[name="imagen"]');
            const imagePreview = document.getElementById('imagePreview');

            inputImage.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener('load', function() {
                        imagePreview.querySelector('img').src = reader.result;
                        imagePreview.querySelector('img').style.display = 'block';
                    });

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.querySelector('img').src = '#';
                    imagePreview.querySelector('img').style.display = 'none';
                }
            });
        </script>
    </div>
</body>

</html>