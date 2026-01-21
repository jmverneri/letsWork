<?php
    namespace Controllers;

    use Services\JobOfferService;
    use Utils\Utils;

    class StudentJobOfferController
    {
        private JobOfferService $jobOfferService;

        public function __construct()
        {
            Utils::checkStudentSession();
            $this->jobOfferService = new JobOfferService();
        }

        public function list()
        {
            $jobOffers = $this->jobOfferService->getActive();
            require_once(STUDENT_VIEWS . "joboffer-list.php");
        }

        public function view($id)
        {
            $jobOffer = $this->jobOfferService->getById($id);
            require_once(STUDENT_VIEWS . "joboffer-view.php");
        }
    }
