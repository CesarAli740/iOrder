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
    $sql = "SELECT * FROM user WHERE correo = '$correo'";
    $resultado = $conexion->query($sql);
    session_start();
    $_SESSION['correo'] = $correo;
    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();

        $_SESSION['id'] = $fila['id'];
        $_SESSION['rol'] = $fila['rol'];
        $_SESSION['establecimiento'] = $fila['tipo'];
        $hashAlmacenado = $fila["password_hash"];
        if (password_verify($password, $hashAlmacenado)) {
            if ($fila['rol'] == 1) { // SuperAdmin
                header("Location: ../SuperAdmin/index.php");
            } else if ($fila['rol'] == 2) { //Admin
                header("Location: ../Admin/index.php");
            } else if ($fila['rol'] == 5) { //Cliente
                header("Location: ../Cliente/index.php");
            } else {
                header('Location: ./login.php');
                session_destroy();
            }
        } else {
            header('Location: ./login.php');
            session_destroy();
        }
    } else {
        // Usuario no encontrado
        echo 'No existe el usuario';
    }
    /* $hashContrasena = password_hash('12345', PASSWORD_BCRYPT);
    echo $hashContrasena; */
}
?>