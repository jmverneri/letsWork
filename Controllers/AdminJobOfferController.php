<?php
    namespace Controllers;

    use Services\JobOfferService;
    use Models\JobOffer;
    use Utils\Utils;

    class AdminJobOfferController
    {
        private JobOfferService $jobOfferService;

        public function __construct()
        {
            Utils::checkAdminSession();
            $this->jobOfferService = new JobOfferService();
        }

        public function list()
        {
            $jobOffers = $this->jobOfferService->getAll();
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
    }
