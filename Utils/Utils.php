<?php 
namespace Utils;

class Utils 
{
    /**
     * Verifica si hay CUALQUIER sesión activa (admin, student o company)
     * Si no hay sesión, redirige al login
     */
    public static function checkSession()
    {
        if (!(isset($_SESSION['admin']) || isset($_SESSION['student']) || isset($_SESSION['userCompany']))) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }
    
    /**
     * Verifica sesión de ADMIN o COMPANY
     * Si no es admin/company, redirige al login
     */
    public static function checkAdminSession()
    {
        if (!(isset($_SESSION['admin']) || isset($_SESSION['userCompany']))) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }
    
    /**
     * Verifica sesión de ESTUDIANTE
     * Si no es estudiante, redirige al login
     */
    public static function checkStudentSession()
    {
        if (!isset($_SESSION['student'])) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }
    
    /**
     * Verifica sesión SOLO de ADMIN (no company)
     * Útil para páginas exclusivas de administrador
     */
    public static function checkAdminOnly()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }
    
    /**
     * Verifica sesión SOLO de COMPANY (no admin)
     * Útil para páginas exclusivas de empresa
     */
    public static function checkCompanyOnly()
    {
        if (!isset($_SESSION['userCompany'])) {
            header("Location: index.php?url=Home/index");
            exit();
        }
        return true;
    }
    
    /**
     * Verifica si un string comienza con otro
     * Ejemplo: strStartsWith("Hello World", "Hello") -> true
     */
    public static function strStartsWith(String $haystack, String $needle)
    {
        return $needle != '' && strncmp($haystack, $needle, strlen($needle)) == 0;
    }
    
    /**
     * Carga el navbar apropiado según el tipo de usuario
     */
    public static function checkNav()
    {
        if (isset($_SESSION['admin'])) {
            require_once(ADMIN_VIEWS . "navcompany.php");
        } elseif (isset($_SESSION['userCompany'])) {
            require_once(USERCOMPANY_VIEWS . "nav-userCompany.php");
        } elseif (isset($_SESSION['student'])) {
            require_once(STUDENT_VIEWS . "nav.php");
        } else {
            // Si no hay sesión, mostrar navbar genérico o nada
            // require_once(VIEWS_PATH . "nav-guest.php");
        }
    }
    
    /**
     * Obtiene el tipo de usuario actual
     * Retorna: 'admin', 'company', 'student' o null
     */
    public static function getUserType()
    {
        if (isset($_SESSION['admin'])) {
            return 'admin';
        } elseif (isset($_SESSION['userCompany'])) {
            return 'company';
        } elseif (isset($_SESSION['student'])) {
            return 'student';
        }
        return null;
    }
    
    /**
     * Obtiene el objeto de usuario actual
     * Retorna el objeto User/Student/UserCompany o null
     */
    public static function getCurrentUser()
    {
        if (isset($_SESSION['admin'])) {
            return $_SESSION['admin'];
        } elseif (isset($_SESSION['userCompany'])) {
            return $_SESSION['userCompany'];
        } elseif (isset($_SESSION['student'])) {
            return $_SESSION['student'];
        }
        return null;
    }
}
?>