<?php

    namespace Controllers;

    use Models\User;
    use Models\Student;
    use Models\UserCompany;
    use Models\Career;

    // Cambiamos los nombres para que coincidan con tus archivos reales
    use DAO\IStudentDAO;
    use DAO\ICareerDAO;
    use DAO\IUserDAO;
    use DAO\UserDAOMySQL as UserDAO;
    use DAO\StudentDAOMySQL as StudentDAO;
    use DAO\ICompanyDAO;
    use Repositories\StudentRepository;

    use Config\DAOFactory;
    use Utils\Utils;

    class HomeController
    {
        private IStudentDAO $studentDAO;
        private ICareerDAO $careerDAO;
        private IUserDAO $userDAO;
        private ICompanyDAO $companyDAO;
        private $studentRepo;
        private $studentDAOMySQL; // Agregamos la propiedad para evitar el warning de deprecated

        public function __construct()
        {
            //$this->studentDAO = DAOFactory::getStudentDAO();    
            //$this->careerDAO = DAOFactory::getCareerDAO();
            //$this->companyDAO = DAOFactory::getCompanyDAO();
            
            // 🔑 REPOS Y DATOS REALES
            $this->studentRepo = new StudentRepository();
            
            // Usamos UserDAO porque pusimos el "as UserDAO" arriba
            $this->userDAO = new UserDAO(); 
            
            // Usamos StudentDAO porque pusimos el "as StudentDAO" arriba
            $this->studentDAOMySQL = new StudentDAO();
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

            require_once(ADMIN_VIEWS . "admin-dashboard.php");
        }

        public function menuStudent()
        {
            Utils::checkStudentSession();
            $user = $_SESSION['loggedUser'];

            $student = $this->studentDAOMySQL->getByUserId($user->getUserId());

            if (!$student) {
                // En lugar de morir, limpiamos la sesión y volvemos al login con error
                session_destroy();
                $message = "Error: No se encontraron datos de perfil para el alumno con ID " . $user->getUserId() . ". Contacte al administrador.";
                require_once(VIEWS_PATH . "login.php");
                exit();
            }

            $_SESSION['student'] = $student;
            require_once(STUDENT_VIEWS . "student-dashboard.php");
        }
    
        public function menuCompany()
        {
            Utils::checkCompanySession();

            $user = $_SESSION['loggedUser'];

            // 🔑 cargar Company por userId
            $company = $this->companyDAO->getByUserId($user->getUserId());

            if (!$company) {
                die("Company not found for userId " . $user->getUserId());
            }

            // opcional: guardarlo en sesión
            $_SESSION['company'] = $company;

            require_once(COMPANY_VIEWS . "company-dashboard.php");
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

            // 1. Buscamos PRIMERO en nuestra tabla de Users (MySQL local)
            // Esto permite que Admins y Companies entren aunque la API de alumnos esté caída.
            $user = $this->userDAO->getByEmail($email);

            // 2. Si NO existe en nuestra DB local, podría ser un Alumno nuevo de la API
            if (!$user) {
                try {
                    // Intentamos buscar y sincronizar desde la API de Python
                    $student = $this->studentRepo->getAndSyncByEmail($email);
                    if ($student) {
                        // Si el Repo lo encontró y lo guardó, ahora sí debería estar en nuestra DB local
                        $user = $this->userDAO->getByEmail($email);
                    }
                } catch (\Exception $ex) {
                    // Si la API falla, logueamos el error pero permitimos que el código siga
                    // para no romper el flujo si el problema es solo de red.
                }
            }

            // 3. Verificación de seguridad (Password)
            // Importante: El admin que creamos por terminal usa password_verify
            if (!$user || !password_verify($password, $user->getPassword())) {          
                $_SESSION['login_error'] = "Credenciales inválidas";
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }

            // 4. Login exitoso
            $_SESSION['loggedUser'] = $user;

            // 5. Redirección según el Rol
            switch ($user->getRole()) {
                case \Models\User::ROLE_ADMIN:
                    header("Location: " . FRONT_ROOT . "Home/menuAdmin");
                    break;

                case \Models\User::ROLE_STUDENT:
                    // Obtenemos los datos específicos del alumno para la sesión
                    $_SESSION['student'] = $this->studentDAOMySQL->getByUserId($user->getUserId());
                    header("Location: " . FRONT_ROOT . "Home/menuStudent");
                    break;

                case \Models\User::ROLE_COMPANY:
                    // Aquí podrías cargar datos específicos de la empresa si tuvieras una tabla Company
                    header("Location: " . FRONT_ROOT . "Home/menuCompany");
                    break;

                default:
                    header("Location: " . FRONT_ROOT . "Home/index");
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
