<?php
namespace Config;

define("ROOT", dirname(__DIR__) . "/");

//Path to your project's root folder
define('BASE_FOLDER', getenv('BASE_FOLDER') ?: 'TPLab4');
define("FRONT_ROOT", "/index.php?url=");
define("BASE_URL", getenv('BASE_URL') ?: "http://localhost:8080/");

define('DEBUG', (getenv('DEBUG') ?: 'true') === 'true'); // Cambiar a false en producción

// 1. Agregamos ROOT solo a las rutas de PHP (esto arregla tu error actual)
define("VIEWS_PATH", ROOT . "Views/");
define("ADMIN_VIEWS", VIEWS_PATH . "adminviews/");
define("STUDENT_VIEWS", VIEWS_PATH . "studentviews/");
define("COMPANY_VIEWS", VIEWS_PATH . "companyviews/");

// 2. Para el Navegador (CSS, JS, IMG), usamos rutas relativas a la URL
// OJO: Aquí NO agregamos ROOT.
define("CSS_PATH", "/Views/css/");
define("JS_PATH", "/Views/js/");
define("IMG_PATH", "/Views/img/");

// API
define('API_KEY', getenv('API_KEY') ?: '4f3bceed-50ba-4461-a910-518598664c08');
define("API_URL", getenv('API_URL') ?: 'http://letswork_api:8000/');

// Database
define("DB_HOST", getenv('DB_HOST') ?: "letswork_db");
define("DB_NAME", getenv('DB_NAME') ?: "letswork");
define("DB_USER", getenv('DB_USER') ?: "root");
define("DB_PASS", getenv('DB_PASS') ?: "root");

date_default_timezone_set('America/Argentina/Buenos_Aires');
?>