<?php
namespace Controllers;

use Services\CompanyService;
use Models\Company;
use Utils\Utils;
use Exception;

class AdminCompanyController
{
    private CompanyService $companyService;

    public function __construct()
    {
        // En un controlador de Admin, validamos la sesión en el constructor
        // para proteger TODOS sus métodos de un solo golpe.
        Utils::checkAdminSession();
        $this->companyService = new CompanyService();
    }

    /**
     * Muestra el panel principal de gestión de empresas
     */
    public function showManagerView()
    {
        $search = $_GET['search'] ?? "";
        $companiesList = $this->companyService->getList($search);
        
        require_once(ADMIN_VIEWS . "company-manager.php");
    }

    /**
     * Muestra el formulario para agregar una nueva empresa
     */
    public function showAddView($message = "")
    {
        require_once(ADMIN_VIEWS . "company-add.php");
    }

    /**
     * Muestra el formulario de edición con los datos cargados
     */
    public function showModifyView($companyId)
    {   
        $company = $this->companyService->getById($companyId);

        if (!$company) {
            $this->showManagerView("Company not found.");
            return;
        }

        require_once(ADMIN_VIEWS . "company-modify.php");
    }

    /**
     * Procesa el alta de una empresa
     */
    public function add($name, $yearFoundation, $city, $description, $email, $phoneNumber, $pre, $dni, $ultimo)
    {
        try {
            $company = new Company();
            $company->setName($name);
            $company->setYearFoundation($yearFoundation);
            $company->setCity($city);
            $company->setDescription($description);      
            $company->setEmail($email);
            $company->setPhoneNumber($phoneNumber);
            $company->buildCuit($pre, $dni, $ultimo);

            // El Service lanza una excepción si el CUIT está duplicado
            $this->companyService->addCompany($company);
            
            $message = "The company has been saved correctly. Flawless Victory.";
            $this->showManagerView($message);

        } catch (Exception $e) {
            $message = $e->getMessage();
            $this->showAddView($message);
        }
    }

    /**
     * Procesa la actualización de datos
     */
    public function update($companyId, $name, $yearFoundation, $city, $description, $email, $phoneNumber, $cuit)
    {
        try {
            $company = new Company();
            $company->setCompanyId($companyId);
            $company->setName($name);
            $company->setYearFoundation($yearFoundation);
            $company->setCity($city);
            $company->setDescription($description);
            $company->setEmail($email);
            $company->setPhoneNumber($phoneNumber);
            $company->setCuit($cuit);

            $this->companyService->updateCompany($company);
            
            $this->showManagerView("Company updated successfully.");

        } catch (Exception $e) {
            $message = $e->getMessage();
            $this->showModifyView($companyId, $message);
        }
    }

    /**
     * Procesa la baja de una empresa
     */
    public function delete($companyId)
    {
        $this->companyService->deleteCompany($companyId);
        $this->showManagerView("Company deleted.");
    }
}