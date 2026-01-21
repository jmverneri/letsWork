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
        if (!isset($_SESSION['loggedUser']) || !$_SESSION['loggedUser']->isAdmin()) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }

    public static function checkStudentSession()
    {
        if (!isset($_SESSION['loggedUser']) || !$_SESSION['loggedUser']->isStudent()) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }

    public static function checkCompanySession()
    {
        if (!isset($_SESSION['loggedUser']) || !$_SESSION['loggedUser']->isCompany()) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }

    public static function checkNav()
    {
        if (isset($_SESSION['loggedUser'])) {
            if ($_SESSION['loggedUser']->isAdmin()) {
                require_once(ADMIN_VIEWS . "navadmin.php");
            } elseif ($_SESSION['loggedUser']->isStudent()) {
                require_once(STUDENT_VIEWS . "nav.php");
            } elseif ($_SESSION['loggedUser']->isCompany()) {
                require_once(USERCOMPANY_VIEWS . "nav-userCompany.php");
            }
        }
    }

}
?>