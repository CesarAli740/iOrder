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
    <?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Tipos de Establecimiento</title>
    <style>
        body {
            background-color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 200px;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #1B9C85;
            color: #fff;
            cursor: pointer;
        }

        table {
            max-width: 800px;
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            color: black;
            padding: 15px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: black;
        }

        th {
            background-color: #f2f2f2;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Buscar Tipos de Establecimiento</h1>
    </div>
    <div class="container form-container">
        <form method="POST">
            <div class="form-group">
                <label for="buscar">Buscar por Tipo:</label>
                <input type="text" name="buscar" required>
            </div>
            <button type="submit" name="buscar_tipo">Buscar</button>
        </form>
    </div>

    <!-- Mostrar resultados de la búsqueda -->
    <div class="container">
        <?php if (isset($result) && $result->num_rows > 0) { ?>
            <table>
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
    </div>
</body>
</html>
