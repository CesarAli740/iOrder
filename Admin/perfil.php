<?php
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
$usuario_id = $_SESSION['id'];
if ($rol != '2') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
include '../includes/_db.php';
include '../NAVBARiorder/index.php';
?>
<?php
$query = "SELECT id, nombre, apPAt, apMAt, correo, telefono FROM user WHERE id = '$usuario_id'";
$resultado = $conexion->query($query);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    die("No se encontró el usuario en la base de datos.");
}

if (isset($_POST['actualizar_perfil'])) {
    $nombre_actualizado = $_POST["nombre"];
    $apPAt_actualizado = $_POST["apPAt"];
    $apMAt_actualizado = $_POST["apMAt"];
    $correo_actualizado = $_POST["correo"];
    $telefono_actualizado = $_POST["telefono"];
    $actualizar_query = "UPDATE user SET nombre = '$nombre_actualizado', apPAt = '$apPAt_actualizado', apMAt = '$apMAt_actualizado', correo = '$correo_actualizado', telefono = '$telefono_actualizado' WHERE id = '$usuario_id'";
    
    if ($conexion->query($actualizar_query) === TRUE) {
        header("Location: ./index.php"); 
        echo '<script>window.location.href = "index.php";</script>';
        exit;
    } 
}

if (isset($_POST['cambiar_contraseña'])) {
    extract($_POST);
    if (empty($new_password)) {
        header("Location: ./index.php"); 
        exit();  
    }
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
    $actualizar = "UPDATE user SET password_hash = '$password_hash' WHERE id = '$usuario_id'";
    mysqli_query($conexion, $actualizar);
    echo '<script>window.location.href = "gestion.php";</script>';
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

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
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
            font-size: 1.1rem;
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

        

        form button:hover {
            background-color: #7d1518; /* Cambiado a un tono más oscuro de rojo al pasar el mouse */
        }
        h1{
    
            color:white;
            font-size: 40px;
        }

        .container-form{
            display: flex;
            width: 90%;
        }
        .btn-success {
        background-color: #ea272d;
        color: #fff;
        padding: 8px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px;
    }

    .btn-success:hover {
        background-color: #7d1518;
    }
    .cambiar-password{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 3rem;
    }
    </style>
</head>
<body>
    <h1>Editar Perfil</h1>
    <div class="container-form">
        <form method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario["nombre"]; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apPAt">Apellido Paterno:</label>
                <input type="text" id="apPAt" name="apPAt" value="<?php echo $usuario["apPAt"]; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apMAt">Apellido Materno:</label>
                <input type="text" id="apMAt" name="apMAt" value="<?php echo $usuario["apMAt"]; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="<?php echo $usuario["correo"]; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" value="<?php echo $usuario["telefono"]; ?>" class="form-control" required>
            </div>
            <button class="btn-success" type="submit" class="btn btn-primary" name="actualizar_perfil" >Actualizar Perfil</button>
        </form>
        <form method="POST">
            <div class="cambiar-password">
                <button class="btn-success" type="submit" name="obtener_contraseña">Cambiar Contraseña *Opcional*</button>
            </div>
            <?php if (isset($current_password_hash_from_db) && !$showChangePasswordForm) { ?>
                <div class="form-group">
                    <label for="password">Contraseña Obtenida:</label><br>
                    <input type="password" id="password_obtenida" name="password_obtenida"
                           value="<?php echo $current_password_hash_from_db ?>" required class="form-control" disabled>
                </div>
            <?php } ?>
        
            <?php if ($showChangePasswordForm) { ?>
                <form method="post">
                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña:</label><br>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                        <button class="btn-success" type="submit" name="cambiar_contraseña">Cambiar Contraseña</button>
                    </div>
                </form>
            <?php } ?>

        </form>
    </div>
        

</body>
</html>
