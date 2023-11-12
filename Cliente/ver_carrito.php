<?php
session_start();

$establecimiento = $_SESSION['establecimiento'];
// Incluir archivo de conexión a la base de datos
include '../includes/_db.php';

// Comprobar el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '<h1>Carrito de compras vacío</h1>';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Agrega tus estilos y enlaces a hojas de estilo aquí -->
    <style>
        /* Agrega aquí tus estilos específicos para el mapa de mesas */
        #mapaMesas {
            display: flex;
            justify-content: space-around;
            margin: 20px;
        }

        .mesa {
    width: 50px;
    height: 50px;
    border-radius: 50%; /* Hace que el div sea un círculo */
    background-color: transparent; /* Sin fondo */
    border: 1px solid #000;
    text-align: center;
    line-height: 50px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}

    </style>
</head>

<body>
    <h1>Carrito de Compras</h1>

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

    mesas.forEach(mesa => {
        mesa.addEventListener("click", () => {
            const idMesa = mesa.getAttribute("data-mesa-id");
            idMesaSeleccionadaInput.value = idMesa;
            alert("Mesa seleccionada: " + idMesa);
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
                <th>Subtotal</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($carrito as $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td>$<?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td>$<?php echo $subtotal; ?></td>
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
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td>Total: $<?php echo $total; ?></td>
                <td>
                    <form action="realizar_pedido.php" method="post">
                    <input type="hidden" name="id_mesa" id="idMesaSeleccionada" value="">
                        <button type="submit">Realizar Pedido</button>
                    </form>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Otros elementos de la página -->

    <!-- Agrega aquí tus scripts, si es necesario -->
    <script>
        // Agrega aquí tus scripts de JavaScript
    </script>
</body>

</html>

<?php
}
?>
