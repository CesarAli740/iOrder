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
?><?php
include('../includes/_db.php');

// Obtener los datos de los usuarios
$consulta = "SELECT id, nombre, apPAt, apMAt 
             FROM user
             WHERE user.rol NOT IN (1, 2)
             AND user.tipo = '$establecimiento'";

$resultado = mysqli_query($conexion, $consulta);
$usuarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Usuarios</title>
</head>

<body>
  <h1 style=color:#1B9C85;>Lista de Usuarios</h1>
  <table>
    <thead>
    <tr>
    <th>Nombre Completo</th>
    <th>Editar</th>
</tr>
    </thead>
    <tbody>
  <?php foreach ($usuarios as $usuario) { ?>
    <tr>
      <td><?php echo $usuario['nombre'] . ' ' . $usuario['apPAt'] . ' ' . $usuario['apMAt']; ?></td>
      <td>
        <a href="editar_user.php?id=<?php echo $usuario['id']; ?>">Editar</a>
      </td>
    </tr>
  <?php } ?>
</tbody>

  </table>
</body>

</html>