<?php
include '../includes/_db.php';
session_start();
error_reporting(0);
$validar = isset($_SESSION['correo']) ? $_SESSION['correo'] : '';
$rol = $_SESSION['rol'];
$establecimiento = $_SESSION['establecimiento'];
if ($rol != '2') {
  session_unset();
  session_destroy();
  header("Location: ../includes/login.php");
  die();
}

include '../NAVBARiorder/index.php';

$query = "SELECT * FROM menu WHERE menu.establecimiento_id = '$establecimiento'";
$result = $conexion->query($query);

$menuData = [];

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $menuData[] = $row;
  }
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
          echo '<a href="editar_producto.php?id=' . $item['id'] . '&categoria=' . $item['tipo'] . '"><i class="bx bxs-edit bx-lg"></i></a>';
          echo '<a href="eliminar_producto.php?id=' . $item['id'] . '&categoria=' . $item['tipo'] . '"><i class="bx bxs-trash bx-lg"></i></a>';
          echo '<img src="./menu/' . $item['imagen'] . '" alt="' . $item['nombre'] . '">';
          echo '<h3>' . $item['nombre'] . '</h3>';
          echo '<p class="price">$' . $item['precio'] . '</p>';
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
    <a href="crear_producto.php">CREAR UN PRODUCTO</a>
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

            const imagen = document.createElement("img");
            imagen.src = `./menu/${item.imagen}`;
            imagen.alt = item.nombre;
            card.appendChild(imagen);

            const titulo = document.createElement("h3");
            titulo.textContent = item.nombre;
            card.appendChild(titulo);

            const precioElemento = document.createElement("p");
            precioElemento.classList.add("price");
            precioElemento.textContent = `$${item.precio}`;
            card.appendChild(precioElemento);

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

      const menuNavbar = document.querySelector(".menu-navbar");
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