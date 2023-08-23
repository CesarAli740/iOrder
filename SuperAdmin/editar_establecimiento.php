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
?><?php
include('../includes/_db.php');

$consulta = "SELECT * FROM establecimiento";
$resultado = mysqli_query($conexion, $consulta);
$establecimientos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Establecimientos</title>
</head>

<body>
  <h1 style="color: #1B9C85;">Lista de Establecimientos</h1>
  <table>
    <thead>
      <tr>
        <th>Establecimiento</th>
        <th>Editar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($establecimientos as $establecimiento) { ?>
        <tr>
          <td><?php echo $establecimiento['nombre']; ?></td>
          <td>
            <a href="editar_establecimiento_action.php?id=<?php echo $establecimiento['id']; ?>">Editar</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>
