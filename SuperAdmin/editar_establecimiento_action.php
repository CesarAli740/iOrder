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
<?php include '../NAVBARiorder/index.php'; ?>
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
      background-color: white;
      margin-top: 200px; /* Reducir el margen superior */
            margin-bottom: 50px; 
    }

    .modal-content {
      background-color: transparent;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      width: 70%;
      margin-bottom: 0; 
      margin-top: 200px; /* Eliminar el margen superior del contenido */
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
      color: white;
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
      $consulta = "SELECT * FROM establecimiento WHERE id = $establecimiento_id";
      $resultado = mysqli_query($conexion, $consulta);
      $establecimiento = mysqli_fetch_assoc($resultado);

      if (!$establecimiento) {
        header('Location: listar_establecimientos.php');
        exit();
      }
    } else {
      header('Location: listar_establecimientos.php');
      exit();
    }

    if (isset($_POST['actualizar'])) {
      extract($_POST);
      $actualizar = "UPDATE establecimiento SET nombre = '$nombre', ubicacion = '$ubicacion' WHERE id = $establecimiento_id";
      mysqli_query($conexion, $actualizar);
      header('Location: listar_establecimientos.php');
      exit();
    }
    ?>

    <form method="POST">
      <div class="form-group">
        <label for="nombre">Establecimiento:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $establecimiento['nombre']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" value="<?php echo $establecimiento['ubicacion']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <button class="button" type="submit" name="actualizar">Actualizar</button>
        <a class="button" href="editar_establecimiento.php">Cancelar</a>
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