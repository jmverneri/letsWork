<?php

namespace Config;

define("ROOT", dirname(__DIR__) . "/");

//Path to your project's root folder
define("FRONT_ROOT", "/TPLab4/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT . VIEWS_PATH . "css/");
define("IMG_PATH", FRONT_ROOT . VIEWS_PATH .  "img/");

define("ADMIN_VIEWS", VIEWS_PATH . "adminviews/");
define("STUDENT_VIEWS", VIEWS_PATH. "studentviews/" );
define("USERCOMPANY_VIEWS", VIEWS_PATH. "usercompanyviews/" );
define("JS_PATH", FRONT_ROOT . VIEWS_PATH . "js/");
define('API_KEY', '4f3bceed-50ba-4461-a910-518598664c08');
//define("API_URL", 'https://utn-students-api.herokuapp.com/api/');
define("API_URL", 'https://utn-students-api.herokuapp.com/api/');

// constants to work with database
define("DB_HOST", "localhost");
define("DB_NAME", "letswork");
define("DB_USER", "root");
define("DB_PASS", "admin");

?>