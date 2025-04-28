<?php
session_start();

// Verifica si hay un mensaje de error o éxito en la sesión
if (isset($_SESSION['error'])) {
    echo "<p style='color: red;'>".$_SESSION['error']."</p>";  // Muestra el mensaje de error
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>".$_SESSION['success']."</p>";  // Muestra el mensaje de éxito
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <form class="login-form" action="../../Controllers/AuthController.php" method="POST">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <h2>LOGINN</h2>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Login Now</button>
                <a href="../../Views/registro.php">¿No tienes una cuenta? Registrate</a>
            </form>
        </div>
        <img class="login-image" src="../../Assets/imagen/logo.png" alt="Login Image">
    </div>
</body>
</html>
