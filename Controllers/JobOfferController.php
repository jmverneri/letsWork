<?php
//JobOffer general para las vistas compartidas. Evita duplicar codigo

namespace Controllers;

use Services\JobOfferService;
use Config\DAOFactory;
use Utils\Utils;

class JobOfferController
{
    private JobOfferService $jobOfferService;
    private $careerDAO;
    public function __construct()
    {
        $this->jobOfferService = new JobOfferService();
        $this->careerDAO = DAOFactory::getCareerDAO();
    }

    /**
     * Esta es la vista que comparten los roles
     */
    public function showOffersByCareer(int $careerId)
    {
        Utils::checkSession();

        $career = $this->careerDAO->getById($careerId);
        
        if (!$career) {
            $message = "Carrera no encontrada";
            require_once(VIEWS_PATH . "error_404.php");
            return;
        }

        $jobOfferList = $this->jobOfferService->getByCareer($careerId);

        require_once(STUDENT_VIEWS . "student-job-offers-by-career.php");
    }
}