<?php 
namespace Config;

class Request
{
    private $controller;
    private $method;
    private $parameters = array();
    private $queryParams = array(); // Separar parámetros GET de la URL
    
    public function __construct()
    {
        // Obtener y limpiar la URL
        $url = $this->getCleanUrl();
        $urlArray = $this->parseUrl($url);
        
        // Parsear Controller, Method y Parameters de la URL
        $this->parseUrlComponents($urlArray);
        
        // Parsear parámetros según el método HTTP
        $this->parseHttpParameters();
    }
    
    /**
     * Obtiene y limpia la URL de forma segura
     */
    private function getCleanUrl()
    {
        $url = $_GET["url"] ?? '';
        
        // Limpiar la URL manualmente (FILTER_SANITIZE_URL está deprecado en PHP 8.1+)
        $url = trim($url);
        $url = strip_tags($url);
        $url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        
        return $url;
    }
    
    /**
     * Parsea la URL en segmentos
     */
    private function parseUrl($url)
    {
        $urlArray = explode("/", $url);
        $urlArray = array_filter($urlArray); // Eliminar vacíos
        $urlArray = array_values($urlArray); // Reindexar
        
        // Eliminar carpeta base del proyecto si existe
        // MEJORA: Usar constante en lugar de hardcodear
        if (defined('BASE_FOLDER') && !empty($urlArray) && $urlArray[0] === BASE_FOLDER) {
            array_shift($urlArray);
        } elseif (!defined('BASE_FOLDER') && !empty($urlArray) && $urlArray[0] === 'TPLab4') {
            // Fallback temporal
            array_shift($urlArray);
        }
        
        return $urlArray;
    }
    
    /**
     * Parsea Controller, Method y parámetros de URL
     */
    private function parseUrlComponents($urlArray)
    {
        // Controller (primer segmento)
        if (empty($urlArray)) {
            $this->controller = "Home";
        } else {
            // Convertir a PascalCase correctamente
            $controller = array_shift($urlArray);
            $this->controller = $this->toPascalCase($controller);
        }
        
        // Method (segundo segmento)
        if (empty($urlArray)) {
            $this->method = "index"; // Minúscula para consistencia
        } else {
            $method = array_shift($urlArray);
            $this->method = strtolower($method); // Todo en minúsculas
        }
        
        // Parámetros restantes de la URL (si los hay)
        $this->parameters = $urlArray;
    }
    
    /**
     * Parsea parámetros según método HTTP
     */
    private function parseHttpParameters()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        switch ($requestMethod) {
            case "GET":
                // Guardar query params separados
                $this->queryParams = $_GET;
                unset($this->queryParams["url"]);
                
                // Si hay query params, usarlos; si no, usar segmentos de URL
                if (!empty($this->queryParams)) {
                    $this->parameters = $this->queryParams;
                }
                break;
                
            case "POST":
                $this->parameters = $_POST;
                break;
                
            case "PUT":
            case "DELETE":
            case "PATCH":
                // Parsear cuerpo de la petición para PUT/DELETE/PATCH
                parse_str(file_get_contents("php://input"), $putData);
                $this->parameters = $putData;
                break;
                
            default:
                $this->parameters = [];
        }
        
        // Agregar archivos si existen
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $this->parameters[$key] = $file;
            }
        }
    }
    
    /**
     * Convierte string a PascalCase correctamente
     * Ejemplo: "user-profile" -> "UserProfile"
     */
    private function toPascalCase($string)
    {
        // Reemplazar guiones y guiones bajos con espacios
        $string = str_replace(['-', '_'], ' ', $string);
        
        // Capitalizar cada palabra
        $string = ucwords(strtolower($string));
        
        // Eliminar espacios
        $string = str_replace(' ', '', $string);
        
        return $string;
    }
    
    /**
     * Getters
     */
    public function getController()
    {
        return $this->controller;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function getQueryParams()
    {
        return $this->queryParams;
    }
    
    public function getRequestMethod()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
    
    /**
     * Verifica si es una petición AJAX
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
?>