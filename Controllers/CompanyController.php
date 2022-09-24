<?php

namespace Controllers;

use DAO\CompanyDAO as CompanyDAO;
use Models\Company as Company;
use Utils\Utils as Utils;

class CompanyController
{
    private $company;
    private $companyDAO;
    private $companiesList = array();


    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
    }

    public function ShowAddView()
    {
        require_once(ADMIN_VIEWS . "company-add.php");
    }


  /*  public function ShowSingleView()
    {
        require_once(VIEWS_PATH . "show-companyAddCompany.php");
    }*/
    
    public function RedirectAddForm()
    {
        Utils::checkAdminSession();
        require_once(ADMIN_VIEWS . "company-add.php");
    }

    
    public function RedirectDeleteForm()
    {
        //Utils::checkAdminSession();
        $this->companiesList = $this->companyDAO->GetAll();
        require_once(ADMIN_VIEWS . "company-delete.php");

    }

    
    public function ShowSingleCompany($companyId)
    {
        Utils::checkSession();
        $this->company = $this->companyDAO->Search($companyId);
        
        require_once(VIEWS_PATH . "student-company-view.php");
        
    }

    public function ShowCompaniesViews($search = "")
    {
        if ($search == "") {
            Utils::checkSession();
            $this->companiesList = $this->companyDAO->GetAll();
              
            require_once(ADMIN_VIEWS. "company-delete.php");
        } else {
            $search = strtolower($search);
            $filteredCompanies = array();
            foreach ($this->companyDAO->getAll() as $company) {
                $companyName = strtolower($company->getName());

                if (Utils::strStartsWith($companyName, $search)) {
                    array_push($filteredCompanies, $company);
                }
            }
            $this->companiesList = $filteredCompanies;
            require_once(ADMIN_VIEWS . "company-delete.php");
        }
    }

    public function ListCompanies()
    {
        Utils::checkSession();
        $this->companiesList = $this->companyDAO->GetAll();
        $this->ShowCompaniesViews();
    }


    public function AddCompany($name, $yearFoundation, $city, $description, $email, $phoneNumber, $pre, $dni, $ultimo)
    {
        Utils::checkSession();
        $company = new Company();
        $company->setName($name);
        $company->setYearFoundation($yearFoundation);
        $company->setCity($city);
        $company->setDescription($description);      
        $company->setEmail($email);
        $company->setPhoneNumber($phoneNumber);
        $company->buildCuit($pre, $dni, $ultimo);

        $result = $this->checkCUIT($company->getCuit());  

        if($result == false)
        {
            $message = "The company has been saved correctly. Flawless Victory.";
            $this->companyDAO->AddCompany($company);
            require_once(ADMIN_VIEWS . "company-add.php");
        }else{
            $message = "There is already a company with that cuit. Please try again.";
            require_once(ADMIN_VIEWS . "company-add.php");
        }
        
        $this->ShowAddView();
    }

    //Validacion CUIT
    private function checkCUIT($cuit){
        $result = false;
        $this->companiesList = $this->companyDAO->GetAll();
        foreach($this->companiesList as $company){
            if($company->getCuit() == $cuit){
                $result = true;
            }
        }

        return $result;
    }
    

    public function updateCompany($companyId, $name, $yearFoundation, $city, $description, $email, $phoneNumber)
    {
        //Utils::checkSession();
        $company = new Company();

        $company->setCompanyId($companyId);
        $company->setName($name);
        $company->setYearFoundation($yearFoundation);
        $company->setCity($city);
        $company->setDescription($description);
        $company->setEmail($email);
        $company->setPhoneNumber($phoneNumber);
        //$company->setCuit($cuit);
        //$company->setLogo($logo);

        $this->companyDAO->Update($company);

        $this->RedirectDeleteForm("The company had been updated successfully");

      
    }

    public function deleteCompany($companyId)
    {

        $this->companyDAO->delete($companyId);

        $this->RedirectDeleteForm();
    }

    public function jobOffersForCompanies($companyName)
    {
        $companiesList = $this->companyDAO->GetAll();
        $jobs = null;

        foreach ($companiesList as $company) {
            if ($company->getName() == $companyName) {
                $jobs = $company;
            }
        }
    }

    public function ShowModifyCompanyView($companyId)
    {   
        $this->company = $this->companyDAO->Search($companyId);

        require_once(ADMIN_VIEWS . "company-modify.php");
    }

    /*public function searchCompanyByName($name){
            $company = $this->companyDAO->search($name);

            $this->ShowSingleView();
        }*/
}