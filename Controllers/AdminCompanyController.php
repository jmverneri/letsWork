<?php
namespace Controllers;

use Services\CompanyService;
use Models\Company;
use Utils\Utils;
use Exception;

use DAO\ICompanyDAO;
use DAO\IJobOfferDAO;
use DAO\ICareerDAO;
use Config\DAOFactory;

class AdminCompanyController
{
    private CompanyService $companyService;
    private ICompanyDAO $companyDAO;
    private IJobOfferDAO $jobOfferDAO;
    private ICareerDAO $careerDAO;

    public function __construct()
    {
        // En un controlador de Admin, validamos la sesión en el constructor
        // para proteger TODOS sus métodos de un solo golpe.
        Utils::checkAdminSession();
        $this->companyService = new CompanyService();
        $this->companyDAO  = DAOFactory::getCompanyDAO();
        $this->jobOfferDAO = DAOFactory::getJobOfferDAO();
        $this->careerDAO = DAOFactory::getCareerDAO();
    }

    /**
     * Muestra el panel principal de gestión de empresas
     */
    public function showCompaniesViews()
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
    public function deleteCompany($companyId)
    {
        if ($this->companyService->deleteCompany((int)$companyId)) {
            header("Location: " . FRONT_ROOT . "Company/showCompaniesViews?msg=deleted");
        } else {
            header("Location: " . FRONT_ROOT . "Company/showCompaniesViews?error=activeOffers");
        }
        exit();
    }
}