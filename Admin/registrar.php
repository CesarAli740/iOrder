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
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .container {
            margin-top: 1rem !important;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.7);
            border-radius: 1rem;
            max-width: 70%;
            border: 1px solid white; /* Borde delgado blanco */
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

        .form-container {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            gap: 5rem;
            padding: 1rem;
            /* border: 1px solid white;
            border-radius: 1rem; */
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
            font-size: 20px;
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
            font-size:15px;
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
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 80%;
        }

        .section-title {
            color: white;
            font-size: 1rem;
            margin-bottom: 3rem;
            text-align: center;
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

        .form-select {
            border-radius: 1rem;
            width: 11rem;
            height: 3rem;
            background-color: white;
            color: black;
            font-weight: bold;
        }
    </style>
</head>
<?php include '../NAVBARiorder/index.php'; ?>

<body>
<h3 class="section-container" style="margin-top: 10rem;">Registro de nuevo usuario</h3>
    <div class="container">
        <form action="../includes/validar.php" method="POST">
            <div class="container-form">
                <div class="container-form-child">
                    <div class="section-title">
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
                </div>
                <div class="container-form-child">
                    <div class="form-group">
                        <label for="correo" class="form-label">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="form-label">Telefono *</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="container-form-child">

                <div class="row">
                    <label for="rol" class="form-label">Rol de usuario </label>
                    <div class="col-6 col-md-9">
                        <select class="form-select" type="number" id="rol" name="rol">
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

                <div class="text-center">
                    <input type="submit" value="Guardar" class="btn btn-success" name="Admin_registrar">
                    <input type="hidden" value="<?php echo $establecimiento; ?>" name="establecimiento">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>

        </form>
    </div>
    </div>


</body>

</html>