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
 <style>
    /* Estilos para la tabla */
    .table-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    table {
      margin: auto;
        margin-top: 2rem;
        background-color: transparent;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        font-family: Arial, sans-serif;
        color: white; /* Cambia el color de texto a negro */
        width: 80%;
    }

    th, td {
        padding: 15px;
        border: 1px solid #ccc;
        text-align: center;
    }
    h1, h2, h3 {
        color: white;
        text-align: center;
        font-size: 50px;
        margin-top: 200px;
    }
    
</style>

<!DOCTYPE html>
<html lang="es">

<head>
 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <div class="container" style="margin-top: 5rem;">
    <div class="section-container">
      <h1>Lista de Establecimientos</h1>
</head>
<?php include '../NAVBARiorder/index.php'; ?>
<body>
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
            <a href="editar_establecimiento_action.php?id=<?php echo $establecimiento['id']; ?>">editar</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>
