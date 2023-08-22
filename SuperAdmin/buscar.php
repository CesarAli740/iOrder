<?php include '../NAVBARiorder/index.php'; 
include ('../includes/_db.php') ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscar Usuarios</title>
</head>

<body>
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
</body>

</html>
