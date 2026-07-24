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

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    public function getOne($studentId, $jobOfferId)
    {
    }

    public function getByJobOfferId($jobOfferId)
    {

        $sql = "SELECT * FROM students_x_job_offers WHERE jobOfferId=:jobOfferId";
        $parameters['jobOfferId'] = $jobOfferId;

        try {
            return $this->jobOfferList = $this->connection->execute($sql, $parameters);
        } catch (PDOException $ex) {
            throw $ex;
        }
    }

    public function addStudentToAJobOffer($jobOfferId, $studentId)
    {
        // Ajustamos los nombres para que coincidan EXACTAMENTE con el array de parámetros
        $sql = "INSERT INTO students_x_job_offers(job_offer_id, student_id)
        VALUES(:job_offer_id, :student_id)";

        $parameters['job_offer_id'] = $jobOfferId;
        $parameters['student_id'] = $studentId; // Antes decía $parameters['student_id'] pero el SQL buscaba :studentId

        try {
            return $this->connection->executeNonQuery($sql, $parameters);
        } catch (\PDOException $exception) {
            throw $exception;
        }
    }
}
