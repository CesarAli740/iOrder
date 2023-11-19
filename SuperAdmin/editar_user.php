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
<?php include '../NAVBARiorder/index.php';
include '../includes/_db.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="../css/stylesuser">
  <title>Gestión de Usuarios</title>
  <style>
    body {
      background-color: transparent;
      margin: 0;
      font-family: Arial, sans-serif;
      overflow:hidden;
    }

    label {
      color: white;
    }

    h1,
    h2,
    h3 {
      color: white;
      text-align: center;
      font-size: 50px;
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
      /* Reducir el margen superior */
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
    margin: 50px auto; /* Centrar en la pantalla */
    max-width: 1500px; /* Ancho máximo del contenedor */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    display: grid;
    gap: 1rem;
    border: 1px solid white; /* Borde delgado blanco */
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
      width: 25%;
    }
    .form-group-newpass{
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: .5rem;
    }
    label {
      font-weight: bold;
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
      /* Distribuir en dos columnas, descontando el espacio entre ellas */
    }

    .form-container {
      margin-top: 3rem;
      display: flex;
      flex-direction: row;
      justify-content: space-evenly;
      align-items: center;
      text-align: center;
    }
  </style>
</head>

<body>
<h2 class="modal-title" style="margin-top: 10rem;">Editar Usuario</h2>
  <div class="modal-content">
    <?php
    include('../includes/_db.php');

    if (isset($_GET['id'])) {
      $usuario_id = $_GET['id'];

      // Obtener los datos del usuario
      $consulta = "SELECT * FROM user WHERE id = '$usuario_id'";
      $resultado = mysqli_query($conexion, $consulta);
      $usuario = mysqli_fetch_assoc($resultado);

      if (!$usuario) {
        header('Location: listar.php');
        exit();
      }
    } else {
      header('Location: listar.php');
      exit();
    }

    if (isset($_POST['actualizar'])) {
      extract($_POST);
      $actualizar = "UPDATE user SET nombre = '$nombre', apPAt = '$apPAt', apMAt = '$apMAt', correo = '$correo', telefono = '$telefono', tipo = '$tipo' WHERE id = '$usuario_id'";
      mysqli_query($conexion, $actualizar);
      echo '<script>window.location.href = "index.php";</script>';
      exit();
    }
    if (isset($_POST['cambiar_contraseña'])) {
      extract($_POST);
      $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
      $actualizar = "UPDATE user SET password_hash = '$password_hash' WHERE id = '$usuario_id'";
      mysqli_query($conexion, $actualizar);
      echo '<script>window.location.href = "index.php";</script>';
      exit();
    }

    $showChangePasswordForm = false;

    if (isset($_POST['obtener_contraseña'])) {
      $query = "SELECT password_hash FROM user WHERE id = '$usuario_id'";
      $resultado = $conexion->query($query);

      if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $current_password_hash_from_db = $fila["password_hash"];
        $showChangePasswordForm = true; // Mostrar el formulario de cambio de contraseña
      } else {
        die("No se encontró el usuario en la base de datos.");
      }
    }
    ?>

    <form method="POST">
      <div class="form-container">
        <div class="form-group">
          <label class="form-label" for="nombre">Nombre:</label><br>
          <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label" for="apPAt">Apellido Paterno:</label><br>
          <input type="text" id="apPAt" name="apPAt" value="<?php echo $usuario['apPAt']; ?>" required class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label" for="apMAt">Apellido Materno:</label><br>
          <input type="text" id="apMAt" name="apMAt" value="<?php echo $usuario['apMAt']; ?>" required class="form-control">
        </div>
      </div>
      <div class="form-container">
        <div class="form-group">
          <label class="form-label" for="correo">Correo:</label><br>
          <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label" for="telefono">Teléfono:</label><br>
          <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required class="form-control">
        </div>
        <?php
        $query = "SELECT id, tipo FROM establecimiento_tipo";
        $resultado = $conexion->query($query);
        ?>
        <div class="form-group">
          <label class="form-label" for="tipo">Tipo de Establecimiento *</label><br>
          <select type='text' id="tipo" name="tipo" class="form-control" required>
            <?php
            echo '<option value="" disabled>Selecciona un tipo</option>';
            while ($fila = $resultado->fetch_assoc()) {
              $selected = ($fila["id"] === $usuario['tipo']) ? "selected" : "";
              echo '<option value="' . $fila["id"] . '" ' . $selected . '>' . $fila["tipo"] . '</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <div class="form-container">
        <div class="form-group">
          <button class="btn btn-success" type="submit" name="actualizar">Actualizar</button>
          <a href="editar.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <form method="POST">
          <button class="btn btn-success" type="submit" name="obtener_contraseña">Cambiar Contraseña Opcional</button>
        </form>
        <?php if (isset($current_password_hash_from_db) && !$showChangePasswordForm) { ?>
          <div class="form-group">
            <label for="password">Contraseña Obtenida:</label><br>
            <input type="password" id="password" name="password" value="<?php echo $current_password_hash_from_db ?>" required class="form-control" disabled>
          </div>
        <?php } ?>

        <?php if ($showChangePasswordForm) { ?>
          <form method="post">
            <div class="form-group-newpass">
              <label class="label" for="new_password">Nueva Contraseña:</label>
              <input type="password" id="new_password" name="new_password" class="form-control">
              <button class="btn btn-success" type="submit" name="cambiar_contraseña">Cambiar Contraseña</button>
            </div>
            
          </form>
        <?php } ?>
    </form>

  </div>


  </div>
  <script>
    function openModal(modalName) {
      document.getElementById(modal${modalName}).style.display = "block";
    }

    function closeModal(modalName) {
      document.getElementById(modal${modalName}).style.display = "none";
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