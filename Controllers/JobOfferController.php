<?php

namespace Controllers;

use Repositories\CareerRepository;
use Repositories\JobOfferRepository;
use Utils\Utils;

class JobOfferController
{
    private JobOfferRepository $jobOfferRepo;
    private CareerRepository $careerRepo;

    public function __construct()
    {
        $this->jobOfferRepo = new JobOfferRepository();
        $this->careerRepo = new CareerRepository();
    }

    /**
     * Esta es la vista que comparten los roles
     */
    public function showOffersByCareer(int $careerId)
    {
        Utils::checkSession();

        $career = $this->careerRepo->getById($careerId);
        
        if (!$career) {
            $message = "Carrera no encontrada";
            require_once(VIEWS_PATH . "error_404.php");
            return;
        }

        $jobOfferList = $this->jobOfferRepo->getByCareer($careerId);

        require_once(STUDENT_VIEWS . "student-job-offers-by-career.php");
    }
}