<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <style>
        body {
            background-color: #ECF8F9;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .button {
            display: inline-block;
            width: 250px;
            height: 60px;
            margin: 10px;
            padding: 15px 30px;
            border-radius: 10px;
            background-color: #1B9C85;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="content">
        <!-- Botones para las funcionalidades -->
        <a class="button" href="registrar.php">Nuevo Registro</a>
        <a class="button" href="listar.php">Listar</a>
        <a class="button" href="buscar.php">Buscar</a>
        <a class="button" href="editar.php">Editar</a>
    </div>
</body>

</html>