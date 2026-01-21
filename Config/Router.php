<?php 
namespace Config;

use Config\Request as Request;

class Router
{
    // Controladores permitidos (whitelist de seguridad)
    private static $allowedControllers = [
        'Home',
        'UserCompany',
        'Admin',
        'Career',
        'Company',
        'JobOffer',
        'JobPosition',
        'Student',
        'Error',
        'Admin',
        'CompanyJobOffer',
        'StudentJobOffer',
        'AdminJobOffer'
    ];

    public static function Route(Request $request)
    {
        $controllerName = $request->getController() . 'Controller';
        $methodName = $request->getMethod();
        $methodParameters = $request->getParameters();
        
        // Validar que el controlador esté en la whitelist
        if (!in_array($request->getController(), self::$allowedControllers)) {
            self::handleError404("Controlador no permitido: " . $request->getController());
            return;
        }
        
        // Construir nombre completo de la clase
        $controllerClassName = "Controllers\\" . $controllerName;
        
        // Verificar que la clase del controlador exista
        if (!class_exists($controllerClassName)) {
            self::handleError404("Controlador no encontrado: " . $controllerName);
            return;
        }

        // Instanciar el controlador
        $controller = new $controllerClassName;
        
        // Verificar que el método exista
        if (!method_exists($controller, $methodName)) {
            self::handleError404("Método no encontrado: " . $methodName . " en " . $controllerName);
            return;
        }
        
        // Verificar que el método sea público (seguridad)
        $reflection = new \ReflectionMethod($controller, $methodName);
        if (!$reflection->isPublic()) {
            self::handleError404("Método no accesible: " . $methodName);
            return;
        }
        
        // Ejecutar el método con los parámetros
        try {
            call_user_func_array([$controller, $methodName], array_values($methodParameters));
        } catch (\Exception $e) {
            self::handleError500($e->getMessage());
        }
    }
    
    /**
     * Maneja errores 404
     */
    private static function handleError404($message = "Página no encontrada")
    {
        http_response_code(404);
        
        // Si tienes un ErrorController, úsalo
        if (class_exists("Controllers\\ErrorController")) {
            $errorController = new \Controllers\ErrorController();
            if (method_exists($errorController, 'notFound')) {
                $errorController->notFound($message);
                return;
            }
        }
        
        // Fallback: mostrar error simple
        echo "<h1>404 - Página no encontrada</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        
        // En desarrollo, mostrar más info
        if (defined('DEBUG') && DEBUG === true) {
            echo "<pre>Detalles: " . htmlspecialchars($message) . "</pre>";
        }
    }
    
    /**
     * Maneja errores 500
     */
    private static function handleError500($message = "Error interno del servidor")
    {
        http_response_code(500);
        
        // Si tienes un ErrorController, úsalo
        if (class_exists("Controllers\\ErrorController")) {
            $errorController = new \Controllers\ErrorController();
            if (method_exists($errorController, 'serverError')) {
                $errorController->serverError($message);
                return;
            }
        }
        
        // Fallback: mostrar error simple
        echo "<h1>500 - Error del servidor</h1>";
        
        // Solo mostrar detalles en desarrollo
        if (defined('DEBUG') && DEBUG === true) {
            echo "<pre>Error: " . htmlspecialchars($message) . "</pre>";
        } else {
            echo "<p>Ocurrió un error. Por favor, inténtalo más tarde.</p>";
        }
    }
    
    /**
     * Agrega un controlador a la whitelist
     */
    public static function addAllowedController($controllerName)
    {
        if (!in_array($controllerName, self::$allowedControllers)) {
            self::$allowedControllers[] = $controllerName;
        }
    }
    
    /**
     * Obtiene la lista de controladores permitidos
     */
    public static function getAllowedControllers()
    {
        return self::$allowedControllers;
    }
}
?>