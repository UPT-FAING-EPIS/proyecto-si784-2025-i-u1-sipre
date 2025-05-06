<?php
session_start();
echo "<script>console.log('Usuario autenticado: " . (isset($_SESSION['user_id']) ? 'Sí' : 'No') . "');</script>";
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirigir al login si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>
<body>

    <!-- Incluir el archivo header.php aquí -->
    <?php include '../Views/header.php'; ?>

    <div class="dashboard-container">
        <!-- Botón para Historial -->
        <div class="historical-btn">
            <a href="base.php">
                <button class="btn-historical">Crear +</button>
            </a>
        </div>
        <!-- Contenido del Dashboard -->
        <div class="dashboard-content">
            <div class="historical">
                <h3>Historial</h3>
                <!-- Aquí podrías poner una tabla o cualquier otro contenido relacionado al historial -->
                <div class="historical-content">
                    <p>El historial aparecerá aquí...</p> <!-- Esto es un ejemplo, puedes agregar contenido dinámico aquí -->
                </div>
            </div>
        </div>
    </div>

</body>
</html>
