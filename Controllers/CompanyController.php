<?php

namespace Controllers;

use Repositories\CompanyRepository;   
use Repositories\JobOfferRepository;  
use Repositories\CareerRepository;
use Repositories\UserRepository;
use Models\Company;
use Utils\Utils;
use \Exception;

class CompanyController
{
    private CompanyRepository $companyRepo;
    private JobOfferRepository $jobOfferRepo;
    private CareerRepository $careerRepo;
    private UserRepository $userRepo;

    private $message;

    public function __construct()
    {
        // Instanciamos directamente los Repositories
        $this->companyRepo = new CompanyRepository();
        $this->jobOfferRepo = new JobOfferRepository();
        $this->careerRepo = new CareerRepository();
        $this->userRepo = new UserRepository();
    }

    public function dashboard()
    {
        Utils::checkCompanySession();

        $user = $_SESSION['loggedUser'];
        // Usamos el Repository
        $company = $this->companyRepo->getByUserId($user->getUserId());

        if (!$company || !$company->isActive()) {
            header("Location: " . FRONT_ROOT . "Home/logout");
            exit();
        }

        require_once(COMPANY_VIEWS . "company-dashboard.php");
    }

    public function profile()
    {
        Utils::checkCompanySession();

        $user = $_SESSION['loggedUser'];
        $company = $this->companyRepo->getByUserId($user->getUserId());

        require_once(COMPANY_VIEWS . "company-profile.php");
    }

    public function redirectAddForm($message = "") {
        $this->message = $message;
        require_once(ADMIN_VIEWS . "company-add.php");
    }

    public function AddCompany($data) 
    {
        try {
            // Validamos si ya existe el CUIT antes de hacer nada
            if ($this->companyRepo->getByCuit($data['cuit'])) {
                $this->redirectAddForm("Error: El CUIT ya se encuentra registrado.");
                return;
            }

            // Llamamos a la lógica del Repository
            $company = $this->companyRepo->createCompany($data);

            if ($company) {
               // Guardamos el mensaje en la sesión para que no se pierda al redireccionar
                $_SESSION['success_message'] = "Empresa registrada con éxito. El CUIT es su contraseña.";
                
                // Redirigimos a la ruta que maneja el Router
                header("location: " . FRONT_ROOT . "AdminCompany/showCompaniesViews");
                exit();
            } else {
                $this->redirectAddForm("No se pudo completar el registro.");
            }

        } catch (\Exception $ex) {
            $this->redirectAddForm("Error: " . $ex->getMessage());
        }
    }

    // Muestra el formulario con los datos actuales
    public function ShowEditView($companyId)
    {
        $company = $this->companyRepo->getById($companyId);
        // IMPORTANTE: Como el email está en User, asegúrate que tu getById traiga el email
        require_once(VIEWS_PATH . "company-edit.php");
    }

  /**
     * Procesa la edición de una empresa y su email asociado
     */
    public function EditCompany()
    {
        if ($_POST) {
            try {
                // 1. Validaciones básicas de seguridad
                if (!isset($_POST['companyId'])) {
                    throw new Exception("ID de empresa no proporcionado.");
                }

                // 2. Recuperamos la empresa existente desde el repositorio
                // Esto garantiza que mantenemos el userId, el logo, etc., que ya teníamos
                $company = $this->companyRepo->getById($_POST['companyId']);

                if (!$company) {
                    throw new Exception("No se encontró la empresa a editar.");
                }

                // 3. Actualizamos los atributos propios de la empresa
                $company->setName($_POST['name']);
                $company->setCity($_POST['city'] ?? null);
                $company->setDescription($_POST['description'] ?? null);
                $company->setPhoneNumber($_POST['phoneNumber'] ?? null);
                $company->setCuit($_POST['cuit'] ?? null);
                $company->setActive(isset($_POST['active'])); 

                // 4. Delegamos la actualización completa al repositorio.
                // Pasamos el objeto $company modificado y el nuevo email recibido por POST.
                // El repositorio se encargará de actualizar 'companies' y 'users'.
                $this->companyRepo->updateCompany($company, $_POST['email']);

                // 5. Redirección exitosa
                header("Location: " . FRONT_ROOT . "Company/List");
                exit();

            } catch (Exception $ex) {
                // Si algo falla, capturamos el mensaje para mostrarlo en la vista
                $message = $ex->getMessage();
                
                // Re-cargamos la vista de edición (asegúrate de que $company esté disponible)
                require_once(VIEWS_PATH . "company-edit.php");
            }
        } else {
            // Redirigir si acceden por GET sin datos
            header("Location: " . FRONT_ROOT . "Company/List");
        }
    }
}