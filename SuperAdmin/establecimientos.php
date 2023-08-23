<?php include '../NAVBARiorder/index.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Gestión de Establecimientos</title>
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

        .content {
            position: absolute;
            top: 54%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 2;
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
        <button class="button" onclick="openModal('Nuevo')">Nuevo Establecimiento</button>
        <button class="button" onclick="openModal('Listar')">Listar Establecimientos</button>
        <button class="button" onclick="openModal('Buscar')">Buscar Establecimientos</button>
        <button class="button" onclick="openModal('Editar')">Editar Establecimiento</button>

        <!-- Modales -->
        <div id="modalNuevo" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Nuevo')">&times;</span>
                <?php include './nuevo_establecimiento.php'; ?>
            </div>
        </div>

        <div id="modalListar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Listar')">&times;</span>
                <?php include './listar_establecimientos.php'; ?>
            </div>
        </div>

        <div id="modalBuscar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Buscar')">&times;</span>
                <?php include './buscar_establecimiento.php'; ?>
            </div>
        </div>

        <div id="modalEditar" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('Editar')">&times;</span>
                <?php include './editar_establecimiento.php'; ?>
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
