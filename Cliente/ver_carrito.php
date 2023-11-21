<?php
session_start();

$establecimiento = $_SESSION['establecimiento'];
// Incluir archivo de conexión a la base de datos
include '../includes/_db.php';

// Comprobar el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '<div class="empty-cart-message" style="text-align: center; margin-top: 20vh; color: #333; font-size: 1.5rem; background-color: #FFF; padding: 20px; ">';
    echo '<h1 style="margin: 3rem; color: #A35E23; font-size: 2rem;">¡Oops! Tu carrito está vacío</h1>';
    echo '<p style="margin-bottom: 5rem;">¿Por qué no exploras nuestro delicioso menú?</p>';
    echo '<div class="back-to-menu" style="text-align: center; margin-top: 20px;"><a href="menu.php" style="color: #fff; text-decoration: none; font-weight: bold; background-color: #A35E23; padding: 10px 20px; border-radius: 4px; transition: background-color 0.3s;">Volver al Menú</a></div>';
    echo '</div>';
} else {
    $carrito = $_SESSION['carrito'];

    // Obtener información de las mesas desde la base de datos
    $queryMesas = "SELECT * FROM mesas WHERE establecimiento_id = '$establecimiento'";
    $resultMesas = $conexion->query($queryMesas);

    if ($resultMesas) {
        $mesasData = $resultMesas->fetch_all(MYSQLI_ASSOC);
    } else {
        $mesasData = [];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../NAVBARiorder/index.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecciona tu mesa para llevar tu pedido </title>
    <!-- Agrega tus estilos y enlaces a hojas de estilo aquí -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #FFDCA0, #A35E23);
            height: 93.2vh;
            overflow: hidden;
        }

        h1 {
            margin: 7rem;
            text-align: center;
            color: white;
        }

        #mapaMesas {
            display: flex;
            justify-content: space-around;
            margin: 4rem;
        }

        .mesa {
            margin-top:-50px;
            width: 8rem;
            height: 8rem;
            border-radius: 50%;
            background-color: rgba(128, 128, 128, 0.7);
            border: 2px solid #000;
            text-align: center;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
            /* Agregamos una transición suave */
        }

        .mesa-seleccionada {
            background-color: #A35E23;
            color: white;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(128, 128, 128, 0.7);
        }

        th,
        td {
            color: white;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgba(128, 128, 128, 0.7);
        }

        button {
           
            background-color: #A35E23;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #77461b;
        }

        /* Estilos para los botones de cantidad */
        .quantity {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            background-color: #A35E23;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
        }

        .quantity-btn:hover {
            background-color: #77461b;
        }

        #realizarPedidoBtn {
            display: none;
            margin: 20px auto;
        }
    /* ... tus estilos existentes ... */

    .realizar-pedido-btn {
        width: 150px; /* ajusta el ancho según tu preferencia */
        background-color: #A35E23;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        position: fixed;
        margin-left: 700px;
        margin-top: auto;
        transform: translateY(-50%);
    }
</style>

 
    </style>
</head>

<body>
    <h1>Selecciona tu mesa para llevar tu pedido </h1>

    <!-- Mapa de Mesas -->
    <div id="mapaMesas">
        <?php
        $contador = 1;
        foreach ($mesasData as $mesa) {
            echo '<div class="mesa" data-mesa-id="' . $mesa['id'] . '">' . $contador . '</div>';
            $contador++;
        }
        ?>
    </div>

    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const mesas = document.querySelectorAll(".mesa");
            const idMesaSeleccionadaInput = document.getElementById("idMesaSeleccionada");
            const realizarPedidoBtn = document.getElementById("realizarPedidoBtn");

            mesas.forEach(mesa => {
                mesa.addEventListener("click", () => {
                    const idMesa = mesa.getAttribute("data-mesa-id");

                    // Despintar mesas anteriores
                    mesas.forEach(m => m.classList.remove("mesa-seleccionada"));

                    // Pintar la mesa seleccionada
                    mesa.classList.add("mesa-seleccionada");

                    idMesaSeleccionadaInput.value = idMesa;

                    // Mostrar el botón de realizar pedido si se ha seleccionado una mesa
                    realizarPedidoBtn.style.display = "block";
                });
            });
        });
    </script>

    <!-- Carrito de Compras -->
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($carrito as $producto) {
            ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td>$<?php echo $producto['precio']; ?></td>
                    <td>
                        <!-- Agrega botones de aumento y disminución de cantidad -->
                        <div class="quantity">
                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $producto['id']; ?>, -1)">-</button>
                            <span class="quantity-value" id="quantity-<?php echo $producto['id']; ?>"><?php echo $producto['cantidad']; ?></span>
                            <button class="quantity-btn" onclick="updateQuantity(<?php echo $producto['id']; ?>, 1)">+</button>
                        </div>
                    </td>
                    <td>
                        <form action="eliminar_del_carrito.php" method="post">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Botón de Realizar Pedido -->
    <div id="realizarPedidoBtn">
        <form action="realizar_pedido.php" method="post">
            <input type="hidden" name="id_mesa" id="idMesaSeleccionada" value="">
            <button type="submit" class="realizar-pedido-btn">Realizar Pedido</button>

        </form>
    </div>

    <!-- Agrega aquí tus scripts, si es necesario -->
    <script>
        // Función para actualizar la cantidad y recalcular el subtotal
        function updateQuantity(productId, amount) {
            const quantityElement = document.querySelector(`#quantity-${productId}`);
            const currentQuantity = parseInt(quantityElement.innerText);
            const newQuantity = Math.max(currentQuantity + amount, 1); // Evitar cantidades negativas

            // Actualizar la cantidad en la interfaz
            quantityElement.innerText = newQuantity;
        }
    </script>
</body>

</html>

<?php
}
?>
