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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
            padding: 10px;
            /* Reducir el padding general */
            margin-top: 50px;
            /* Reducir el margen superior */
            margin-bottom: 50px;
            /* Reducir el margen superior */
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            /* Reducido el ancho máximo */
            width: 100%;
            padding: 15px;
            /* Reducido el padding */
            background-color: #fff;
            margin-top: 0;
            /* Eliminar el margen superior del contenido */
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
        <h3 class="card-title">Registro de nuevo usuario</h3>
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

            <div class="form-group">
                <label for="rol" class="form-label">Rol de usuario </label>
                <div class="container">
                    <div class="row">
                        <div class="col-6 col-md-9">
                            <select class="form-select " type="number" id="rol" name="rol">
                                <?php
                                $SQL = "SELECT * FROM permisos WHERE id <> 1 AND id <> 2;";
                                $dato = mysqli_query($conexion, $SQL);
                                if ($dato->num_rows > 0) {
                                    while ($fila = mysqli_fetch_array($dato)) {
                                        ?>
                                        <option value="<?php echo $fila['id']; ?>"><?php echo $fila['rol']; ?></option>
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
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="submit" value="Guardar" class="btn btn-success" name="Admin_registrar">
                <input type="hidden" value="<?php echo $establecimiento; ?>" name="establecimiento">
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
    </div>


</body>

</html>