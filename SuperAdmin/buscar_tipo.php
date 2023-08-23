<?php

session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if($rol != '1'){
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}

if (isset($_POST['buscar_tipo'])) {
    $buscar = $_POST['buscar'];
    
    $SQL = "SELECT * FROM establecimiento_tipo WHERE tipo LIKE '%$buscar%'";
    $result = mysqli_query($conexion, $SQL);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Tipos de Establecimiento</title>
</head>
<body>
    <h1>Buscar Tipos de Establecimiento</h1>
    
    <form method="POST">
        <label for="buscar">Buscar por Tipo:</label>
        <input type="text" name="buscar" required>
        <button type="submit" name="buscar_tipo">Buscar</button>
    </form>
    
    <!-- Mostrar resultados de la búsqueda -->
    <?php if (isset($result) && $result->num_rows > 0) { ?>
        <table >
            <tr>
                <th>Tipo</th>
            </tr>
            <?php while ($fila = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $fila['tipo']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } elseif (isset($result)) { ?>
        <p>No se encontraron resultados</p>
    <?php } ?>
</body>
</html>
