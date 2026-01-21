<?php
    namespace Controllers;

    use DAO\IStudentDAO;
    use DAO\ICompanyDAO;
    use DAO\ICareerDAO;
    use Config\DAOFactory;
    use Models\Student;
    use Models\Career;
    use Utils\Utils;

    class AdminController
    {
        private IStudentDAO $studentDAO;
        private ICompanyDAO $companyDAO;
        private ICareerDAO $careerDAO;

        public function __construct()
        {
            $this->studentDAO = DAOFactory::getStudentDAO();
            //$this->companyDAO = DAOFactory::getCompanyDAO();
            //$this->careerDAO  = DAOFactory::getCareerDAO();
        }

        public function showStudentList()
        {
            Utils::checkAdminSession();

            $students = $this->studentDAO->GetAll();
            //$careers = $this->careerDAO->GetAll();
            require_once(VIEWS_PATH . "student-list.php");
        }
    }
