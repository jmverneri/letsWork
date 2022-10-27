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

    public function getAllActiveJobOffer()
    {
        $sql = "SELECT * FROM job_offer WHERE active=".true;

        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql);
        } catch (\PDOException $exeption) {
            throw $exeption;
        }
        if (!empty($this->jobOfferList)) {
            return $this->retrieveActiveJobOffer();
        } else {
            return $this->jobOfferList;
        }
    }

    public function deleteJobOffer($jobOfferId)
    {
        $sql = "DELETE FROM job_Offer WHERE job_offer_id=:job_offer_id";
        $parameters['job_offer_id'] = $jobOfferId;

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function addJobOffer(JobOffer $jobOffer)
    {
        $sql = "INSERT INTO job_offer(name, start_day, dead_line, active, description, salary, fkcompany_id, fkcareer_id, fkjob_position_id) 
                VALUES(:name, :start_day, :dead_line, :active, :description, :salary, :fkcompany_id, :fkcareer_id, :fkjob_position_id);";
     
        $parameters['name'] = $jobOffer->getName();
        $parameters['start_day'] = $jobOffer->getStartDay();
        $parameters['dead_line'] = $jobOffer->getDeadline();
        $parameters['active'] = $jobOffer->getActive();
        $parameters['description'] = $jobOffer->getDescription();
        $parameters['salary'] = $jobOffer->getSalary();
        $parameters['fkcompany_id'] = $jobOffer->getCompanyId();
        $parameters['fkcareer_id'] = $jobOffer->getCareerId();
        $parameters['fkjob_position_id'] = $jobOffer->getJobPositionId();
      

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exeption) {
            throw $exeption;
        }
    }

    public function updateJobOffer(JobOffer $jobOffer)
    {
        $sql = "UPDATE job_offer SET name =:name, start_day=:start_day, dead_line=:dead_line, description=:description, salary=:salary, career_id=:career_id, job_position_id=:job_position_id WHERE job_offer_id=:job_offer_id";

        $parameters['job_offer_id'] = $jobOffer->getjobOfferId();
        $parameters['name'] = $jobOffer->getName();
        $parameters['description'] = $jobOffer->getDescription();
        $parameters['start_day'] = $jobOffer->getstartDay();
        $parameters['dead_line'] = $jobOffer->getdeadline();
        $parameters['salary'] = $jobOffer->getSalary();
        $parameters['career_id'] = $jobOffer->getCareerId();
        $parameters['job_position_id'] = $jobOffer->getJobPositionId();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }

    public function searchJobOfferById($jobOfferId)
    {
        $sql = "SELECT * FROM job_offer WHERE job_offer_id=:job_offer_id";
        $parameters['job_offer_id'] = $jobOfferId;

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
        $sql = "UPDATE job_offer SET student_id=:student_id, active=:active WHERE jobOfferId=:jobOfferId;";

        $parameters['student_id'] = $studentId;
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
        $sql = 'SELECT * FROM job_offer WHERE fkcompany_id = ' . $companyId . ' AND active = :active';
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

    public function getActiveJobOfferByCompany($companyId){
        $sql = 'SELECT * FROM job_offer WHERE fkcompany_id = ' . $companyId . ' AND active = :active';
        $parameters['active']=true;
   
        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql, $parameters);
       
        } catch (\PDOException $exception) {
            throw $exception;
        }
       
        if (!empty($this->jobOfferList)) {
            return $this->retrieveActiveJobOffer();
        } else {
            return false;
        }
    }

    public function getJobOfferByCareer($careerId){
        $sql = 'SELECT * FROM job_offer WHERE fkcareer_id = ' . $careerId . ' AND active = :active';
        $parameters['active']= true;
   
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
            $jobOffer->setJobOfferId($values['job_offer_id']);
            $jobOffer->setstartDay($values['start_day']);
            $jobOffer->setdeadLine($values['dead_line']);
            $jobOffer->setActive($values['active']);
            $jobOffer->setDescription($values['description']);
            $jobOffer->setSalary($values['salary']);
            $jobOffer->setCompanyId($values['fkcompany_id']);
            $jobOffer->setCareerId($values['fkcareer_id']);
            $jobOffer->setjobPositionId(($values['fkjob_position_id']));

            array_push($listToReturn, $jobOffer);
        }
        return  $listToReturn;
    }

    private function retrieveActiveJobOffer()
    {
        $listToReturn = array();

        foreach ($this->jobOfferList as $values) {
            $jobOffer = new JobOffer();
            $jobOffer->setName($values['name']);
            $jobOffer->setJobOfferId($values['job_offer_id']);
            $jobOffer->setstartDay($values['start_day']);
            $jobOffer->setdeadLine($values['dead_line']);
            $jobOffer->setActive($values['active']);
            $jobOffer->setDescription($values['description']);
            $jobOffer->setSalary($values['salary']);
            $jobOffer->setCompanyId($values['fkcompany_id']);
            $jobOffer->setCareerId($values['fkcareer_id']);
            $jobOffer->setjobPositionId(($values['fkjob_position_id']));

            if (strtotime($jobOffer->getDeadLine()) > strtotime(date("Y-m-d H:i:00", time()))) {
                array_push($listToReturn, $jobOffer);    
            }
        }
        return  $listToReturn;
    }

    public function retrieveDataSingleJobOffer(){

        foreach ($this->jobOfferList as $values) {
            $jobOffer = new JobOffer();
            $jobOffer->setName($values['name']);
            $jobOffer->setJobOfferId($values['job_offer_id']);
            $jobOffer->setstartDay($values['start_day']);
            $jobOffer->setdeadLine($values['dead_line']);
            $jobOffer->setActive($values['active']);
            $jobOffer->setDescription($values['description']);
            $jobOffer->setSalary($values['salary']);
            $jobOffer->setCompanyId($values['company_id']);
            $jobOffer->setStudentId($values['student_id']);
            $jobOffer->setCareerId($values['career_id']);
            $jobOffer->setjobPositionId(($values['job_position_id']));
  
        }
        return  $jobOffer;
    }
}
