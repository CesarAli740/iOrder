<?php
include '../NAVBARiorder/index.php';
include '../includes/_db.php';

$establecimiento = isset($_GET['idvisita']) ? $_GET['idvisita'] : $_SESSION['establecimiento'];

$query = "SELECT * FROM establecimiento WHERE id = $establecimiento";
$result = mysqli_query($conexion, $query);

if ($result) {
    $establecimientoData = mysqli_fetch_assoc($result);
    mysqli_close($conexion);
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Cliente</title>
        <style>
            body {
            
                display: flex;
                flex-direction: column;
                align-items: center;
                height: 100vh;
                margin: 100;
            }

            .welcome-message {
                font-size: 4rem;
                text-align: center;
                color: white;
                margin: 13rem 
            }
            .establecimiento-info {
                font-size: 1.5rem;
                color: white;
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-top: 10rem;
            }

            .establecimiento-info div {
                color: white;
               

                margin: 20px;
                padding: 15px;
                border-radius: 10px;
                width: 80%; /* Ancho del contenedor de información */
            }

            .establecimiento-info img {
                
                color: white;
                max-width: 200px;
                max-height: 200px;
            }

            
            #map-container {
        height: 300px; /* Ajusta la altura según sea necesario */
        border-radius: 1rem;
        overflow: hidden;
        margin-bottom: 20px;
    }

    /* Estilos adicionales para el formulario y las mesas */
    /* ... (otros estilos) ... */

    .form-group {
        color: white;
        margin-bottom: 20px;
        width: 25%;
    }

    .contenedor-mesas {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .mesa {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid #000;
        margin: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        position: relative;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
        </style>
    </head>

    <body>
        <div class="welcome-message"><br>
            <p>¡Bienvenido a <?php echo $establecimientoData['nombre']?>!</p>
        </div>

        <div class="establecimiento-info">
            <div>
                <h2>Información del Establecimiento</h2><br><br>
                
                <p><strong>Teléfono de Contacto:</strong><br>
                    <?php echo $establecimientoData['tel_responsable']; ?>
                </p><br><br>
                <p><strong>Descripción:</strong><br>
                    <?php echo $establecimientoData['descripcion']; ?><br>
                </p>
            </div>

            <div>
                <h3>Ubicación:</h3>
                <div id="map" style="height: 400px; width: 80%;"></div>
            </div>

            <div>
                <h3>Horario de Operación:</h3>
                <p>
                    <?php echo $establecimientoData['horario_operacion']; ?>
                </p>
            </div>

            <div>
                <h3>Visión del Negocio:</h3>
                <p>
                    <?php echo $establecimientoData['vision_negocio']; ?>
                </p>
            </div>


        </div>
    </body>

    </html>

    <script>
        function initMap() {
            var latitud = <?php echo $establecimientoData['latitud']; ?>;
            var longitud = <?php echo $establecimientoData['longitud']; ?>;

            var establecimientoLatLng = new google.maps.LatLng(latitud, longitud);

            var mapOptions = {
                center: establecimientoLatLng,
                zoom: 15
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var marker = new google.maps.Marker({
                position: establecimientoLatLng,
                map: map,
                title: '<?php echo $establecimientoData['nombre']; ?>'
            });
        }
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDsMDudKEIbSQZH-dP2W9JP3b3F10_85k&callback=initMap" async defer></script>

    <?php
} else {
    echo "Error al obtener la información del establecimiento";
}
?>