<?php
include '../../includes/_db.php';
if (!$conexion) {
    echo "No se realizo la conexion a la base de datos, el error fue:" .
        mysqli_connect_error();
}
// Obtener todos los IDs de establecimientos
$idResult = mysqli_query($conexion, "SELECT id FROM establecimiento");

if ($idResult !== false) {
    // Verificar si se obtuvieron resultados
    if (mysqli_num_rows($idResult) > 0) {
        // Inicializar el array para almacenar la información
        $establecimientos = array();

        // Obtener el nombre, tipo y logo de cada establecimiento
        while ($idRow = mysqli_fetch_assoc($idResult)) {
            $id = $idRow["id"];

            // Consulta SQL para obtener el nombre, tipo y logo de cada establecimiento
            $sql = "SELECT e.nombre, et.tipo, e.logo FROM establecimiento e
                    INNER JOIN establecimiento_tipo et ON e.tipo_id = et.id
                    WHERE e.id = $id";

            $result = mysqli_query($conexion, $sql);

            if ($result !== false && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $nombreEstablecimiento = $row["nombre"];
                $tipoEstablecimiento = $row["tipo"];
                $logoEstablecimiento = $row["logo"];

                $establecimientos[] = array(
                    'id' => $id,
                    'nombre' => $nombreEstablecimiento,
                    'tipo' => $tipoEstablecimiento,
                    'logo' => $logoEstablecimiento
                );
            }
        }
    } else {
        echo "No se encontraron establecimientos.";
    }
} else {
    // Manejar errores en la consulta
    echo "Error en la consulta: " . mysqli_error($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>iOrder</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.min.css" rel="stylesheet">
</head>

<body class="bg-white">
    <!-- Navbar Start -->
    <div class="container-fluid p-0 nav-bar">
        <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
            <a href="" class="navbar-brand" style="width: 100%; text-align: center;">
                <img src="img/logo2.svg" alt="Logo de Gymnast" class="logo" style="max-height: 150px;">
            </a>
        </nav>
    </div>
    <!--Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="blog-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/pasa1.png" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h3 class="text-primary text-capitalize m-0" style="font-size: 3em;">Bienvenido a iOrder</h3>
                        <h2 class="display-2 m-0 mt-2 mt-md-4 text-white font-weight-bold text-capitalize">Sistema de Reservas</h2>
                        <a href="../../includes/login.php" class="btn btn-lg btn-outline-light mt-3 mt-md-5 py-md-3 px-md-5">Unirse ahora</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/pasa2.png" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h3 class="text-primary text-capitalize m-0" style="font-size: 3em;">Bienvenido a iOrder</h3>
                        <h2 class="display-2 m-0 mt-2 mt-md-4 text-white font-weight-bold text-capitalize">Sistema de Pedidos</h2>
                        <a href="../../includes/login.php" class="btn btn-lg btn-outline-light mt-3 mt-md-5 py-md-3 px-md-5">Unirse ahora</a>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#blog-carousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#blog-carousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Gym Class Start -->
    <style>
        .list-unstyled li {
            list-style-type: disc;
            /* Utiliza "disc" para viñetas redondas. Puedes cambiarlo a "square", "circle", etc. si prefieres otro estilo. */
        }
    </style>

    <div class="container gym-class mb-5">
        <div class="row px-3">
            <div class="col-md-6 p-0">
                <div class="gym-class-box d-flex flex-column align-items-end justify-content-center bg-primary text-right text-white py-5 px-5" style="background-image: url('ruta_de_la_imagen.jpg'); background-size: cover;">
                    <h3 class="display-4 mb-3 text-white font-weight-bold">Plan Premium</h3>
                    <ul class="list-unstyled text-left mb-4" style="margin-top: 10px;">
                        <li>Tablets en el establecimiento para realizar pedidos.</li>
                        <li>Personalización de menús y opciones de pedido según las necesidades del negocio.</li>
                        <li>Gestión avanzada de reservas y pedidos para optimizar la operación.</li>
                        <li>Informes sobre actividad de reservas y actividad de pedidos.</li>
                        <li><strong>Soporte y mantenimiento mensual.</strong></li>
                    </ul>
                    <h3 class="display-4 mb-3 text-white font-weight-bold" style="font-size: 2rem;">Bs. 350/mes + costo de tablets</h3>
                    <a href="paypal.html" class="btn btn-lg btn-outline-light mt-auto px-4">Suscribirse</a>
                </div>
            </div>
            <div class="col-md-6 p-0">
                <div class="gym-class-box d-flex flex-column align-items-start justify-content-center bg-secondary text-left text-white py-5 px-5">

                    <h3 class="display-4 mb-3 text-white font-weight-bold">Plan Básico</h3>
                    <ul class="list-unstyled text-left mb-4" style="margin-top: 10px;">
                        <li>Codigo QR en el establecimiento para realizar pedidos.</li>
                        <li>Personalización de menús y opciones de pedido según las necesidades del negocio.</li>
                        <li>Gestión básica de reservas y pedidos para mantener un control eficiente de la operación.</li>
                        <li>Informes sobre actividad de reservas y actividad de pedidos.</li>
                        <li><strong>Soporte y mantenimiento mensual.</strong></li>
                    </ul>
                    <h3 class="display-4 mb-3 text-white font-weight-bold" style="font-size: 2rem;">Bs. 350/mes</h3>
                    <a href="paypal.html" class="btn btn-lg btn-outline-light mt-auto px-4">Suscribirse</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gym Class End -->


    <!-- About Start -->
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img class="img-fluid mb-4 mb-lg-0" src="./img/About.png" alt="Image">
            </div>
            <div class="col-lg-6">
                <!-- Cambia el título para describir tu sistema -->
                <h2 class="display-4 font-weight-bold mb-4">Sistema de Reservas y Pedidos Personalizado</h2>
                <!-- Puedes describir las características y ventajas de tu sistema aquí -->
                <div class="container">
                    <p>iOrder sistema de reservas y pedidos ofrece una solución completa para la gestión eficiente en establecimientos de hostelería, proporcionando ventajas tales como:</p>
                    <div class="row py-2">
                        <div class="col-sm-6">
                            <h4 class="font-weight-bold" style="color: #e31c25;">Pedidos a Través de Tablets</h4>
                            <p>Ofrece a tus clientes una experiencia de pedido única a través de tablets en el establecimiento, creando un ambiente moderno y atrayente.</p>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="font-weight-bold" style="color: #e31c25;">Pedidos con Código QR</h4>
                            <p>Brinda a tus clientes la capacidad de hacer pedidos de forma instantánea escaneando un código QR desde sus propios dispositivos, agilizando el proceso y mejorando la satisfacción.</p>
                        </div>
                    </div>
                    <div class="row py-2">
                        <div class="col-sm-6">
                            <h4 class="font-weight-bold" style="color: #e31c25;">Configuración Personalizada</h4>
                            <p>Adapta el sistema a las necesidades específicas de tu establecimiento, ofreciendo menús y opciones de pedido personalizados que destaquen tu marca y fidelicen a tus clientes.</p>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="font-weight-bold" style="color: #e31c25;">Informes Detallados</h4>
                            <p>Accede a informes detallados sobre la actividad de reservas y pedidos para tomar decisiones estratégicas que impulsen la eficiencia operativa y la rentabilidad de tu establecimiento.</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- About End -->


    <!-- Features Start -->
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-lg-4 p-0">
                <div class="d-flex align-items-center bg-secondary text-white px-5" style="min-height: 300px;">
                    <div class="text-center">
                        <h2 class="text-white mb-3">Discoteca</h2>
                        <p>Experimenta noches llenas de energía con los mejores DJ y una selección premium de bebidas. Simplifica tu experiencia con reservas y pedidos online para un servicio ágil y sin complicaciones.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-0">
                <div class="d-flex align-items-center bg-primary text-white px-5" style="min-height: 300px;">
                    <div class="text-center">
                        <h2 class="text-white mb-3">Restaurante</h2>
                        <p>Disfruta de una experiencia culinaria extraordinaria con platillos exquisitos preparados por nuestros chefs expertos. Simplifica tu experiencia con reservas y pedidos online para un servicio personalizado y sin demoras.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-0">
                <div class="d-flex align-items-center bg-secondary text-white px-5" style="min-height: 300px;">
                    <div class="text-center">
                        <h2 class="text-white mb-3">Pub</h2>
                        <p>Vive momentos relajados y especiales con una amplia selección de bebidas. Disfruta de veladas inolvidables con amigos y familiares. Simplifica tu experiencia con reservas y pedidos online para un servicio rápido y sin complicaciones.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features End -->
    <!-- Team Start -->

    <div class="container pt-5 team">
        <div class="d-flex flex-column text-center mb-5">
            <h4 class="text-primary font-weight-bold" style="font-size: 50px;">Nuestros Establecimientos Asociados</h4>
            <h4 class="display-4 font-weight-bold">Revisa sus Menús</h4>
        </div>
        <style>
            .carousel-control-prev,
            .carousel-control-next {
                width: auto;
                background: none;
                border: none;
                font-size: 1rem;
                /* Ajusta el tamaño de la fuente según sea necesario */
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                width: 20px;
                /* Ajusta el tamaño del icono según sea necesario */
                height: 20px;
                /* Ajusta el tamaño del icono según sea necesario */
            }
        </style>
        <div id="card-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $contador = 0; // Inicializar el contador
                $totalEstablecimientos = count($establecimientos);

                foreach ($establecimientos as $establecimiento) {
                    if ($contador % 4 === 0) {
                        // Si el contador es divisible por 4, comienza una nueva diapositiva
                        echo '<div class="carousel-item';
                        echo $contador === 0 ? ' active' : ''; // Agrega la clase "active" a la primera diapositiva
                        echo '"><div class="row">';
                    }

                    // Muestra la tarjeta actual
                    echo '<div class="col-lg-3 col-md-6 mb-5">
            <div class="card border-0 bg-secondary text-center text-white">
                <div style="height: 200px; overflow: hidden;">
                    <img class="card-img-top mx-auto" src="../../SuperAdmin/' . $establecimiento['logo'] . '" alt="" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                </div>
                <div class="card-social d-flex align-items-center justify-content-center">
                    <a class="btn btn-outline-light rounded-pill text-center mr-2 px-3" href="../../Cliente/index.php?idvisita=' . $establecimiento['id'] . '">Ver Menú</a>
                </div>
                <div class="card-body bg-secondary">
                    <h4 class="card-title text-primary">' . $establecimiento['nombre'] . '</h4>
                    <p class="card-text">' . $establecimiento['tipo'] . '</p>
                </div>
            </div>
          </div>';

                    $contador++;

                    if ($contador % 4 === 0 || $contador === $totalEstablecimientos) {
                        // Si el contador es divisible por 4 o es el último elemento, cierra la fila
                        echo '</div></div>';
                    }
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#card-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#card-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <!-- Team End -->
    <h1 style="text-decoration: none; text-align: center;">
        <a href="../../../iOrder/informacion/index.html">VOLVER A NOVA</a>
    </h1>

    <!-- Footer Start -->
    <div class="footer container-fluid mt-5 py-5 px-sm-3 px-md-5 text-white">
        <div class="container border-top border-dark pt-5">
            <p class="m-0 text-center text-white">
                &copy; <a class="text-white font-weight-bold" href="#">iOrder</a>. All Rights Reserved. Designed by
                <a class="text-white font-weight-bold" href="https://htmlcodex.com">NOVA</a>
            </p>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-outline-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>