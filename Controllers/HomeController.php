<?php

    namespace Controllers;

        use Models\User;
        use Models\Student;
        use Models\UserCompany;
        use Models\Career;

        use DAO\IStudentDAO;
        use DAO\ICareerDAO;
        use DAO\IUserDAO;
        use DAO\IUserCompanyDAO;

        use Config\DAOFactory;
        use Utils\Utils;

    class HomeController

    {
        private IStudentDAO $studentDAO;
        private ICareerDAO $careerDAO;
        private IUserDAO $userDAO;
        private IUserCompanyDAO $userCompanyDAO;

        public function __construct()
        {
            $this->studentDAO = DAOFactory::getStudentDAO();    
            $this->careerDAO = DAOFactory::getCareerDAO();
            $this->userDAO = DAOFactory::getUserDAO();
            $this->userCompanyDAO = DAOFactory::getUserCompanyDAO();
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
            Utils::checkStudentSession();

            $user = $_SESSION['loggedUser'];

            // 🔑 cargar Student por userId
            $student = $this->studentDAO->getByUserId($user->getUserId());

            if (!$student) {
                die("Student not found for userId " . $user->getUserId());
            }

            // opcional: guardarlo en sesión
            $_SESSION['student'] = $student;

            require_once(STUDENT_VIEWS . "menu-student.php");
        }
    
        public function menuCompany()
        {
            Utils::checkCompanySession();

            $user = $_SESSION['loggedUser'];

            // 🔑 cargar Company por userId
            $company = $this->userCompanyDAO->getByUserId($user->getUserId());

            if (!$userCompany) {
                die("Company not found for userId " . $user->getUserId());
            }

            // opcional: guardarlo en sesión
            $_SESSION['userCompany'] = $userCompany;

            require_once(STUDENT_VIEWS . "menu-usercompany.php");
        }

        public function login($data)
        {
            $email    = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if (!$email || !$password) {
                $_SESSION['login_error'] = "Complete todos los campos";
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }

            $user = $this->userDAO->getByEmail($email);

            if (!$user || !password_verify($password, $user->getPassword())) {
                $_SESSION['login_error'] = "Credenciales inválidas";
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }

            $_SESSION['loggedUser'] = $user;

            if ($user->mustChangePassword()) {
                header("Location: " . FRONT_ROOT . "User/changePassword");
                exit();
            }

            switch ($user->getRole()) {
                case User::ROLE_ADMIN:
                    header("Location: " . FRONT_ROOT . "Home/menuAdmin");
                    break;

                case User::ROLE_STUDENT:
                    $_SESSION['student'] = $this->studentDAO->getByUserId($user->getUserId());
                    header("Location: " . FRONT_ROOT . "Home/menuStudent");
                    break;

                case User::ROLE_COMPANY:
                    header("Location: " . FRONT_ROOT . "Home/menuCompany");
                    break;
            }

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
