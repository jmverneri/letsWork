<?php
    namespace Controllers;

    use Repositories\StudentRepository;
    use Repositories\CompanyRepository;
    use Repositories\CareerRepository;
    use DAO\UserDAOMySQL;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;

    class AdminController
    {
        private StudentRepository $studentRepo;
        private CompanyRepository $companyRepo;
        private CareerRepository $careerRepo;
        private UserDAOMySQL $userDAO;

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
    }
