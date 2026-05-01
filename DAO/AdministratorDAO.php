<?php

namespace DAO;

use Models\Admin as Admin;
use DAO\Connection as Connection;

class AdministratorDao implements IAdministratorDAO {

    private $connection;
    private $tableName = "administrators";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::getInstance();
    }

    public function GetAll() {
        $sql = "SELECT * FROM " . $this->tableName;
        try {
            $administratorList = $this->connection->execute($sql);
        } catch(\PDOException $exception) {
            throw $exception;
        }

        if(!empty($administratorList)) {
            return $this->mapear($administratorList);
        }
        return [];
    }

    public function AddAdministrator(Admin $admin) { 
        $sql = "INSERT INTO " . $this->tableName . " (firstName, lastName, dni, gender, birthDate, email, phoneNumber)
                VALUES (:firstName, :lastName, :dni, :gender, :birthDate, :email, :phoneNumber);";
        
        $parameters['firstName'] = $admin->getFirstName();
        $parameters['lastName'] = $admin->getLastName();
        $parameters['dni'] = $admin->getDni(); 
        $parameters['gender'] = $admin->getGender();
        $parameters['birthDate'] = $admin->getBirthDate();
        $parameters['email'] = $admin->getEmail();
        $parameters['phoneNumber'] = $admin->getPhoneNumber();

        try {
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch(\PDOException $exception) {
            throw $exception;
        }        
    }

    public function Delete($idToDelete) {
        $sql = "DELETE FROM " . $this->tableName . " WHERE administratorId=:administratorId;";
        $parameters['administratorId'] = $idToDelete;
        try {
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch(\PDOException $exception) {
            throw $exception;
        }
    }

    public function Update(Admin $admin) {
        $sql = "UPDATE " . $this->tableName . " 
                SET firstName=:firstName, lastName=:lastName, dni=:dni, gender=:gender, 
                    birthDate=:birthDate, email=:email, phoneNumber=:phoneNumber 
                WHERE administratorId=:administratorId;";
        
        $parameters['firstName'] = $admin->getFirstName();
        $parameters['lastName'] = $admin->getLastName();
        $parameters['dni'] = $admin->getDni();
        $parameters['gender'] = $admin->getGender();
        $parameters['birthDate'] = $admin->getBirthDate();
        $parameters['email'] = $admin->getEmail();
        $parameters['phoneNumber'] = $admin->getPhoneNumber();
        $parameters['administratorId'] = $admin->getadministratorId();

        try {
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch(\PDOException $exception) {
            throw $exception;
        }        
    }

    private function mapear($administratorList) {
        $administratorList = is_array($administratorList) ? $administratorList : [];
        return array_map(function($pos) {
            $newAdmin = new Admin( // Instanciamos Admin
                $pos['firstName'], 
                $pos['lastName'], 
                $pos['dni'], 
                $pos['gender'], 
                $pos['birthDate'], 
                $pos['email'], 
                $pos['phoneNumber']
            );
            $newAdmin->setadministratorId($pos['administratorId']);
            return $newAdmin;
        }, $administratorList);
    }  
}