<?php
class ErrorHandler
{
    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return false;
        }

        switch ($errno) {
            case E_USER_ERROR:
                echo "<b>ERROR</b> [$errno] $errstr<br />\n";
                echo "  Error fatal en la línea $errline en el archivo $errfile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Abortando...<br />\n";
                exit(1);
                break;

            case E_USER_WARNING:
                echo "<b>ADVERTENCIA</b> [$errno] $errstr<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>AVISO</b> [$errno] $errstr<br />\n";
                break;

            default:
                echo "Tipo de error desconocido: [$errno] $errstr<br />\n";
                break;
        }

        // No ejecutar el gestor de errores interno de PHP
        return true;
    }

    public static function exceptionHandler($exception)
    {
        echo "<b>Excepción:</b> " , $exception->getMessage(), "<br />";
        echo "En el archivo " , $exception->getFile(), " en la línea ", $exception->getLine(), "<br />";
        echo "<pre>", $exception->getTraceAsString(), "</pre>";
    }

    public static function init()
    {
        // Establecer el nivel de reporte de errores
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        // Registrar los manejadores de errores y excepciones
        set_error_handler([__CLASS__, 'errorHandler']);
        set_exception_handler([__CLASS__, 'exceptionHandler']);
        
        // Asegurarse de que los errores fatales sean capturados
        register_shutdown_function(function() {
            $error = error_get_last();
            if ($error !== NULL && $error['type'] === E_ERROR) {
                ErrorHandler::errorHandler(E_ERROR, $error['message'], $error['file'], $error['line']);
            }
        });
    }
}