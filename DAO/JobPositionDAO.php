<?php

namespace DAO;

use Models\JobPosition as JobPosition;
use DAO\IJobPositionDAO as IJobPositionDAO;
use DAO\Connection as Connection;

class JobPositionDAO implements IJobPositionDAO
{

    private $jobPositionList;
    private $conection;
    private $tableName = "jobpositions";
    private $jobPositionfilteredList;

    public function __construct()
    {
        $this->jobPositionList= array();
    }
    public function getAllJobpositions()
    {

        $sql = "SELECT * FROM " . $this->tableName;

        try {
            $this->connection = Connection::getInstance();
            $this->jobPositionList = $this->connection->execute($sql);
            //var_dump($this->jobPositionList);
            //die;
        } catch (\PDOException $exeption) {
            throw $exeption;
        }
        if (!empty($this->jobPositionList)) {
            return $this->retrieveDataJobPosition();
        } else {
            return false;
        }
    }

    public function deleteJobPosition($jobPosition)
    {
        $sql = "DELETE FROM jobposition WHERE jobPositionId=:jobPositionId";
        $parameters['jobPositionId'] = $jobPosition;

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }
    
    public function addJobPosition(JobPosition $jobPosition)
    {   
        $sql = "INSERT INTO jobposition(carrerId,descriptio)  
                VALUES(:carrerId,:description);";

        $parameters['careerId'] = $jobPosition->getCareerId();
        $parameters['description'] = $jobPosition->getDescription();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exeption) {
            throw $exeption;
        }
    }

    public function updateJobPosition(JobPosition $jobPosition)
    {
        $sql = "UPDATE jobposition SET description=:description;";

        $parameters['description'] = $jobPosition->getDescription();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function searchJobPositionById($jobPosition)
    {
        $sql = "SELECT * FROM jobposition WHERE jobPositionId=:jobPositionId";
        $parameters['jobPositionId'] = $jobPosition;

        try {
            $this->connection = Connection::getInstance();
            $this->jobPositionList = $this->connection->execute($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
        //var_dump($companiesList);
      //  die;
        if (!empty($jobPositionList)) {
            return $this->retrieveDataJobPosition();
        } else {
            return false;
        }
    }   
    public function searchJobPositionByCareerId($careerId)
    {
        $sql = "SELECT * FROM jobposition WHERE careerId=:careerId";
        $parameters['careerId'] = $careerId;

        try {
            $this->connection = Connection::getInstance();
            $this->jobPositionList = $this->connection->execute($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
        //var_dump($companiesList);
      //  die;
        if (!empty($jobPositionList)) {
            return $this->retrieveDataJobPosition();
        } else {
            return false;
        }
    }   


     private function retrieveDataJobPosition()
    {
        $listToReturn = array();

        foreach ($this->jobPositionList as $values) {
            $jobPosition = new JobPosition();
            $jobPosition->setJobPositionId($values['jobPositionId']);
            $jobPosition->setDescription($values['description']);
            $jobPosition->setCareerId($values['careerId']);

            array_push($listToReturn, $jobPosition);
        }
        return  $listToReturn;
    }



   
}
