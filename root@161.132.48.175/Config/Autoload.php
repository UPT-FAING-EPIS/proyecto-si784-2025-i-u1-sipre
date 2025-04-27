<?php
class Autoload {
    public static function loadClasses($class) {
        // Definir el directorio raíz del proyecto
        $root = dirname(__DIR__);
        
        // Array de directorios donde buscar las clases
        $directories = [
            $root . '/Controllers/',
            $root . '/Models/',
            $root . '/Config/'
        ];
        
        // Limpiar el nombre de la clase (por si viene con namespace)
        $class = str_replace('\\', '/', $class);
        
        // Buscar la clase en cada directorio
        foreach ($directories as $directory) {
            $file = $directory . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
        
        return false;
    }
    
    public static function init() {
        spl_autoload_register([__CLASS__, 'loadClasses']);
    }
}