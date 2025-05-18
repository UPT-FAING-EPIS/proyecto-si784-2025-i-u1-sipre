// public/js/base_marp.js

document.addEventListener('DOMContentLoaded', function() {
    const editorTextareaMarp = document.getElementById('editor-marp'); // ID específico para el textarea de este editor
    const previewDivMarp = document.getElementById('ppt-preview');     // ID del div donde se mostrará la previsualización
    const modeSelectMarp = document.getElementById('mode-select-marp-page'); // ID específico para el select de esta página

    // BASE_URL se espera que sea definida en la vista PHP (Views/base_marp.php)
    // como una variable global de JavaScript ANTES de que este script se cargue.
    // Ejemplo en base_marp.php: <script>window.BASE_APP_URL = "<?php echo $base_url; ?>";</script>
    const baseUrl = typeof window.BASE_APP_URL !== 'undefined' ? window.BASE_APP_URL : '';

    let marpDebounceTimer; // Timer para el debounce de la actualización de la previsualización

    // Verificar si los elementos esenciales existen para evitar errores
    if (!editorTextareaMarp) {
        console.error("Elemento textarea con id 'editor-marp' no encontrado. El editor Marp no se inicializará.");
        return; // Salir si el textarea no existe
    }
    if (!previewDivMarp) {
        console.error("Elemento div con id 'ppt-preview' no encontrado. La previsualización de Marp no funcionará.");
        // No necesariamente salir, el editor podría funcionar sin previsualización
    }
    if (!modeSelectMarp) {
        console.warn("Elemento select con id 'mode-select-marp-page' no encontrado. El cambio de modo no funcionará desde esta página.");
    }

    // Inicializar CodeMirror para el editor Marp
    const marpCodeMirrorEditor = CodeMirror.fromTextArea(editorTextareaMarp, {
        mode: 'markdown',        // Marp usa sintaxis Markdown
        theme: 'dracula',        // Tema oscuro popular
        lineNumbers: true,       // Mostrar números de línea
        lineWrapping: true,      // Envolver líneas largas
        matchBrackets: true,     // Resaltar paréntesis/corchetes que coinciden
        // Configuración para la tecla "Enter"
        extraKeys: {
            "Enter": "newlineAndIndentContinueMarkdownList" // Para un comportamiento inteligente en listas Markdown
            // Alternativas si la anterior no funciona como se espera:
            // "Enter": "newlineAndIndent", // Indentación simple
            // "Enter": function(cm) { cm.replaceSelection("\n"); } // Solo nueva línea
        }
    });

    // Ajustar el tamaño del editor para ocupar el espacio disponible
    // Puedes ajustar 'calc(100vh - XYZpx)' según la altura de tu header y otros elementos.
    marpCodeMirrorEditor.setSize(null, "calc(100vh - 220px)"); // Ejemplo de altura

    /**
     * Función para actualizar la vista previa de Marp.
     * Envía el contenido Markdown al backend para ser renderizado.
     */
    async function updateMarpPreview() {
        if (!previewDivMarp || !marpCodeMirrorEditor) return; // Salir si no hay elementos necesarios

        const markdownText = marpCodeMirrorEditor.getValue();
        previewDivMarp.innerHTML = '<p>Generando vista previa Marp...</p>'; // Mensaje de carga

        try {
            // URL del endpoint API en el backend que renderiza Marp
            const renderEndpoint = baseUrl + '/markdown/render-marp-preview'; // Asegúrate que esta ruta exista en index.php

            const response = await fetch(renderEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    // Si tu endpoint requiere un token CSRF para peticiones POST:
                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token-marp-editor"]')?.content || '' // Necesitarías esta meta tag en base_marp.php
                },
                body: `markdown=${encodeURIComponent(markdownText)}`
            });

            if (!response.ok) {
                let errorDetail = await response.text(); // Intentar obtener detalles del error
                try { // Intentar parsear como JSON si el servidor envía errores JSON
                  const errorJson = JSON.parse(errorDetail);
                  errorDetail = errorJson.details || errorJson.error || errorDetail; // Tomar el mensaje más específico
                } catch(e) { /* No era JSON, usar el texto original del error */ }
                throw new Error(`Error del servidor: ${response.status} - ${errorDetail}`);
            }

            const htmlResult = await response.text();
            previewDivMarp.innerHTML = htmlResult; // Mostrar el HTML renderizado por Marp
        } catch (error) {
            console.error("Error al generar vista previa Marp:", error);
            if (previewDivMarp) {
                previewDivMarp.innerHTML = `<p style="color:red;">Error al cargar la previsualización Marp: ${error.message}</p>`;
            }
        }
    }

    // Escuchar cambios en el editor CodeMirror para actualizar la previsualización (con debounce)
    if (marpCodeMirrorEditor) {
        marpCodeMirrorEditor.on('change', () => {
            clearTimeout(marpDebounceTimer);
            marpDebounceTimer = setTimeout(updateMarpPreview, 700); // Debounce de 700ms
        });
    }

    // Evento de cambio de modo en el select de esta página (Marp)
    if (modeSelectMarp) {
        modeSelectMarp.addEventListener('change', function () {
            const selectedMode = this.value;
            if (selectedMode === 'markdown') {
                // Redirigir a la página del editor Markdown estándar
                window.location.href = baseUrl + '/markdown/create'; // URL limpia para el editor Markdown
            } else if (selectedMode === 'marp') {
                // Ya estamos en la página de Marp, no es necesario redirigir.
                // Se podría forzar una actualización de la previsualización si se desea.
                // updateMarpPreview();
                console.log("Modo Marp ya seleccionado en la página Marp.");
            }
        });
    }

    // Actualizar la vista previa una vez cuando la página carga y CodeMirror está listo
    // Esperar un poco para que CodeMirror se inicialice completamente podría ser necesario en algunos casos
    setTimeout(updateMarpPreview, 100); 
});