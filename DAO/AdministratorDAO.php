<?php


namespace DAO;

use AddressInfo;
use Models\Administrator as Administrator;
use interfaces\Idaos as IDaos;
use DAO\Connection as Connection;

class AdministratorDao implements IAdministratorDAO{

    private $connection;

    public function GetAll(){
        $sql = "SELECT * FROM administrators";
        try{
            $this->connection = Connection::getInstance();
            $administratorList = $this->connection->execute($sql);
        }catch(\PDOException $exception){
            throw $exception;
        }
        if(!empty($administratorList)){
            return $this->mapear($administratorList);
        }
        
    }


    public function AddAdministrator(Administrator $administrator)
    {
        $sql = "INSERT INTO administrators(firstName, lastName, dni, gender, birthDate, email, phoneNumber)
        VALUES (:firstName, :lastName, :dni, :gender, :birthDate, :email, :phoneNumber);";
        $parameters['firstName'] = $administrator->getFirstName();
        $parameters['lastName'] = $administrator->getLastName();
        $parameters['dni'] = $administrator->getDni;
        $parameters['gender'] = $administrator->getGender();
        $parameters['birthDate'] = $administrator->getBirthDate();
        $parameters['email'] = $administrator->getEmail();
        $parameters['phoneNumber'] = $administrator->getPhoneNumber();

        try{
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql,$parameters);

        }catch(\PDOException $exception){
            throw $exception;
        }        
    }

    public function Delete($idToDelete){
        $sql = "DELETE FROM administrators WHERE administratorId=:administratorId;";
        $parameters['administratorId'] = $idToDelete;
        try{
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql,$parameters);

        }catch(\PDOException $exception){
            throw $exception;
        }
    }
    public function Update(Administrator $administrator){
    $idToFind = $administrator->getadministratorId();
    $sql = "UPDATE SET firstName=:firstName, lastName=:lastName, dni=:dni, gender=:gender, birthDate=:birthDate, email=:email, phoneNumber=:phoneNumber WHERE administratorId='$idToFind';";
    $parameters['firstName'] = $administrator->getFirstName();
    $parameters['lastName'] = $administrator->getLastName();
    $parameters['dni'] = $administrator->getDni;
    $parameters['gender'] = $administrator->getGender();
    $parameters['birthDate'] = $administrator->getBirthDate();
    $parameters['email'] = $administrator->getEmail();
    $parameters['phoneNumber'] = $administrator->getPhoneNumber();

    try{
        $this->connection = Connection::getInstance();
        return $this->connection->executeNonQuery($sql,$parameters);

    }catch(\PDOException $exception){
        throw $exception;
    }        
    }
    public function Search($objet){}//en cada calse que la implemente, este objeto sera el atributo
    //por el cual se quiere buscar un registro

    private function mapear($administratorList){
        $administratorList = is_array($administratorList)? $administratorList:[];
        $adminList = array_map(function($pos){
            $newAdmin = new Administrator($pos['firstName'], $pos['lastName'], $pos['dni'], $pos['gender'], $pos['birthDate'], $pos['email'], $pos['phoneNumber']);
            $newAdmin->setadministratorId($pos['administratorId']);
            return $newAdmin;
        },$administratorList);
        return count($administratorList)>1? $administratorList:$administratorList['0'];
    }  
}
