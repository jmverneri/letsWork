<?php
namespace Controllers;
class ErrorController {
    public function notFound($message = "") {
        require_once(VIEWS_PATH."error_404.php");
    }

    public function serverError($message = "") {
        require_once(VIEWS_PATH."error_500.php");
    }
}
?>