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

        private Student $student;
        private Career $career;

        public function __construct()
        {
            
            $this->studentDAO = DAOFactory::getStudentDAO();
            //$this->companyDAO = DAOFactory::getCompanyDAO();
            //$this->careerDAO  = DAOFactory::getCareerDAO();

            $this->student = new Student();
            $this->career  = new Career();
        }

        public function showStudentRegistration()
        {
            require_once(VIEWS_PATH . "registration.php");
        }

        public function showStudentProfile($email)
        {
            $this->getStudentByMail($email);
        }

        public function showListView()
        {
            Utils::checkSession();

            $this->studentList = $this->studentDAO->getAll();
            //$this->careerList  = $this->careerDAO->getAll();

            require_once(VIEWS_PATH . "student-list.php");
        }

        public function getStudentByMail($email)
        {
            if ($email !== null) {

                $this->student = $this->studentDAO->getLoginStudent($email);
                $this->career  = $this->careerDAO->getCareerStudent($this->student);

                $_SESSION['student'] = $this->student;

                require_once(STUDENT_VIEWS . "student-profile.php");
            } else {
                $message = "This mail doesn't exist";
                require_once(VIEWS_PATH . "registration.php");
            }
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
