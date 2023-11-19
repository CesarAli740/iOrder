<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if ($rol != '2') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}

// Código de conexión a la base de datos (asegúrate de ajustarlo según tu configuración)
// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrar_mesas"])) {
    // Obtener datos del formulario
    $cantidadMesas = $_POST["cantidad_mesas"];
    $estadoMesas = $_POST["estado_mesas"];

    // Validar datos (puedes agregar más validaciones según tus necesidades)
    if (empty($cantidadMesas) || empty($estadoMesas)) {
        echo "Por favor, ingresa todos los campos.";
    } else {
        // Llamar a la función para agregar las mesas
        agregarMesas($cantidadMesas, $estadoMesas, $establecimiento);
    }
}

// Función para agregar nuevas mesas
function agregarMesas($cantidad, $estado, $establecimiento) {
    global $conexion;
    $establecimiento_id = $establecimiento; // Reemplaza con el valor correspondiente

    // Insertar en la base de datos
    $sql = "INSERT INTO mesas (establecimiento_id, estado) VALUES ";
    for ($i = 0; $i < $cantidad; $i++) {
        $sql .= "($establecimiento_id, '$estado'),";
    }
    $sql = rtrim($sql, ','); // Eliminar la última coma

    if ($conexion->query($sql) === TRUE) {
        echo "Mesas creadas exitosamente.";
    } else {
        echo "Error al crear mesas: " . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros mesa</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" />
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 9rem !important;
            margin: 1rem;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.7);
            border-radius: 1rem;
        }

        input {
            background-color: transparent;
            color: white;
        }

        h3 {
            color: white;
            text-align: center;
            font-size: 50px;
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
            color: white;
            margin-bottom: 20px;
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
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
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

        .text-center {
            text-align: center;
        }

        .form-select {
            border-radius: 1rem;
            width: 11rem;
            height: 3rem;
            background-color: white;
            color: black;
            font-weight: bold;
        }
        .section-container{
            margin-top: 20px;
        }

    </style>
</head>
<?php include '../NAVBARiorder/index.php'; ?>
<body>
    <div class="container">
    <div>
            <h3 class="section-container">Registro de Nuevas Mesas</h3>
        </div>
        <form action="" method="POST" class="container-form">
            <div class="container-form-child">
                <div class="form-group">
        <label for="cantidad_mesas" class="form-label">Ingrese la Cantidad de Mesas *</label>
        <input type="number" id="cantidad_mesas" name="cantidad_mesas" class="form-control" required min="1" pattern="\d+" title="Ingrese un número entero positivo">
    </div>
                <div class="form-group">
                    <label for="estado_mesas" class="form-label">Estado de las Mesas *</label>
                    <select id="estado_mesas" name="estado_mesas" class="form-select" required>
                        <option value="disponible">Disponible</option>
                        <option value="reservado">Reservado</option>
                        <option value="ocupado">Ocupado</option>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" value="Crear Mesas" class="btn btn-success" name="registrar_mesas">
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
    
    <!-- Agregamos jQuery y jQuery-confirm para el modal de confirmación -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
</body>
</html>
