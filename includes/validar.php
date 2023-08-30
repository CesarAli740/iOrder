<?php
include('./_db.php');
if (isset($_POST['registrar'])) {
  extract($_POST);
  $password_hash = password_hash($password, PASSWORD_BCRYPT);
  $consulta = "INSERT INTO user (nombre, apPAt, apMAt, correo, telefono, password_hash, rol, tipo,estado)
               VALUES ('$nombre', '$apPAt', '$apMAt', '$correo', '$telefono', '$password_hash', '2','$establecimiento' ,'1')";
  mysqli_query($conexion, $consulta);
  mysqli_close($conexion);
  header('Location: ../SuperAdmin/index.php');
  exit();
}else {
  echo "Error en la consulta: " . mysqli_error($conexion);
}
if (isset($_POST['Admin_registrar'])) {
  extract($_POST);
  $password_hash = password_hash($password, PASSWORD_BCRYPT);
  $consulta = "INSERT INTO user (nombre, apPAt, apMAt, correo, telefono, password_hash, rol, tipo,estado)
               VALUES ('$nombre', '$apPAt', '$apMAt', '$correo', '$telefono', '$password_hash', '$rol','$establecimiento' ,'1')";
  mysqli_query($conexion, $consulta);
  mysqli_close($conexion);
  header('Location: ../SuperAdmin/index.php');
  exit();
}else {
  echo "Error en la consulta: " . mysqli_error($conexion);
}
?>