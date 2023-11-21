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

    .container {
      width: 100%;
      text-align: center;
      background-color: rgba(128, 128, 128, 0.7);
      border: 1px solid black;
      border-radius: 2rem;
      padding: 1rem;
      font-family: Arial, sans-serif;
    }

    .contenedor-mesas {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      align-items: center;
    }

    .mesa {
      width: 100px;
      height: 100px;
      border: 2px solid #000;
      border-radius: 10px;
      margin: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      position: relative;
      cursor: pointer;
    }

    .numero-mesa {
      position: absolute;
      top: 100px;
      font-size: 18px;
      margin-top: .5rem;
    }

    .estado-mesa {
      font-size: 14px;
    }

    .mesa i {
      font-size: 48px;
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

    .mesa-select {
      display: none;
    }

    .reservar-container {
      display: flex;
      flex-direction: row;
      justify-content: space-evenly;
      align-items: center;
    }

    .title-reservas {
      font-size: 3rem;
      color: white;
      font-family: sans-serif;
      margin-bottom: 2rem;
    }

    .form-group {
      color: white;
      margin-bottom: 20px;
      width: 25%;
    }

    .form-label {
      display: block;
      font-weight: bold;
      margin-bottom: 1.5rem;
      font-size: 1.5rem;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 1rem;
      font-size: 14px;
    }

    .btn-reservar {
      background-color: #ea272d;
      color: white;
      margin: 1rem;
      border-radius: 1rem;
      padding: 1rem;
      cursor: pointer;
      font-weight: bold;
      font-size: 1rem;
    }
    .btn-reservar:hover {
      background-color: #7d1518;
    }

    .mesa.seleccionada {
      background-color: lightblue;
    }

    .footer {
      margin: 1rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="title-reservas">Reserva Tu Mesa</h1>

    <form action="_functions.php" method="post">
      <div class="reservar-container">
        <div class="form-group">
          <label class="form-label" for="nombre">Nombre:</label>
          <input class="form-control" type="text" id="nombre" name="nombre" required><br>
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email:</label>
          <input class="form-control" type="email" id="email" name="email" required><br>
        </div>
        <div class="form-group">
          <label class="form-label" for="telefono">Teléfono:</label>
          <input class="form-control" type="tel" id="telefono" name="telefono" required><br>
        </div>
      </div>
      <div class="reservar-container">
        <div class="form-group">
          <label class="form-label" for="fecha">Fecha de reserva:</label>
          <input class="form-control" type="date" id="fecha" name="fecha" required><br>
        </div>
        <div class="form-group">
          <label class="form-label" for="hora">Hora de reserva:</label>
          <input class="form-control" type="time" id="hora" name="hora" required><br>
        </div>
        <div class="form-group">
          <label class="form-label" for="mesaSelect"></label>
          <select class="form-control mesa-select" id="mesaSelect" name="mesaId">
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
        </div>
      </div>

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
            </span>
            <i class="fa-solid fa-utensils"></i>
            <span class="estado-mesa">
              <?php echo $estado_texto; ?>
            </span>
          </div>
        <?php
          $contador++;
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
      </div>

      <br>
      <input class="btn-reservar" type="submit" value="Reservar">
    </form>
    <div class="footer">
      <p>Seleccione un número de mesa para reservar.</p>
    </div>
  </div>

  <!-- ... tu código JavaScript ... -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const mesas = document.querySelectorAll(".mesa");

      mesas.forEach(mesa => {
        mesa.addEventListener("click", () => {
          const mesaId = mesa.getAttribute("data-id");
          const mesaSelect = document.getElementById("mesaSelect");
          const estadoMesa = mesa.classList.contains("reservado") ? "reservado" : "disponible";

          // Verificar si la mesa está disponible antes de seleccionarla
          if (estadoMesa === "disponible") {
            // Actualizar el valor del campo de selección
            mesaSelect.value = mesaId;

            // Agregar la clase 'seleccionada' a la mesa clicada
            mesa.classList.add("seleccionada");

            // Quitar la clase 'seleccionada' de otras mesas
            mesas.forEach(otraMesa => {
              if (otraMesa !== mesa) {
                otraMesa.classList.remove("seleccionada");
              }
            });
          }
        });
      });
    });
  </script>
</body>

</html>