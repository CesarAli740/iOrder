<?php

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
<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../css/stylesuser">
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 7%;
        }

        h1,
        h2,
        h3 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .form-group {
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

        /* styles.css */

        /* ... tus estilos generales ... */

        /* Estilos para las secciones abiertas al hacer clic en los botones */
        .section-container {
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 80%;
            /* Ajusta el ancho máximo según tu preferencia */
        }

        .section-title {
            color: #1B9C85;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="modal-content" style="margin-top: 7rem">
        <h2 class="modal-title">Lista de Usuarios</h2>
        <?php include('../includes/_db.php'); ?>

        <div class="container is-fluid">
            <div class="col-xs-12"><br>

                <table id="table_id">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Rol</th>
                            <th>Establecimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono, permisos.rol, establecimiento_tipo.tipo
                            FROM user
                            LEFT JOIN permisos ON user.rol = permisos.id
                            LEFT JOIN establecimiento_tipo ON user.tipo = establecimiento_tipo.id";
                        $dato = mysqli_query($conexion, $SQL);

                        if ($dato->num_rows > 0) {
                            while ($fila = mysqli_fetch_array($dato)) {
                        ?>
                                <tr>
                                    <td><?php echo $fila['nombre']; ?></td>
                                    <td><?php echo $fila['apPAt']; ?></td>
                                    <td><?php echo $fila['apMAt']; ?></td>
                                    <td><?php echo $fila['correo']; ?></td>
                                    <td><?php echo $fila['telefono']; ?></td>
                                    <td><?php echo $fila['rol']; ?></td>
                                    <td><?php echo $fila['tipo']; ?></td>
                                </tr>
                            <?php
                            }
                        } else { ?>
                            <tr class="text-center">
                                <td colspan="7">No existen registros</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

</body>

</html>