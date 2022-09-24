<?php

namespace DAO;

use Models\JobOffer as JobOffer;
use DAO\IJobOfferDAO as IJobOfferDAO;
use DAO\Connection as Connection;


class JobOfferDAO implements IJobOfferDAO
{
    private $jobOfferList;
    private $connection;
    private $tableName = "job_Offer";

    public function __construct()
    {
        $this->jobOfferList = array();
    }

    public function getAllJobOffer()
    {

        $sql = "SELECT * FROM job_offer WHERE active=".true;
       //    $parameter['active']=true;

        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql);
        } catch (\PDOException $exeption) {
            throw $exeption;
        }
        if (!empty($this->jobOfferList)) {
            return $this->retrieveDataJobOffer();
        } else {
            return $this->jobOfferList;
        }
    }

    public function deleteJobOffer($jobOfferId)
    {
        $sql = "DELETE FROM job_Offer WHERE jobOfferId=:jobOfferId";
        $parameters['jobOfferId'] = $jobOfferId;

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function addJobOffer(JobOffer $jobOffer)
    {
        $sql = "INSERT INTO job_offer(name, startDay, deadline, active, description, salary, companyId, careerId, jobPositionId) 
                VALUES(:name, :startDay, :deadline, :active, :description, :salary, :companyId, :careerId, :jobPositionId);";
     
        $parameters['name'] = $jobOffer->getName();
        $parameters['startDay'] = $jobOffer->getStartDay();
        $parameters['deadline'] = $jobOffer->getDeadline();
        $parameters['active'] = $jobOffer->getActive();
        $parameters['description'] = $jobOffer->getDescription();
        $parameters['salary'] = $jobOffer->getSalary();
        $parameters['companyId'] = $jobOffer->getCompanyId();
        $parameters['careerId'] = $jobOffer->getCareerId();
        $parameters['jobPositionId'] = $jobOffer->getJobPositionId();
      

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exeption) {
            throw $exeption;
        }
    }

    public function updateJobOffer(JobOffer $jobOffer)
    {
        $sql = "UPDATE job_offer SET name =:name, startDay=:startDay, deadline=:deadline, description=:description, salary=:salary, careerId=:careerId, jobPositionId=:jobPositionId WHERE jobOfferId=:jobOfferId";

        $parameters['jobOfferId'] = $jobOffer->getjobOfferId();
        $parameters['name'] = $jobOffer->getName();
        $parameters['description'] = $jobOffer->getDescription();
        $parameters['startDay'] = $jobOffer->getstartDay();
        $parameters['deadline'] = $jobOffer->getdeadline();
        $parameters['salary'] = $jobOffer->getSalary();
        $parameters['careerId'] = $jobOffer->getCareerId();
        $parameters['jobPositionId'] = $jobOffer->getJobPositionId();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function searchJobOfferById($jobOfferId)
    {
        $sql = "SELECT * FROM job_offer WHERE jobOfferId=:jobOfferId";
        $parameters['jobOfferId'] = $jobOfferId;

        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
       
        if (!empty($this->jobOfferList)) {
            return $this->retrieveDataSingleJobOffer();
        } else {
            return false;
        }
    }
    
    public function searchJobOfferByName($jobOfferName)
    {
        $sql = "SELECT * FROM job_offer WHERE name=:name";
        $parameters['name'] = $jobOfferName;

        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql, $parameters);           
        } catch (\PDOException $exception) {
            throw $exception;
        }
       
        if (!empty($this->jobOfferList)) {
            return $this->retrieveDataJobOffer();
        } else {
            return $this->jobOfferList;
        }
    }

    public function addStudentToAJobOffer($jobOfferId, $studentId){
        $sql = "UPDATE job_offer SET studentId=:studentId, active=:active WHERE jobOfferId=:jobOfferId;";

        $parameters['studentId'] = $studentId;
        $parameters['jobOfferId'] = $jobOfferId;
        $parameters['active'] = false;
        
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }

    }

    public function getJobOfferByCompany($companyId){
        $sql = 'SELECT*FROM letswork.job_offer WHERE companyId = ' . $companyId . ' AND active = :active';
        $parameters['active']=true;
   
               
        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql, $parameters);
       
        } catch (\PDOException $exception) {
            throw $exception;
        }
       
        if (!empty($this->jobOfferList)) {
            return $this->retrieveDataJobOffer();
        } else {
            return false;
        }

    }

    public function getJobOfferByCareer($careerId){
        $sql = 'SELECT*FROM letswork.job_offer WHERE careerId = ' . $careerId . ' AND active = :active';
        $parameters['active']=true;
   
               
        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql, $parameters);
       
        } catch (\PDOException $exception) {
            throw $exception;
        }
       
        if (!empty($this->jobOfferList)) {
            return $this->retrieveDataJobOffer();
        } else {
            return false;
        }
    }

    private function retrieveDataJobOffer()
    {
        $listToReturn = array();

        foreach ($this->jobOfferList as $values) {
            $jobOffer = new JobOffer();
            $jobOffer->setName($values['name']);
            $jobOffer->setJobOfferId($values['jobOfferId']);
            $jobOffer->setstartDay($values['startDay']);
            $jobOffer->setdeadLine($values['deadline']);
            $jobOffer->setActive($values['active']);
            $jobOffer->setDescription($values['description']);
            $jobOffer->setSalary($values['salary']);
            $jobOffer->setCompanyId($values['companyId']);
            $jobOffer->setCareerId($values['careerId']);
            $jobOffer->setjobPositionId(($values['jobPositionId']));

            array_push($listToReturn, $jobOffer);
        }
        return  $listToReturn;
    }

    public function retrieveDataSingleJobOffer(){

        foreach ($this->jobOfferList as $values) {
            $jobOffer = new JobOffer();
            $jobOffer->setName($values['name']);
            $jobOffer->setJobOfferId($values['jobOfferId']);
            $jobOffer->setstartDay($values['startDay']);
            $jobOffer->setdeadLine($values['deadline']);
            $jobOffer->setActive($values['active']);
            $jobOffer->setDescription($values['description']);
            $jobOffer->setSalary($values['salary']);
            $jobOffer->setCompanyId($values['companyId']);
            $jobOffer->setStudentId($values['studentId']);
            $jobOffer->setCareerId($values['careerId']);
            $jobOffer->setjobPositionId(($values['jobPositionId']));

            
        }
        return  $jobOffer;
    }
}
