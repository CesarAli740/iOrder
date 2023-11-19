<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <style>
        body {
            display: flex;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            line-height: 1.7;
            color: #ffeba7;
            overflow: hidden;
            height: 100vh;
            background: radial-gradient(ellipse at bottom, #1B2735 0%, #12141d 100%);
        }

        .card {
            background-color: gray;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            max-width: 80%;
            text-align: center;
            margin: 0 auto;
        }


        .botonlogin {
            text-decoration: none;
            background-color: #161d32;
            border: none;
            color: white;
            padding: 0.5rem;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            font-family: 'Roboto', sans-serif;
            width: 90%;
            transition: background-color 0.3s;
        }

        .botonlogin:hover {
            background-color: #435a9c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: black;
        }

        .form-control {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            width: 93%;
            transition: box-shadow 0.3s, border-color 0.3s;
        }

        .form-control:focus {
            border-color: #1B9C85;
            box-shadow: 0px 0px 5px rgba(27, 156, 133, 0.5);
        }

        .my-2 {
            color: black;
        }

        .login-heading {
            color: black;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>
    <div class="card">
        <form action="_functions.php" method="POST">
            <h3 class="login-heading">Bienvenido a </h3>
            <?php
            include '../includes/_db.php';
            if (isset($_GET['idvisita'])) {
                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }
                $idvisita = $_GET['idvisita'];
                $sql = "SELECT logo FROM establecimiento WHERE id = $idvisita";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $rutaLogo = $row['logo'];
                    ?>
                    <img src="../SuperAdmin/<?php echo $rutaLogo; ?>" alt="LOGO" style="width: 10rem;">
                <!-- </br>
            <h5 class="login-heading">por:</h5>
                <img src="../informacion/images/logo2.svg" alt="LOGO" style="width: 5rem;"> -->
                    <?php
                }

            } else {
                ?>
                <img src="../informacion/images/logo2.svg" alt="LOGO" style="width: 10rem;">
            <?php } ?>
            <h3 class="login-heading">Iniciar Sesión</h3>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <input type="hidden" name="accion" value="acceso_user">
            </div>
            <div class="form-group">
                <input type="submit" class="botonlogin" value="Ingresar">
            </div>
            <?php
            if (isset($_GET['idvisita'])) {
                ?>
                <h3 class="login-heading">¿No Estás Registrado?</h3>
                <div class="form-group">
                    <a href="./registrar.php?idvisita=<?php echo $_GET['idvisita'] ?>" class="botonlogin">Regístrate</a>
                </div>
                <?php
            }
            ?>
        </form>
        <?php
        if (isset($_GET['message'])) {
            ?>
            <div class="alert alert-primary text-center" role="alert">
                <?php
                switch ($_GET['message']) {
                    case 'ok':
                        echo 'Por favor, revisa tu correo';
                        break;
                    case 'success_password':
                        echo 'Inicia sesión con tu nueva contraseña';
                        break;
                    default:
                        echo 'Algo salió mal, intenta de nuevo';
                        break;
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>

</body>

</html>