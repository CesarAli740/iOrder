<?php
include '../includes/_db.php';
session_start();

error_reporting(0);
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];

?>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: sans-serif;
  }

  body {


    background-image: url('../images/imagenmesa.svg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    /* Opcional: mantiene la imagen fija mientras se desplaza */

    min-height: 100vh;
  }

  .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 1.3rem 10%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
  }

  .header::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(50px);
    z-index: -1;
  }

  .header::after {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg,
        transparent,
        rgba(255, 255, 255, 0.4),
        transparent);
    transition: 0.5s;
  }

  .header:hover::after {
    left: 100%;
  }

  .logo {
    font-size: 2rem;
    color: #fff;
    text-decoration: none;
    font-weight: 700;
  }

  .navbar a {
    font-size: 1.5rem;
    /* Cambia el valor a tu preferencia */
    color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    margin-left: 2.5rem;
  }

  .navbar a:hover {
    /* color: #f34dc3;
  color: #9c3cea;
  color: #582417;
  color: #FDBB03;
  color: #EE0000;
  color: #00144b; */
    color: black;
    transition: 0.5s ease;
  }

  #check {
    display: none;
  }

  .icons {
    position: absolute;
    right: 5%;
    font-size: 2.8rem;
    color: #fff;
    cursor: pointer;
    display: none;
  }

  /* responsive */
  @media (max-width: 992px) {
    .header {
      padding: 1.3rem 5%;
    }
  }

  @media (max-width: 768px) {
    .icons {
      display: inline-flex;
    }

    #check:checked~.icons #menu-icon {
      display: none;
    }

    .icons #close-icon {
      display: none;
    }

    #check:checked~.icons #close-icon {
      display: block;
    }

    .navbar {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      height: 0;
      background: rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(50px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: 0.3s ease;
    }

    #check:checked~.navbar {
      height: 17.7rem;
    }

    .navbar a {
      display: block;
      font-size: 1.1rem;
      margin: 1.9rem 0;
      text-align: center;
      transform: translateY(-50px);
      opacity: 0;
    }

    #check:checked~.navbar a {
      transform: translateY(0);
      opacity: 1;
      transition-delay: calc(0.1s * var(--i));
    }
  }

  .video-container {
    position: relative;
    height: 100vh;
    overflow: hidden;
    z-index: 1;
  }

  .video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .video-container::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
  }

  /* Add this CSS to your existing styles */
  .dropdown {
    position: relative;
    display: inline-block;
    position: relative;
    /* Agregar posición relativa */
  }

  .dropdown-content {
    position: absolute;
    background-color: rgba(169, 169, 169, 0.5);
    
    ;
    width: 140px;
    border-radius: 8px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    opacity: 0;
    visibility: hidden;
    text-align: center;
    left: 60%;
    /* Centrar horizontalmente con respecto al elemento padre */
    transform: translateX(-50%);
    /* Centrar horizontalmente con respecto al elemento padre */
    top: 100%;
    /* Coloca el menú debajo del elemento padre */
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
  }

  .navbar {
    position: relative;
    /* Add relative positioning to the navbar container */
  }

  .dropdown:hover .dropdown-content {
    opacity: 1;
    visibility: visible;
  }

  .dropdown-content a {
    color: white;
    padding: 12px 0;
    margin-left: 2.5rem;
    /* Remove left margin to align the text to the left edge */
    text-decoration: none;
    display: block;
    text-align: left;
    /* Align the text to the left within the dropdown option */
  }

  .dropdown-content a:hover {
    background-color: rgba(255, 255, 255, 0.2);
  }

  /* Add a transition for the dropdown content */
  .dropdown:hover .dropdown-content {
    opacity: 1;
    visibility: visible;
  }


  .btn {
    background-color: #4CAF50;
    /* Cambia el color de fondo del botón a verde */
    color: #fff;
    /* Cambia el color del texto del botón a blanco */
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .btn:hover {
    background-color: #45a049;
    /* Cambia el color de fondo al pasar el mouse */
  }
</style>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NAVBAR</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php

if ($rol == '1') {
  ?>

  <body style="background-image: url('../images/mesa2.svg');">
    <header class="header">
      <a href="../SuperAdmin/index.php" class="logo">
        <img src="../informacion/images/logo2.svg" alt="LOGO" style="width: 10rem;">
      </a>
      <input type="checkbox" id="check">
      <label for="check" class="icons">
        <i class='bx bx-menu' id="menu-icon"></i>
        <i class='bx bx-x' id="close-icon"></i>
      </label>
      <nav class="navbar">
        <a href="../SuperAdmin/index.php" style="--i:0;">Inicio</a>
        <div class="dropdown">
          <a href="#" style="--i:1;">Usuarios</a>
          <div class="dropdown-content">
            <a href="../SuperAdmin/registrar.php">Crear</a>
            <a href="../SuperAdmin/listar.php">Listar</a>
            <a href="../SuperAdmin/buscar.php">Buscar</a>
            <a href="../SuperAdmin/editar.php">Editar</a>
          </div>
        </div>
        <div class="dropdown">
          <a href="#" style="--i:2;">Establecimientos</a>
          <div class="dropdown-content">
            <a href="../SuperAdmin/nuevo_establecimiento.php">Crear</a>
            <a href="../SuperAdmin/listar_establecimientos.php">Listar</a>
            <a href="../SuperAdmin/buscar_establecimiento.php">Buscar</a>
            <a href="../SuperAdmin/editar_establecimiento.php">Editar</a>
            <a href="../SuperAdmin/control_establecimiento.php">Control</a>
          </div>
        </div>
        <!-- <div class="dropdown">
                <a href="#" style="--i:3;">Tipo</a>
                <div class="dropdown-content">
                    <a href="../SuperAdmin/registrar_tipo.php">Crear</a>
                    <a href="../SuperAdmin/listar_tipo.php">Listar</a>
                    <a href="../SuperAdmin/buscar_tipo.php">Buscar</a>
                    <a href="../SuperAdmin/editar_tipo_form.php">Editar</a>
                </div>
            </div> -->
        <a href="../includes/_sesion/cerrarSesion.php" style="--i:4;">Salir</a>
      </nav>
    </header>


  </body>
  <?php
} else ?>

<?php
if ($rol == '2') {
  ?>

  <body style="background-image: url('../images/mesa3.svg');">
    <header class="header">
      <a href="../Admin/index.php" class="logo">
        <?php $query = "SELECT logo FROM establecimiento WHERE id = $establecimiento";

        $resultado = $conexion->query($query);

        if ($resultado) {
          $fila = $resultado->fetch_assoc();
          $logo = $fila['logo'];
          $resultado->free();
        } else {
          echo "Error en la consulta: " . $conexion->error;
        } ?>
        <?php if (isset($logo)): ?>
          <img src="../SuperAdmin/<?php echo $logo ?>" alt="LOGO" style="height: 5rem;">
        <?php else: ?>
          <p>No se encontró ninguna imagen para este establecimiento.</p>
        <?php endif; ?>

      </a>

      <input type="checkbox" id="check">
      <label for "check" class="icons">
        <i class='bx bx-menu' id="menu-icon"></i>
        <i class='bx bx-x' id="close-icon"></i>
      </label>
      <nav class="navbar">
        <a href="../Admin/index.php" style="--i:0;">Inicio</a>
        <a href="../Admin/menu.php" style="--i:0;">Menu</a>
        <div class="dropdown">
          <a href="#" style="--i:1;">Usuarios</a>
          <div class="dropdown-content">
            <a href="../Admin/registrar.php">Crear</a>
            <a href="../Admin/listar.php">Listar</a>
            <a href="../Admin/buscar.php">Buscar</a>
            <a href="../Admin/editar.php">Editar</a>
          </div>
        </div>
        <div class="dropdown">
          <a href="#" style="--i:1;">Mesas</a>
          <div class="dropdown-content">
            <a href="../Admin/registrar_mesa.php">Crear</a>
            <a href="../Admin/listar_mesa.php">Listar</a>
          
          </div>
        </div>
        <div class="dropdown">
          <a href="#" style="--i:3;">Reportes</a>
          <div class="dropdown-content">
            <a href="../Admin/reportes-pedidos.php">Pedidos</a>
            <a href="../Admin/reportes-reservas.php">Reservas</a>
          </div>
       </div>

        <a href="../Admin/perfil.php" style="--i:4;">Perfil</a>
        <a href="../includes/_sesion/cerrarSesion.php" style="--i:5;">Salir</a>
      </nav>
    </header>
  </body>

  <?php
} ?>

<?php
if ($rol == '4') {
  ?>

  <body style="background-image: url('../images/mesa3.svg');">
    <header class="header">
      <a href="../Empleado/index.php" class="logo">
        <?php $query = "SELECT logo FROM establecimiento WHERE id = $establecimiento";

        $resultado = $conexion->query($query);

        if ($resultado) {
          $fila = $resultado->fetch_assoc();
          $logo = $fila['logo'];
          $resultado->free();
        } else {
          echo "Error en la consulta: " . $conexion->error;
        } ?>
        <?php if (isset($logo)): ?>
          <img src="../SuperAdmin/<?php echo $logo ?>" alt="LOGO" style="height: 5rem;">
        <?php else: ?>
          <p>No se encontró ninguna imagen para este establecimiento.</p>
        <?php endif; ?>

      </a>

      <input type="checkbox" id="check">
      <label for "check" class="icons">
        <i class='bx bx-menu' id="menu-icon"></i>
        <i class='bx bx-x' id="close-icon"></i>
      </label>
      <nav class="navbar">
        <a href="../Empleado/index.php" style="--i:0;">Inicio</a>
        <a href="../Empleado/reservas.php" style="--i:1;">Reservas</a>
        <a href="../Empleado/pedidos.php" style="--i:2;">Pedidos</a>
        <a href="../Empleado/mesas.php" style="--i:3;">Mesas</a>
        <a href="../includes/_sesion/cerrarSesion.php" style="--i:5;">Salir</a>
      </nav>
    </header>
  </body>

  <?php
} ?>

<?php
if ($rol == '5') {
  ?>

  <body style="background-image: url('../images/mesa4.svg');">
    <header class="header">
      <a href="../Cliente/index.php" class="logo">
        <?php $query = "SELECT logo FROM establecimiento WHERE id = $establecimiento";

        $resultado = $conexion->query($query);

        if ($resultado) {
          $fila = $resultado->fetch_assoc();
          $logo = $fila['logo'];
          $resultado->free();
        } else {
          echo "Error en la consulta: " . $conexion->error;
        } ?>
        <?php if (isset($logo)): ?>
          <img src="../SuperAdmin/<?php echo $logo ?>" alt="LOGO" style="height: 5rem;">
        <?php else: ?>
          <p>No se encontró ninguna imagen para este establecimiento.</p>
        <?php endif; ?>
      </a>
      <input type="checkbox" id="check">
      <label for="check" class="icons">
        <i class='bx bx-menu' id="menu-icon"></i>
        <i class='bx bx-x' id="close-icon"></i>
      </label>
      <nav class="navbar">
        <a href="../Cliente/index.php" style="--i:0;">Inicio</a>
        <a href="../Cliente/menu.php" style="--i:1;">Menu</a>
        <div class="dropdown">
          <a href="../Cliente/reservar.php" style="--i:3;">Reservas</a>
        </div>
        <a href="../includes/_sesion/cerrarSesion.php" style="--i:4;">Salir</a>
      </nav>
    </header>

  </body>

  <?php
}
if (isset($_GET['idvisita'])){
  $visita = $_GET['idvisita'];
  ?>

  <body style="background-image: url('../images/mesa4.svg');">
    <header class="header">
      <a href="../Cliente/index.php?idvisita=<?php echo $visita ?>" class="logo">
        <?php $query = "SELECT logo FROM establecimiento WHERE id = $visita";

        $resultado = $conexion->query($query);

        if ($resultado) {
          $fila = $resultado->fetch_assoc();
          $logo = $fila['logo'];
          $resultado->free();
        } else {
          echo "Error en la consulta: " . $conexion->error;
        } ?>
        <?php if (isset($logo)): ?>
          <img src="../SuperAdmin/<?php echo $logo ?>" alt="LOGO" style="height: 5rem;">
        <?php else: ?>
          <p>No se encontró ninguna imagen para este establecimiento.</p>
        <?php endif; ?>
      </a>
      <input type="checkbox" id="check">
      <label for="check" class="icons">
        <i class='bx bx-menu' id="menu-icon"></i>
        <i class='bx bx-x' id="close-icon"></i>
      </label>
      <nav class="navbar">
        <a href="../Cliente/index.php?idvisita=<?php echo $visita ?>" style="--i:0;">Inicio</a>
        <a href="../Cliente/menu2.php?idvisita=<?php echo $visita ?>" style="--i:1;">Menu</a>
        <div class="dropdown">
          <a href="../includes/login.php?idvisita=<?php echo $visita ?>" style="--i:3;">Reservas</a>
        </div>
        <a href="../includes/login.php?idvisita=<?php echo $visita ?>" style="--i:4;">Inicia Sesión!</a>
      </nav>
    </header>

  </body>

<?php
}
?>

</html>