<?php

namespace DAO;

use Models\JobOffer as JobOffer;
use DAO\IJobOfferDAO as IJobOfferDAO;
use DAO\Connection as Connection;
use Models\StudentByJobOffer as StudentByJobOffer;
use PDOException;

class StudentByJobOfferDAO implements IStudentByJobOfferDAO
{
    private $jobOfferList;
    private $connection;
    private $tableName = "job_Offer";

    public function getOne($studentId, $jobOfferId)
    {
    }

    public function getByJobOfferId($jobOfferId)
    {

        $sql = "SELECT * FROM students_x_job_offers WHERE jobOfferId=:jobOfferId";
        $parameters['jobOfferId'] = $jobOfferId;

        try {
            $this->connection = Connection::getInstance();
            $this->jobOfferList = $this->connection->execute($sql, $parameters);
        } catch (PDOException $ex) {
            throw $ex;
        }
        if (!empty($this->jobOfferList)) {
            return $this->retrieveData();
        } else {
            return $this->jobOfferList;
        }
    }

    public function addStudentToAJobOffer($jobOfferId, $studentId)
    {
        $sql = "INSERT INTO students_x_job_offers(jobOfferId, studentId)
        VALUES(:jobOfferId, :studentId)";

        $parameters['jobOfferId'] = $jobOfferId;
        $parameters['studentId'] = $studentId;
        

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }


    private function retrieveData()
    {
        $listToReturn = array();

        foreach ($this->jobOfferList as $values) {
            $studentByJobOffer = new StudentByJobOffer();
            $studentByJobOffer->setStudentByJobOfferId($values['studentXJobOffersId']);
            $studentByJobOffer->setJobOfferId($values['jobOfferId']);
            $studentByJobOffer->setStudentId($values['studentId']);

            array_push($listToReturn, $studentByJobOffer);
        }
        return  $listToReturn;
    }
}
