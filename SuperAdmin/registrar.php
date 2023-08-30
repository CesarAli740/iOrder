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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 70px;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        input {
            background-color: transparent;
            color: white;
        }


        h1,
        h2,
        h3 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .form-group {
            color: white;
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
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
            background-color: #1B9C85;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .section-container {
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 80%;
        }

        .section-title {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>

</head>
<?php include '../NAVBARiorder/index.php'; ?>

<body>
    <div class="container" style="margin-top: 5rem;">
        <div class="section-container">
            <h2 class="section-title">Registrar Usuario</h2>
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
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="telefono" class="form-label">Telefono *</label>
                    <input type="tel" id="telefono" name="telefono" class="form-control" required>
                </div>
                <?php
                $query = "SELECT id, nombre FROM establecimiento";
                $resultado = $conexion->query($query);
                ?>
                <div class="form-group">
                    <label for="establecimiento" class="form-label">Establecimiento *</label>
                    <select type='text' id="establecimiento" name="establecimiento" class="form-control" required>
                        <option value="" disabled selected>Selecciona un Establecimiento</option>
                        <?php
                        while ($fila = $resultado->fetch_assoc()) {
                            echo '<option value="' . $fila["id"] . '">' . $fila["nombre"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="text-center">
                    <input type="submit" value="Guardar" class="btn btn-success" name="registrar"><button
                        onclick="window.location.href='./gestion.php'" type="button"
                        class="btn btn-secondary">Cancelar</button>

                </div>
            </form>
        </div>
    </div>
</body>

</html>