<?php
namespace Controllers;

use Services\CompanyService;
use Utils\Utils;

use DAO\ICompanyDAO;
use DAO\IJobOfferDAO;
use DAO\ICareerDAO;
use Config\DAOFactory;

class StudentCompanyController
{
    private CompanyService $companyService;
    private ICompanyDAO $companyDAO;
    private IJobOfferDAO $jobOfferDAO;
    private ICareerDAO $careerDAO;

    public function __construct()
    {
        // Solo verificamos que haya una sesión activa (Alumno o cualquier rol logueado)
        Utils::checkSession();
        $this->companyService = new CompanyService();
        $this->companyDAO  = DAOFactory::getCompanyDAO();
        $this->jobOfferDAO = DAOFactory::getJobOfferDAO();
        $this->careerDAO = DAOFactory::getCareerDAO();
    }

    /**
     * Lista todas las empresas con una vista amigable para el estudiante
     */
    public function showListView()
    {
        Utils::checkSession();
        $search = $_GET['search'] ?? "";

        $companyList = $this->companyDAO->getAll();
        $userDAO = DAOFactory::getUserDAO();

        $companiesWithUser = [];

        foreach ($companyList as $company) {

            // Filtro por nombre si hay search
            if ($search !== "" && !str_starts_with(
                    strtolower($company->getName()),
                    strtolower($search)
                )) {
                continue;
            }

            // Obtener el usuario dueño de la company
            $user = $userDAO->getById($company->getUserId());

            $companiesWithUser[] = [
                'company' => $company,
                'email'   => $user ? $user->getEmail() : '—'
            ];
        }
        
        // Esta vista NO tiene botones de borrar ni editar
        require_once(STUDENT_VIEWS . "student-company-list.php");
    }

    /**
     * Muestra el detalle completo de una sola empresa
     */
    public function showDetail($companyId)
    {
        $company = $this->companyService->getById($companyId);

        if (!$company) {
            // Podrías redirigir a una página 404 o mostrar un mensaje
            $this->showListView();
            return;
        }

        require_once(VIEWS_PATH . "student-company-detail.php");
    }

    // Controllers/StudentJobOfferController.php
    public function addStudentToAJobOffer($jobOfferId) 
    {
        Utils::checkSession();
        $studentId = $_SESSION["loggedUser"];

        $student = $this->studentService->getByUserId($user->getUserId());

        if (!$student) {
            throw new Exception("Student profile not found.");
        }

        $studentId = $student->getStudentId();

        try {
            // Ahora el método ya existe en el Service
            $this->jobOfferService->addStudentToJobOffer($jobOfferId, $studentId);
            $message = "Application successful!";
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
        
        // Redirigir o mostrar vista
        $this->showListView($message);
    }
}