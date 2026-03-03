<?php
namespace Controllers;

use Repositories\JobOfferRepository as JobOfferRepository;
use Repositories\CompanyRepository as CompanyRepository;
use DAO\JobPositionDAOMySQL as JobPositionDAO;
use DAO\ApplicationDAO as ApplicationDAO;
use Models\JobOffer as JobOffer;
use \Exception as Exception;

class AdminJobOfferController
{
    /** @var \DAO\JobOfferDAOMySQL */
    private $jobOfferRepo;
    private $companyRepo;
    private $jobPositionDAO;
    private $applicationDAO;

    public function __construct()
    {
        $this->jobOfferRepo = new JobOfferRepository();
        $this->companyRepo = new CompanyRepository();
        $this->jobPositionDAO = new JobPositionDAO();
        $this->applicationDAO = new ApplicationDAO();
    }

    public function showAddView($companyId = null, $message = "")
    {
        try {
            // 1. Siempre traemos los puestos
            $jobPositions = $this->jobPositionDAO->getAll(); 

            // 2. Si hay ID, buscamos el objeto de ESA empresa
            $company = null;
            $companiesList = null;

            if ($companyId) {
                $company = $this->companyRepo->getById($companyId);
            } else {
                // Si no hay ID, traemos TODAS para el desplegable
                $companiesList = $this->companyRepo->getAll();
            }

            // Pasamos TODO a la vista
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
                header("location: " . FRONT_ROOT . "AdminJobOffer/showActiveJobOffers");
                
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
            
            $companiesList = $this->companyRepo->getAll(); 
            
            $careerList = $this->jobPositionDAO->getAll(); 

            require_once(ADMIN_VIEWS . "job-offer-list.php");
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function showModifyJobOfferView($jobOfferId)
    {
        try {
            // 1. Buscamos la oferta específica que queremos editar
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);

            if($jobOffer) {
                // 2. Necesitamos estas listas para llenar los <select> del formulario
                $companiesList = $this->companyRepo->getAll();
                $jobPositionList = $this->jobPositionDAO->getAll();

                // 3. Cargamos la vista de modificación
                require_once(ADMIN_VIEWS . "modify-jobOffer-view.php");
            } else {
                // Si por alguna razón no existe el ID, volvemos al listado con un error
                echo "Job Offer not found.";
            }
        } catch (Exception $ex) {
            echo "Error: " . $ex->getMessage();
        }
    }

    public function modifyJobOffer($params) // Recibimos el array que manda el Router
    {
        try {
            // Extraemos los datos del array usando los nombres del 'name' del formulario
            $jobOfferId = $params["jobOfferId"];
            $title = $params["title"];
            $startDate = $params["startDate"];
            $deadline = $params["deadline"];
            $description = $params["description"];
            $salary = $params["salary"];
            $active = $params["active"];
            $jobPositionId = $params["jobPositionId"];
            $companyId = $params["companyId"];

            // Creamos el objeto
            $jobOffer = new JobOffer();
            $jobOffer->setJobOfferId($jobOfferId);
            $jobOffer->setTitle($title);
            $jobOffer->setStartDate($startDate);
            $jobOffer->setDeadline($deadline);
            $jobOffer->setDescription($description);
            $jobOffer->setSalary($salary);
            $jobOffer->setActive($active);
            $jobOffer->setJobPositionId($jobPositionId);
            $jobOffer->setCompanyId($companyId);

            // Llamamos al repositorio para actualizar
            $this->jobOfferRepo->update($jobOffer);

            // Redirigimos al listado de la empresa
            header("Location: " . FRONT_ROOT . "AdminJobOffer/showListView/" . $companyId);

        } catch (Exception $ex) {
            echo "Error al modificar: " . $ex->getMessage();
        }
    }

    public function deleteJobOffer($jobOfferId, $companyId)
    {
        try {
            $this->jobOfferRepo->delete($jobOfferId);
            
            // Redirigimos al listado de la empresa para ver los cambios
            header("Location: " . FRONT_ROOT . "AdminJobOffer/showListView/" . $companyId);
        } catch (Exception $ex) {
            echo "Error al eliminar: " . $ex->getMessage();
        }
    }

    public function restoreJobOffer($jobOfferId, $companyId)
    {
        try {
            // Usamos el método que ya creamos antes, pero enviando 'true' para activar
            $this->jobOfferRepo->updateActiveStatus($jobOfferId, true);
            
            header("Location: " . FRONT_ROOT . "AdminJobOffer/showListView/" . $companyId);
        } catch (Exception $ex) {
            echo "Error al restaurar: " . $ex->getMessage();
        }
    }

    public function showActiveJobOffers() {
        
       $jobOfferList = $this->jobOfferRepo->getOpenOffers();

        $companiesList = $this->companyRepo->getAll();

        require_once(ADMIN_VIEWS."admin-active-offers-list.php");
    }

    public function showExpiredJobOffers() {
        
        $allOffers = $this->jobOfferRepo->getAll();
        $today = date("Y-m-d");

        // Filtramos: las que ya pasaron de fecha O las que el admin desactivó manualmente
        $jobOfferList = array_filter($allOffers, function($offer) use ($today) {
            return ($offer->getDeadline() < $today || $offer->getActive() == false);
        });

        $companiesList = $this->companyRepo->getAll();

        require_once(ADMIN_VIEWS."admin-expired-offers-list.php");
    }

    public function showApplicants($jobOfferId)
    {
        try {
            // 1. Opcional: Traer los datos de la oferta para mostrar el título en la vista
            $jobOffer = $this->jobOfferRepo->getById($jobOfferId);
            
            // 2. Traer la lista de alumnos postulados usando el DAO de aplicaciones
            // Nota: Asegurate de tener $this->applicationDAO inicializado en el constructor
            $applicantList = $this->applicationDAO->getApplicantsByOffer($jobOfferId);

            // 3. Cargar la vista
            require_once(ADMIN_VIEWS . "admin-job-offer-applicants.php");
            
        } catch (Exception $ex) {
            echo "Error al obtener postulantes: " . $ex->getMessage();
        }
    }

    public function declineApplicant($studentId, $jobOfferId)
    {
        // En lugar de borrar, marcamos como 'declined' o 'rejected'
        $this->applicationDAO->UpdateStatus($studentId, $jobOfferId, 'declined');
        $this->showApplicants($jobOfferId);
    }
}