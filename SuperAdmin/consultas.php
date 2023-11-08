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

    // Query para insertar los datos en la tabla establecimiento
    $query = "INSERT INTO establecimiento (nombre, tipo_id, latitud, longitud, responsable, tel_responsable) VALUES ('$nombre', '$tipo', '$latitud', '$longitud', '$responsable', '$numeroResponsable')";

    // Ejecutar el query
    if (mysqli_query($conexion, $query)) {
        header("Location: index.php");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        echo "Error al registrar el establecimiento: " . mysqli_error($conexion);
    }
}

if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
    // Ruta donde se guardará el archivo
    $uploadDir = '../logos/'; // Reemplaza esto con la ruta adecuada en tu servidor

    // Obtener el nombre original del archivo
    $logoName = $_FILES['logo']['name'];

    // Ruta completa del archivo en el servidor
    $uploadFile = $uploadDir . $logoName;

    // Mover el archivo cargado al destino
    if(move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
        // El archivo se ha cargado correctamente, ahora puedes guardar el nombre del archivo en la base de datos o realizar otras operaciones necesarias.
        echo 'El archivo se ha cargado correctamente.';
    } else {
        echo 'Error al cargar el archivo.';
    }
} else {
    echo 'No se ha seleccionado ningún archivo.';
} 
?>
