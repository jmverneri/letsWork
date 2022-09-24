<?php
    namespace Controllers;

    use DAO\CareerDAO as CareerDAO;
    use Models\Career as Career;
    use Utils\Utils as Utils;

    class CareerController{
        private $careerDAO;
        private $careerList;

        public function __construct()
        {
            $this->careerDAO = new CareerDAO();
            $this->careerList = array();
        }

        public function ShowSingleCareer($careerId)
        {
            Utils::checkSession();
            $this->career = $this->careerDAO->GetCareerById($careerId);
        
            require_once(VIEWS_PATH . "student-company-view.php");  ///Modificar
        
        }

        public function showCareerListView()
        {
            Utils::checkSession();
            $this->careerList = $this->careerDAO->GetAll();
            
            require_once(VIEWS_PATH . "career-list.php");
        }

    }
?>