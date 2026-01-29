<?php

namespace Controllers;

use DAO\ICompanyDAO;
use DAO\IJobOfferDAO;
use DAO\ICareerDAO;
use Config\DAOFactory;
use Utils\Utils;

class CompanyController
{
    private ICompanyDAO $companyDAO;
    private IJobOfferDAO $jobOfferDAO;
    private ICareerDAO $careerDAO;

    public function __construct()
    {
        $this->companyDAO  = DAOFactory::getCompanyDAO();
        $this->jobOfferDAO = DAOFactory::getJobOfferDAO();
        $this->careerDAO = DAOFactory::getCareerDAO();
    }

    /**
     * Dashboard principal de Company
     */
    public function dashboard()
    {
        Utils::checkCompanySession();

        $user = $_SESSION['loggedUser'];
        $company = $this->companyDAO->getByUserId($user->getUserId());

        if (!$company || !$company->isActive()) {
            header("Location: " . FRONT_ROOT . "Home/logout");
            exit();
        }

        require_once(COMPANY_VIEWS . "company-dashboard.php");
    }

    /**
     * Ver perfil de la empresa
     */
    public function profile()
    {
        Utils::checkCompanySession();

        $user = $_SESSION['loggedUser'];
        $company = $this->companyDAO->getByUserId($user->getUserId());

        require_once(COMPANY_VIEWS . "company-profile.php");
    }

    /**
     * Formulario edición empresa
     */
    public function edit()
    {
        Utils::checkCompanySession();

        $user = $_SESSION['loggedUser'];
        $company = $this->companyDAO->getByUserId($user->getUserId());

        require_once(COMPANY_VIEWS . "company-edit.php");
    }

    /**
     * Guardar cambios empresa
     */
    public function update($data)
    {
        Utils::checkCompanySession();

        $user = $_SESSION['loggedUser'];
        $company = $this->companyDAO->getByUserId($user->getUserId());

        $company->setName($data['name'])
                ->setCity($data['city'])
                ->setDescription($data['description'])
                ->setPhoneNumber($data['phoneNumber']);

        $this->companyDAO->update($company);

        header("Location: " . FRONT_ROOT . "Company/profile");
        exit();
    }
}
