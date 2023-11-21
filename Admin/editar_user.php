<?php

session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if ($rol != '2') {
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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <title>Gestión de Usuarios</title>
  <style>
    body {
        margin-top: 8rem;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        background-color: rgba(128, 128, 128, 0.7);
    }

    form {
        margin-top: 20px;
        width: 50rem;
        padding: 3rem;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        background-color: rgba(128, 128, 128, 0.7);
        color: white;
    }

    .form-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 1rem;
        justify-content: center;
    }

    .form-group label {
        font-weight: bold;
        width: 20%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group input[type="password"] {
        color: white;
        flex: 1;
        width: 80%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
        background-color: rgba(128, 128, 128, 0.7);
    }

    .form-group input[type="password"] {
        width: 100%;
    }

    form button {
        width: 20rem;
        margin-top: 1rem;
        margin-left: 15rem;
        padding: 1rem;
        background-color: red; /* Cambiado a rojo */
        color: white;
        border: none;
        border-radius: 9px;
        cursor: pointer;
    }

    form button:hover {
        background-color: darkred; /* Cambiado a un tono más oscuro de rojo al pasar el mouse */
    }

    h1 {
        color: white;
        font-size: 40px;
        position: relative;
    }
    h2 {
        color: white;
        font-size: 40px;
        margin-left: 300px;
    }
    
    
    .cancel-button {
    background-color: #ccc !important;
    color: #333;
    text-decoration: none !important;
    padding: 1rem 2rem; /* Ajusta el padding según sea necesario */
    border-radius: 9px;
    display: inline-block;
    text-align: center;
    font-weight: bold;
    margin-top: 1rem;
}

.cancel-button:hover {
    background-color: #5f5f5f !important;
}

</style>
</head>

<body style="background-image: url('../images/mesa3.svg');">
<?php include '../NAVBARiorder/index.php'; ?>
  <div class="modal-content">
    <span class="close" id="closeSpan">&times;</span>
    <h2 class="modal-title" style="color: white;">Editar Usuario</h2>
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
      $actualizar = "UPDATE user SET nombre = '$nombre', apPAt = '$apPAt', apMAt = '$apMAt', correo = '$correo', telefono = '$telefono' WHERE id = '$usuario_id'";
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
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required
          class="form-control">
      </div>
      <div class="form-group">
        <label for="apPAt">Apellido Paterno:</label>
        <input type="text" id="apPAt" name="apPAt" value="<?php echo $usuario['apPAt']; ?>" required
          class="form-control">
      </div>
      <div class="form-group">
        <label for="apMAt">Apellido Materno:</label>
        <input type="text" id="apMAt" name="apMAt" value="<?php echo $usuario['apMAt']; ?>" required
          class="form-control">
      </div>
      <div class="form-group">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required
          class="form-control">
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required
          class="form-control">
      </div>


      <div class="form-group">
        <button class="button" type="submit" name="actualizar">Actualizar</button>
        <a class="button cancel-button" href="editar.php">Cancelar</a>
      </div>
    </form>
    <form method="POST">
      <button type="submit" name="obtener_contraseña">Cambiar Contraseña *Opcional*</button>
    </form>

    <?php if (isset($current_password_hash_from_db) && !$showChangePasswordForm) { ?>
      <div class="form-group">
        <label for="password">Contraseña Obtenida:</label><br>
        <input type="password" id="password" name="password" value="<?php echo $current_password_hash_from_db ?>" required
          class="form-control" disabled>
      </div>
    <?php } ?>

    <?php if ($showChangePasswordForm) { ?>
      <form method="post">
        <div class="form-group">
          <label for="new_password">Nueva Contraseña:</label><br>
          <input type="password" id="new_password" name="new_password" class="form-control">
        </div>
        <button type="submit" name="cambiar_contraseña">Cambiar Contraseña</button>
      </form>
    <?php } ?>

  </div>

  <script>
    function openModal(modalName) {
      document.getElementById(`modal${modalName}`).style.display = "block";
    }

    function closeModal(modalName) {
      document.getElementById(`modal${modalName}`).style.display = "none";
    }
    document.addEventListener("DOMContentLoaded", function () {
      var closeSpan = document.getElementById("closeSpan");
      closeSpan.addEventListener("click", function () {
        window.location.href = "editar.php";
      });
    });
  </script>
</body>

</html>