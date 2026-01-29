<?php
namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define('BASE_FOLDER', 'TPLab4');
define("FRONT_ROOT", "/index.php?url=");
define('DEBUG', true); // Cambiar a false en producción

// RUTAS RELATIVAS (para includes PHP)
define("VIEWS_PATH", "Views/");
define("ADMIN_VIEWS", VIEWS_PATH . "adminviews/");
define("STUDENT_VIEWS", VIEWS_PATH . "studentviews/");
define("COMPANY_VIEWS", VIEWS_PATH . "companyviews/");

// RUTAS ABSOLUTAS (para browser: CSS, JS, IMG)
define("CSS_PATH", "Views/css/");
define("IMG_PATH", "Views/img/");
define("JS_PATH", "Views/js/");

// API
define('API_KEY', '4f3bceed-50ba-4461-a910-518598664c08');
define("API_URL", 'https://utn-students-api.herokuapp.com/api/');

// Database
define("DB_HOST", "localhost");
define("DB_NAME", "lets");
define("DB_USER", "root");
define("DB_PASS", "admin");
?>