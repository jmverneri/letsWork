<?php
namespace Controllers;

use Repositories\CompanyRepository;
use Models\Company;
use Utils\Utils;
use Exception;

class AdminCompanyController
{
    private $companyRepo;
    public $message;
    public $company;

    public function __construct()
    {
        // Validamos que sea Admin antes de dejarlo tocar nada
        Utils::checkAdminSession();
        $this->companyRepo = new CompanyRepository();
    }

    /**
     * Muestra el panel principal de gestión de empresas
     */
    // Modificamos para que acepte el parámetro que manda el Router
    public function showCompaniesViews($data = "")
    {
        // Si $data es un array, es que viene del formulario POST
        $search = "";
        if (is_array($data) && isset($data['search'])) {
            $search = $data['search'];
        } elseif (isset($_GET['search'])) { // Por si acaso queda algún link GET
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

        require_once(ADMIN_VIEWS . "company-manager.php");
    }

    /**
     * Muestra el formulario para agregar
     */
    public function showAddView($message = "")
    {
        $this->message = $message;
        require_once(ADMIN_VIEWS . "company-add.php");
    }

    /**
     * Muestra el formulario de edición (el que armamos antes)
     */
    public function showModifyView($companyId) 
    {
        // 1. Extraer ID del array del Router
        $id = is_array($companyId) ? ($companyId['companyId'] ?? null) : $companyId;

        if ($id) {
            // 2. Buscar la empresa
            $company = $this->companyRepo->getById((int)$id);

            if($company) {
                // 3. Buscar el email del usuario relacionado
                $user = $this->companyRepo->getUserById($company->getUserId());
                $email = ($user) ? $user->getEmail() : '';

                // 4. Cargar la vista. 
                // IMPORTANTE: Las variables $company y $email ya están disponibles aquí.
                require_once(ADMIN_VIEWS . "company-edit.php");
            } else {
                $this->showCompaniesViews("Error: Company not found in database.");
            }
        } else {
            $this->showCompaniesViews("Error: No ID provided for editing.");
        }
    }

    /**
     * Procesa el alta: Delegamos todo al Repo
     */
    public function add($name, $city, $description, $email, $phoneNumber, $pre, $dni, $ultimo)
    {
        try {
            // Armamos el CUIT desde los 3 campitos del form
            $cuit = $pre . "-" . $dni . "-" . $ultimo;

            $data = [
                'name' => $name,
                'city' => $city,
                'description' => $description,
                'email' => $email,
                'phoneNumber' => $phoneNumber,
                'cuit' => $cuit
            ];

            // Este método del Repo crea el User y la Company
            $this->companyRepo->createWithUser($data);
            
            $this->showCompaniesViews("The company has been saved correctly.");

        } catch (Exception $e) {
            $this->showAddView("Error: " . $e->getMessage());
        }
    }

    /**
     * Procesa la actualización
     */
    // Cambiamos los 7 parámetros por uno solo: $data
    public function update($data)
    {
        try {
            // Extraemos manualmente los datos del array que mandó el Router
            $companyId   = $data['companyId'];
            $name        = $data['name'];
            $cuit        = $data['cuit'];
            $email       = $data['email'];
            $city        = $data['city'];
            $phoneNumber = $data['phoneNumber'];
            $active      = $data['active'];
            $description = $data['description'];

            // 1. Buscamos la empresa en la base de datos
            $company = $this->companyRepo->getById((int)$companyId);

            if($company) {
                // 2. Seteamos los nuevos valores al objeto Company
                $company->setName($name);
                $company->setCuit($cuit);
                $company->setCity($city);
                $company->setPhoneNumber($phoneNumber);
                $company->setDescription($description);
                $company->setActive((bool)$active);

                // 3. Persistimos los cambios (esto actualiza Company y User)
                $this->companyRepo->updateCompany($company, $email);

                $this->showCompaniesViews("Company updated successfully!");
            } else {
                $this->showCompaniesViews("Error: Company not found.");
            }
        } catch (Exception $ex) {
            $this->showCompaniesViews("Error during update: " . $ex->getMessage());
        }
    }

    /**
     * Procesa la baja (Baja lógica: active = 0)
     */
    public function deleteCompany($companyId)
    {
        try {
            // El Router suele mandar el ID en un array si viene de un POST
            $id = is_array($companyId) ? $companyId['companyId'] : $companyId;
            
            // 1. Buscamos la empresa
            $company = $this->companyRepo->getById((int)$id);

            if($company) {
                // 2. FILTRO: Verificamos si ya está inactiva
                if($company->isActive() == false) {
                    $this->showCompaniesViews("The company is already inactive.");
                    return;
                }

                // 3. Ejecutamos el borrado lógico a través del repo
                $this->companyRepo->deleteLogic($company);
                
                $this->showCompaniesViews("Company deactivated successfully.");
            } else {
                $this->showCompaniesViews("Error: Company not found.");
            }
        } catch (Exception $ex) {
            $this->showCompaniesViews("Error: " . $ex->getMessage());
        }
    }

    public function reactiveCompany($companyId)
    {
        try {
            // Manejamos si viene por POST (array) o directo
            $id = is_array($companyId) ? $companyId['companyId'] : $companyId;
            
            $company = $this->companyRepo->getById((int)$id);

            if($company) {
                // Pasamos a true el estado
                $this->companyRepo->reactivateLogic($company);
                
                $this->showCompaniesViews("Company reactivated successfully.");
            } else {
                $this->showCompaniesViews("Error: Company not found.");
            }
        } catch (Exception $ex) {
            $this->showCompaniesViews("Error: " . $ex->getMessage());
        }
    }
}