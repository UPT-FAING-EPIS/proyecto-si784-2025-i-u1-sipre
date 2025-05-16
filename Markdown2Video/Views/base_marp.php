<?php
// --- Views/base_marp.php ---
// Variables pasadas por MarkdownController->showMarpEditor(): $base_url, $pageTitle, $csrf_token
$base_url = $base_url ?? '';
$pageTitle = $pageTitle ?? 'Editor de Presentación Marp';
// $csrf_token = $csrf_token ?? ''; // Si necesitas CSRF para formularios en esta página

// Definir BASE_URL para JavaScript
echo "<script>window.BASE_APP_URL = " . json_encode($base_url) . ";</script>";
// Si necesitas el token CSRF en JS:
// echo "<meta name='csrf-token' content='" . htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') . "'>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    
    <!-- CodeMirror CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/theme/dracula.min.css">
    
    <!-- CSS locales -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>/public/css/header.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>/public/css/base_marp.css"> <!-- Tu CSS específico para Marp -->
</head>
<body class="marp-editor-page"> <!-- Clase opcional para body -->

    <?php
        // Incluir el header.php
        if (defined('VIEWS_PATH') && file_exists(VIEWS_PATH . 'header.php')) {
            include VIEWS_PATH . 'header.php';
        }
    ?>

    <div class="marp-editor-page-container"> <!-- Usar la clase renombrada del CSS -->
        <!-- Editor Section -->
        <div class="editor-container">
            <div class="editor-header">
                <h2>Editor (Marp)</h2>
                <select id="mode-select-marp-page" class="mode-selector"> <!-- ID específico -->
                    <option value="marp" selected>Marp</option>
                    <option value="markdown">Markdown Estándar</option>
                </select>
            </div>
            <div class="editor-body">
                <textarea id="editor-marp" class="editor" placeholder="Escribe tu presentación en Marp aquí..."></textarea> <!-- ID específico -->
            </div>
        </div>

        <!-- Preview Section -->
        <div class="preview-container">
            <div class="preview-header">
                <h2>Vista Previa Marp</h2>
            </div>
            <div class="preview-body">
                <div id="ppt-preview"> <!-- Mismo ID para el div de preview -->
                    <p>Escribe en el editor para ver la vista previa...</p>
                </div>
            </div>

            <!-- Buttons for Generating Files -->
            <div class="button-container">
                <button class="generate-btn" data-format="ppt">Generar PPT</button>
                <button class="generate-btn" data-format="pdf">Generar PDF</button>
                <button class="generate-btn" data-format="mp4">Generar Video MP4</button>
                <button class="generate-btn" data-format="html">Generar HTML</button>
                 <!-- Podrías añadir un botón de Guardar aquí si es necesario -->
            </div>
        </div>
    </div>

    <!-- Scripts JS (CDNs primero, luego los tuyos) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/mode/markdown/markdown.min.js"></script> <!-- Marp usa sintaxis Markdown -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/addon/display/lineNumbers.min.js"></script>
    <!-- Si Marp tiene una librería JS para preview en cliente, inclúyela aquí -->
    
    <!-- Tu JS local para la página Marp -->
    <script src="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>/public/js/base_marp.js"></script>
</body>
</html>