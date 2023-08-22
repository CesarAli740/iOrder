<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        body {
            background-color: #ECF8F9;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px; /* Reducido el ancho máximo */
            width: 100%;
            padding: 15px; /* Reducido el padding */
            background-color: #fff;
        }

        .card-title {
            color: #1B9C85;
            font-size: 1.5rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        }

        .btn-success {
            background-color: #1B9C85;
        }

        .btn-secondary {
            background-color: #ccc;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
   
        <div class="modal-content">
            <h3 class="card-title">Registro de nuevo usuario</h3>
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
                    <label for="correo">Correo:</label>
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
                    <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                    <button type="button" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const openModalBtn = document.getElementById("openModal");
        const modal = document.getElementById("myModal");

        openModalBtn.addEventListener("click", () => {
            modal.style.display = "flex";
        });
    </script>
</body>

</html>