<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reservas de Mesas</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
  }
  header {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 1rem;
  }
  .container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  .mesa {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0.5rem;
    text-align: center;
    line-height: 100px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 50%;
    background-color: #E0E0E0;
    transition: background-color 0.3s;
  }
  .libre {
    background-color: green;
  }
  .ocupada {
    background-color: red;
  }
  .reservada {
    background-color: yellow;
  }
  .reservado-label {
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 10px;
    color: #333;
  }
  form {
    max-width: 400px;
    margin: 1rem auto 2rem;
    padding: 1rem;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 1;
  }
  .btn-container {
    position: fixed;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
  }
  button {
    padding: 0.5rem 1rem;
    font-size: 16px;
    margin-bottom: 1rem;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  button:hover {
    background-color: #555;
  }
</style>
</head>
<body>
  <header>
    <h1>Reservas de Mesas</h1>
  </header>
  <form id="formulario-reserva">
    <h2>Formulario de Reserva</h2>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <label for="mesa">Mesa:</label>
    <select id="mesa" name="mesa" required>
      <option value="" disabled selected>Seleccionar mesa</option>
      <option value="Mesa 1">Mesa 1</option>
      <option value="Mesa 2">Mesa 2</option>
      <option value="Mesa 3">Mesa 3</option>
    </select>
    <button type="submit">Reservar</button>
  </form>
  <div class="btn-container">
    <button id="agregar-mesa">+</button>
    <button id="quitar-mesa">-</button>
  </div>
  <div class="container">
    <div class="mesa libre">Mesa 1</div>
    <div class="mesa libre">Mesa 2</div>
    <div class="mesa libre">Mesa 3</div>
  </div>
  <script>
    // JavaScript aquí (modificado para mostrar "Reservado")
    document.addEventListener("DOMContentLoaded", () => {
      let numeroMesas = 3; // Inicialmente hay 3 mesas

      const mesas = document.querySelectorAll(".mesa");
      const formularioReserva = document.querySelector("#formulario-reserva");
      const botonAgregarMesa = document.querySelector("#agregar-mesa");
      const botonQuitarMesa = document.querySelector("#quitar-mesa");
      const selectMesa = document.querySelector("#mesa");

      // Evento al hacer clic en una mesa
      mesas.forEach(mesa => {
        mesa.addEventListener("click", () => {
          const mesaSeleccionada = mesa.textContent;
          const nombre = document.querySelector("#nombre").value;

          if (mesa.classList.contains("libre")) {
            mesa.textContent = ` ${mesaSeleccionada} - Reservado ${nombre}`;
            mesa.classList.remove("libre");
            mesa.classList.add("reservada");
          }
        });
      });

      // Evento al enviar el formulario de reserva
      formularioReserva.addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar que se recargue la página

        const nombre = document.querySelector("#nombre").value;
        const mesaSeleccionada = selectMesa.value;
        const mesa = document.querySelector(`.mesa:contains('${mesaSeleccionada}')`);

        if (mesa) {
          mesa.textContent = `Mesa ${mesaSeleccionada} - Reservado por ${nombre}`;
          mesa.classList.remove("libre");
          mesa.classList.add("reservada");
          alert(`¡Reserva realizada por ${nombre} en ${mesaSeleccionada}!`);
        }
      });

      // Evento para agregar mesa
      botonAgregarMesa.addEventListener("click", () => {
        numeroMesas++;
        const nuevaMesa = document.createElement("div");
        nuevaMesa.classList.add("mesa", "libre");
        nuevaMesa.textContent = `Mesa ${numeroMesas}`;
        
        nuevaMesa.addEventListener("click", () => {
          const nombre = document.querySelector("#nombre").value;
          nuevaMesa.textContent = `Mesa ${numeroMesas} - Reservado por ${nombre}`;
          nuevaMesa.classList.remove("libre");
          nuevaMesa.classList.add("reservada");
        });

        selectMesa.innerHTML += `<option value="Mesa ${numeroMesas}">Mesa ${numeroMesas}</option>`;
        document.querySelector(".container").appendChild(nuevaMesa);
      });

      // Evento para quitar mesa
      botonQuitarMesa.addEventListener("click", () => {
        const ultimaMesa = document.querySelector(".container").lastChild;
        if (ultimaMesa && ultimaMesa.classList.contains("mesa")) {
          selectMesa.removeChild(selectMesa.lastChild);
          document.querySelector(".container").removeChild(ultimaMesa);
          numeroMesas--;
        }
      });
    });
  </script>
</body>
</html>