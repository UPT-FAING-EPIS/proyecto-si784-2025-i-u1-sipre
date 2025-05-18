document.addEventListener('DOMContentLoaded', function () {
    var editor = CodeMirror.fromTextArea(document.getElementById('editor'), {
        lineNumbers: true,
        mode: "markdown", // Modo inicial
        theme: "dracula",
        lineWrapping: true,
        matchBrackets: true,
        extraKeys: { "Enter": function() { editor.execCommand("newlineAndIndent"); } }
    });

    const previewDiv = document.getElementById('ppt-preview');
    const modeSelect = document.getElementById('mode-select');

    // Obtener BASE_URL de PHP. Lo pasamos a la vista desde el controlador.
    // Asegúrate de que la variable PHP $base_url esté disponible y tenga el valor correcto.
    const baseUrl = "<?php echo htmlspecialchars($base_url ?? '', ENT_QUOTES, 'UTF-8'); ?>";

    function updatePreview() {
        const markdownText = editor.getValue();
        // Asegúrate de que 'marked' esté cargado y disponible globalmente
        if (typeof marked !== 'undefined') {
            const html = marked.parse(markdownText);
            previewDiv.innerHTML = html;
        } else {
            console.error("Marked.js no está cargado.");
            previewDiv.innerHTML = "<p style='color:red;'>Error: Librería de previsualización no encontrada.</p>";
        }
    }

    editor.on("change", updatePreview);

    if (modeSelect) { // Buena práctica verificar si el elemento existe
        modeSelect.addEventListener("change", function () {
            const selectedMode = modeSelect.value;
            
            if (selectedMode === "marp") {
                // ¡CORRECCIÓN! Redirigir a la URL limpia que maneja tu router
                window.location.href = baseUrl + '/markdown/marp-editor'; // Ajusta '/markdown/marp-editor' si tu ruta es diferente
            } else if (selectedMode === "markdown") {
                // Si ya estás en el editor de markdown, puedes simplemente actualizar la vista previa
                // o si es una página diferente, redirigir a la URL del editor markdown
                // window.location.href = baseUrl + '/markdown/create'; // Si esta es la URL del editor Markdown
                updatePreview(); // O simplemente actualiza la previsualización si el editor cambia de modo dinámicamente
                console.log("Modo Markdown seleccionado.");
            }
        });
    }

    // Llamada inicial para la previsualización cuando la página carga
    if (typeof marked !== 'undefined') {
        updatePreview();
    } else {
         // Manejar si marked no está listo al cargar
        if (previewDiv) {
            previewDiv.innerHTML = "<p>Cargando previsualización...</p>";
        }
    }
    
    editor.setSize(null, "100%"); // Ajustar tamaño después de que todo esté listo
});