<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if($rol != '1'){
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>
<?php
$mensaje = ''; 

if (isset($_POST['crear_tipo'])) {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    
    $sql = "INSERT INTO establecimiento_tipo (tipo) VALUES ('$tipo')";
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "Tipo de establecimiento registrado exitosamente.";
    } else {
        $mensaje = "Error al registrar el tipo de establecimiento: " . mysqli_error($conexion);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tipos de Establecimiento</title>
</head>
<body>
    <h1>Gestión de Tipos de Establecimiento</h1>
    
    <h2>Registrar Tipo de Establecimiento</h2>
    <form method="POST">
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" required><br>
        
        <button type="submit" name="crear_tipo">Registrar</button>
    </form>
    
</body>
</html>
