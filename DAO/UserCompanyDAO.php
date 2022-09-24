<?php

namespace DAO;

use interfaces\Idaos as IDaos;
use Models\Student as Student;
use DAO\IStudentDAO as IStudentDAO;

use DAO\Connection as Connection;
use Models\UserCompany;
use PDO;
use \PDOException as PDOException;


class UserCompanyDAO implements IUserCompanyDAO
{
    private $userCompany;
    private $connection;
    private $tableName = "user_company";

    public function __construct()
    {

    }

    function getUserCompanyByEmail($email)
    {

        $sql = "SELECT * FROM ". $this->tableName . " WHERE email=:email;";
        $parameters['email']=$email;

        try{
            $this->connection = Connection::getInstance();
            $this->userCompany = $this->connection->Execute($sql, $parameters);
            //var_dump($this->userCompany);
           // die;
        }catch(PDOException $ex){
           
            echo "Error message: " . $ex->getMessage();
        }

        if(!empty($this->userCompany)){
            $userCompanyObj = new UserCompany();

            return $this->retrieveUserCompanyData(); 
        }

    }

    function getCompaniesByUserCompany($userCompanyId)
    {
    }


    private function retrieveUserCompanyData(){
        foreach($this->userCompany as $userCompany){
            $userCompanyObj = new UserCompany();

            $userCompanyObj->setUserCompanyId($userCompany['userCompanyId']);
            $userCompanyObj->setEmail($userCompany['email']);
            $userCompanyObj->setFirstName($userCompany['firstName']);
            $userCompanyObj->setLastName($userCompany['lastName']);
            $userCompanyObj->setPhoneNumber($userCompany['phoneNumber']);
            $userCompanyObj->setPassword($userCompany['password']);
            $userCompanyObj->setDni($userCompany['dni']);
        }
        
        return $userCompanyObj;
        
    }

    public function AddUserCompany(UserCompany $userCompany)
    {
        
      $sql = "INSERT INTO user_company (firstName, lastName, dni, phoneNumber, active, password, email)
                 VALUES (:firstName, :lastName, :dni, :phoneNumber, :active, :password, :email);";
        $parameters["firstName"]=$userCompany->getFirstName();
        $parameters['lastName']=$userCompany->getLastName();
        $parameters['dni']=$userCompany->getDni();       
        $parameters['phoneNumber']=$userCompany->getPhoneNumber();
        $parameters['active']=true;
        $parameters['password']=$userCompany->getPassword();
        $parameters['email']=$userCompany->getEmail();
        try {
            $this->connection= Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}


?>