<?php
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if($rol != '2'){
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
    <title>Lista de Usuarios</title>
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
            margin-bottom: 50px;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Ancho máximo de la modal */
            width: 100%;
            padding: 15px;
            background-color: #fff;
            margin-top: 0; /* Eliminar el margen superior del contenido */
            margin-bottom: 0;
        }
        .modal-title {
            color: #1B9C85; /* Color de las letras en los títulos de los modales */
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

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
        }

        th, td {
            background-color: whitesmoke; /* Color de fondo de las celdas de encabezado */
            color: black; /* Color de texto en las celdas de encabezado */
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
    </style>
</head>

<body>
 
        <div class="modal-content">
        <h2 class="modal-title">Lista de Usuarios</h2> 
            <?php include ('../includes/_db.php'); ?>

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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $loggedInUserId = $_SESSION['id']; 
                            $SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono, permisos.rol
                            FROM user
                            LEFT JOIN permisos ON user.rol = permisos.id
                            WHERE user.rol <> 1 AND user.rol <> 2 ";
                    
                            
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