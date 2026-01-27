<?php
namespace Controllers;

use Services\CompanyService;
use Utils\Utils;

class StudentCompanyController
{
    private CompanyService $companyService;

    public function __construct()
    {
        // Solo verificamos que haya una sesión activa (Alumno o cualquier rol logueado)
        Utils::checkSession();
        $this->companyService = new CompanyService();
    }

    /**
     * Lista todas las empresas con una vista amigable para el estudiante
     */
    public function showListView()
    {
        // Obtenemos el término de búsqueda si existe
        $search = $_GET['search'] ?? "";

        // Usamos el mismo método que el Admin, pero los datos irán a otra vista
        $companiesList = $this->companyService->getList($search);
        
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