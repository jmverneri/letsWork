<?php

namespace Controllers;

use Repositories\CompanyRepository;   
use Repositories\JobOfferRepository;  
use Repositories\CareerRepository;
use Repositories\UserRepository;
use Models\Company;
use Utils\Utils;

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
                $this->ShowAddView("Error: El CUIT ya se encuentra registrado.");
                return;
            }

            // Llamamos a la lógica del Repository
            $company = $this->companyRepo->createCompany($data);

            if ($company) {
                $this->redirectAddForm("Empresa registrada con éxito. El CUIT es su contraseña.");
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

    // Procesa la modificación
    public function EditCompany($companyId, $name, $cuit, $email, $city, $description, $phoneNumber)
    {
        try {
            $company = $this->companyRepo->getById($companyId);
            
            if($company) {
                $company->setName($name);
                $company->setCuit($cuit);
                $company->setCity($city);
                $company->setDescription($description);
                $company->setPhoneNumber($phoneNumber);

                $this->companyRepo->updateCompany($company, $email);
                
                $this->ShowListView("Empresa actualizada correctamente.");
            }
        } catch (\Exception $ex) {
            $this->Index("Error al editar: " . $ex->getMessage());
        }
    }
}