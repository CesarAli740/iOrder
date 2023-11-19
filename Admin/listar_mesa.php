<?php
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if ($rol != '2') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('../includes/_db.php');

    // Lógica para cambiar el estado de la mesa
    if (isset($_POST['idMesa']) && isset($_POST['nuevoEstado'])) {
        $idMesa = $_POST['idMesa'];
        $nuevoEstado = $_POST['nuevoEstado'];

        // Realiza la actualización en la base de datos
        $updateSQL = "UPDATE mesas SET estado = '$nuevoEstado' WHERE id = '$idMesa' AND establecimiento_id = '$establecimiento'";
        if (mysqli_query($conexion, $updateSQL)) {
            // Actualización exitosa, puedes mostrar un mensaje si es necesario
            echo "Estado de la mesa $idMesa actualizado a $nuevoEstado";
        } else {
            // Error en la actualización
            echo "Error al actualizar el estado de la mesa.";
        }
    }

    // Lógica para eliminar la mesa
    if (isset($_POST['eliminarMesa'])) {
        $idMesaEliminar = $_POST['eliminarMesa'];
        $deleteSQL = "DELETE FROM mesas WHERE id = '$idMesaEliminar' AND establecimiento_id = '$establecimiento'";
        if (mysqli_query($conexion, $deleteSQL)) {
            echo "Mesa $idMesaEliminar eliminada exitosamente";
        } else {
            echo "Error al eliminar la mesa.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Mesas</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" />
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .container {
            margin: auto;
            margin-top:30px;
            background-color: rgba(128, 128, 128, 0.7);
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h2,
        h3 {
            color: white;
            text-align: center;
            font-size: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-success {
            background-color: #1B9C85;
        }

        .btn-secondary {
            background-color: #ea272d;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            margin: auto;
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
            width: 100%;
        }

        th,
        td {
            color: white;
            padding: 15px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: rgba(128, 128, 128, 0.5);
        }

        /* styles.css */

        /* ... tus estilos generales ... */

        /* Estilos para las secciones abiertas al hacer clic en los botones */
        .section-container {
            background-color: transparent;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 80%;
            /* Ajusta el ancho máximo según tu preferencia */
        }

        .section-title {
            color: #1B9C85;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .table-header {
            margin-top: 1rem;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 5rem;
            margin-bottom: 2rem;
        }

        /* Nuevos estilos agregados */
        .container {
            margin: auto;
            margin-top: 50px;
            background-color: rgba(128, 128, 128, 0.7);
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white; /* Cambia el color de texto a negro */
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
         .btn-danger {
            background-color: #ea272d;
            color: white;
        }
        </style>
</head>

<body>

    <div class="modal-content" style="margin-top: 10rem">
        <div class="table-header">
            <h2 class="modal-title">Lista de Mesas</h2>
            <?php include('../includes/_db.php'); ?>
        </div>
        <div class="container is-fluid">
            <div class="col-xs-12"><br>

                <table id="table_id">
                    <thead>
                        <tr>
                            <th>ID Mesa</th>
                            <th>Estado</th>
                            <th>Cambiar Estado</th>
                            <th>Eliminar Mesa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $SQL = "SELECT id, estado FROM mesas WHERE establecimiento_id = '$establecimiento'";
                        $result = mysqli_query($conexion, $SQL);

                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['estado']; ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="idMesa" value="<?php echo $row['id']; ?>">
                                            <select name="nuevoEstado" class="select-estado" onchange="this.form.submit()">
                                                <option value="disponible" <?php echo ($row['estado'] == 'disponible') ? 'selected' : ''; ?>>Disponible</option>
                                                <option value="reservado" <?php echo ($row['estado'] == 'reservado') ? 'selected' : ''; ?>>Reservado</option>
                                                <option value="ocupado" <?php echo ($row['estado'] == 'ocupado') ? 'selected' : ''; ?>>Ocupado</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST">
                                            <button type="submit" name="eliminarMesa" value="<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr class="text-center">
                                <td colspan="4">No existen mesas registradas</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <!-- Agregamos jQuery y DataTables para el modal de confirmación -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

    <script>
        $(document).ready(function() {
            // Configuración del DataTable con idioma español
            $('#table_id').DataTable({
                searching: false,
                lengthChange: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });
        });

        function confirmarCambioEstado(idMesa, estadoActual, nuevoEstado) {
            $.confirm({
                title: 'Confirmación',
                content: `¿Estás seguro de cambiar el estado de la mesa ${idMesa} de ${estadoActual} a ${nuevoEstado}?`,
                buttons: {
                    confirm: function() {
                        // Enviar la solicitud AJAX para cambiar el estado en la base de datos
                        $.ajax({
                            type: 'POST',
                            url: 'cambiar_estado_mesa.php',
                            data: {
                                idMesa: idMesa,
                                nuevoEstado: nuevoEstado
                            },
                            success: function(response) {
                                // Muestra el mensaje de éxito en un popup
                                $.alert({
                                    title: 'Éxito',
                                    content: response,
                                    buttons: {
                                        ok: function() {
                                            // Actualizar la interfaz o realizar otras acciones si es necesario
                                            location.reload(); // Recargar la página para reflejar los cambios
                                        }
                                    }
                                });
                            },
                            error: function() {
                                // Muestra el mensaje de error en un popup
                                $.alert('Error al cambiar el estado de la mesa.');
                            }
                        });
                    },
                    cancel: function() {
                        // Revertir la selección del estado si se cancela la confirmación
                        $('.select-estado').val(estadoActual);
                    }
                }
            });
        }
    </script>
</body>

</html>