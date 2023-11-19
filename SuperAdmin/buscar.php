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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuarios</title>
    <link rel="stylesheet" href="../css/stylesuser">
    <style>
    body {
        background-color: transparent;
        font-family: Arial, sans-serif;
        
    }

    .container {
        margin-top: 70px;
        margin: 0 auto;
        padding: 20px;
        max-width: 80%;
    }

    h2 {
        color: white;
        text-align: center;
        font-size: 50px;
    }

    .section-container {
        background-color: rgba(128, 128, 128, 0.7);
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem;
        margin: 50px auto; /* Ajusta el valor de margin-top según sea necesario */
        max-width: 100%;
        border: 1px solid white; /* Nuevo estilo para el borde */
    }

    .search-header {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 5rem;
    }

    .etiqueta {
        font-weight: bold;
        margin-right: 1rem;
        color: white;
        font-size: 20px;
    }

    .campo-texto {
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        width: 15rem;
        margin-right: 1rem;
        color: white;
        background-color: transparent;
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
        background-color: #7d1518;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        border: 1px solid #ccc;
        margin: auto;
        font-family: Arial, sans-serif;
    }

    th,
    td {
        color: white;
        padding: 15px;
        border: 1px solid #ccc;
        text-align: center;
        background-color: transparent;
    }

    .btn-secondary {
        background-color: #ea272d !important;
        color: white;
        text-decoration: none;
        display: inline-block;
        padding: 8px 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
        text-transform: uppercase;
    }

    .btn-secondary:hover {
        background-color: #7d1518 !important;
    }

    .text-center {
        text-align: center;
    }
</style>

</head>
<?php
include('../includes/_db.php');

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
    $SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono, permisos.rol, establecimiento_tipo.tipo
    FROM user
    LEFT JOIN permisos ON user.rol = permisos.id
    LEFT JOIN establecimiento_tipo ON user.tipo = establecimiento_tipo.id
            WHERE user.nombre LIKE '%$buscar%'
            OR user.apPAt LIKE '%$buscar%'
            OR user.apMAt LIKE '%$buscar%'
            OR user.correo LIKE '%$buscar%'
            OR user.telefono LIKE '%$buscar%'
            OR permisos.rol LIKE '%$buscar%'
            OR establecimiento_tipo.tipo LIKE '%$buscar%'";
    $dato = mysqli_query($conexion, $SQL);
}
?><?php include '../NAVBARiorder/index.php'; ?>

<body>
    <div class="container" style="margin-top: 7rem;">
    <h2>Buscar Usuario</h2>
        <div class="section-container">
            <div class="search-header">

                <form action="" method="GET">
                    <label class="etiqueta" for="buscar">Buscar:</label>
                    <input class="campo-texto" type="text" name="buscar" id="buscar">
                    <button class="boton-buscar" type="submit">BUSCAR</button>
                </form>
            </div>
            <br>
            <?php if (isset($_GET['buscar'])) : ?>
                <?php if ($dato->num_rows > 0) : ?>
                    <table>
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
                            <?php while ($fila = mysqli_fetch_array($dato)) : ?>
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
                                    <td>
                                        <?php echo $fila['tipo']; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No se encontraron resultados.</p>
                <?php endif; ?>
            <?php endif; ?>
            <div class="text-center" style="margin-top: 20px;"> <!-- Agrega margen superior para separar del formulario -->
                <a href="index.php" class="boton-buscar">REGRESAR</a> <!-- Botón para regresar a gestion.php -->
            </div>
</body>

</html>