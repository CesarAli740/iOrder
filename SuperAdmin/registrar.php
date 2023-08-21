<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <!-- Enlace a los estilos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #1B9C85;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Registro de nuevo usuario</h3>
                    <form action="../includes/validar.php" method="POST">
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
                            <label for="username">Correo:</label>
                            <input type="email" name="correo" id="correo" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Telefono *</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <input type="submit" value="Guardar" class="btn btn-success">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a los scripts de JavaScript de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>