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

   public function updateActiveStatus($id, $status)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET active = :status WHERE jobOfferId = :id";
            
            $parameters["id"] = $id;
            $parameters["status"] = ($status) ? 1 : 0;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update(JobOffer $jobOffer)
    {
        try {
            $query = "UPDATE " . $this->tableName . " 
                    SET title = :title, 
                        description = :description, 
                        salary = :salary, 
                        startDate = :startDate, 
                        deadline = :deadline, 
                        active = :active, 
                        companyId = :companyId, 
                        jobPositionId = :jobPositionId 
                    WHERE jobOfferId = :jobOfferId";

            $parameters["title"] = $jobOffer->getTitle();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["salary"] = $jobOffer->getSalary();
            $parameters["startDate"] = $jobOffer->getStartDate();
            $parameters["deadline"] = $jobOffer->getDeadline();
            $parameters["active"] = $jobOffer->getActive();
            $parameters["companyId"] = $jobOffer->getCompanyId();
            $parameters["jobPositionId"] = $jobOffer->getJobPositionId();
            $parameters["jobOfferId"] = $jobOffer->getJobOfferId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE jobOfferId = :id";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                $row = $resultSet[0];
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

                return $jobOffer;
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetOpenOffers()
    {
        try {
            $jobOfferList = array();

            // Agregamos el filtro: active = 1 Y la fecha de hoy es menor o igual al deadline
            $query = "SELECT jo.*, c.name as companyName, jp.description as jobPositionDescription
                    FROM " . $this->tableName . " jo
                    INNER JOIN companies c ON jo.companyId = c.companyId
                    INNER JOIN job_positions jp ON jo.jobPositionId = jp.jobPositionId
                    WHERE jo.active = 1 AND jo.deadline >= CURDATE()";

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
                
                $jobOffer->setCompanyName($row["companyName"]);
                $jobOffer->setJobPositionDescription($row["jobPositionDescription"]);

                array_push($jobOfferList, $jobOffer);
            }

            return $jobOfferList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getExpiredOffersToNotify() {
        $expiredList = array();
        // Buscamos ofertas que vencieron (deadline < hoy), estén activas y no notificadas
        $query = "SELECT * FROM job_offers 
                WHERE expirationDate < CURDATE() 
                AND active = 1 
                AND notified = 0";

        try {
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
                array_push($expiredList, $jobOffer);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $expiredList;
    }

    public function markAsNotified($jobOfferId) {
        $query = "UPDATE job_offers SET notified = 1 WHERE jobOfferId = :jobOfferId";
        $parameters["jobOfferId"] = $jobOfferId;

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getExpiredToNotify()
    {
        $expiredList = array();
        $query = "SELECT * FROM job_offers 
                WHERE deadline <= CURDATE() 
                AND active = 1 
                AND notified = 0";

        try {
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($row["jobOfferId"]);
                $jobOffer->setTitle($row["title"]);
                $jobOffer->setDeadline($row["deadline"]);
                $jobOffer->setActive($row["active"]);
                // Agregá los setters que necesites para tu modelo
                
                array_push($expiredList, $jobOffer);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
        return $expiredList;
    }

    public function updateNotifiedStatus($jobOfferId, $status)
    {
        $query = "UPDATE job_offers SET notified = :notified WHERE jobOfferId = :jobOfferId";
        
        $parameters["notified"] = $status ? 1 : 0;
        $parameters["jobOfferId"] = $jobOfferId;

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}