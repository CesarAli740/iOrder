
<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
    <head>
        <title>Gestión de Usuarios</title>
        <style>
            /* Estilos para los modales */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.7);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 10% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 50%;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            /* Estilos para los botones */
            .button {
                padding: 10px 20px;
                margin: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>

<body>
    <div class="content"><!-- Botones para las funcionalidades -->
        <button class="button" onclick="openModal('Nuevo')">Nuevo Registro</button>
        <button class="button" onclick="openModal('Listar')">Listar</button>
        <button class="button" onclick="openModal('Buscar')">Buscar</button>
        <button class="button" onclick="openModal('Editar')">Editar</button>

        <!-- Modales -->
        <div id="modalNuevo" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Nuevo')">&times;</span>
                <?php include './registrar.php'; ?>
            </div>
        </div>

        <div id="modalListar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Listar')">&times;</span>
                <!-- Contenido del modal de Listar -->
            </div>
        </div>

        <div id="modalBuscar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Buscar')">&times;</span>
                <!-- Contenido del modal de Buscar -->
            </div>
        </div>

        <div id="modalEditar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Editar')">&times;</span>
                <!-- Contenido del modal de Editar -->
            </div>
        </div>

        <script>
            function openModal(modalName) {
                document.getElementById(`modal${modalName}`).style.display = "block";
            }

            function closeModal(modalName) {
                document.getElementById(`modal${modalName}`).style.display = "none";
            }
        </script>
    </div>

</body>

</html>