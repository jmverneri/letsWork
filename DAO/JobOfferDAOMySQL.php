<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use Models\JobOffer as JobOffer;

class JobOfferDAOMySQL
{
    private $connection;
    private $tableName = "job_offers";

    public function Add(JobOffer $jobOffer)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (title, description, salary, startDate, deadline, active, companyId, jobPositionId) 
                      VALUES (:title, :description, :salary, :startDate, :deadline, :active, :companyId, :jobPositionId);";

            $parameters["title"] = $jobOffer->getTitle();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["salary"] = $jobOffer->getSalary();
            $parameters["startDate"] = $jobOffer->getStartDate();
            $parameters["deadline"] = $jobOffer->getDeadline();
            $parameters["active"] = $jobOffer->getActive() ? 1 : 0;
            $parameters["companyId"] = $jobOffer->getCompanyId();
            $parameters["jobPositionId"] = $jobOffer->getJobPositionId();

            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $jobOfferList = array();

            // SQL con JOINs para traer los nombres de empresa y posición de una sola vez
            $query = "SELECT jo.*, c.name as companyName, jp.description as jobPositionDescription
                      FROM " . $this->tableName . " jo
                      INNER JOIN companies c ON jo.companyId = c.companyId
                      INNER JOIN job_positions jp ON jo.jobPositionId = jp.jobPositionId";

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setTitle($row["title"]);
                $jobOffer->setDescription($row["description"]);
                $jobOffer->setSalary($row["salary"]);
                $jobOffer->setStartDate($row["startDate"]);
                $jobOffer->setDeadline($row["deadline"]);
                $jobOffer->setActive($row["active"]);
                $jobOffer->setCompanyId($row["companyId"]);
                $jobOffer->setJobPositionId($row["jobPositionId"]);
                
                // Seteamos los nombres que vienen del JOIN
                $jobOffer->setCompanyName($row["companyName"]);
                $jobOffer->setJobPositionDescription($row["jobPositionDescription"]);

                array_push($jobOfferList, $jobOffer);
            }

            return $jobOfferList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function UpdateActiveStatus($jobOfferId, $status)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET active = :active WHERE jobOfferId = :jobOfferId";
            $parameters["active"] = $status ? 1 : 0;
            $parameters["jobOfferId"] = $jobOfferId;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}