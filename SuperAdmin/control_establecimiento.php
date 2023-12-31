<?php
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if ($rol != '1') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}

include '../NAVBARiorder/index.php';

include('../includes/_db.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <title>Control de Establecimientos</title>
    <style>
        body {
            background-color: transparent;
            margin: 0;
            font-family: Arial, sans-serif;
           
        }

        .container {
            margin: auto;
            margin-top: 20px;
            background-color: transparent;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white;
            /* Cambia el color de texto a negro */
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(128, 128, 128, 0.7);
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #1B9C85;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #1B9C85;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
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
            background-color: #ea272d;
            color: white;
        }

        .btn-secondary {
            background-color: #ea272d !important;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7d1518 !important;
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
            /* Cambia el color de texto a negro */
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
        }

        /* Estilos para el botón con éxito (verde) */
        .btn-success {
            background-color: #28a745;
            color: white;
        }

        /* Estilos para el botón con peligro (rojo) */
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        /* Estilos para el ícono dentro del botón */
        .btn-estado span {
            font-size: 1.5em;
            vertical-align: middle;
            margin-right: 5px;
        }


        
    </style>
</head>


<body>

    <div class="modal-content" style="margin-top: 8rem">
        <div class="table-header">
            <h2 class="modal-title">Lista de Establecimientos</h2>
            <button onclick="window.location.href='./index.php'" type="button" class="btn btn-secondary">Volver</button>
        </div>

        <?php include('../includes/_db.php'); ?>

        <div class="container is-fluid">
            <div class="col-xs-12"><br>
                <table id="table_id">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th>Inicio de suscripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $SQL = "SELECT * FROM establecimiento";
                        $result = mysqli_query($conexion, $SQL);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['responsable']; ?></td>
                                    <td><?php echo $row['fecha_creacion']; ?></td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" <?php echo ($row['estado'] == 1) ? 'checked' : ''; ?> data-id="<?php echo $row['id']; ?>" onchange="cambiarEstado(this)">
                                            <span class="slider"></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="4">No existen registros</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../js/user.js"></script>
    <script>
        function cambiarEstado(checkbox) {
            var id = $(checkbox).data('id');

            $.ajax({
                url: '../includes/estado.php',
                method: 'POST',
                data: {
                    id: id
                },
                success: function (response) {
                    console.log(response);
                    if (response.trim() !== 'success') {
                        alert('Hubo un problema al cambiar el estado. Respuesta: ' + response);
                        // Revertir el cambio en la interfaz si hay un error
                        checkbox.checked = !checkbox.checked;
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente más tarde.');
                    // Revertir el cambio en la interfaz si hay un error
                    checkbox.checked = !checkbox.checked;
                }
            });
        }
    </script>

</body>


</html>