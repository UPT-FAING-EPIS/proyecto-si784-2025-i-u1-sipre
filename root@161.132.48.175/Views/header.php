<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="../public/css/header.css"> <!-- Ruta CSS -->
</head>
<body>

    <!-- Header con navbar -->
    <header class="header-container">
        <nav class="navbar">
            <div class="navbar-left">
                <!-- Enlace que redirige al dashboard.php al hacer clic en el logo -->
                <a href="../Views/dashboard.php">
                    <img src="../Assets/imagen/logo.png" alt="Logo" class="logo-img">
                </a>
            </div>
            <div class="navbar-right">
                <div class="user-profile">
                    <img src="../Assets/imagen/usuario.png" alt="usuario" class="usuario-img">
                </div>
            </div>
        </nav>
    </header>

</body>
</html>
