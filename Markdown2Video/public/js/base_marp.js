// public/js/base_marp.js

document.addEventListener('DOMContentLoaded', function() {
    const editorTextareaMarp = document.getElementById('editor-marp');         // ID del textarea en base_marp.php
    const previewDivMarp = document.getElementById('ppt-preview');             // ID del div de previsualización
    const modeSelectMarp = document.getElementById('mode-select-marp-page'); // ID del select en base_marp.php
    
    // Obtener BASE_URL de la variable global definida en la vista PHP (Views/base_marp.php)
    const baseUrl = typeof window.BASE_APP_URL !== 'undefined' ? window.BASE_APP_URL : '';
    if (baseUrl === '') {
        console.warn("ADVERTENCIA: window.BASE_APP_URL no está definida en el HTML. Las funcionalidades podrían fallar.");
    }

    // Obtener el token CSRF si se definió para el endpoint API
    // const csrfTokenMarpEditor = typeof window.CSRF_TOKEN_MARP_EDITOR !== 'undefined' ? window.CSRF_TOKEN_MARP_EDITOR : '';


    let marpDebounceTimer; // Timer para el debounce de la actualización de la previsualización

    if (!editorTextareaMarp) {
        console.error("Textarea con ID 'editor-marp' no encontrado. El editor Marp no se inicializará.");
        return;
    }

    // Inicializar CodeMirror para el editor Marp
    const marpCodeMirrorEditor = CodeMirror.fromTextArea(editorTextareaMarp, {
        mode: 'markdown',        // Marp usa sintaxis Markdown
        theme: 'dracula',
        lineNumbers: true,
        lineWrapping: true,
        matchBrackets: true,
        placeholder: editorTextareaMarp.getAttribute('placeholder') || "Escribe tu presentación Marp aquí...",
        extraKeys: {
            "Enter": "newlineAndIndentContinueMarkdownList"
        }
    });

    function refreshMarpEditorLayout() {
        if (marpCodeMirrorEditor) {
            marpCodeMirrorEditor.setSize('100%', '100%'); // Asume que .editor-body tiene altura flexible
            marpCodeMirrorEditor.refresh();
        }
    }
    setTimeout(refreshMarpEditorLayout, 50);

    /**
     * Función asíncrona para actualizar la vista previa de Marp.
     * Envía el contenido Markdown al endpoint del backend para ser renderizado.
     */
    async function updateMarpPreview() {
        if (!previewDivMarp || !marpCodeMirrorEditor) return;

        const markdownText = marpCodeMirrorEditor.getValue();
        previewDivMarp.innerHTML = '<p>Generando vista previa Marp...</p>';

        try {
            const renderEndpoint = baseUrl + '/markdown/render-marp-preview'; // URL limpia a tu API
            const requestBody = `markdown=${encodeURIComponent(markdownText)}`;
            
            // Preparar cabeceras
            const headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
            // if (csrfTokenMarpEditor) { // Añadir token CSRF si existe y es necesario para el endpoint POST
            //     headers['X-CSRF-TOKEN'] = csrfTokenMarpEditor;
            // }

            const response = await fetch(renderEndpoint, {
                method: 'POST',
                headers: headers,
                body: requestBody
            });

            if (!response.ok) {
                let errorDetail = await response.text();
                try {
                  const errorJson = JSON.parse(errorDetail);
                  errorDetail = errorJson.details || errorJson.error || errorDetail;
                } catch(e) { /* No era JSON */ }
                throw new Error(`Error del servidor: ${response.status} - ${errorDetail}`);
            }

            const htmlResult = await response.text();
            // ¡IMPORTANTE! Confías en que el HTML de Marp es seguro.
            // Considera DOMPurify si el Markdown original no es de confianza.
            previewDivMarp.innerHTML = htmlResult;

        } catch (error) {
            console.error("Error al generar vista previa Marp:", error);
            if (previewDivMarp) {
                previewDivMarp.innerHTML = ''; // Limpiar
                const errorParagraph = document.createElement('p');
                errorParagraph.style.color = 'red';
                errorParagraph.textContent = `Error al cargar la previsualización Marp: ${error.message}`;
                previewDivMarp.appendChild(errorParagraph);
            }
        }
    }

    if (marpCodeMirrorEditor) {
        marpCodeMirrorEditor.on('change', () => {
            clearTimeout(marpDebounceTimer);
            marpDebounceTimer = setTimeout(updateMarpPreview, 700); // Debounce
        });
    }

    // Manejador para el combobox de modo en la página de Marp
    if (modeSelectMarp) {
        modeSelectMarp.addEventListener('change', function () {
            const selectedMode = this.value;
            if (selectedMode === 'markdown') {
                if (baseUrl) {
                    window.location.href = baseUrl + '/markdown/create'; // URL limpia al editor Markdown
                } else { console.error("BASE_URL no configurada en JS (Marp)."); alert("Error de config.");}
            } else if (selectedMode === 'marp') {
                console.log("Modo Marp ya seleccionado.");
            }
        });
    }

    // Actualización inicial de la previsualización al cargar
    setTimeout(updateMarpPreview, 100); 
});