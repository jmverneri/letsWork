<?php
namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define('BASE_FOLDER', 'TPLab4');
define('DEBUG', true); // Cambiar a false en producción

define("VIEWS_PATH", "Views/");
define("CSS_PATH", "/" . BASE_FOLDER . "/" . VIEWS_PATH . "css/");
define("IMG_PATH", "/" . BASE_FOLDER . "/" . VIEWS_PATH . "img/");
define("JS_PATH", "/" . BASE_FOLDER . "/" . VIEWS_PATH . "js/");
define("ADMIN_VIEWS", VIEWS_PATH . "adminviews/");
define("STUDENT_VIEWS", VIEWS_PATH . "studentviews/");
define("USERCOMPANY_VIEWS", VIEWS_PATH . "usercompanyviews/");

define('API_KEY', '4f3bceed-50ba-4461-a910-518598664c08');
define("API_URL", 'https://utn-students-api.herokuapp.com/api/');

// constants to work with database
define("DB_HOST", "localhost");
define("DB_NAME", "lets");
define("DB_USER", "root");
define("DB_PASS", "admin");
?>