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
  <link rel="stylesheet" href="../css/stylesuser">
  <style>
    body {
      background-color: transparent;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .container {
     
        background-color: transparent;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: white; /* Cambia el color de texto a negro */
        
     
      margin-top: 7rem;
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
      text-decoration: none;
    }

    .btn-success {
      background-color: #1B9C85;
    }

    .btn-secondary {
      background-color: #ea272d !important;
      color: white;
      text-decoration: none;
    }
    .btn-secondary:hover {
      background-color: #7d1518 !important;
    }
    .text-center {
      text-align: center;
    }
    a {
      color: red;
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
      background-color: transparent;
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
  </style>
</head>

<body>
  <?php include '../NAVBARiorder/index.php'; ?>
  <div class="container">
    <div class="section-container">
      <h1>Lista de Usuarios</h1>
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
      <div class="text-center" style="margin-top: 20px;"> <!-- Agrega margen superior para separar del formulario -->
        <a href="index.php" class="btn btn-secondary">Regresar</a> <!-- Botón para regresar a gestion.php -->
</body>

</html>