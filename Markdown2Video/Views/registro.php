<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/registro.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <form class="login-form" action="../../Controllers/AuthController.php" method="POST">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <h2>Registrate</h2>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Registrate Ahora</button>
                <a href="../../Views/login.php">No tienes una cuenta? Registrate</a>
            </form>
        </div>
    </div>
</body>
</html>
