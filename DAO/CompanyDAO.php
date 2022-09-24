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
        $sql = "INSERT INTO companies(name, yearFoundation, city, description, email, phoneNumber, cuit) 
                VALUES(:name, :yearFoundation, :city, :description, :email, :phoneNumber, :cuit);";

        $parameters['name'] = $company->getName();
        $parameters['yearFoundation'] = $company->getYearFoundation();
        $parameters['city'] = $company->getCity();
        $parameters['description'] = $company->getDescription();       
        $parameters['email'] = $company->getEmail();
        $parameters['phoneNumber'] = $company->getPhoneNumber();
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
        $sql = "DELETE FROM companies WHERE companyId=:companyId";
        $parameters['companyId'] = $companyId;

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function Update(Company $company)
    {
        $sql = "UPDATE companies SET name = :name, yearFoundation = :yearFoundation, city = :city, description = :description, email = :email, phoneNumber = :phoneNumber, cuit= :cuit WHERE companyId= :companyId";
        
        $parameters['companyId'] = $company->getCompanyId();
        $parameters['name'] = $company->getName();
        $parameters['yearFoundation'] = $company->getYearFoundation();
        $parameters['city'] = $company->getCity();
        $parameters['description'] = $company->getDescription();
       // $parameters['logo'] = $company->getLogo();
        $parameters['email'] = $company->getEmail();
        $parameters['phoneNumber'] = $company->getPhoneNumber();
        $parameters['cuit']= $company->getCuit();
       // var_dump($sql);
        //die;
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }


    public function Search($companyId)
    {
        $sql = "SELECT * FROM companies WHERE companyId=:companyId";
        $parameters['companyId'] = $companyId;
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
            $company->setCompanyId($values['companyId']);
            $company->setName($values['name']);
            $company->setYearFoundation($values['yearFoundation']);
            $company->setDescription(($values['description']));
            $company->setCity($values['city']);
            $company->setLogo($values['logo']);
            $company->setEmail($values['email']);
            $company->setPhoneNumber($values['phoneNumber']);
            $company->setCuit($values['cuit']);
            array_push($listToReturn, $company);
        }
        return  $listToReturn;
    }

    private function retrieveOneCompanyData()
    {
        foreach ($this->companyBD as $com) {
            $this->company->setCompanyId($com['companyId']);
            $this->company->setName($com['name']);
            $this->company->setYearFoundation($com['yearFoundation']);
            $this->company->setDescription(($com['description']));
            $this->company->setCity($com['city']);
            $this->company->setLogo($com['logo']);
            $this->company->setEmail($com['email']);
            $this->company->setPhoneNumber($com['phoneNumber']);
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
