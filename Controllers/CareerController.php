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
        private Career $career;

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

        public function showCareersView()
        {
            Utils::checkSession();

            $search = $_GET['search'] ?? "";

            if ($search === "") {
                $this->careerList = $this->careerDAO->getAll();
            } else {
                $search = strtolower($search);
                $filteredCarriers = [];

                foreach ($this->careerDAO->getAll() as $career) {
                    if (str_starts_with(strtolower($career->getDescription()), $search)) {
                        $filteredCarriers[] = $career;
                    }
                }

                $this->careerList = $filteredCarriers;
            }

            require_once(VIEWS_PATH . "career-list.php");
        }
    }
