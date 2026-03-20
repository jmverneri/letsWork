<?php
    namespace Controllers;

    use Repositories\StudentRepository;
    use Repositories\CompanyRepository;
    use Repositories\CareerRepository;
    use DAO\UserDAOMySQL;
    use Models\Student;
    use Models\Career;
    use Models\User;
    use Utils\Utils;

    class AdminController
    {
        private StudentRepository $studentRepo;
        private CompanyRepository $companyRepo;
        private CareerRepository $careerRepo;
        private UserDAOMySQL $userDAO;
        private $viewMessage;

        public function __construct()
        {
            $this->studentRepo = new StudentRepository();
            $this->companyRepo = new CompanyRepository();
            $this->careerRepo  = new CareerRepository();
            $this->userDAO = new UserDAOMySQL();
        }

        public function showStudentList()
    {
        Utils::checkNav();

        // 1. El Repo ahora devuelve un Array de Arrays (API + flag isRegistered)
        $studentList = $this->studentRepo->getAll(); 

        // 2. Si tenés este array_map para filtrar o comparar, cambialo así:
        // (Asegurate de que las llaves coincidan con el var_dump que vimos)
        $registeredIds = array_map(function($student) {
            return $student['studentId']; // <-- Cambio: de objeto a array
        }, $studentList);

        require_once(ADMIN_VIEWS . "student-list.php");
    }

        public function updateCareers() 
        {
            Utils::checkAdminSession();
            
            // El Repository sabe que tiene que ir a la API y guardar en MySQL
            $this->careerRepo->syncFromApi();
            
            $_SESSION['message'] = "Carreras actualizadas correctamente desde la API.";
            header("Location: " . FRONT_ROOT . "Home/menuAdmin");
            exit();
        }

        public function updateCompanies() 
        {
            Utils::checkAdminSession();
            
            $this->companyRepo->syncFromApi();
            
            $_SESSION['message'] = "Empresas sincronizadas correctamente.";
            header("Location: " . FRONT_ROOT . "Home/menuAdmin");
            exit();
        }

        public function showDashboard()
        {
            Utils::checkNav();
        
            require_once(ADMIN_VIEWS . "admin-dashboard.php");
        }

        public function addAdmin()
        {
            Utils::checkNav(); // Solo un admin puede crear otro admin

            $user = new User();
            $user->setEmail($_POST["email"]);
            // IMPORTANTE: Hashear siempre la password
            $user->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
            $user->setRole("admin");
            $user->setActive(true);

            try {
                $this->userDAO->add($user);
                $this->viewMessage = "Admin created successfully";
            } catch (\Exception $ex) {
                $this->viewMessage = "Error creating admin: " . $ex->getMessage();
            }
            
            $this->showDashboard();
        }   

        public function removeAdmin($params)
        {
            \Utils\Utils::checkNav();

            // 1. Extraemos el ID del array que manda el Router (desde el $_POST)
            // Usamos el nombre 'userId' porque es el que pusiste en el <input name="userId">
            $userId = (isset($params['userId'])) ? (int)$params['userId'] : 0;

            // 2. Ahora sí podemos usar $userId para las validaciones
            if($_SESSION["loggedUser"]->getUserId() == $userId) {
                $this->showCreateUserForm("You cannot delete your own account.");
                return;
            }

            try {
                // 3. Pasamos el ID limpio al DAO
                if($userId > 0) {
                    $this->userDAO->delete($userId);
                    $this->showCreateUserForm("Administrator removed successfully.");
                } else {
                    $this->showCreateUserForm("Invalid Admin ID.");
                }
            } catch (\Exception $ex) {
                $this->showCreateUserForm("Error removing admin.");
            }
        }

        public function restoreAdmin($params)
        {
            \Utils\Utils::checkNav();
            $userId = (isset($params['userId'])) ? (int)$params['userId'] : 0;

            try {
                $this->userDAO->activate($userId);
                $this->showCreateUserForm("Administrator restored successfully.");
            } catch (\Exception $ex) {
                $this->showCreateUserForm("Error restoring admin.");
            }
        }

    public function showCreateUserForm($message = "")
    {
        Utils::checkNav();
        $this->viewMessage = $message;
        
        $allUsers = $this->userDAO->getAll();
        
        // Filtramos los activos para la tabla principal
        $adminList = array_filter($allUsers, function($user) {
            return $user->getRole() === "admin" && $user->getActive() == true;
        });

        // Filtramos los inactivos para una sección de "Papelera" o "Historial"
        $inactiveAdmins = array_filter($allUsers, function($user) {
            return $user->getRole() === "admin" && $user->getActive() == false;
        });

        require_once(ADMIN_VIEWS . "add-admin.php");
    }
}
