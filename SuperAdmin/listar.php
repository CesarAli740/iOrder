<?php include '../NAVBARiorder/index.php'; 

include ('../includes/_db.php') ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar</title>
</head>

<body>
  <div class="container is-fluid">
    <div class="col-xs-12"><br>
      
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
$SQL = "SELECT user.id, user.nombre, user.apPAt, user.apMAt, user.correo, user.telefono
        FROM user
        LEFT JOIN permisos ON user.rol = permisos.id";
            $dato = mysqli_query($conexion, $SQL);

            if ($dato->num_rows > 0) {
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
            } else { ?>
          <tr class="text-center">
            <td colspan="7">No existen registros</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
