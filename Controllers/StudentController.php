<?php

    namespace Controllers;

    use DAO\IStudentDAO;
    use DAO\ICompanyDAO;
    use DAO\ICareerDAO;
    use Config\DAOFactory;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;

    class StudentController
    {
        private IStudentDAO $studentDAO;
        private ICompanyDAO $companyDAO;
        private ICareerDAO $careerDAO;

        private array $studentList = [];
        private array $careerList = [];

        public function __construct()
        {
            
            $this->studentDAO = DAOFactory::getStudentDAO();
            //$this->companyDAO = DAOFactory::getCompanyDAO();
            $this->careerDAO  = DAOFactory::getCareerDAO();
        }

        public function showStudentRegistration()
        {
            require_once(VIEWS_PATH . "registration.php");
        }

        public function showStudentProfileByMail($email)
        {
            $this->getStudentByMail($email);
        }

        public function showListView()
        {
            Utils::checkSession();

            $students = $this->studentDAO->getAll();
            $careers  = $this->careerDAO->getAll();

            /**
             * Armamos un mapa careerId => description
             * para evitar loops innecesarios
             */
            $careerMap = [];
            foreach ($careers as $career) {
                $careerMap[$career->getCareerId()] = $career->getDescription();
            }

            /**
             * ViewModel / DTO
             */
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

       public function showStudentProfile()
        {
            Utils::checkStudentSession();

            $user = $_SESSION['loggedUser'];

            $student = $this->studentDAO->getByUserId($user->getUserId());

            if (!$student) {
                header("Location: " . FRONT_ROOT . "Home/index");
                exit();
            }

            $career = null;
            if ($student->getCareerId()) {
                $career = $this->careerDAO->getById($student->getCareerId());
            }

            require_once(STUDENT_VIEWS . "student-profile.php");
}


        public function studentValidation($email)
        {
            $student = $this->studentDAO->getStudentByMail($email);

            if ($student !== null) {
                require_once(VIEWS_PATH . "student-registration.php");
            } else {
                $message = "This mail doesn't exist";
                require_once(VIEWS_PATH . "login.php");
            }
        }

        public function studentRegistration($email, $password, $confirmPass)
        {
            if ($password === $confirmPass) {

                $student = $this->studentDAO->getStudentByMail($email);
                $student->setPassword($password);

                $this->studentDAO->add($student);

                require_once(VIEWS_PATH . "student-profile.php");
            }
        }

        public function showAddView()
        {
            require_once(VIEWS_PATH . "student-add.php");
        }
    }
