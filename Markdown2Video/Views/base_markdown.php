<?php
// --- Views/base_markdown.php ---
$base_url = $base_url ?? ''; // Pasada por MarkdownController->create()
$pageTitle = $pageTitle ?? 'Editor Markdown'; // Pasada por MarkdownController->create()
$csrf_token = $csrf_token ?? ''; // Pasada por MarkdownController->create()
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/theme/dracula.min.css">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>/public/css/header.css">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>/public/css/base_markdown.css">
</head>
<body>
  <?php if (defined('VIEWS_PATH') && file_exists(VIEWS_PATH . 'header.php')) { include VIEWS_PATH . 'header.php'; } ?>

  <div class="container">
    <div class="editor-container">
      <div class="editor-header">
        <h2>Editor</h2>
        <select id="mode-select" class="mode-selector">
          <option value="markdown" selected>Markdown Estándar</option>
          <option value="marp">Marp</option>
        </select>
      </div>
      <div class="editor-body"><textarea id="editor" class="editor" placeholder="Escribe tu presentación aquí..."></textarea></div>
    </div>
    <div class="preview-container">
      <div class="preview-header"><h2>Vista Previa</h2></div>
      <div class="preview-body"><div id="ppt-preview" class="ppt-preview"><p>La vista previa se mostrará aquí...</p></div></div>
      <div class="button-container">
        <button class="generate-btn">Generar PPT</button>
        <button class="generate-btn">Generar PDF</button>
        <button class="generate-btn">Generar Video MP4</button>
        <button class="generate-btn">Generar HTML</button>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/codemirror.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/mode/markdown/markdown.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.59.4/addon/display/lineNumbers.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script src="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>/public/js/base_markdown.js"></script>
  
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    var editorInstance = CodeMirror.fromTextArea(document.getElementById('editor'), {
      lineNumbers: true, mode: "markdown", theme: "dracula", lineWrapping: true, matchBrackets: true,
      extraKeys: { "Enter": function(cm) { cm.execCommand("newlineAndIndentContinueMarkdownList"); } }
    });
    editorInstance.setSize(null, "calc(100vh - 250px)");

    const previewDiv = document.getElementById('ppt-preview');
    const modeSelect = document.getElementById('mode-select');
    const baseUrlJs = "<?php echo htmlspecialchars($base_url ?? '', ENT_QUOTES, 'UTF-8'); ?>"; // $base_url es pasada por el controlador

    function updateMarkdownPreview() {
      if (typeof marked !== 'undefined' && editorInstance && previewDiv) {
        previewDiv.innerHTML = marked.parse(editorInstance.getValue());
      }
    }
    if (editorInstance) { editorInstance.on("change", updateMarkdownPreview); updateMarkdownPreview(); }

    if (modeSelect) {
      modeSelect.addEventListener("change", function () {
        const selectedMode = this.value;
        if (selectedMode === "marp") {
          window.location.href = baseUrlJs + '/markdown/marp-editor'; // URL Limpia
        } else if (selectedMode === "markdown") {
          // Ya estamos aquí, o podrías redirigir a /markdown/create si es necesario
          console.log("Modo Markdown ya seleccionado.");
        }
      });
    }
  });
</script>
</body>
</html>