<?php
require_once 'Config/Autoload.php';
require_once 'Config/ErrorHandler.php';
Autoload::init();
ErrorHandler::init();
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir constantes del sistema
define('ROOT_PATH', dirname(__FILE__));
define('CONTROLLERS_PATH', ROOT_PATH . '/Controllers/');
define('MODELS_PATH', ROOT_PATH . '/Models/');
define('VIEWS_PATH', ROOT_PATH . '/Views/');
define('CONFIG_PATH', ROOT_PATH . '/Config/');

// Configurar el autoloader
spl_autoload_register(function ($class) {
    // Convertir namespace a path
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Array de directorios donde buscar las clases
    $directories = [
        CONTROLLERS_PATH,
        MODELS_PATH,
        CONFIG_PATH
    ];
    
    // Buscar la clase en cada directorio
    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Iniciar sesión
session_start();

// Obtener la URL solicitada
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Determinar el controlador y la acción
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$actionName = !empty($url[1]) ? $url[1] : 'index';

// Verificar si existe el controlador
if (file_exists(CONTROLLERS_PATH . $controllerName . '.php')) {
    require_once CONTROLLERS_PATH . $controllerName . '.php';
    $controller = new $controllerName();
    
    // Verificar si existe el método
    if (method_exists($controller, $actionName)) {
        // Obtener parámetros adicionales
        $params = array_slice($url, 2);
        call_user_func_array([$controller, $actionName], $params);
    } else {
        // Método no encontrado
        header("HTTP/1.0 404 Not Found");
        require_once VIEWS_PATH . 'error/404.php';
    }
} else {
    // Controlador no encontrado
    header("HTTP/1.0 404 Not Found");
    require_once VIEWS_PATH . 'error/404.php';
}