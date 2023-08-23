<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>

<head>
    <title>Gestión de Usuarios</title>
    <style>
        /* Estilos para los modales */


        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }


        .content {
            position: absolute;
            top: 54%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 1;
            height: 60%;
            width: 70%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .button {
            width: 35%;
            height: 20%;
            border-radius: 0.5em;
            font-size: 1.3rem;
            color: #ffffff;
            cursor: pointer;
            text-align: center;
            margin: 5px;
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid #fff;
            border-style: outset;
        }

        .button:hover {
            background: rgba(255, 255, 255, 0.4);
            color: black;
        }

        @media (max-width: 420px) {
            .button {
                font-size: 1rem;
            }
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
                <?php include './listar.php'; ?>
            </div>
        </div>

        <div id="modalBuscar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Buscar')">&times;</span>
                <iframe src="buscar.php" frameborder="0" style="width: 100%; height: 60%;"></iframe>
            </div>
        </div>

        <div id="modalEditar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Editar')">&times;</span>
                <?php include './editar.php'; ?>
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