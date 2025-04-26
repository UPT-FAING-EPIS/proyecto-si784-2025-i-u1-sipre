<?php
require_once '../Config/Database.php'; // Incluir la clase de conexión a la base de datos

class AuthController {
    private $db;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->db = new Database();
        $this->db = $this->db->connect(); // Conexión a la base de datos
    }

    // Función para hacer login
    public function login($email, $password) {
        try {
            // Usar la tabla 'users' para encontrar el usuario por 'username' o 'email'
            $query = "SELECT * FROM users WHERE username = ? OR email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email, $email]); // Ejecutar la consulta buscando por email o username
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el usuario

            // Verificar si el usuario fue encontrado
            if ($user) {
                // Comparar la contraseña directamente ya que estamos usando texto plano
                if ($password === $user['password']) { // Comparación de la contraseña en texto plano
                    session_start();  // Iniciar sesión

                    // Guardar datos de usuario en la sesión
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['created_at'] = $user['created_at'];

                    // Guardar mensaje de éxito en la sesión y redirigir al dashboard
                    $_SESSION['success'] = 'Login exitoso';
                    header('Location: ../Views/dashboard.php'); // Redirigir al dashboard
                    exit();
                } else {
                    // Contraseña incorrecta
                    throw new Exception('Usuario o contraseña incorrectos');
                }
            } else {
                // Usuario no encontrado
                throw new Exception('Usuario o contraseña incorrectos');
            }
        } catch (Exception $e) {
            session_start();
            $_SESSION['error'] = $e->getMessage(); // Guardar el error en la sesión
            header('Location: ../Views/auth/login.php'); // Redirigir al login con el error
            exit();
        }
    }

    // Función para hacer logout
    public function logout() {
        session_start();  // Iniciar sesión
        session_destroy();  // Destruir la sesión para cerrar sesión
        header('Location: ../Views/auth/login.php'); // Redirigir al login después de cerrar sesión
        exit();
    }
}

// Manejo de la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController(); // Crear una instancia del controlador

    // Verificar qué acción se está solicitando (login o logout)
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                // Verificar que los campos 'email' y 'password' estén presentes en el POST
                if (isset($_POST['email']) && isset($_POST['password'])) {
                    $auth->login($_POST['email'], $_POST['password']); // Llamar al método login
                }
                break;
            case 'logout':
                // Si la acción es logout, ejecutar la función logout
                $auth->logout();
                break;
        }
    }
}
?>
