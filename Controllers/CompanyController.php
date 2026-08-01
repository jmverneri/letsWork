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
        Utils::checkAdminSession();
        $this->message = $message;
        require_once(ADMIN_VIEWS . "company-add.php");
    }

    public function AddCompany($data) 
    {
        Utils::checkAdminSession();
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
    public function showEditView()
    {
        $user = $_SESSION['loggedUser'];
        $company = $this->companyRepo->getByUserId($user->getUserId());
        
        // Necesitamos el email que está en el usuario
        $email = $user->getEmail();
        require_once(COMPANY_VIEWS . "company-edit.php");
    }

  /**
     * Procesa la edición de una empresa y su email asociado
     */
    public function editCompany()
    {
        if ($_POST) {
            try {
                // A. Verificar sesión activa
                if (!isset($_SESSION['loggedUser'])) {
                    throw new Exception("Debe iniciar sesión para realizar esta acción.");
                }

                $loggedUser = $_SESSION['loggedUser'];

                // B. Buscar la empresa correspondiente a este usuario
                $company = $this->companyRepo->getByUserId($loggedUser->getUserId());

                if (!$company) {
                    throw new Exception("No se encontró la empresa asociada a su usuario.");
                }

                // C. Validar que el nuevo email no esté en uso por OTRO usuario
                $newEmail = trim($_POST['email']);
                $existingUser = $this->userRepo->getByEmail($newEmail);

                if ($existingUser && $existingUser->getUserId() !== $loggedUser->getUserId()) {
                    throw new Exception("El email ya se encuentra registrado por otro usuario.");
                }

                // D. Actualizar los datos de la empresa
                $company->setName($_POST['name']);
                $company->setCity($_POST['city'] ?? null);
                $company->setDescription($_POST['description'] ?? null);
                $company->setPhoneNumber($_POST['phoneNumber'] ?? null);

                // E. Guardar cambios en la tabla 'companies'
                $this->companyRepo->updateCompany($company);

                // F. Actualizar el email en la tabla 'users' y en la SESIÓN
                $loggedUser->setEmail($newEmail);
                $this->userRepo->updateEmail($loggedUser->getUserId(), $newEmail);

                // Actualizamos el usuario guardado en sesión
                $_SESSION['loggedUser'] = $loggedUser;

                // G. Redirección exitosa
                header("Location: " . FRONT_ROOT . "Company/profile");
                exit();

            } catch (Exception $ex) {
                $message = $ex->getMessage();
                
                // Re-obtener la empresa para que la vista no rompa al renderizar $company
                if (isset($_SESSION['loggedUser'])) {
                    $company = $this->companyRepo->getByUserId($_SESSION['loggedUser']->getUserId());
                }
                
                require_once(VIEWS_PATH . "company-edit.php");
            }
        } else {
            header("Location: " . FRONT_ROOT . "Company/profile");
            exit();
        }
    }
}