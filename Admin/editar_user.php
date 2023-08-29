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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: sans-serif;
    }

    body {

      min-height: 100vh;
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 1.3rem 10%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 100;
    }

    .header::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(50px);
      z-index: -1;
    }

    .header::after {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg,
          transparent,
          rgba(255, 255, 255, 0.4),
          transparent);
      transition: 0.5s;
    }

    .header:hover::after {
      left: 100%;
    }

    .logo {
      font-size: 2rem;
      color: #fff;
      text-decoration: none;
      font-weight: 700;
    }

    .navbar a {
      font-size: 1.5rem;
      /* Cambia el valor a tu preferencia */
      color: #ffffff;
      text-decoration: none;
      font-weight: 500;
      margin-left: 2.5rem;
    }

    .navbar a:hover {
      /* color: #f34dc3;
  color: #9c3cea;
  color: #582417;
  color: #FDBB03;
  color: #EE0000;
  color: #00144b; */
      color: black;
      transition: 0.5s ease;
    }

    #check {
      display: none;
    }

    .icons {
      position: absolute;
      right: 5%;
      font-size: 2.8rem;
      color: #fff;
      cursor: pointer;
      display: none;
    }

    /* responsive */
    @media (max-width: 992px) {
      .header {
        padding: 1.3rem 5%;
      }
    }

    @media (max-width: 768px) {
      .icons {
        display: inline-flex;
      }

      #check:checked~.icons #menu-icon {
        display: none;
      }

      .icons #close-icon {
        display: none;
      }

      #check:checked~.icons #close-icon {
        display: block;
      }

      .navbar {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 0;
        background: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(50px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: 0.3s ease;
      }

      #check:checked~.navbar {
        height: 17.7rem;
      }

      .navbar a {
        display: block;
        font-size: 1.1rem;
        margin: 1.9rem 0;
        text-align: center;
        transform: translateY(-50px);
        opacity: 0;
      }

      #check:checked~.navbar a {
        transform: translateY(0);
        opacity: 1;
        transition-delay: calc(0.1s * var(--i));
      }
    }

    .video-container {
      position: relative;
      height: 100vh;
      overflow: hidden;
      z-index: 1;
    }

    video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .video-container::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
    }

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
      margin-top: 50px;
      /* Reducir el margen superior */
      margin-bottom: 50px;
    }

    .modal-content {
      background-color: #ffffff;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      width: 70%;
      margin-bottom: 0;
      margin-top: 10%;
      /* Eliminar el margen superior del contenido */
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

<body style="background-image: url('../images/constelacion.svg');">
  <header class="header">
    <a href="../Admin/index.php" class="logo">
      <img src="../informacion/images/logo2.svg" alt="LOGO" style="width: 10rem;">
    </a>
    <input type="checkbox" id="check">
    <label for="check" class="icons">
      <i class='bx bx-menu' id="menu-icon"></i>
      <i class='bx bx-x' id="close-icon"></i>
    </label>
    <nav class="navbar">
      <a href="../Admin/index.php" style="--i:0;">Inicio</a>
      <a href="../Admin/gestion.php" style="--i:1;">Usuarios</a>
      <a href="#" style="--i:2;">Vista Admin</a>
      <a href="#" style="--i:3;">Reservas</a><!-- 
      <a href="#" style="--i:4;">Contacto</a> -->
      <a href="../includes/_sesion/cerrarSesion.php" style="--i:4;">Salir</a>
    </nav>
  </header>
  <div class="modal-content">
    <span class="close" id="closeSpan">&times;</span>
    <h2 class="modal-title" style="color: green;">Editar Usuario</h2>
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
// Evita el uso de extract(), ya que puede ser peligroso si no se maneja adecuadamente.
// Mejor accede directamente a los valores $_POST['nombre'], $_POST['apPAt'], etc.

// Asegúrate de conectar a la base de datos de manera segura y de manejar posibles errores de conexión.

// Escapa y valida los datos antes de usarlos en la consulta para evitar inyecciones SQL.
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apPAt = mysqli_real_escape_string($conexion, $_POST['apPAt']);
$apMAt = mysqli_real_escape_string($conexion, $_POST['apMAt']);
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
$password = mysqli_real_escape_string($conexion, $_POST['password']);

// Genera el hash de la contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Evita la interpolación directa de variables en la consulta, utiliza consultas preparadas.
$actualizar = "UPDATE user SET nombre = ?, apPAt = ?, apMAt = ?, correo = ?, telefono = ?, password_hash = ? WHERE id = ?";
$stmt = mysqli_prepare($conexion, $actualizar);
mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $apPAt, $apMAt, $correo, $telefono, $password_hash, $usuario_id);
$resultado = mysqli_stmt_execute($stmt);

if ($resultado) {
    echo "Actualización exitosa.";
} else {
    echo "Error al actualizar: " . mysqli_error($conexion);
}

// Cierra la conexión a la base de datos.
mysqli_close($conexion);
      header('Location: listar.php');
      exit();
    }
    ?>

    <form method="POST">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <label for="apPAt">Apellido Paterno:</label>
        <input type="text" id="apPAt" name="apPAt" value="<?php echo $usuario['apPAt']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <label for="apMAt">Apellido Materno:</label>
        <input type="text" id="apMAt" name="apMAt" value="<?php echo $usuario['apMAt']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required class="form-control">
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required class="form-control">
      </div>

      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required class="form-control">
      </div>
      <div class="form-group">
        <button class="button" type="submit" href="gestion.php" name="actualizar">Actualizar</button>
        <a class="button" href="gestion.php">Cancelar</a>
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
    document.addEventListener("DOMContentLoaded", function() {
      // Obtener el elemento span por su ID
      var closeSpan = document.getElementById("closeSpan");

      // Agregar un evento de clic al elemento span
      closeSpan.addEventListener("click", function() {
        // Redirigir a la página "gestion.php"
        window.location.href = "gestion.php";
      });
    });
  </script>
</body>

</html>