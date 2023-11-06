<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESERVAS</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
  body {
  display: flex;
  justify-content: center;
  align-items: center;  
  margin: 0;
  background: linear-gradient(to right, rgb(128, 74, 0), rgb(255, 162, 0));
}

.reservation-container {
  margin: 3rem;
  display: flex;
  flex-wrap: wrap;
  flex-direction: row;
  width: 85%;
  height: auto;
  padding: 2rem;
  background: white;
  border-radius: 2rem;
  box-shadow: 0px 10px 20px rgba(0, 0, 0);
}

.form-container {
  padding: 2rem;
  margin: 2rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 1rem;
}
label {
  font-weight: bold;
  display: block;
  margin-bottom: 0.5rem;
  font-size: 1.2rem;
}
select,
input[type="text"] {
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #ccc;
  border-radius: 1rem;
}
#reserve-button {
  background: rgb(245, 193, 104);
  width: 9rem;
  height: 2.5rem;
  border-radius: 1rem;
  border: 1px solid rgba(0, 0, 0, 0.2);
  margin: auto;
}
#reserve-button:hover {
  background: rgb(248, 217, 163);
  cursor: pointer;
}

.reservation-details {
  flex: 1;
  padding: 2rem;
  background: #f3f3f3;
  border-radius: 1rem;
}

.table-map {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.table {
  width: 6.5rem;
  height: 6.5rem;
  border-radius: 50%;
  background: #dbd9d9;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  cursor: pointer;
}

.table.selected {
  background: #1cb978;
  color: white;
}

@media (max-width: 746px) {
    .reservation-container {
        margin: 2rem;
        display: flex;
        flex-direction: column;
    }
    .table {
        width: 4rem;
        height: 4rem;
    }
    .form-group{
        display: flex;
        gap: 2rem;
    }
    .form-container{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 1rem;
    }
}
@media (max-width: 425px) {
    .reservation-container {
        margin: 1rem;
        display: flex;
        flex-direction: column;
    }
    .form-group{
        display: flex;
        gap: 1rem;
    }
}
@media (max-width: 380px) {
    .reservation-container {
        margin: 1rem;
        display: flex;
        flex-direction: column;
        padding: .4rem;
    }
    .form-group{
        display: flex;
        gap: 1rem;
    }
    .reservation-details{
        padding: .8rem;
        margin: .6rem;
    }
}
</style>

<body>
    <div class="reservation-container">
        <div class="form-container">
            <h2>Reserva tu mesa</h2>
            <div class="form-group">
                <label for="day">Día:</label>
                <select id="day" >
                    <option value="">Selecciona un día</option>
                    <option value="opcion1">Lunes</option>
                    <option value="opcion3">Martes</option>
                    <option value="opcion4">Miercoles</option>
                    <option value="opcion5">Jueves</option>
                    <option value="opcion6">Viernes</option>
                    <option value="opcion7">Sábado</option>
                    <option value="opcion8">Domingo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="time">Hora:</label>
                <input type="time" id="time">
            </div>
            <div class="form-group">
                <label>Costo por mesa:</label>
                <span id="cost">50 dólares</span>
            </div>
            <div class="form-group">
                <label>Total:</label>
                <span id="total">0 dólares</span>
            </div>
            <button id="reserve-button" onclick="reserveTable()">Reservar</button>
        </div>
        <div class="reservation-details">
            <h2>Mapa de mesas</h2>
            <div class="table-map">
                <!-- Generar mesas aquí -->
            </div>
        </div>
    </div>


    <script>
        // Función para calcular el costo total
        function calculateTotal() {
            const selectedTables = document.querySelectorAll(".table.selected");
            const costPerTable = 50;

            const totalTables = selectedTables.length;
            const totalCost = totalTables * costPerTable;

            document.getElementById("total").textContent = totalCost + " dólares";
        }

        // Función para reservar mesa
        function reserveTable() {
            // Resto del código para recopilar los valores del formulario

            // Llamamos a la función para calcular el costo total
            calculateTotal();

            // Resto del código para procesar la reserva
        }

        // Código para generar las mesas
        const tableMap = document.querySelector(".table-map");
        const numberOfTables = 8; // Puedes ajustar la cantidad de mesas aquí

        for (let i = 1; i <= numberOfTables; i++) {
            const table = document.createElement("div");
            table.classList.add("table");
            table.textContent = i;
            table.addEventListener("click", () => {
                table.classList.toggle("selected");
                calculateTotal(); // Llamamos a la función para recalcular el costo total al seleccionar/deseleccionar mesas
            });
            tableMap.appendChild(table);
        }
    </script>
</body>
</html>