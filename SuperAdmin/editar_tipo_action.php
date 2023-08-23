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
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Establecimiento</title>
  <style>
    /* Estilos para los modales */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.7);
      margin-top: 50px; /* Reducir el margen superior */
            margin-bottom: 50px; 
    }

    .modal-content {
      background-color: #ffffff;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      width: 70%;
      margin-bottom: 0; 
      margin-top: 0; /* Eliminar el margen superior del contenido */
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    /* Estilos para los botones */
    .button {
      padding: 10px 20px;
      margin: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    /* Estilos para los formularios */
    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-control:focus {
      border-color: #007bff;
    }
  </style>
</head>

<body>
  <div class="modal-content">
    <span class="close" onclick="closeModal('Editar')">&times;</span>
    <h2 class="modal-title" style="color: green;">Editar Establecimiento</h2>
    <?php
    include('../includes/_db.php');

    if (isset($_GET['id'])) {
      $establecimiento_id = $_GET['id'];

      // Obtener los datos del establecimiento
      $consulta = "SELECT * FROM establecimiento_tipo WHERE id = $establecimiento_id";
      $resultado = mysqli_query($conexion, $consulta);
      $establecimiento = mysqli_fetch_assoc($resultado);

      if (!$establecimiento) {
        header('Location: listar_tipo.php');
        exit();
      }
    } else {
      header('Location: listar_tipo.php');
      exit();
    }

    if (isset($_POST['actualizar'])) {
      extract($_POST);
      $actualizar = "UPDATE establecimiento_tipo SET tipo = '$est' WHERE id = $establecimiento_id";
      mysqli_query($conexion, $actualizar);
      header('Location: listar_tipo.php');
      exit();
    }
    ?>

    <form method="POST">
      <div class="form-group">
        <label for="est">Establecimiento:</label>
        <input type="text" id="est" name="est" value="<?php echo $establecimiento['tipo']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <button class="button" type="submit" name="actualizar">Actualizar</button>
        <a class="button" href="listar_tipo.php">Cancelar</a>
      </div>
    </form>
  </div>

  <script>
    function openModal(modalName) {
      document.getElementById(`modal${modalName}`).style.display = "block";
    }

    function closeModal(modalName) {
      document.getElementById(`modal${modalName}`).style.display = "none";
    }
  </script>
</body>

</html>