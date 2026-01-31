<?php
    namespace Controllers;

    use Services\JobOfferService;
    use Models\JobOffer;
    use Utils\Utils;
    use Config\DAOFactory;
    use DAO\ICompanyDAO;

    class AdminJobOfferController
    {
        private JobOfferService $jobOfferService;
        private ICompanyDAO $companyDAO;

        public function __construct()
        {
            Utils::checkAdminSession();
            $this->jobOfferService = new JobOfferService();
            $this->companyDAO = DAOFactory::getCompanyDAO();
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
             $isAdmin = true;
             
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

        public function deleteCompany($id)
        {
            try {
                $this->companyService->deleteCompany((int)$id);
                // Redirección de éxito
                header("Location: " . FRONT_ROOT . "Company/showCompaniesViews?success=deleted");
            } catch (\Exception $ex) {
                // Redirección de error (usando & si ya hay un ?, o dejando que el Router lo maneje)
                // Lo más seguro es pasar el error por la URL así:
                header("Location: " . FRONT_ROOT . "Company/showCompaniesViews&error=" . $ex->getMessage());
            }
            exit();
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

        public function showOffersByCompany(int $companyId)
        {
            Utils::checkSession();

            $company = $this->companyDAO->getById($companyId);
            
            if (!$company) {
                $message = "Empresa no encontrada";
                require_once(VIEWS_PATH . "error_404.php");
                return;
            }

            $jobOfferList = $this->jobOfferService->getByCompany($companyId);

            require_once(VIEWS_PATH . "job-offers-by-company.php");
        }
    }
