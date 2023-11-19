<?php

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
<html lang="es">

<head>
?><?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuarios</title>
    <style>
        /* styles.css */

        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
    margin: 0 auto;
    padding: 20px;
    background-color: rgba(128, 128, 128, 0.7);
    border-radius: 1rem;
    max-width: 80%;
    border: 1px solid white; /* Borde delgado blanco */
}

/* Otros estilos permanecen igual */


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

        label {
            color: white;
            font-size: 30px;
        }

        .form-control {
            margin-left: 700px;
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
            text-decoration: none;
            width: 8rem;
            border-radius: 1rem;
        }

        .text-center {
            text-align: center;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 80%;
            border: 1px solid #ccc;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        th, td {
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: transparent;    
    }

        /* styles.css */

        /* ... tus estilos generales ... */

        /* Estilos para las secciones abiertas al hacer clic en los botones */
        .section-container {
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            margin: 20px auto;
            /* Ajusta el ancho máximo según tu preferencia */
        }

        .section-title {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .search-header{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 5rem;
        }
        /*ESTILOS DE HEADER SEARCH */
        .etiqueta {
            font-weight: bold;
            margin-right: 1rem;
        }

        .campo-texto {
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            width: 15rem;
            margin-right: 1rem;
        }

        .boton-buscar {
            background-color: #ea272d;
        color: #fff;
        padding: 8px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px; /* Ajusta el tamaño del texto */
        font-weight: bold;
        }

        .boton-buscar:hover {
            background-color: #0056b3;
        }
        .container-search{
            display: flex;
            justify-content: space-evenly;
        }
        .input-search{
            border-radius: 1rem;
            font-size: 17px;
            border: 2px solid #ccc;
        }
    </style>
</head>
<?php
include('../includes/_db.php');

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
    $SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono, user.tipo, permisos.rol
    FROM user
    LEFT JOIN permisos ON user.rol = permisos.id
    WHERE (user.nombre LIKE '%$buscar%'
        OR user.apPAt LIKE '%$buscar%'
        OR user.apMAt LIKE '%$buscar%'
        OR user.correo LIKE '%$buscar%'
        OR user.telefono LIKE '%$buscar%'
        OR permisos.rol LIKE '%$buscar%')
    AND user.rol <> 1
    AND user.rol <> 2
    AND user.tipo = '$establecimiento'";

    $dato = mysqli_query($conexion, $SQL);
}
?>

<body> 
<h2 class="search-header" style="margin-top: 10rem;">Buscar un Usuario</h2>
<div class="container" style="margin-top: 3rem;">
    <div class="col-xs-12">
        <form action="" method="GET">
            <div class="container-search">
                <label for="buscar">Buscar Usuario:</label>
                <input class="input-search" type="text" name="buscar" id="buscar">
                <button class="boton-buscar" type="submit">BUSCAR</button>
            </div>
        </form>
        <br>
        <?php if (isset($_GET['buscar'])): ?>
            <?php if ($dato->num_rows > 0): ?>
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
                        <?php while ($fila = mysqli_fetch_array($dato)): ?>
                            <tr>
                                <td>
                                    <?php echo $fila['nombre']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['apPAt']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['apMAt']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['correo']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['telefono']; ?>
                                </td>
                                <td>
                                    <?php echo $fila['rol']; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron resultados.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>



</body>


</html>