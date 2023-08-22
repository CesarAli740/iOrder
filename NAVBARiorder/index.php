<?php
session_start();
error_reporting(0);
$validar = isset($_SESSION['correo']) ? $_SESSION['correo'] : '';

if ($validar == '') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}
?>

<style>
   * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}
body {
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
  background: linear-gradient(
    90deg,
    transparent,
    rgba(255, 255, 255, 0.4),
    transparent
  );
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
  font-size: 1.15rem;
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
  color: #A35E23;
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
  #check:checked ~ .icons #menu-icon {
    display: none;
  }
  .icons #close-icon {
    display: none;
  }
  #check:checked ~ .icons #close-icon {
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
  #check:checked ~ .navbar {
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
  #check:checked ~ .navbar a {
    transform: translateY(0);
    opacity: 1;
    transition-delay: calc(0.1s * var(--i));
  }
}

.video-container {
  position: relative;
  height: 100vh;
  overflow: hidden;
}

video {
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
  background: rgba(0, 0, 0, 0.6);
}
</style>

  <!--   <header class="header">
        <a href="#" class="logo">LOGO</a>

        <input type="checkbox" id="check">
        <label for="check" class="icons">
            <i class='bx bx-menu' id="menu-icon"></i>
            <i class='bx bx-x' id="close-icon"></i>
        </label>

        <nav class="navbar">
            <a href="../SuperAdmin/index.php" style="--i:0;">Home</a>
            <a href="../SuperAdmin/gestion.php" style="--i:1;">Usuarios</a>
            <a href="#" style="--i:2;">Reservas</a>
            <a href="#" style="--i:3;">Pedidos</a>
            <a href="#" style="--i:4;">Contacto</a>
            <a href="../includes/_sesion/cerrarSesion.php" style="--i:4;">Salir</a>
        </nav>
        
    </header>
    <video id="video" autoplay loop muted>
        <source src="../video/pub.mp4" type="video/mp4">
    </video>


    <h1>hooasss</h1><br>
    <h1>hooasss</h1><br>
    <h1>hooasss</h1><br>
    <h1>hooasss</h1><br>
    <h1>hooasss</h1><br> -->

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVBAR</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header class="header">
        <a href="#" class="logo">LOGO</a>

        <input type="checkbox" id="check">
        <label for="check" class="icons">
            <i class='bx bx-menu' id="menu-icon"></i>
            <i class='bx bx-x' id="close-icon"></i>
        </label>

        <nav class="navbar">
            <a href="../SuperAdmin/index.php" style="--i:0;">Home</a>
            <a href="../SuperAdmin/gestion.php" style="--i:1;">Usuarios</a>
            <a href="#" style="--i:2;">Reservas</a>
            <a href="#" style="--i:3;">Pedidos</a>
            <a href="#" style="--i:4;">Contacto</a>
            <a href="../includes/_sesion/cerrarSesion.php" style="--i:4;">Salir</a>
        </nav>
    </header>
    <div class="video-container">
        <video autoplay loop muted>
          <!-- <source src="./discoteca2.mp4" type="video/mp4">
          <source src="./discoteca1.mp4" type="video/mp4">
          <source src="./restaurante.mp4" type="video/mp4"> -->
          <source src="../video/pub.mp4" type="video/mp4">
        </video>
    </div>
</body>
</html>
    
