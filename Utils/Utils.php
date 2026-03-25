<?php 
namespace Utils;

class Utils 
{
    public static function checkSession()
    {
        if (!isset($_SESSION['loggedUser'])) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }

    public static function checkAdminSession()
    {
        self::checkSession();

        if (!$_SESSION['loggedUser']->isAdmin()) {
            header("Location: " . FRONT_ROOT . "Home/index");
            exit();
        }
        return true;
    }

    public static function checkStudentSession()
    {
        self::checkSession();

        if (!$_SESSION['loggedUser']->isStudent()) {
            header("Location: " . FRONT_ROOT . "Home/index");
            exit();
        }
        return true;
    }

    public static function checkCompanySession()
    {
        if (!isset($_SESSION['loggedUser']) || !$_SESSION['loggedUser']->isCompany()) {
            header("Location: " . FRONT_ROOT . "Home/index");
            exit();
        }
        return true;
    }

    public static function checkNav($notifications = [], $cantNotif = 0)
    {
        if (isset($_SESSION['loggedUser'])) {
            if ($_SESSION['loggedUser']->isAdmin()) {
                require_once(ADMIN_VIEWS . "admin-nav.php");
            } elseif ($_SESSION['loggedUser']->isStudent()) {
                require_once(STUDENT_VIEWS . "student-nav.php");
            } elseif ($_SESSION['loggedUser']->isCompany()) {
                require_once(COMPANY_VIEWS . "company-nav.php");
            }
        } else {
            require_once(VIEWS_PATH . "guest-nav.php");
        }
    }

    public static function loadNav()
    {
        if (!isset($_SESSION['loggedUser'])) {
            require_once(VIEWS_PATH . "nav-guest.php");
            return;
        }

        $user = $_SESSION['loggedUser'];

        if ($user->isAdmin()) {
            require_once(ADMIN_VIEWS . "admin-nav.php");
        } elseif ($user->isCompany()) {
            require_once(COMPANY_VIEWS . "company-nav.php");
        } else {
            require_once(STUDENT_VIEWS . "student-nav.php");
        }
    }

}
?>