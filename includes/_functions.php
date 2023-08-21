<?php
include('./_db.php');

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'acceso_user':
            acceso_user();
            break;
    }
}

function acceso_user()
{
    global $conexion;

    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $sql = "SELECT password_hash, rol FROM user WHERE correo = '$correo'";
    $resultado = $conexion->query($sql);
session_start();
  $_SESSION['correo'] = $correo;
    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        $hashAlmacenado = $fila["password_hash"];
        if (password_verify($password, $hashAlmacenado)) {
            if ($fila['rol'] == 1) { // SuperAdmin
                header("Location: ../SuperAdmin/index.php");
            } else {
                header('Location: ./login.php');
                session_destroy();
            }
        } else {
            // Contraseña incorrecta
            echo 'Contraseña incorrecta';
        }
    } else {
        // Usuario no encontrado
        echo 'No existe el usuario';
    }
/* $hashContrasena = password_hash('12345', PASSWORD_BCRYPT);
echo $hashContrasena; */
}
?>
