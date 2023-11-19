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
    body {
      
      background-color: transparent;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    h2 {
      color: white;
      text-align: center;
      font-size: 50px;
      margin-top: 10rem;
      /* Ajusta según tus preferencias */
    }

    /* Estilos para los modales */
    .modal {
      display: none;
      position: absolute;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.7);
      margin-top: 50px;
      margin-bottom: 50px;
    }
    .btn-success {
      background-color: #ea272d;
      color: white;
      text-decoration: none;
      margin-right: 2rem;
    }

    .btn-success:hover {
      background-color: #7d1518;
    }

    .btn-secondary {
      background-color: #5f5f5f;
      color: #333;
      text-decoration: none;
      margin-right: 2rem;
    }

    .btn-secondary:hover {
      background-color: #ccc;
    }

    .modal-content {
      background-color: rgba(128, 128, 128, 0.7);
      padding: 20px;
      border-radius: 10px;
      margin: 50px auto;
      max-width: 1500px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      display: grid;
      gap: 1rem;
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
    .form-container {
      margin-top: 1rem;
      display: flex;
      flex-direction: row;
      justify-content: space-evenly;
      align-items: center;
      text-align: center;
    }

    .form-group {
      margin-bottom: 1.5rem;
      width: 25%;
    }

    label {
      font-weight: bold;
      color: white;
    }

    input {
      color: white;
      background-color: transparent;
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
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-label {
      display: block;
      font-weight: bold;
      margin-bottom: 1rem;
      font-size: 18px;
    }

    .form-control:focus {
      border-color: #007bff;
    }

    .form-row {
      display: flex;
      justify-content: space-between;
    }

    .form-col {
      flex-basis: calc(50% - 10px);
    }
    .llenado {
      width: 400%;
      text-align: center;
    }
  </style>

</head>

<body>
  <h2 class="modal-title">Editar Establecimiento</h2>
  <div class="modal-content">
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
      $actualizar = "UPDATE establecimiento SET nombre = '$nombre', responsable = '$responsable', tel_responsable = '$tel_responsable', descripcion = '$descripcion', horario_operacion = '$horario', vision_negocio = '$vision' WHERE id = $establecimiento_id";
      mysqli_query($conexion, $actualizar);
      header('Location: listar_establecimientos.php');
      exit();
    }
    ?>

    <form method="POST">
      <div class="form-container">
        <div class="form-group">
          <label class="form-label" for="nombre">Establecimiento:</label><br>
          <input type="text" id="nombre" name="nombre" value="<?php echo $establecimiento['nombre']; ?>" required class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label" for="responsable">Nombre del Responsable:</label><br>
          <input type="text" id="responsable" name="responsable" value="<?php echo $establecimiento['responsable']; ?>" required class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label" for="tel_responsable">Número del Responsable:</label><br>
          <input type="tel" id="tel_responsable" name="tel_responsable" value="<?php echo $establecimiento['tel_responsable']; ?>" required class="form-control">
        </div>
      </div>
        <div class="form-group">
          <label class="form-label" for="descripcion">Descripción de Establecimiento:</label><br>
          <input type="text" id="descripcion" name="descripcion" value="<?php echo $establecimiento['descripcion']; ?>" required class="form-control llenado">
      </div>
        <div class="form-group">
          <label class="form-label" for="horario">Horario de Operación:</label><br>
          <input type="text" id="horario" name="horario" value="<?php echo $establecimiento['horario_operacion']; ?>" required class="form-control llenado"></input>
      </div>
        <div class="form-group">
          <label class="form-label" for="vision">Frase o Visión del Negocio:</label><br>
          <input type="text" id="vision" name="vision" value="<?php echo $establecimiento['vision_negocio']; ?>" required class="form-control llenado"></input>
      </div>
      
      <div class="form-container">
        <div class="form-group">
          <button class="btn btn-success" type="submit" name="actualizar">Actualizar</button>
          <a href="editar_establecimiento.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </div>
    </form>
  </div>

  <script>
    function openModal(modalName) {
      document.getElementById(modal$, {
        modalName
      }).style.display = "block";
    }

    function closeModal(modalName) {
      document.getElementById(modal$, {
        modalName
      }).style.display = "none";
    }

    document.addEventListener("DOMContentLoaded", function() {
      // Obtener el elemento span por su ID
      var closeSpan = document.getElementById("closeSpan");

      // Agregar un evento de clic al elemento span
      closeSpan.addEventListener("click", function() {
        // Redirigir a la página "gestion.php"
        window.location.href = "index.php";
      });
    });
  </script>
</body>

</html>