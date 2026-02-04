<?php
namespace Controllers;

use Repositories\JobOfferRepository as JobOfferRepository;
use Repositories\CompanyRepository as CompanyRepository;
use DAO\JobPositionDAOMySQL as JobPositionDAO;
use Models\JobOffer as JobOffer;
use \Exception as Exception;

class AdminJobOfferController
{
    private $jobOfferRepo;
    private $companyRepo;
    private $jobPositionDAO;

    public function __construct()
    {
        $this->jobOfferRepo = new JobOfferRepository();
        $this->companyRepo = new CompanyRepository();
        $this->jobPositionDAO = new JobPositionDAO();
    }

    public function showAddView($companyId, $message = "")
    {
        try {
            $company = $this->companyRepo->getById($companyId);
            $jobPositions = $this->jobPositionDAO->getAll();
            
            require_once(ADMIN_VIEWS . "job-offer-add.php");
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function add()
    {
        if($_POST) {
            try {
                $jobOffer = new JobOffer();
                
                // Extraemos los datos del POST manualmente
                $jobOffer->setTitle($_POST["title"]);
                $jobOffer->setDescription($_POST["description"]);
                $jobOffer->setSalary($_POST["salary"]);
                $jobOffer->setStartDate($_POST["startDate"]);
                $jobOffer->setDeadline($_POST["deadline"]);
                $jobOffer->setCompanyId($_POST["companyId"]);
                $jobOffer->setJobPositionId($_POST["jobPositionId"]);
                $jobOffer->setActive(true);

                $this->jobOfferRepo->add($jobOffer);

                // Si todo sale bien, volvemos a la lista
                header("location: " . FRONT_ROOT . "AdminCompany/showCompaniesViews");
                
            } catch (Exception $ex) {
                // Si hay error, volvemos a la vista de alta con el ID de la empresa
                $this->showAddView($_POST["companyId"], "Error: " . $ex->getMessage());
            }
        }
    }

   public function showListView($companyId)
    {
        try {
            $company = $this->companyRepo->getById($companyId);
            $jobOfferList = $this->jobOfferRepo->getByCompanyId($companyId);
            
            // ESTA ES LA LÍNEA QUE TE FALTA:
            $companiesList = $this->companyRepo->getAll(); 
            
            // También asegurate de tener esta para las posiciones:
            $careerList = $this->jobPositionDAO->getAll(); 

            require_once(ADMIN_VIEWS . "job-offer-list.php");
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }
}