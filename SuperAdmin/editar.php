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
?><?php
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
  <style>
    body {
      background-color: #ECF8F9;
      margin: 0;
      font-family: Arial, sans-serif;

    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 50%;
      /* Ajusta esta línea para cambiar la posición vertical */
      transform: translateY(-50%);
      /* Añade esta línea para centrar verticalmente */
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 100%;
    }

    .modal-title {
      color: #1B9C85;
      font-size: 1.5rem;
      margin-bottom: 3rem;
      text-align: center;
    }

    .container.is-fluid {
      display: flex;
      justify-content: center;
      align-items: center;

    }

    .modal-title {
      color: #1B9C85;
      font-size: 1.5rem;
      margin-bottom: 3rem;
      text-align: center;
    }
  </style>
</head>

<body>
  <h1 style="color: #1B9C85; text-align: center;">Lista de Usuarios</h1>
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