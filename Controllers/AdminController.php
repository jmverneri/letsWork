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
            Utils::checkSession();

            $students = $this->studentDAO->getAll();
            $careers  = $this->careerDAO->getAll();

            $careerMap = [];
            foreach ($careers as $career) {
                $careerMap[$career->getCareerId()] = $career->getDescription();
            }

            $studentsView = [];

            foreach ($students as $student) {
                $user = $this->userDAO->getById($student->getUserId());

                $studentsView[] = [
                    'fileNumber' => $student->getFileNumber(),
                    'firstName'  => $student->getFirstName(),
                    'lastName'   => $student->getLastName(),
                    'gender'     => $student->getGender(),
                    'email'      => $user ? $user->getEmail() : null,
                    'career'     => $careerMap[$student->getCareerId()] ?? null,
                ];
            }

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
    }
