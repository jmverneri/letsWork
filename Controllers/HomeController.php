<?php

    namespace Controllers;

        use Models\User;
        use Models\Student;
        use Models\UserCompany;
        use Models\Career;

        use DAO\IStudentDAO;
        use DAO\ICareerDAO;

        use Config\DAOFactory;
        
        //use DAO\UserCompanyDAO as UserCompanyDAO;

    class HomeController

    {
        private IStudentDAO $studentDAO;
        private ICareerDAO $careerDAO;

        public function __construct()
        {
            $this->studentDAO = DAOFactory::getStudentDAO();    
            $this->careerDAO = DAOFactory::getCareerDAO();
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
            if (!isset($_SESSION['loggedUser']) || !$_SESSION['loggedUser']->isStudent()) {
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }
            
            require_once(STUDENT_VIEWS . "menu-student.php");
        }
    
        public function login($data)
        {
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = "Por favor, complete todos los campos.";
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }

            // Admin
            if ($email === 'user@hot.com' && $password === '123') {
                $_SESSION['loggedUser'] = new User($email, null, User::ROLE_ADMIN);
                header("Location: " . FRONT_ROOT . "Home/menuAdmin");
                exit();
            }

           // Student login
            $student = $this->studentDAO->getByEmail($email);

            if ($student && $student->getPassword() === $password) {

                $_SESSION['loggedUser'] = new User(
                    $student->getEmail(),
                    null,
                    User::ROLE_STUDENT
                );

                $_SESSION['student'] = $student;

                header("Location: " . FRONT_ROOT . "Home/menuStudent");
                exit();
            }
            /*
            // Empresa
            $userCompany = $this->userCompanyDAO->getUserCompanyByEmail($email);

            if ($userCompany !== null && $userCompany->getPassword() === $password) {
                
                $user = new User($email, User::ROLE_COMPANY);
                $user->setReferenceId($userCompany->getId()); // ID real de la empresa

                $_SESSION['loggedUser'] = $user;

                header("Location: " . FRONT_ROOT . "UserCompany/profile");
                exit();
            }
            */
            $_SESSION['login_error'] = "Credenciales inválidas";
            header("Location: " . FRONT_ROOT . "Home/index");
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
