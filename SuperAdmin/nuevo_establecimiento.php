<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if ($rol != '1') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Establecimiento</title>
    <style>
        .container-map {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 8rem;
            color: white;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
            font-size: 1.4rem;
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
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-success {
            background-color: #ea272d;
            color: white;
            width: 50%;
            height: 3rem;
            border-radius: 1rem;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: #7d1518;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
            margin-left: 8rem;
        }

        .btn-secondary:hover {
            background-color: #5f5f5f;
            color: #333;
            margin-left: 8rem;
        }

        .container-map-child {
            display: flex;
            flex-direction: row;
            gap: 10rem;
            margin: 0 5rem;
            padding: 2rem;
        }
        .container-map-1{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 35%;
        }
        .container-map-2{
            width: 50%;
        }
        .form-select{
            width: 100%;
            height: 3rem;
            border-radius: 1rem;
            cursor: pointer;
        }
        form{
            width: 100%;
        }
    </style>
    <?php include '../NAVBARiorder/index.php'; ?>
</head>

<body>
    <div class="container-map">
        <form id="formulario" method="POST" action="consultas.php" enctype="multipart/form-data">
            <div class="container-map-child">
                <div class="container-map-1">
                    <label class="form-label" for="nombre">Nombre del Establecimiento:</label>
                    <input class="form-control" type="text" id="nombre" name="nombre" required><br>
                    <label class="form-label" for="tipo">Selecciona un tipo:</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <?php
                        // Hacer una consulta a la base de datos para obtener las mesas disponibles
                        $sql = "SELECT * FROM establecimiento_tipo";
                        $result = $conexion->query($sql);

                        // Mostrar las mesas disponibles en el formulario
                        while ($row = $result->fetch_assoc()) {
                            $establecimiento_id = $row['id'];
                            $nombre = $row['tipo'];
                            echo "<option value='$establecimiento_id'>$nombre</option>";
                        }
                        ?>
                    </select>
                    <input class="form-control" type="hidden" id="latitud" name="latitud" required>
                    <input class="form-control" type="hidden" id="longitud" name="longitud" required><br>

                    <label class="form-label" for="responsable">Nombre del Responsable:</label>
                    <input class="form-control" type="text" id="responsable" name="responsable" required><br>

                    <label class="form-label" for="tel_responsable">Número del Responsable:</label>
                    <input class="form-control" type="tel" id="tel_responsable" name="tel_responsable" required><br>
                    <button class="btn-success" type="submit" name="crear_establecimiento">Registrar</button>
                </div>
                <div class="container-map-2">
                    <label class="form-label" for="ubicacion">Selecciona tu Ubicación!:</label>
                    <div id="map" style="width: 100%; height: 450px;"></div><br>
                </div>

            </div>



            <label for="logo">Seleccionar Logo:</label>
    <input type="file" id="logo" name="logo" accept="image/*"><br>


        </form>
    </div>



    <script>
        var map;
        var marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: -16.519822,
                    lng: -68.115971
                }, // Centrar el mapa en una ubicación inicial
                zoom: 15
            });

            // Agregar un evento de clic al mapa para obtener las coordenadas y colocar el marcador
            map.addListener('click', function(event) {
                placeMarker(event.latLng);
                document.getElementById('latitud').value = event.latLng.lat();
                document.getElementById('longitud').value = event.latLng.lng();
            });

            // Función para colocar un marcador en la ubicación dada
            function placeMarker(location) {
                // Si el marcador ya existe, actualiza su posición, de lo contrario, crea un nuevo marcador
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        animation: google.maps.Animation.DROP
                    });
                }
            }

            var formulario = document.getElementById('formulario');

            // Agregar un evento de submit al formulario
            formulario.addEventListener('submit', function(event) {
                // Verificar si se ha colocado el marcador en el mapa
                if (!marker) {
                    alert('Debes seleccionar una ubicación en el mapa antes de enviar el formulario.');
                    event.preventDefault(); // Evita el envío del formulario si no hay marcador
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDsMDudKEIbSQZH-dP2W9JP3b3F10_85k&callback=initMap" async defer></script>
</body>

</html>