<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use Models\JobOffer as JobOffer;

class JobOfferDAOMySQL
{
    private $connection;
    private $tableName = "job_offers";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    public function add(JobOffer $jobOffer)
    {
        try {
            $query = "INSERT INTO job_offers (title, description, salary, startDate, deadline, active, companyId, jobPositionId, flyer_image_path) 
                  VALUES (:title, :description, :salary, :startDate, :deadline, :active, :companyId, :jobPositionId, :flyer_image_path);";

            $parameters["title"] = $jobOffer->getTitle();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["salary"] = $jobOffer->getSalary();
            $parameters["startDate"] = $jobOffer->getStartDate();
            $parameters["deadline"] = $jobOffer->getDeadline();
            $parameters["active"] = $jobOffer->getActive() ? 1 : 0;
            $parameters["companyId"] = $jobOffer->getCompanyId();
            $parameters["jobPositionId"] = $jobOffer->getJobPositionId();
            $parameters["flyer_image_path"]  = $jobOffer->getFlyerImagePath();

            $this->connection->ExecuteNonQuery($query, $parameters);

            return $this->connection->lastInsertId();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $jobOfferList = array();

            $query = "SELECT jo.*, c.name as companyName, jp.description as jobPositionDescription
                      FROM " . $this->tableName . " jo
                      INNER JOIN companies c ON jo.companyId = c.companyId
                      INNER JOIN job_positions jp ON jo.jobPositionId = jp.jobPositionId";

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
                $jobOffer->setFlyerImagePath($row["flyer_image_path"] ?? null);
                
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
                        jobPositionId = :jobPositionId,
                        flyer_image_path = :flyer_image_path 
                    WHERE jobOfferId = :jobOfferId";

            $parameters["title"] = $jobOffer->getTitle();
            $parameters["description"] = $jobOffer->getDescription();
            $parameters["salary"] = $jobOffer->getSalary();
            $parameters["startDate"] = $jobOffer->getStartDate();
            $parameters["deadline"] = $jobOffer->getDeadline();
            $parameters["active"] = $jobOffer->getActive();
            $parameters["companyId"] = $jobOffer->getCompanyId();
            $parameters["jobPositionId"] = $jobOffer->getJobPositionId();
            $parameters["flyer_image_path"] = $jobOffer->getFlyerImagePath(); // Incluido en el UPDATE
            $parameters["jobOfferId"] = $jobOffer->getJobOfferId();

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
                $jobOffer->setFlyerImagePath($row["flyer_image_path"] ?? null);

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
                $jobOffer->setFlyerImagePath($row["flyer_image_path"] ?? null);
                
                $jobOffer->setCompanyName($row["companyName"]);
                $jobOffer->setJobPositionDescription($row["jobPositionDescription"]);

                array_push($jobOfferList, $jobOffer);
            }

            return $jobOfferList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getExpiredToNotify() {
        $expiredList = array();
        // Buscamos ofertas que vencieron (deadline < hoy), estén activas y no notificadas
        $query = "SELECT * FROM job_offers 
                WHERE deadline <= CURDATE() 
                AND active = 1 
                AND notified = 0";

        try {
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
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateNotifiedStatus($jobOfferId, $status)
    {
        $query = "UPDATE job_offers SET notified = :notified WHERE jobOfferId = :jobOfferId";
        
        $parameters["notified"] = $status ? 1 : 0;
        $parameters["jobOfferId"] = $jobOfferId;

        try {
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Retorna estadísticas de ofertas: activas vs inactivas
     */
    public function GetStats()
    {
        try {
            // Contamos cuántas están activas y cuántas no
            $query = "SELECT 
                        SUM(CASE WHEN active = 1 AND deadline >= CURDATE() THEN 1 ELSE 0 END) as active_count,
                        SUM(CASE WHEN active = 0 OR deadline < CURDATE() THEN 1 ELSE 0 END) as inactive_count,
                        COUNT(*) as total_count
                      FROM " . $this->tableName;

            $resultSet = $this->connection->Execute($query);

            return (!empty($resultSet)) ? $resultSet[0] : null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Retorna el top 5 de posiciones con más ofertas
     */
    public function GetTopPositions()
    {
        try {
            $query = "SELECT jp.description, COUNT(jo.jobOfferId) as count
                      FROM job_offers jo
                      INNER JOIN job_positions jp ON jo.jobPositionId = jp.jobPositionId
                      GROUP BY jp.jobPositionId
                      ORDER BY count DESC
                      LIMIT 5";

            return $this->connection->Execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Retorna las ofertas de trabajo filtradas por el ID de carrera
     */
    public function GetByCareer($careerId)
    {
        try {
            $jobOfferList = array();

            // SQL con JOIN triple: JobOffer -> JobPosition -> Career
            $query = "SELECT jo.*, c.name as companyName, jp.description as jobPositionDescription
                      FROM " . $this->tableName . " jo
                      INNER JOIN companies c ON jo.companyId = c.companyId
                      INNER JOIN job_positions jp ON jo.jobPositionId = jp.jobPositionId
                      WHERE jp.careerId = :careerId AND jo.active = 1 AND jo.deadline >= CURDATE()";

            $parameters["careerId"] = $careerId;

            $resultSet = $this->connection->Execute($query, $parameters);

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
                $jobOffer->setFlyerImagePath($row["flyer_image_path"] ?? null);
                
                // Nombres de los JOINs
                $jobOffer->setCompanyName($row["companyName"]);
                $jobOffer->setJobPositionDescription($row["jobPositionDescription"]);

                array_push($jobOfferList, $jobOffer);
            }

            return $jobOfferList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}