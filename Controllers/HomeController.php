<?php

    namespace Controllers;

        use Models\User as User;
        use Controllers\StudentController as StudentController;
        use Models\Student as Student;
        use DAO\StudentDAOMock as StudentDAOMock;
        use DAO\careerDAOMock as careerDAOMock;
        use Models\Career as Career;
        use Models\UserCompany as UserCompany;
        use DAO\UserCompanyDAO as UserCompanyDAO;

    class HomeController

    {
        private $studentDAOMock;
        private $student;
        private $careerDAOMock;
        private $career;
        private $userCompany;
        private $userCompanyDAO;

        public function __construct()
        {
            $this->studentDAOMock = new StudentDAOMock;    
            $this->student = new Student();
            $this->careerDAOMock = new careerDAOMock;
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
            if (!isset($_SESSION['loggedUser']) || !$_SESSION['loggedUser']->isAdmin()) {
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }

            require_once(ADMIN_VIEWS . "menu-admin.php");
        }

        public function menuStudent()
        {
            if (!isset($_SESSION['student'])) {
                header("Location: " . FRONT_ROOT . "Home/index");
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
                $user = new User($email, $password, User::ROLE_ADMIN);
                $_SESSION['loggedUser'] = $user; // Un solo key para todos
                
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
            header("Location: " . FRONT_ROOT . "Home/index");
            exit();
        }
    }
