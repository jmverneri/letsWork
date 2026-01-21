<?php
    namespace Controllers;

    use Services\JobOfferService;
    use Utils\Utils;

    class CompanyJobOfferController
    {
        private JobOfferService $jobOfferService;

        public function __construct()
        {
            Utils::checkCompanyOnly();
            $this->jobOfferService = new JobOfferService();
        }

        public function listMyOffers()
        {
            $companyId = $_SESSION['userCompany']->getCompanyId();
            $jobOffers = $this->jobOfferService->getByCompany($companyId);

            require_once(USERCOMPANY_VIEWS . "joboffer-list.php");
        }
    }
