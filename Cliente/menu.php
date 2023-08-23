<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NAVBAR</title>
    <link rel="stylesheet" href="menu.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
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
    <script>
      const menuCardsContainer = document.getElementById("menuCards");

      function renderMenuCards(category) {
        menuCardsContainer.innerHTML = ""; // Limpiar el contenedor de cartas

        fetch("./menu.JSON") // Ajusta la ruta al archivo JSON según sea necesario
          .then((response) => response.json())
          .then((data) => {
            data.forEach((item) => {
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
          })
          .catch((error) => console.error("Error al cargar el JSON:", error));
      }

      document.addEventListener("DOMContentLoaded", () => {
        renderMenuCards("comida"); // Mostrar inicialmente las comidas

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