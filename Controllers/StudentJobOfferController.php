<?php
    namespace Controllers;

    use Services\JobOfferService;
    use Utils\Utils;

    use DAO\ICompanyDAO;
    use DAO\ICareerDAO;

    use Config\DAOFactory;

    class StudentJobOfferController
    {
        private JobOfferService $jobOfferService;
        private ICompanyDAO $companyDAO;
        private ICareerDAO $careerDAO;

        public function __construct()
        {
            Utils::checkStudentSession();
            $this->jobOfferService = new JobOfferService();
            $this->companyDAO = DAOFactory::getCompanyDAO();
            $this->careerDAO  = DAOFactory::getCareerDAO();
        }

        public function listJobOffers()
        {
            $jobOffers = $this->jobOfferService->getActive();

            $careerMap = [];
            foreach ($this->careerDAO->getAll() as $career) {
                $careerMap[$career->getCareerId()] = $career->getDescription();
            }

            $companyMap = [];
            foreach ($this->companyDAO->getAll() as $company) {
                $companyMap[$company->getCompanyId()] = $company->getName();
            }

            foreach ($jobOffers as $jobOffer) {
                $jobOffer->setCareerName(
                    $careerMap[$jobOffer->getCareerId()] ?? 'N/A'
                );

                $jobOffer->setCompanyName(
                    $companyMap[$jobOffer->getCompanyId()] ?? 'N/A'
                );

            }
            require_once(STUDENT_VIEWS . "student-job-offers-list.php");
        }

        public function view($id)
        {
            $jobOffer = $this->jobOfferService->getById($id);
            require_once(STUDENT_VIEWS . "joboffer-view.php");
        }

        public function addStudentToAJobOffer($jobOfferId)
        {
            Utils::checkStudentSession();

            $studentId = $_SESSION['loggedUser']->getUserId();
            var_dump($_SESSION['loggedUser']);
die;


            $this->jobOfferService->addStudentToJobOffer($jobOfferId, $studentId);

            header("Location: " . FRONT_ROOT . "StudentJobOffer/listJobOffers");
            exit();
        }
    }
