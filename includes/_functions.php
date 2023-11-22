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
        $user_id = $fila['id'];
        $_SESSION['rol'] = $fila['rol'];
        $_SESSION['establecimiento'] = $fila['tipo'];
        $establecimiento_id = $fila['tipo'];

        $sql_user = "SELECT estado FROM user WHERE id = $user_id";
        $result_user = $conexion->query($sql_user);
        $row_user = $result_user->fetch_assoc();
        $estado_user = $row_user['estado'];

        $sql2 = "SELECT estado FROM establecimiento WHERE id = '$establecimiento_id'";
        $result = $conexion->query($sql2);
        $row = $result->fetch_assoc();
        $estado = $row['estado'];

        $hashAlmacenado = $fila["password_hash"];
        if (password_verify($password, $hashAlmacenado)) {
            if ($fila['rol'] == 1) { // SuperAdmin
                header("Location: ../SuperAdmin/index.php");
            }
            if ($fila['rol'] != 1 and $estado == 1 and $estado_user == 1){
                if ($fila['rol'] == 2) { //Admin
                    header("Location: ../Admin/index.php");
                } else if ($fila['rol'] == 4) { //Empleado
                    header("Location: ../Empleado/index.php");
                } else if ($fila['rol'] == 5) { //Cliente
                    header("Location: ../Cliente/index.php");
                } else {
                    header('Location: ./login.php');
                    session_destroy();
                }
            } else if ($fila['rol'] != 1) {
                header('Location: ./login.php');
                session_destroy();
            }
        } else {
            header('Location: ./login.php');
            session_destroy();
        }
    } else {
        echo 'No existe el usuario';
    }
    /* $hashContrasena = password_hash('12345', PASSWORD_BCRYPT);
    echo $hashContrasena; */
}
?>