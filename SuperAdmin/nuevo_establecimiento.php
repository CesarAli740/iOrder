<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
if($rol != '1'){
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
</head>

<body>

<form id="formulario" method="POST" action="consultas.php" enctype="multipart/form-data">
    <label for="nombre">Nombre del Establecimiento:</label>
    <input type="text" id="nombre" name="nombre" required><br>
    <label for="ubicacion">Selecciona tu Ubicación!:</label>
    <div id="map" style="width: 100%; height: 400px;"></div><br>

    <label for="tipo">Selecciona un tipo:</label>
    <select id="tipo" name="tipo">
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
    <input type="hidden" id="latitud" name="latitud" required>
    <input type="hidden" id="longitud" name="longitud" required><br>

    <label for="responsable">Nombre del Responsable:</label>
    <input type="text" id="responsable" name="responsable" required><br>

    <label for="tel_responsable">Número del Responsable:</label>
    <input type="tel" id="tel_responsable" name="tel_responsable" required><br>
    
    <!-- <label for="logo">Seleccionar Logo:</label>
    <input type="file" id="logo" name="logo" accept="image/*"><br>
 -->

    <button type="submit" name="crear_establecimiento">Registrar</button>
</form>


<script>
    var map;
    var marker;

    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: -16.519822, lng: -68.115971 }, // Centrar el mapa en una ubicación inicial
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