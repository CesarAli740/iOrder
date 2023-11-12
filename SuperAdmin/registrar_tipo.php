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
    <?php include '../NAVBARiorder/index.php'; ?>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tipos de Establecimiento</title>
    <style>
        /* Estilos generales */
        body {
            background-color: white;
            margin: 0;
            font-family: Arial, sans-serif;
            color: black;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 200px;
        }

        h1, h2, h3 {
            color: black;
            text-align: center;
            font-size: 50px;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #1B9C85;
            color: #fff;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #ccc;
        }

        .results {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Gestión de Tipos de Establecimiento</h1>
    <div class="center-container"> <!-- Contenedor para centrar el formulario -->
        <div class="form-container"> <!-- Formulario -->
            <h2>Registrar Tipo de Establecimiento</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <input type="text" name="tipo" class="form-control" required>
                </div>
                <button type="submit" name="crear_tipo" class="btn">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>
