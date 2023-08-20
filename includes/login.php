<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<style>
    body {
        background-color: #ECF8F9;
        margin-top: 5rem;
    }

    .botonlogin {
        text-decoration: none;
        background-color: #1B9C85;
        border: none;
        color: white;
        padding: 0.375rem 0.75rem;
        text-align: center;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px;
        font-family: 'Roboto', sans-serif;
    }
</style>

<body>
<div id="stars"></div>
  <div id="stars2"></div>
  <div id="stars3"></div>
    <form action="_functions.php" method="POST">
        <div id="login">
            <div class="container ">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-8">
                        <div id="login-box" class="col-md-12">
                            <br>

                            <br>
                            <h3 class="text-center">Iniciar Sesión</h3>
                            <br>
                            <div class="form-group">
                                <label for="correo">Correo:</label><br>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <input type="hidden" name="accion" value="acceso_user">
                            </div>
                            <div class="form-group">
                                <br>
                                <center>
                                    <input type="submit" class="botonlogin" value="Ingresar">
                                </center>
                                <div class="my-2">
                                    <a href="../recuperacion/recovery.php">¿Olvidaste tu contraseña?</a>
                                </div>
                                <?php
                                if (isset($_GET['message'])) {

                                    ?>
                                    <div class="alert alert-primary" role="alert">
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
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </form>
</body>

</html>