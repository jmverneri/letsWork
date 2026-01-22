<?php
    namespace Controllers;

    use Services\JobOfferService;
    use Models\JobOffer;
    use Utils\Utils;
    use Config\DAOFactory;

    class AdminJobOfferController
    {
        private JobOfferService $jobOfferService;

        public function __construct()
        {
            Utils::checkAdminSession();
            $this->jobOfferService = new JobOfferService();
        }

        public function listJobOffers()
        {
            $jobOfferList = $this->jobOfferService->getAll();

            $careerDAO = DAOFactory::getCareerDAO();
            $companyDAO = DAOFactory::getCompanyDAO();

            $careerList = $careerDAO->getAll();
            $companiesList = $companyDAO->getAll();

            // Defensa
            $careerList = $careerList ?? [];
            $companiesList = $companiesList ?? [];

            require_once(ADMIN_VIEWS . "joboffer-list.php");
        }

        public function addView()
        {
            require_once(ADMIN_VIEWS . "joboffer-add.php");
        }

        public function add(
            $title,
            $description,
            $salary,
            $startDate,
            $deadline,
            $companyId,
            $careerId,
            $jobPositionId
        ) {
            $jobOffer = new JobOffer();
            $jobOffer->setTitle($title)
                    ->setDescription($description)
                    ->setSalary($salary)
                    ->setStartDate($startDate)
                    ->setDeadline($deadline)
                    ->setCompanyId($companyId)
                    ->setCareerId($careerId)
                    ->setJobPositionId($jobPositionId)
                    ->setStatus("published");

            $this->jobOfferService->add($jobOffer);

            $this->list();
        }

        public function delete($id)
        {
            $this->jobOfferService->delete($id);
            $this->list();
        }

        public function listExpired()
        {
            $jobOfferList = $this->jobOfferService->getExpired();

            $careerDAO = DAOFactory::getCareerDAO();
            $companyDAO = DAOFactory::getCompanyDAO();

            $careerList = $careerDAO->getAll() ?? [];
            $companiesList = $companyDAO->getAll() ?? [];

            require_once(ADMIN_VIEWS . "expired-job-offers.php");
        }
    }
