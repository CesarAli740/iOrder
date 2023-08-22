<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuarios</title>
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
            max-width: 800px; /* Ancho máximo de la modal */
            width: 100%;
            padding: 15px;
            background-color: #fff;
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

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
    </style>
</head>

<body>
        <div class="modal-content">
            <?php  
                  include ('../includes/_db.php'); ?>

            <div class="container is-fluid">
                <div class="col-xs-12"><br>
                    <form action="" method="GET">
                        <label for="buscar">Buscar:</label>
                        <input type="text" name="buscar" id="buscar">
                        <button type="submit">Buscar</button>
                    </form>
                    <br>
                    <?php
                    if (isset($_GET['buscar'])) {
                        $buscar = $_GET['buscar'];
                        $SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono, permisos.rol
                                FROM user
                                LEFT JOIN permisos ON user.rol = permisos.id
                                WHERE user.nombre LIKE '%$buscar%'
                                OR user.apPAt LIKE '%$buscar%'
                                OR user.apMAt LIKE '%$buscar%'
                                OR user.correo LIKE '%$buscar%'
                                OR user.telefono LIKE '%$buscar%'
                                OR permisos.rol LIKE '%$buscar%'";
                        $dato = mysqli_query($conexion, $SQL);

                        if ($dato->num_rows > 0) {
                    ?>
                            <table id="table_id">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Correo</th>
                                        <th>Telefono</th>
                                        <th>Rol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($fila = mysqli_fetch_array($dato)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $fila['nombre']; ?></td>
                                            <td><?php echo $fila['apPAt']; ?></td>
                                            <td><?php echo $fila['apMAt']; ?></td>
                                            <td><?php echo $fila['correo']; ?></td>
                                            <td><?php echo $fila['telefono']; ?></td>
                                            <td><?php echo $fila['rol']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        } else {
                            echo "<p>No se encontraron resultados.</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.querySelector(".modal");
        modal.style.display = "flex"; // Abre el modal automáticamente al cargar la página
    </script>
</body>

</html>