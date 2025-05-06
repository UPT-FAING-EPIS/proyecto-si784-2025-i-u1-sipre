<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de PPT</title>
    <!-- Carga de los archivos de CSS de CodeMirror -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/theme/dracula.min.css">
    <link rel="stylesheet" href="../public/css/base.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>
    <!-- Incluir el archivo header.php aquí -->
    <?php include '../Views/header.php'; ?>

    <div class="container">
        <!-- Panel izquierdo para el editor -->
        <div class="editor-container">
            <div class="editor-header">
                <h2>Editor</h2>
            </div>
            <div class="editor-body">
                <!-- Contenedor para el editor de CodeMirror -->
                <textarea id="editor" class="editor" placeholder="Escribe tu presentación en Marp aquí..."></textarea>
            </div>
        </div>

        <!-- Panel derecho para la vista previa -->
        <div class="preview-container">
            <div class="preview-header">
                <h2>Vista Previa</h2>
            </div>
            <div class="preview-body">
                <div id="ppt-preview" class="ppt-preview">
                    <p>La vista previa del PPT se mostrará aquí...</p>
                </div>
            </div>

            <!-- Espacio para los botones debajo de la vista previa -->
            <div class="button-container">
                <button class="generate-btn">Generar PPT</button>
                <button class="generate-btn">Generar PDF</button>
                <button class="generate-btn">Generar Video MP4</button>
                <button class="generate-btn">Generar HTML</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/addon/display/lineNumbers.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editor = CodeMirror.fromTextArea(document.getElementById('editor'), {
                lineNumbers: true,          // Mostrar números de línea
                mode: "markdown",           // Tipo de archivo, en este caso Markdown
                theme: "dracula",           // Tema (opcional)
                lineWrapping: true,         // Permitir que el texto se ajuste automáticamente
                matchBrackets: true,        // Resaltado de los corchetes
                extraKeys: { "Enter": function() { editor.execCommand("newlineAndIndent"); } } // Comportamiento de "enter"
            });

            // Ajusta la altura para el editor
            editor.setSize(null, "100%"); // Esto hace que el editor use todo el espacio disponible
        });
    </script>

</body>
</html>
