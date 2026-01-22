<?php
namespace Config;

class Request
{
    private string $controller = "Home";
    private string $method     = "index";
    private array  $urlParams  = [];
    private array  $queryParams = [];
    private array  $bodyParams  = [];

    public function __construct()
    {
        $this->parseUrl();
        $this->parseQueryParams();
        $this->parseBodyParams();
    }

    /* =======================
     * URL
     * ======================= */
    private function parseUrl(): void
    {
        if (!isset($_GET['url'])) {
            return;
        }

        $url = trim($_GET['url'], '/');
        $parts = array_values(array_filter(explode('/', $url)));

        if (!empty($parts[0])) {
            $this->controller = $this->toPascalCase(array_shift($parts));
        }

        if (!empty($parts[0])) {
            $this->method = strtolower(array_shift($parts));
        }

        $this->urlParams = $parts;
    }

    private function toPascalCase($string)
    {
        // Si ya viene en CamelCase, NO tocarlo
        if (preg_match('/[A-Z]/', $string)) {
            return $string;
        }

        $string = str_replace(['-', '_'], ' ', $string);
        $string = ucwords(strtolower($string));
        $string = str_replace(' ', '', $string);

        return $string;
    }


    /* =======================
     * QUERY PARAMS (?a=b)
     * ======================= */
    private function parseQueryParams(): void
    {
        $this->queryParams = $_GET;
        unset($this->queryParams['url']);
    }

    /* =======================
     * BODY (POST / PUT)
     * ======================= */
    private function parseBodyParams(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if ($method === 'POST') {
            $this->bodyParams = $_POST;
        }

        if (in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
            parse_str(file_get_contents("php://input"), $this->bodyParams);
        }
    }

    /* =======================
     * GETTERS
     * ======================= */
    public function getController(): string
    {
        return $this->controller;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBodyParams(): array
    {
        return $this->bodyParams;
    }

    public function getHttpMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }
}
