<?php
namespace Controllers;

use Services\JobOfferService;
use DAO\ICompanyDAO;
use DAO\ICareerDAO;
use Config\DAOFactory;
use Models\JobOffer;
use Utils\Utils;
use Exception;

class CompanyJobOfferController
{
    private JobOfferService $jobOfferService;
    private ICompanyDAO $companyDAO;
    private ICareerDAO $careerDAO;

    public function __construct()
    {
        Utils::checkCompanySession();
        $this->jobOfferService = new JobOfferService();
        $this->companyDAO = DAOFactory::getCompanyDAO();
        $this->careerDAO = DAOFactory::getCareerDAO();
    }

    /**
     * Listar las ofertas de la empresa logueada
     */
    public function listMyOffers()
    {
        try {
            $user = $_SESSION['loggedUser'];
            $company = $this->companyDAO->getByUserId($user->getUserId());
            
            $jobOffers = $this->jobOfferService->getByCompany($company->getCompanyId());
            
            // Necesitamos los nombres de las carreras para la tabla
            $careers = $this->careerDAO->getAll();

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
        $careers = $this->careerDAO->getAll();
        $isAdmin = false;
        $companies = [];
        
        require_once(VIEWS_PATH . "joboffer-add.php");
    }

    /**
     * Procesar el alta de una oferta
     */
    public function add($careerId, $position, $deadline, $description)
    {
        try {
            $user = $_SESSION['loggedUser'];
            $company = $this->companyDAO->getByUserId($user->getUserId());

            $jobOffer = new JobOffer();
            $jobOffer->setCompanyId($company->getCompanyId())
                     ->setCareerId($careerId)
                     ->setPosition($position)
                     ->setDeadline($deadline)
                     ->setDescription($description)
                     ->setActive(true);

            // El Service se encarga de las validaciones de negocio
            $this->jobOfferService->add($jobOffer);
            
            header("Location: " . FRONT_ROOT . "CompanyJobOffer/listMyOffers");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $careers = $this->careerDAO->getAll();
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
            $jobOffer = $this->jobOfferService->getById($jobOfferId);
            
            // Usamos el Service para obtener la data procesada
            // (Asegúrate de que tu DAO devuelva info útil del estudiante)
            $applicants = $this->jobOfferService->getApplicantsByOffer($jobOfferId);

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