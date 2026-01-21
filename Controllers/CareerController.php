<?php
    namespace Controllers;

    use DAO\ICareerDAO;
    use Config\DAOFactory;
    use Models\Career;
    use Utils\Utils;

    class CareerController
    {
        private ICareerDAO $careerDAO;
        private array $careerList = [];
        private ?Career $career = null;

        public function __construct()
        {
            $this->careerDAO = DAOFactory::getCareerDAO();
        }

        public function showSingleCareer(int $careerId)
        {
            Utils::checkSession();

            $this->career = $this->careerDAO->getById($careerId);

            if ($this->career === null) {
                $message = "Career not found";
                require_once(VIEWS_PATH . "error.php");
                return;
            }

            require_once(VIEWS_PATH . "career-detail.php");
        }

        public function showCareerListView()
        {
            Utils::checkSession();

            $this->careerList = $this->careerDAO->getAll();

            require_once(VIEWS_PATH . "career-list.php");
        }
    }
