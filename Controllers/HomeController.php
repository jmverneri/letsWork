<?php

    namespace Controllers;

    use Models\User as User;
    use Models\Student;
    use Models\UserCompany;
    use Models\Career;

    // Cambiamos los nombres para que coincidan con tus archivos reales
    use DAO\StudentDAOMySQL as StudentDAO;
    use DAO\NotificationDAO;
    use Repositories\UserRepository;
    use Repositories\CompanyRepository;
    use Repositories\StudentRepository;

    use Config\DAOFactory;
    use Utils\Utils;

    class HomeController
    {
        private CompanyRepository $companyRepo;
        private StudentRepository $studentRepo;
        private UserRepository $userRepo;
        private $studentDAOMySQL;
        private NotificationDAO $notificationDAO;

        public function __construct()
        {
            // 🔑 REPOS Y DATOS REALES
            $this->studentRepo = new StudentRepository();
            $this->userRepo = new UserRepository(); 
            $this->studentDAOMySQL = new StudentDAO();
            $this->companyRepo = new CompanyRepository();
            $this->notificationDAO = new NotificationDAO();
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
                session_destroy();
                $message = "Error: No se encontraron datos de perfil para el alumno con ID " . $user->getUserId() . ". Contacte al administrador.";
                require_once(VIEWS_PATH . "login.php");
                exit();
            }

            $studentId = $student->getStudentId();
            $notifications = $this->notificationDAO->getUnreadByStudent($studentId);
            $cantNotif = count($notifications);

            $_SESSION['student'] = $student;
            require_once(STUDENT_VIEWS . "student-dashboard.php");
        }
    
        public function menuCompany()
        {
            Utils::checkCompanySession();

            $user = $_SESSION['loggedUser'];

            // 🔑 cargar Company por userId
            $company = $this->companyRepo->getByUserId($user->getUserId());

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
            $user = $this->userRepo->getByEmail($email);

            // 2. Si NO existe en nuestra DB local, podría ser un Alumno nuevo de la API
            if (!$user) {
                try {
                    // Intentamos buscar y sincronizar desde la API de Python
                    $student = $this->studentRepo->getAndSyncByEmail($email);
                    if ($student) {
                        // Si el Repo lo encontró y lo guardó, ahora sí debería estar en nuestra DB local
                        $user = $this->userRepo->getByEmail($email);
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

            if ($user->getMustChangePassword()) {
                header("Location: " . FRONT_ROOT . "User/ShowChangePasswordView");
                exit();
            }
            // 5. Redirección según el Rol
            switch ($user->getRole()) {
                case User::ROLE_ADMIN:
                    header("Location: " . FRONT_ROOT . "Home/menuAdmin");
                    break;

                case User::ROLE_STUDENT:
                    $student = $this->studentDAOMySQL->getByUserId($user->getUserId());

                    if ($student) {
                        // 2. Guardamos el studentId a mano para tenerlo siempre a tiro
                        $_SESSION['student'] = $student;
                        $_SESSION['studentId'] = $student->getStudentId();
                        
                        // Cargamos las notificaciones una sola vez
                        $notifDAO = new NotificationDAO();
                        $unreadList = $notifDAO->getUnreadByStudent($student->getStudentId());
                        
                        // GUARDAMOS EN SESIÓN
                        $_SESSION['unreadNotifications'] = $unreadList;
                        $_SESSION['cantNotif'] = count($unreadList);
                    }
                    header("Location: " . FRONT_ROOT . "Home/menuStudent");
                    break;

                case User::ROLE_COMPANY:
                    // 1. Buscamos la empresa asociada al usuario
                    $company = $this->companyRepo->getByUserId($user->getUserId());

                    // 2. Validación de estado: Si no existe o está inactiva, bloqueamos
                    if (!$company || !$company->isActive()) {
                        $_SESSION['login_error'] = "Su cuenta de empresa ha sido desactivada. Contacte al administrador.";
                        header("Location: " . FRONT_ROOT . "Home/index");
                        exit();
                    }
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

        // En Controllers/HomeController.php

    public function Privacy() {
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "privacy.php");
        require_once(VIEWS_PATH . "footer.php");
    }

    public function Terms() {
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "terms.php");
        require_once(VIEWS_PATH . "footer.php");
    }

    public function Support() {
        require_once(VIEWS_PATH . "header.php");
        require_once(VIEWS_PATH . "support.php");
        require_once(VIEWS_PATH . "footer.php");
    }
}
