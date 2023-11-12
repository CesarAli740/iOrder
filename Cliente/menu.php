<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$validar = isset($_SESSION['correo']) ? $_SESSION['correo'] : '';
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];

if ($rol != '5') {
    session_unset();
    session_destroy();
    header("Location: ../includes/login.php");
    die();
}

include '../NAVBARiorder/index.php';

// Manejo de la acción agregar al carrito
if (isset($_POST['action']) && $_POST['action'] == 'agregarAlCarrito') {
    if (isset($_POST['producto_id'])) {
        $productoId = $_POST['producto_id'];
        $producto = obtenerProductoPorId($productoId);

        if ($producto) {
            agregarAlCarrito($producto);
        }
    }
}

// Función para obtener un producto por su ID
function obtenerProductoPorId($id)
{
    global $conexion;
    $query = "SELECT * FROM menu WHERE id = '$id'";
    $result = $conexion->query($query);

    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
}

// Función para agregar un producto al carrito
function agregarAlCarrito($producto)
{
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verifica si el producto ya está en el carrito
    $productoEnCarrito = array_filter($_SESSION['carrito'], function ($item) use ($producto) {
        return $item['id'] == $producto['id'];
    });

    if (empty($productoEnCarrito)) {
        // Agrega el producto al carrito con una cantidad inicial de 1
        $producto['cantidad'] = 1;
        $_SESSION['carrito'][] = $producto;
    } else {
        // Incrementa la cantidad si el producto ya está en el carrito
        $productoEnCarritoId = key($productoEnCarrito);
        $_SESSION['carrito'][$productoEnCarritoId]['cantidad']++;
    }
}

$menuData = obtenerMenu();

function obtenerMenu()
{
    global $conexion, $establecimiento;
    $query = "SELECT * FROM menu WHERE menu.establecimiento_id = '$establecimiento'";
    $result = $conexion->query($query);

    $menuData = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $menuData[] = $row;
        }
    }

    return $menuData;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NAVBAR</title>
    <link rel="stylesheet" href="menu.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>

    <br><br><br><br><br><br>
    <section class="menu-section">
        <div class="menu-container">
            <div class="menu-navbar">
                <a data-category="comida" style="--i: 0">Comidas</a>
                <a data-category="bebida" style="--i: 1">Bebidas</a>
                <a data-category="otro" style="--i: 2">Otros</a>
            </div>
            <div class="menu-cards" id="menuCards">
                <?php
                foreach ($menuData as $item) {
                    echo '<div class="card" data-category="' . $item['tipo'] . '">';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="action" value="agregarAlCarrito" />';
                    echo '<input type="hidden" name="producto_id" value="' . $item['id'] . '" />';
                    echo '<img src="../Admin/menu/' . $item['imagen'] . '" alt="' . $item['nombre'] . '">';
                    echo '<h3>' . $item['nombre'] . '</h3>';
                    echo '<p class="price">$' . $item['precio'] . '</p>';
                    echo '<button type="submit">Agregar al Carrito</button>';
                    echo '</form>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>
    <div class="options">
        <div class="filter-options">
            <h3>Buscar nombre de producto</h3>
            <input type="search" />
        </div>
        <a href="ver_carrito.php">Ver Carrito</a>
    </div>
    <div class="menu-panel">
        <div class="panel-header">
            <h1>Panel de Menú</h1>
        </div>
        <div class="panel-content">
            <table id="menuTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($menuData as $item) {
                        echo '<tr>';
                        echo '<td>' . $item['nombre'] . '</td>';
                        echo '<td>$' . $item['precio'] . '</td>';
                        echo '<td>' . $item['tipo'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const filterInput = document.querySelector(".filter-options input[type='search']");
            const menuNavbar = document.querySelector(".menu-navbar");

            const menuTableBody = document.querySelector("#menuTable tbody");
            let menuData = <?php echo json_encode($menuData); ?>;

            function renderMenuCards(category) {
                const menuCardsContainer = document.getElementById("menuCards");
                menuCardsContainer.innerHTML = "";

                menuData.forEach((item) => {
                    if (item.tipo === category) {
                        const card = document.createElement("div");
                        card.classList.add("card");
                        card.setAttribute("data-category", item.tipo);

                        const form = document.createElement("form");
                        form.action = "";
                        form.method = "post";

                        const inputAction = document.createElement("input");
                        inputAction.type = "hidden";
                        inputAction.name = "action";
                        inputAction.value = "agregarAlCarrito";
                        form.appendChild(inputAction);

                        const inputProductoId = document.createElement("input");
                        inputProductoId.type = "hidden";
                        inputProductoId.name = "producto_id";
                        inputProductoId.value = item.id;
                        form.appendChild(inputProductoId);

                        const imagen = document.createElement("img");
                        imagen.src = `../Admin/menu/${item.imagen}`;
                        imagen.alt = item.nombre;
                        card.appendChild(imagen);

                        const titulo = document.createElement("h3");
                        titulo.textContent = item.nombre;
                        card.appendChild(titulo);

                        const precioElemento = document.createElement("p");
                        precioElemento.classList.add("price");
                        precioElemento.textContent = `$${item.precio}`;
                        card.appendChild(precioElemento);

                        const button = document.createElement("button");
                        button.type = "submit";
                        button.textContent = "Agregar al Carrito";
                        form.appendChild(button);

                        card.appendChild(form);

                        menuCardsContainer.appendChild(card);
                    }
                });
            }

            filterInput.addEventListener("input", () => {
                const searchTerm = filterInput.value.toLowerCase();

                const filteredItems = menuData.filter((item) =>
                    item.nombre.toLowerCase().includes(searchTerm)
                );

                menuTableBody.innerHTML = "";

                filteredItems.forEach((item) => {
                    const row = document.createElement("tr");
                    const nameCell = document.createElement("td");
                    const priceCell = document.createElement("td");
                    const typeCell = document.createElement("td");

                    nameCell.textContent = item.nombre;
                    priceCell.textContent = `$${item.precio}`;
                    typeCell.textContent = item.tipo;

                    row.appendChild(nameCell);
                    row.appendChild(priceCell);
                    row.appendChild(typeCell);

                    menuTableBody.appendChild(row);
                });
            });

            menuNavbar.addEventListener("click", (event) => {
                if (event.target.tagName === "A") {
                    const category = event.target.getAttribute("data-category");
                    renderMenuCards(category);
                }
            });
        });
    </script>
</body>

</html>
