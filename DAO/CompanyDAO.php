<?php


namespace DAO;

use COM;

use DAO\ICompanyDAO as ICompanyDAO;
use Models\Company as Company;
use DAO\Connection as Connection;

class CompanyDAO implements ICompanyDAO
{
    private $companiesList ;
    private $company;
    private $companyBD;
    private $connection;
    private $tableName = "companies";

    public function __construct()
    {
        $this->companyBD = new Company();
        $this->company = new Company();
        $this->companiesList = array();
    }

    public function GetAll()
    {

        $sql = "SELECT * FROM " . $this->tableName;

        try {
            $this->connection = Connection::getInstance();
            $this->companiesList = $this->connection->execute($sql);
        } catch (\PDOException $exeption) {
            throw $exeption;
        }

        if (!empty($this->companiesList)) {
            return $this->retrieveData();
        } else {
            return false;
        }
    }

    public function AddCompany(Company $company)
    {
        $sql = "INSERT INTO companies(name, year_foundation, city, description, email, phone_number, cuit) 
                VALUES(:name, :year_foundation, :city, :description, :email, :phone_number, :cuit);";

        $parameters['name'] = $company->getName();
        $parameters['year_foundation'] = $company->getYearFoundation();
        $parameters['city'] = $company->getCity();
        $parameters['description'] = $company->getDescription();       
        $parameters['email'] = $company->getEmail();
        $parameters['phone_number'] = $company->getPhoneNumber();
        $parameters['cuit'] = $company->getCuit();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exeption) {
            throw $exeption;
            require_once(ADMIN_VIEWS."company-modify.php");
        }
    }

    public function Delete($companyId)
    {
        $sql = "DELETE FROM companies WHERE company_id=:company_id";
        $parameters['company_id'] = $companyId;

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function Update(Company $company)
    {
        $sql = "UPDATE companies SET name = :name, year_foundation = :year_foundation, city = :city, description = :description, email = :email, phone_number = :phone_number, cuit= :cuit WHERE company_id= :company_id";
        
        $parameters['company_id'] = $company->getCompanyId();
        $parameters['name'] = $company->getName();
        $parameters['year_foundation'] = $company->getYearFoundation();
        $parameters['city'] = $company->getCity();
        $parameters['description'] = $company->getDescription();
       // $parameters['logo'] = $company->getLogo();
        $parameters['email'] = $company->getEmail();
        $parameters['phone_number'] = $company->getPhoneNumber();
        $parameters['cuit']= $company->getCuit();
       
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function Search($companyId)
    {
        $sql = "SELECT * FROM companies WHERE company_id=:company_id";
        $parameters['company_id'] = $companyId;

        try {
            $this->connection = Connection::getInstance();
            
            $this->companyBD = $this->connection->execute($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }

        if ($this->companyBD != null) {
            $this->retrieveOneCompanyData();

            return $this->company;
        } else {
            return false;
        }
    }

    private function retrieveData()
    {
        $listToReturn = array();

        foreach ($this->companiesList as $values) {
            $company = new Company();
            $company->setCompanyId($values['company_id']);
            $company->setName($values['name']);
            $company->setYearFoundation($values['year_foundation']);
            $company->setDescription(($values['description']));
            $company->setCity($values['city']);
            $company->setLogo($values['logo']);
            $company->setEmail($values['email']);
            $company->setPhoneNumber($values['phone_number']);
            $company->setCuit($values['cuit']);
            array_push($listToReturn, $company);
        }
        return  $listToReturn;
    }

    private function retrieveOneCompanyData()
    {
        foreach ($this->companyBD as $com) {
            $this->company->setCompanyId($com['company_id']);
            $this->company->setName($com['name']);
            $this->company->setYearFoundation($com['year_foundation']);
            $this->company->setDescription(($com['description']));
            $this->company->setCity($com['city']);
            $this->company->setLogo($com['logo']);
            $this->company->setEmail($com['email']);
            $this->company->setPhoneNumber($com['phone_number']);
            $this->company->setCuit($com['cuit']);
        }
    }

    /*
    private function mapear($companiesList)
    {
        $companiesList = is_array($companiesList) ? $companiesList : [];
        $companiesArray = array_map(function ($pos) {
            $newCompany = new Company($pos['name'], $pos['yearFoundation'], $pos['city'], $pos['description'], $pos['logo'], $pos['email'], $pos['phoneNumber']);
            $newCompany->setCompanyId($pos['companyId']);
            return $newCompany;
        }, $companiesList);
        return count($companiesArray) >= 0 ? $companiesArray : $companiesArray['0'];
    }
    */
}
