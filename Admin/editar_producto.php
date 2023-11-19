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
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .title-edit {
            font-size: 3rem;
        }

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
            font-size: 1.5rem;
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

        .form-select {
            border-radius: 1rem;
            width: 11rem;
            height: 3rem;
            background-color: white;
            color: black;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .tipo-select {
            color: white;
            margin-right: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
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

        .image-preview {
            text-align: center;
            width: 100%;
            height: 15rem;
            border-radius: 2rem;
            padding: .5rem;
        }

        .image-preview img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title-edit">Editar Producto</h1>

        <form action="procesar_edicion.php" method="POST" class="container-form" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

            <div class="container-form-child">
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input class="form-control" type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

                    <label class="form-label" for="precio">Precio:</label>
                    <input class="form-control" type="text" name="precio" value="<?php echo $producto['precio']; ?>" required>

                    <label class="tipo-select" for="tipo">Tipo:</label>
                    <select class="form-select" name="tipo" required>
                        <option value="comida" <?php echo ($producto['tipo'] === 'comida') ? 'selected' : ''; ?>>Comida</option>
                        <option value="bebida" <?php echo ($producto['tipo'] === 'bebida') ? 'selected' : ''; ?>>Bebida</option>
                        <option value="otro" <?php echo ($producto['tipo'] === 'otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>

                    <label class="form-label" for="descripcion">Descripción:</label>
                    <input class="form-control" type="text" name="descripcion" value="<?php echo $producto['descripcion']; ?>" required>


                </div>

                <div class="form-group">
                    <label class="form-label" for="imagen">Imagen:</label>
                    <input class="form-control" type="file" name="imagen" id="imagen" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .webp, .svg, .ico">
                    <!-- Vista previa de la imagen -->
                    <div class="image-preview" id="imagePreview">
                        <img src="<?php echo 'ruta_a_tu_directorio_de_imagenes' . $producto['imagen']; ?>" alt="Vista previa de la imagen" style="display: block; max-width: 100%; max-height: 200px;">
                    </div>
                    <button class="btn btn-success" type="submit">Guardar Cambios</button>
                    <a href="menu.php" class="btn btn-secondary">Cancelar</a>
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
                    imagePreview.querySelector('img').src = '<?php echo 'ruta_a_tu_directorio_de_imagenes' . $producto['imagen']; ?>';
                    imagePreview.querySelector('img').style.display = 'block';
                }
            });
        </script>
    </div>
</body>

</html>