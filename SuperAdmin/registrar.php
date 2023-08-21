<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
</head>

<body id="page-top">
    <form action="../includes/validar.php" method="POST">
        <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12"><br><br>
                            <h3 class="text-center">Registro de nuevo usuario</h3>
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="apPAt" class="form-label">Apellido Paterno *</label>
                                <input type="text" id="apPAt" name="apPAt" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="apMAt" class="form-label">Apellido Materno *</label>
                                <input type="text" id="apMAt" name="apMAt" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Correo:</label><br>
                                <input type="email" name="correo" id="correo" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="telefono" class="form-label">Telefono *</label>
                                <input type="tel" id="telefono" name="telefono" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                                <a href="#">Cancelar</a>
                            </div>
    </form>
</body>

</html>