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

//COLORES
$queryEstablecimiento = "SELECT color1, color2 FROM establecimiento WHERE id = '$establecimiento'";
$resultEstablecimiento = $conexion->query($queryEstablecimiento);

$colores = [];

if ($resultEstablecimiento) {
  $colores = $resultEstablecimiento->fetch_assoc();
}

// Obtener los colores
$color1 = isset($colores['color1']) ? $colores['color1'] : '';
$color2 = isset($colores['color2']) ? $colores['color2'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NAVBAR</title>
  <link rel="stylesheet" href="menu.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    .ver-carrito {
      /* background-color: #ea272d; */
      padding: 1rem;
      border-radius: 1rem;
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    .ver-carrito:hover {
      background-color: #7d1518;
    }

    .icono-menu {
      width: 4rem;
      height: 4rem;
      text-align: center;
      padding-top: .5rem;
    }

    .icons-container {
      display: flex;
      flex-direction: row;
      border: 1px solid white;
      background-color: white;
      margin-bottom: 1rem;
      border-radius: 1rem;
    }

    .icon1 {
      color: blue;
    }

    .icon1:hover {
      color: darkblue;
    }

    .icon2 {
      color: #ea272d;
    }

    .icon2:hover {
      color: #7d1518;
    }
    .container-report{
      display: grid;
      place-items: center;
    }
    #button-report-menu {
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      text-transform: uppercase;
    }

  </style>
</head>

<body>

  <br><br><br><br><br><br><br><br>
  <form class="container-report" action="menu_reporte.php" method="post">
    <input id="button-report-menu" type="submit" value="Generar Reporte del Menú">
  </form>

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
          echo '<div class="icons-container">';
          echo '<a class="icono-menu editar-btn" href="editar_producto.php?id=' . $item['id'] . '&categoria=' . $item['tipo'] . '"><i class="icon1 bx bxs-edit bx-lg"></i></a>';
          echo '<a class="icono-menu eliminar-btn" href="eliminar_producto.php?id=' . $item['id'] . '&categoria=' . $item['tipo'] . '"><i class="icon2 bx bxs-trash bx-lg"></i></a>';
          echo '</div>';
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
      <h3 id="filterh3">Buscar nombre de producto</h3>
      <input type="search" />
    </div>
    <a class="ver-carrito" href="crear_producto.php">CREAR UN PRODUCTO</a>
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
    const color1 = '<?php echo $color1; ?>';
    const color2 = '<?php echo $color2; ?>';

    document.addEventListener("DOMContentLoaded", () => {

      //COLORES
      document.body.style.backgroundColor = color2;

      const menuNavbar1 = document.querySelector(".menu-navbar");
      menuNavbar1.style.backgroundColor = color1;
      const filterH3 = document.getElementById("filterh3");
      filterH3.style.color = color2;

      const panelH1 = document.querySelector(".panel-header h1");
      panelH1.style.color = color2;

      const thElements = document.querySelectorAll("#menuTable th");
      thElements.forEach(th => th.style.backgroundColor = color1);

      const crearProductButton = document.querySelector(".ver-carrito");
      crearProductButton.style.backgroundColor = color1;
      crearProductButton.style.color = color2;

      
      
      crearProductButton.addEventListener("mouseover", () => {
        const hoverColor = darkenColor(color1, 1); // Ajusta el valor de oscurecimiento según tu preferencia
        crearProductButton.style.backgroundColor = hoverColor;
      });
      crearProductButton.addEventListener("mouseout", () => {
        crearProductButton.style.backgroundColor = color1;
      });

      const reportMenu = document.getElementById('button-report-menu');
      reportMenu.style.backgroundColor = color1;
      reportMenu.style.color = color2;
      
      reportMenu.addEventListener("mouseover", () => {
        const hoverColor = darkenColor(color1, 100); // Ajusta el valor de oscurecimiento según tu preferencia
        reportMenu.style.backgroundColor = hoverColor;
      });
      reportMenu.addEventListener("mouseout", () => {
        reportMenu.style.backgroundColor = color1;
      });

      const categoryLinks = document.querySelectorAll(".menu-navbar a");

      // Cambiar color al hacer hover
      categoryLinks.forEach((link) => {
        link.addEventListener("mouseover", () => {
          link.style.color = color2;
        });

        // Restaurar color original al quitar el hover
        link.addEventListener("mouseout", () => {
          link.style.color = "";
        });
      });

      // Función para oscurecer el color en porcentaje
      function darkenColor(color, percent) {
        const num = parseInt(color.slice(1), 16);
        const amt = Math.round(2.55 * percent);
        const R = (num >> 16) - amt;
        const G = (num >> 8 & 0x00FF) - amt;
        const B = (num & 0x0000FF) - amt;
        return `#${(1 << 24 | R << 16 | G << 8 | B).toString(16).slice(1)}`;
      }
      //ACABA COLORES

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

            const iconsContainer = document.createElement("div");
            iconsContainer.classList.add("icons-container");

            const editarBtn = document.createElement("a");
            editarBtn.classList.add("icono-menu", "editar-btn");
            editarBtn.href = `editar_producto.php?id=${item.id}&categoria=${item.tipo}`;
            editarBtn.innerHTML = '<i class="icon1 bx bxs-edit bx-lg"></i>';

            const eliminarBtn = document.createElement("a");
            eliminarBtn.classList.add("icono-menu", "eliminar-btn");
            eliminarBtn.href = `eliminar_producto.php?id=${item.id}&categoria=${item.tipo}`;
            eliminarBtn.innerHTML = '<i class="icon2 bx bxs-trash bx-lg"></i>';

            iconsContainer.appendChild(editarBtn);
            iconsContainer.appendChild(eliminarBtn);

            card.appendChild(iconsContainer);

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

          // Ocultar o mostrar botones según la categoría
          const editarBtns = document.querySelectorAll(".editar-btn");
          const eliminarBtns = document.querySelectorAll(".eliminar-btn");

          if (category === "comida" || "bebida" || "otros") {
            editarBtns.forEach((btn) => (btn.style.display = "block"));
            eliminarBtns.forEach((btn) => (btn.style.display = "block"));
          } else {
            editarBtns.forEach((btn) => (btn.style.display = "none"));
            eliminarBtns.forEach((btn) => (btn.style.display = "none"));
          }
        }
      });
    });
  </script>
</body>

</html>