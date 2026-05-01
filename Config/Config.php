<?php
namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define('BASE_FOLDER', 'TPLab4');
define("FRONT_ROOT", "/index.php?url=");
define("BASE_URL", "http://localhost:8001/TPLab4/");

define('DEBUG', true); // Cambiar a false en producción

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
define('API_KEY', '4f3bceed-50ba-4461-a910-518598664c08');
define("API_URL", 'http://127.0.0.1:8000/');

// Database
define("DB_HOST", "localhost");
define("DB_NAME", "letswork");
define("DB_USER", "root");
define("DB_PASS", "");

date_default_timezone_set('America/Argentina/Buenos_Aires');
?>