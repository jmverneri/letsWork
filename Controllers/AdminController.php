<?php
    namespace Controllers;

    use DAO\IStudentDAO;
    use DAO\ICompanyDAO;
    use DAO\ICareerDAO;
    use DAO\IUserDAO;
    use Config\DAOFactory;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;

    class AdminController
    {
        private IStudentDAO $studentDAO;
        private ICompanyDAO $companyDAO;
        private ICareerDAO $careerDAO;
        private IUserDAO $userDAO;

        public function __construct()
        {
            $this->studentDAO = DAOFactory::getStudentDAO();
            $this->companyDAO = DAOFactory::getCompanyDAO();
            $this->careerDAO  = DAOFactory::getCareerDAO();
            $this->userDAO = DAOFactory::getUserDAO();
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

    }
