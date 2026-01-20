<?php

namespace Controllers;

    use Models\User as User;
    use Controllers\StudentController as StudentController;
    use Models\Student as Student;
    use DAO\StudentDAO as StudentDAO;
    use DAO\CareerDAO as CareerDAO;
    use Models\Career as Career;
    use Models\UserCompany as UserCompany;
    use DAO\UserCompanyDAO as UserCompanyDAO;

class HomeController

{
    private $studentDAO;
    private $student;
    private $careerDAO;
    private $career;
    private $userCompany;
    private $userCompanyDAO;

    public function __construct()
    {
        $this->studentDAO =new StudentDAO;    
        $this->student = new Student();
        $this->careerDAO = new CareerDAO();
        $this->career = new Career();
        $this->userCompany = new UserCompany();
        $this->userCompanyDAO = new UserCompanyDAO();
    }

    public function index($message = "")
    {
        $error = '';
        if (isset($_SESSION['login_error'])) {
            $error = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }
        
        require_once(VIEWS_PATH . "login.php");
    }

    public function menuAdmin()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: " . BASE_FOLDER . "Home/index");
            exit();
        }

        require_once(ADMIN_VIEWS . "menu-admin.php");
    }

    public function menuStudent()
    {
        if (!isset($_SESSION['student'])) {
            header("Location: " . BASE_FOLDER . "Home/index");
            exit();
        }
        
        require_once(STUDENT_VIEWS . "menu-student.php");
    }
   
    public function login($email, $password)
    {
            // Validar campos vacíos
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = "Por favor, complete todos los campos.";
            header("Location: index.php?url=Home/index");
            exit();
        }
        
        // Admin hardcodeado
        if ($email == 'user@hot.com' && $password == '123') {
            $user = new User($email);
            $_SESSION['admin'] = $user;
            header("Location: index.php?url=Home/menuAdmin");
            exit();
        }
        /*
        // Buscar estudiante
        $this->student = $this->studentDAO->getLoginStudent($email);
        
        if ($this->student != null) {
            if ($this->student->getEmail() == $email && $password == $this->student->getPassword()) {
                $this->career = $this->careerDAO->GetCareerById($this->student->getCareerId());
                $_SESSION['student'] = $this->student;
                session_write_close();
                ?>
                <!DOCTYPE html>
                <html><head>
                <script>window.location.href='index.php?url=Home/menuStudent';</script>
                </head></html>
                <?php
                exit();
            }
        }
        
        // Buscar empresa
        $this->userCompany = $this->userCompanyDAO->getUserCompanyByEmail($email);
        
        if ($this->userCompany != null) {
            if ($this->userCompany->getEmail() == $email && $password == $this->userCompany->getPassword()) {
                $_SESSION['userCompany'] = $this->userCompany;
                session_write_close();
                ?>
                <!DOCTYPE html>
                <html><head>
                <script>window.location.href='index.php?url=UserCompany/profile';</script>
                </head></html>
                <?php
                exit();
            }
        }*/
        
            // Login falló
        $_SESSION['login_error'] = "Email o contraseña incorrectos.";
        header("Location: index.php?url=Home/index");
         exit();
    }
 
    public function redirectAdm()
    {
        require_once(VIEWS_PATH . "admin-view.php");
    }

    public function Logout()
    {
        session_destroy();

        header("Location: " . BASE_FOLDER . "Home/index");
        exit();
    }

    /**
 * Método helper para redireccionar de forma confiable
 */
    private function redirect($path)
    {
        $fullPath = "/" . BASE_FOLDER . $path;
        
        // Intentar header primero
        if (!headers_sent()) {
            header("Location: " . $fullPath);
            exit();
        }
        
        // Si header falló, usar JavaScript
        echo "<script type='text/javascript'>";
        echo "window.location.href='" . $fullPath . "';";
        echo "</script>";
        echo "<noscript>";
        echo "<meta http-equiv='refresh' content='0;url=" . $fullPath . "' />";
        echo "</noscript>";
        exit();
    }
}
