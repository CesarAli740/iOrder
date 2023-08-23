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
}// Procesar el formulario al enviar
if(isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $tipo = $_POST['tipo'];

    // Insertar en la base de datos
    $insertar = "INSERT INTO establecimiento (nombre, ubicacion, tipo_id) VALUES ('$nombre', '$ubicacion', '$tipo')";
    if(mysqli_query($conexion, $insertar)) {
        // Redirigir después de la inserción exitosa
        header("Location: nuevo_establecimiento.php");
        exit();
    } else {
        $error_message = "Error al insertar en la base de datos: " . mysqli_error($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de nuevo establecimiento</title>
    <style>
        body {
            background-color: #ECF8F9;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
            padding: 10px; /* Reducir el padding general */
            margin-top: 50px; /* Reducir el margen superior */
            margin-bottom: 50px; /* Reducir el margen superior */
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px; /* Reducido el ancho máximo */
            width: 100%;
            padding: 15px; /* Reducido el padding */
            background-color: #fff;
            margin-top: 0; /* Eliminar el margen superior del contenido */
            margin-bottom: 0; 

        }

        .card-title {
            color: #1B9C85;
            font-size: 1.5rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        }

        .btn-success {
            background-color: #1B9C85;
        }

        .btn-secondary {
            background-color: #ccc;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="modal-content">
        <h3 class="card-title">Registro de nuevo establecimiento</h3>
        <?php if(isset($error_message)) { ?>
            <div style="color: red;"><?php echo $error_message; ?></div>
        <?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ubicacion" class="form-label">Ubicación *</label>
                <input type="text" id="ubicacion" name="ubicacion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tipo" class="form-label">Tipo *</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <?php
                    $SQL = "SELECT * FROM establecimiento_tipo";
                    $dato = mysqli_query($conexion, $SQL);
                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato)) {
                            ?>
                            <option value="<?php echo $fila['id']; ?>"><?php echo $fila['tipo']; ?></option>
                            <?php
                        }
                    } else {
                        ?>
                        <option value="">No Existen Registros</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="text-center">
                <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</body>


</html>
