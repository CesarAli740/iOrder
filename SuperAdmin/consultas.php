<?php
// Verificar si se ha enviado el formulario
include '../includes/_db.php';
if (isset($_POST['crear_establecimiento'])) {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $latitud = $_POST["latitud"];
    $longitud = $_POST["longitud"];
    $responsable = $_POST["responsable"];
    $numeroResponsable = $_POST["tel_responsable"];
    $tipo = $_POST["tipo"];

    $imagen = $_FILES["imagen"];

    // Validar que se haya seleccionado una imagen
    if ($imagen["error"] != 0) {
        echo "Se ha producido un error al subir la imagen.";
    } else {

        // Obtener el nombre del archivo
        $nombre_archivo = $imagen["name"];

        // Obtener la extensión del archivo
        $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

        // Validar que la extensión del archivo sea válida
        if (!in_array($extension, ["jpg", "jpeg", "png"])) {
            echo "El archivo no es una imagen válida.";
        } else {

            // Guardar la imagen en el servidor
            $nombreb = str_replace(' ', '_', $nombre);
            $ruta_archivo = "logos/" . $nombreb . 'logo'. '.' . $extension;
            move_uploaded_file($imagen["tmp_name"], $ruta_archivo);

            // Insertar la imagen en la base de datos
            $query = "INSERT INTO establecimiento (nombre, tipo_id, latitud, longitud, responsable, tel_responsable, logo) VALUES ('$nombre', '$tipo', '$latitud', '$longitud', '$responsable', '$numeroResponsable', '$ruta_archivo')";
            $resultado = $conexion->query($query);

            if ($resultado) {
                echo "La imagen se ha subido correctamente.";
                
        header("Location: index.php");
            } else {
                echo "Se ha producido un error al guardar la imagen en la base de datos.";
            }

        }

    }
}

?>