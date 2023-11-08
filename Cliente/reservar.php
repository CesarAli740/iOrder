<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if ($rol != '5') {
  session_unset();
  session_destroy();
  header("Location: ../includes/login.php");
  die();
}
?>
<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Reservar Mesa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      margin-top: 120px;
      padding: 20px;
    }

    .contenedor-mesas {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      /* Espacio entre las mesas */
    }

    .mesa {
      width: 100px;
      /* Ancho de cada mesa */
      height: 100px;
      /* Altura de cada mesa */
      border: 2px solid #000;
      border-radius: 10px;
      /* Bordes redondeados */
      margin: 20px;
      /* Espaciado entre las mesas */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      /* Tamaño del número de mesa */
      position: relative;
      /* Para posicionar el número y el estado */
    }

    .numero-mesa {
      position: absolute;
      top: 100px;
      /* Ajusta la posición vertical del número */
      font-size: 18px;
      /* Tamaño del número de mesa */
    }


    .estado-mesa {
      font-size: 14px;
      /* Tamaño del texto del estado */
    }

    .mesa i {
      font-size: 48px;
      /* Tamaño del icono */
    }

    .disponible {
      color: green;
    }

    .reservado {
      color: yellow;
    }

    .ocupado {
      color: red;
    }

    /* Deshabilitar la interacción del usuario */
    .mesa {
      pointer-events: none;
    }

    .footer {
      background-color: #f1f1f1;
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>

<body>
  <h1>Reservar Mesa</h1>
  <form action="_functions.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="telefono">Teléfono:</label>
    <input type="tel" id="telefono" name="telefono" required><br>

    <label for="fecha">Fecha de reserva:</label>
    <input type="date" id="fecha" name="fecha" required><br>

    <label for="hora">Hora de reserva:</label>
    <input type="time" id="hora" name="hora" required><br>

    <label for="mesa">Selecciona una mesa:</label>
    <select id="mesaId" name="mesaId">
      <?php
      // Hacer una consulta a la base de datos para obtener las mesas disponibles
      $sql = "SELECT id, estado FROM mesas WHERE mesas.establecimiento_id = $establecimiento";
      $result = $conexion->query($sql);
      $contador = 1;

      // Mostrar las mesas disponibles en el formulario
      while ($row = $result->fetch_assoc()) {
        $mesa_id = $row['id'];
        if ($row['estado'] == 'disponible') {
          echo "<option value='$mesa_id'>Mesa $contador</option>";
        }
        $contador++;
      }
      ?>
    </select>
    <!-- Campo oculto para almacenar el ID de la mesa -->

    <div class="contenedor-mesas">
      <?php
      if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
      }

      // Consultar las mesas de la base de datos
      $sql = "SELECT id, nombre, estado FROM mesas WHERE mesas.establecimiento_id = $establecimiento";
      $result = $conexion->query($sql);
      $contador = 1;

      while ($row = $result->fetch_assoc()) {
        $mesa_id = $row['id'];
        $estado_mesa = $row['estado'];
        $clase_estado = ($estado_mesa == 'disponible') ? 'disponible' : (($estado_mesa == 'reservado') ? 'reservado' : 'ocupado');
        $estado_texto = ($estado_mesa == 'disponible') ? 'Disponible' : (($estado_mesa == 'reservado') ? 'Reservado' : 'Ocupado');
        ?>
        <div class="mesa <?php echo $clase_estado; ?>" data-id="<?php echo $mesa_id; ?>">
          <span class="numero-mesa">Mesa
            <?php echo $contador; ?>
          </span> <!-- Número de mesa con el prefijo "Mesa" -->
          <i class="fa-solid fa-bowl-food"></i> <!-- Icono dentro del margen de la mesa -->
          <span class="estado-mesa">
            <?php echo $estado_texto; ?>
          </span> <!-- Texto del estado debajo del icono -->
        </div>

        <?php
        $contador++;
      }

      // Cerrar la conexión
      $conexion->close();
      ?>
    </div>

    <br>
    <input type="submit" value="Reservar">
  </form>
  <div class="footer">
    <p>Seleccione un número de mesa para reservar.</p>
  </div>
</body>

</html>