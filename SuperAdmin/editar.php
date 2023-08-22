<?php
include('../includes/_db.php');

// Obtener los datos de los usuarios
$consulta = "SELECT id, nombre, apPAt, apMAt FROM user";
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
  <h1 style=color:#1B9C85;">Lista de Usuarios</h1>
  <table>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario) { ?>
        <tr>
          <td><?php echo $usuario['nombre']; ?></td>
          <td><?php echo $usuario['apPAt']; ?></td>
          <td><?php echo $usuario['apMAt']; ?></td>
          <td>
            <a href="editar_user.php?id=<?php echo $usuario['id']; ?>">Editar</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>