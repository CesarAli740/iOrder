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
  header('Location: listar.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuario</title>
</head>

<body>
  <h1>Editar Usuario</h1>
  <form method="POST">
    <div>
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
    </div>
    <div>
      <label for="apPAt">Apellido Paterno:</label>
      <input type="text" id="apPAt" name="apPAt" value="<?php echo $usuario['apPAt']; ?>" required>
    </div>
    <div>
      <label for="apMAt">Apellido Materno:</label>
      <input type="text" id="apMAt" name="apMAt" value="<?php echo $usuario['apMAt']; ?>" required>
    </div>
    <div>
      <label for="correo">Correo:</label>
      <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required>
    </div>
    <div>
      <label for="telefono">Teléfono:</label>
      <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>" required>
    </div>
    <div>
      <button type="submit" name="actualizar">Actualizar</button>
      <a href="listar.php">Cancelar</a>
    </div>
  </form>
</body>

</html>
