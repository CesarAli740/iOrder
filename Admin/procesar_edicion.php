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

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Obtener los datos del formulario
    $producto_id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    // Obtener la información del producto desde la base de datos
    $query = "SELECT * FROM menu WHERE id = $producto_id";
    $result = $conexion->query($query);

    if ($result) {
        $producto = $result->fetch_assoc();

        // Guardar el nombre de la antigua imagen
        $oldImagen = $producto['imagen'];

        // Actualizar los campos del producto
        $producto['nombre'] = $nombre;
        $producto['precio'] = $precio;
        $producto['tipo'] = $tipo;
        $producto['descripcion'] = $descripcion;

        // Actualizar la imagen solo si se selecciona una nueva
        if ($_FILES['imagen']['error'] === 0) {
            $imagen = $_FILES['imagen'];

            $nombreArchivo = $imagen['name'];
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

            // Verificar la extensión del archivo
            $allowed_extensions = ["jpg", "jpeg", "png", "gif", "bmp", "tiff", "webp", "svg", "ico"];

            if (in_array(strtolower($extension), $allowed_extensions)) {
                $nombreUnico = uniqid() . '.' . $extension;

                $rutaDestino = 'menu/' . str_replace(' ', '_', $nombreUnico);

                // Mover la nueva imagen al directorio
                move_uploaded_file($imagen['tmp_name'], $rutaDestino);

                // Actualizar la referencia de la imagen en la base de datos
                $producto['imagen'] = $nombreUnico;

                // Eliminar la antigua imagen
                if (!empty($oldImagen) && file_exists('menu/' . $oldImagen)) {
                    unlink('menu/' . $oldImagen);
                }
            }
        }

        // Actualizar los datos en la base de datos
        $query_update = "UPDATE menu SET nombre=?, precio=?, tipo=?, descripcion=?, imagen=? WHERE id=?";
        $stmt = mysqli_prepare($conexion, $query_update);
        mysqli_stmt_bind_param($stmt, "sssssi", $producto['nombre'], $producto['precio'], $producto['tipo'], $producto['descripcion'], $producto['imagen'], $producto_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Producto actualizado exitosamente.";
            header("Location: ./menu.php");
        } else {
            echo "Error al actualizar el producto: " . mysqli_error($conexion);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al obtener la información del producto.";
    }
}
?>