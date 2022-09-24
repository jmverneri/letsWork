<?php 
namespace Utils;

class Utils {
    public static function checkSession(){
        if(!(isset($_SESSION['admin']) || isset($_SESSION['student']) || isset($_SESSION['userCompany']))){
            $userNotLogged = true;
            require_once(VIEWS_PATH ."login.php");
        }
    }
    public static function checkAdminSession(){
        if(isset($_SESSION['userCompany']) || isset($_SESSION['admin'])){
            $adminLogged = true;
        } else {
            $userNotAdmin = true;
            require_once(VIEWS_PATH ."login.php");
        }
    }

    public static function checkStudentSession(){
        if(!(isset($_SESSION['student']))){
            $userNotStudent = true;
            require_once(VIEWS_PATH ."login.php");
        } else {
            $studentLogged = true;
        }
    }

    public static function strStartsWith(String $haystack, String $needle){
        return $needle != '' && strncmp($haystack, $needle, strlen($needle)) == 0;
    }

    public static function checkNav(){
        if(isset($_SESSION['admin'])){
            require_once(ADMIN_VIEWS . "navcompany.php");
        }elseif(isset($_SESSION['userCompany'])){
            require_once(USERCOMPANY_VIEWS . "nav-userCompany.php");
        }else{
            require_once(STUDENT_VIEWS . "nav.php");
        }
    }

}
?>