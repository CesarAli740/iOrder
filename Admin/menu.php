<?php include '../NAVBARiorder/index.php'; ?>
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


  <div class="titulo-menu">
    <h1>¿Que vas a comer Hoy?</h1>
  </div>
  <section class="menu-section">
    <div class="menu-container">
      <div class="menu-navbar">
        <a data-category="comida" style="--i: 0">Comidas</a>
        <a data-category="bebida" style="--i: 1">Bebidas</a>
        <a data-category="otro" style="--i: 2">Otros</a>
      </div>
      <div class="menu-cards" id="menuCards">
        <!-- Cards se generarán aquí con JavaScript -->
      </div>
    </div>
  </section>
  <div class="options">
    <div class="filter-options">
      <h3>Buscar nombre de producto</h3>
      <input type="search" />
    </div>
    <!-- <button>CREAR UN PRODUCTO</button>
    <button>EDITAR UN PRODUCTO</button>
    <button>ELIMINAR UN PRODUCTO</button> -->
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
        <tbody></tbody>
      </table>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const filterInput = document.querySelector(
        ".filter-options input[type='search']"
      );
      const menuTableBody = document.querySelector("#menuTable tbody");
      let menuData = [];

      fetch("./menu.JSON")
        .then((response) => response.json())
        .then((data) => {
          menuData = data;
          renderMenuCards("comida");
        })
        .catch((error) => console.error("Error al cargar el JSON:", error));

      function renderMenuCards(category) {
        const menuCardsContainer = document.getElementById("menuCards");
        menuCardsContainer.innerHTML = "";

        menuData.forEach((item) => {
          if (item.tipo === category) {
            const card = document.createElement("div");
            card.classList.add("card");
            card.setAttribute("data-category", item.tipo);

            const imagen = document.createElement("img");
            imagen.src = `./assets/${item.imagen}`;
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