<?php
namespace Controllers;

use Utils\Utils;
use Repositories\CompanyRepository;
use Repositories\StudentRepository;
use Repositories\JobOfferRepository;
use Models\Company;

class StudentCompanyController
{
    private $companyRepo;
    private $studentRepo;
    private $jobOfferRepo;
    public $message;
    public $company;

    public function __construct()
    {
        Utils::checkSession();
        $this->companyRepo = new CompanyRepository();
        $this->studentRepo = new StudentRepository();
        $this->jobOfferRepo = new JobOfferRepository();
    }

    /**
     * Lista todas las empresas con una vista amigable para el estudiante
     */
    public function showCompaniesViews($data = "")
    {
        // Si $data es un array, es que viene del formulario POST
        $search = "";
        if (is_array($data) && isset($data['search'])) {
            $search = $data['search'];
        } elseif (isset($_GET['search'])) {
            $search = $_GET['search'];
        }

        $this->message = is_string($data) ? $data : "";

        $companyList = $this->companyRepo->getAll();
        $companiesWithEmail = [];
        foreach ($companyList as $company) {
        // Si hay un término de búsqueda...
        if (!empty($search)) {
            $companyName = strtolower($company->getName());
            $searchTerm = strtolower($search);

            // strpos devuelve la posición del término. 
            // Si NO es 0 (cero), significa que o no está, o está en el medio.
            // Usamos !== 0 para descartar todo lo que no empiece exacto.
            if (strpos($companyName, $searchTerm) !== 0) {
                continue;
            }
        }

        $user = $this->companyRepo->getUserById($company->getUserId());

        $companiesWithEmail[] = [
            'company' => $company,
            'email'   => ($user) ? $user->getEmail() : 'No email'
        ];
        }

        require_once(STUDENT_VIEWS . "student-company-list.php");
    }
    
    /**
     * Muestra el detalle completo de una sola empresa
     */
    public function showDetail($companyId)
    {
        $company = $this->companyRepo->getById($companyId);

        if (!$company) {
            // Podrías redirigir a una página 404 o mostrar un mensaje
            $this->showCompaniesViews();
            return;
        }

        require_once(VIEWS_PATH . "student-company-detail.php");
    }

    public function showCompanyDetails($companyId)
    {
        // 1. Verificamos sesión
        Utils::checkNav();
        
        // 2. Buscamos la empresa específica por ID
        // Supongo que tienes un método en tu repositorio que hace esto:
        $company = $this->companyRepo->getById($companyId);
        
        if($company) {
            // 3. Cargamos la vista de detalles
            require_once(STUDENT_VIEWS . "company-details.php");
        } else {
            // Manejo de error si no existe
            echo "Compañía no encontrada.";
        }
    }
}