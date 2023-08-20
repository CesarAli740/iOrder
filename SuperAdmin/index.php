<!DOCTYPE html>
<html>

<head>
    <title>Cambio de Colores</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <form id="colorForm">
        <label for="colorInput">Selecciona un color:</label>
        <input type="color" id="colorInput" name="colorInput">
        <button type="button" onclick="cambiarColores()">Cambiar Colores</button>
    </form>
    <script>
        function cambiarColores() {
            var nuevoColor = document.getElementById("colorInput").value;
            var estiloCSS = document.styleSheets[0];

            for (var i = 0; i < estiloCSS.rules.length; i++) {
                if (estiloCSS.rules[i].selectorText === "body") {
                    estiloCSS.rules[i].style.backgroundColor = nuevoColor;
                    break;
                }
            }
        }
    </script>
</body>

</html>