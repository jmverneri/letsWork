<?php
namespace Controllers;

use Services\JobOfferService;
use Repositories\CompanyRepository;   
use Repositories\CareerRepository;
use Repositories\JobOfferRepository;
use Repositories\JobPositionRepository;  
use Models\JobOffer;
use Utils\Utils;
use Exception;

class CompanyJobOfferController
{
    private CompanyRepository $companyRepo;
    private CareerRepository $careerRepo;
    private JobOfferRepository $jobOfferRepository;
    private JobPositionRepository $jobPositionRepo;  

    public function __construct()
    {
        Utils::checkCompanySession();
        $this->jobOfferRepository = new JobOfferRepository();
        $this->jobPositionRepo = new JobPositionRepository();
        $this->companyRepo = new CompanyRepository();
        $this->careerRepo = new CareerRepository();
    }

    /**
     * Listar las ofertas de la empresa logueada
     */
    public function listMyOffers()
    {
        try {
            $user = $_SESSION['loggedUser'];
            $company = $this->companyRepo->getByUserId($user->getUserId());
            
            $jobOffers = $this->jobOfferRepository->getByCompanyId($company->getCompanyId());
            
            // Necesitamos los nombres de las carreras para la tabla
            $careers = $this->careerRepo->getAll();

            require_once(COMPANY_VIEWS . "company-joboffer-list.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            require_once(COMPANY_VIEWS . "company-menu.php");
        }
    }

    /**
     * Mostrar formulario de agregar
     */
    public function showAddView()
    {
        $careers = $this->careerRepo->getAll();

        $jobPositions = $this->jobPositionRepo->getAll();
        
        require_once(COMPANY_VIEWS . "company-joboffer-add.php");
    }

    /**
     * Procesar el alta de una oferta
     */
  public function add($title, $description, $salary, $startDate, $deadline, $jobPositionId)
    {
        try {
            $user = $_SESSION['loggedUser'];
            $company = $this->companyRepo->getByUserId($user->getUserId());

            $jobOffer = new JobOffer();
            $jobOffer->setCompanyId($company->getCompanyId())
                    ->setTitle($title)
                    ->setDescription($description)
                    ->setSalary($salary)
                    ->setStartDate($startDate)
                    ->setDeadline($deadline)
                    ->setJobPositionId($jobPositionId)
                    ->setActive(true);

            // Usamos el servicio para guardar
            $this->jobOfferRepository->add($jobOffer);
            
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            // Recargamos los datos necesarios para que el formulario no falle al volver a mostrarse
            $careers = $this->careerRepo->getAll(); 
            // Si necesitas puestos, agrégalos aquí también:
            // $jobPositions = $this->jobPositionRepo->getAll(); 
            
            require_once(COMPANY_VIEWS . "joboffer-add.php");
        }
    }

    /**
     * Ver postulantes de una oferta específica
     */
    public function viewApplicants($jobOfferId)
    {
        try {
            // Podrías validar aquí que la oferta pertenezca a la empresa logueada
            $jobOffer = $this->jobOfferRepository->getById($jobOfferId);
            
            // Usamos el Service para obtener la data procesada
            // (Asegúrate de que tu DAO devuelva info útil del estudiante)
            $applicants = $this->jobOfferRepository->getApplicantsByOffer($jobOfferId);

            require_once(COMPANY_VIEWS . "joboffer-applicants.php");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }

    /**
     * Baja lógica de una oferta
     */
    public function delete($jobOfferId)
    {
        try {
            $this->jobOfferService->delete($jobOfferId);
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $this->listMyOffers();
        }
    }
}