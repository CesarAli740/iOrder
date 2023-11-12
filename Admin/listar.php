<?php
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
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
<?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <style>
        body {
           
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .container {
            margin: auto;
        margin-top: 50px;
        background-color: transparent;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: white; /* Cambia el color de texto a negro */
        width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
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
            background-color: #ea272d;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            margin: auto;
      
        background-color: transparent;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: white; /* Cambia el color de texto a negro */
        width: 100%;
           
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: rgba(128, 128, 128, 0.5);
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
        .table-header{
            margin-top: 1rem;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
 
<div class="modal-content" style="margin-top: 10rem">
        <div class="table-header">
            <h2 class="modal-title">Lista de Usuarios</h2>
            <?php include ('../includes/_db.php'); ?>
</div>
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
                            $SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono, user.tipo, permisos.rol
                            FROM user
                            LEFT JOIN permisos ON user.rol = permisos.id
                            WHERE user.rol <> 1 AND user.rol <> 2 AND user.tipo = '$establecimiento'";
                    
                            
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