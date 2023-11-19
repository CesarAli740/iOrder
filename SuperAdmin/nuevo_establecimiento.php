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
            justify-content: flex-end;
            /* Alinea el contenedor hacia la derecha */
            align-items: center;
            margin-top: 1rem;
            color: white;
            width: 100%;
            background-color: rgba(128, 128, 128, 0.7);
        }

        .titulo {
            margin-top: 150px;
        }

        h1,
        h2,
        h3 {
            color: white;
            text-align: center;
            font-size: 50px;
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

        .form-control,
        .form-select,
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 1rem;
            /* Espacio entre los elementos */
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
            margin-top: 1rem;
        }

        .btn-success:hover {
            background-color: #7d1518;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
            border-radius: 1rem;
        }

        .container-map-child {
            display: flex;
            flex-direction: row;
            gap: 10rem;
            margin: 0 5rem;
            padding: 2rem;
        }

        .container-map-1 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 35%;
        }

        .container-map-2 {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50%;
        }

        form {
            width: 100%;
        }
        .container-image-logo {
            width: 6rem;
            height: 6rem;
            border-radius: .1rem;
            overflow: hidden; 
        }
        .imagen-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .container-logo{
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .input-logo{
            width: 80%;
            background-color: #ea272d;
            font-size: 1rem;
            border-radius: 1rem;
        }
        .send-form{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
        }
        .btn-success-2{
            background-color: #ea272d;
            color: white;
            width: 20%;
            height: 3rem;
            border-radius: 1rem;
            cursor: pointer;
            font-size: 1.5rem;
        }
        .btn-success-2:hover {
            background-color: #7d1518;
        }
        .colores{
            display: flex;
            gap: 1rem;
        }
        .color-input{
            width: 8rem;
            height: 3rem;
            cursor: pointer;
            border-radius: .5rem;
        }
        .form-label-colors{
            text-align: center;
        }

    </style>
    <?php include '../NAVBARiorder/index.php'; ?>
</head>

<body>
    <div class="titulo">
        <h2>Registro de Establecimiento</h2>
    </div>
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
                    <input class="form-label" type="hidden" id="latitud" name="latitud" required>
                    <input class="form-control" type="hidden" id="longitud" name="longitud" required><br>

                    <label class="form-label" for="responsable">Nombre del Responsable:</label>
                    <input class="form-control" type="text" id="responsable" name="responsable" required><br>

                    <label class="form-label" for="tel_responsable">Número del Responsable:</label>
                    <input class="form-control" type="tel" id="tel_responsable" name="tel_responsable" required><br>
                    <!-- REVISARRRRRRRRRRRRRR -->
                    <label class="form-label" for="horario">Horario de Operación:</label>
                    <textarea id="horario" name="horario" rows="4" cols="50" required></textarea>

                    <label class="form-label" for="vision">Frase o Visión del Negocio:</label>
                    <textarea id="vision" name="vision" rows="4" cols="50" required></textarea>

                    <label class="form-label" for="tel_responsable">Seleccione sus colores principales:</label>
                    <div class="colores">
                        <div class="form-label-colors">
                            <input class="color-input" name="color1" type="color" required><br>
                            <label for="">Menu</label>
                        </div>
                        <div class="form-label-colors">
                            <input class="color-input" name="color2" type="color" required><br>
                            <label  for="">Letras</label>
                        </div>
                    </div>

                    
                </div>
                <div class="container-map-2">
                    <label class="form-label" for="ubicacion">Selecciona tu Ubicación!:</label>
                    <div id="map" style="width: 100%; height: 450px;"></div><br>
                    <label class="form-label" for="imagen">Seleccionar Logo:</label>
                    <div class="container-logo">
                        <div class="container-image-logo">
                            <img class="imagen-logo" src="" alt="">
                        </div>
                        <input class="input-logo" type="file" id="seleccionar-imagen" name="imagen" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .webp, .svg, .ico" required>
                    </div>
                    <label class="form-label" for="descripcion">Descripción de Establecimiento:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50" required></textarea>
                </div>

            </div>

            <div class="send-form">
                <button class="btn-success-2" type="submit" name="crear_establecimiento">Registrar</button>
            </div>

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
    <script>
    const imagen = document.querySelector('.imagen-logo'); // Usar querySelector en lugar de getElementsByClassName
    const input = document.getElementById('seleccionar-imagen'); // Corregir el nombre del id

    input.addEventListener('change', (e) => {
        imagen.src = URL.createObjectURL(e.target.files[0]);
    });
</script>
</body>

</html>