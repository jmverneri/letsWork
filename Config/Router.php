<?php
namespace Config;

class Router
{
    private static array $allowedControllers = [
        'Home',
        'Admin',
        'Company',
        'Career',
        'JobOffer',
        'User',
        'AdminJobOffer',
        'CompanyJobOffer',
        'StudentJobOffer',
        'Student',
        'StudentCompany',
        'AdminCompany',
        'Error'
    ];

    public static function Route(Request $request): void
    {
        $controllerName = $request->getController();
        $methodName     = $request->getMethod();

        /* =======================
         * Security: whitelist
         * ======================= */
        if (!in_array($controllerName, self::$allowedControllers)) {
            self::error404("Controller no permitido");
            return;
        }

        $controllerClass = "Controllers\\{$controllerName}Controller";

        if (!class_exists($controllerClass)) {
            self::error404("Controller no encontrado");
            return;
        }

        $controller = new $controllerClass;

        if (!method_exists($controller, $methodName)) {
            self::error404("Método no encontrado");
            return;
        }

        $reflection = new \ReflectionMethod($controller, $methodName);
        if (!$reflection->isPublic()) {
            self::error404("Método no accesible");
            return;
        }

        /* =======================
         * Parameters resolution
         * ======================= */
        $params = [];

        // 1️⃣ URL params (ordenados)
        if (!empty($request->getUrlParams())) {
            $params = array_values($request->getUrlParams());
        }

        // 2️⃣ GET params (como array)
        if (!empty($request->getQueryParams())) {
            $params[] = $request->getQueryParams();
        }

        // 3️⃣ POST / BODY params
        if (!empty($request->getBodyParams())) {
            $params[] = $request->getBodyParams();
        }

        /* =======================
         * Execute
         * ======================= */
        try {
            call_user_func_array([$controller, $methodName], $params);
        } catch (\Throwable $e) {
            self::error500($e);
        }
    }

    /* =======================
     * Errors
     * ======================= */
    private static function error404(string $message): void
    {
        http_response_code(404);

        if (class_exists("Controllers\\ErrorController")) {
            (new \Controllers\ErrorController())->notFound($message);
            return;
        }

        echo "<h1>404</h1><p>$message</p>";
    }

    private static function error500(\Throwable $e): void
    {
        http_response_code(500);

        if (defined('DEBUG') && DEBUG === true) {
            echo "<pre>{$e}</pre>";
        } else {
            echo "<h1>500</h1><p>Error interno</p>";
        }
    }
}
