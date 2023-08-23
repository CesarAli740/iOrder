<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if ($rol != '1') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        body {
            background-color: #ECF8F9;
            margin: 0;
            font-family: Arial, sans-serif;

        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        .modal-title {
            color: #1B9C85;
            font-size: 1.5rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
            /* Alinear contenido a la izquierda */
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-right: 10px;
            /* Ajustar margen derecho */
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
        <h3 class="modal-title">Registro de nuevo usuario</h3>
        <form action="../includes/validar.php" method="POST">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apPAt" class="form-label">Apellido Paterno *</label>
                <input type="text" id="apPAt" name="apPAt" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apMAt" class="form-label">Apellido Materno *</label>
                <input type="text" id="apMAt" name="apMAt" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label for="telefono" class="form-label">Telefono *</label>
                <input type="tel" id="telefono" name="telefono" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="text-center">
                <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</body>

</html>