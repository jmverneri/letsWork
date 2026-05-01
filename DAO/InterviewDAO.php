<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;

class InterviewDAO {
    private $connection;
    private $tableName = "interviews";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    public function add($studentId, $jobOfferId, $dateTime, $location) {
        $query = "INSERT INTO " . $this->tableName . " (studentId, jobOfferId, date_time, location_or_link, status) 
                VALUES (:studentId, :jobOfferId, :date_time, :location_or_link, :status)";
        
        $parameters["studentId"] = $studentId;
        $parameters["jobOfferId"] = $jobOfferId;
        $parameters["date_time"] = $dateTime;
        $parameters["location_or_link"] = $location;
        $parameters["status"] = 'scheduled';

        return $this->connection->ExecuteNonQuery($query, $parameters);
    }

    public function updateStatus($interviewId, $newStatus) {
        try {
            // Cambiamos el WHERE para que sea por la Primary Key (ID único)
            $query = "UPDATE " . $this->tableName . " 
                    SET status = :status 
                    WHERE interviewId = :interviewId";

            $parameters["status"] = $newStatus;
            $parameters["interviewId"] = $interviewId;

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getByCompany($companyId) {
        $query = "SELECT i.*, s.firstName, s.lastName, u.email, jo.title as jobTitle
                  FROM " . $this->tableName . " i
                  INNER JOIN students s ON i.studentId = s.studentId
                  INNER JOIN users u ON s.userId = u.userId
                  INNER JOIN job_offers jo ON i.jobOfferId = jo.jobOfferId
                  WHERE jo.companyId = :companyId
                  ORDER BY i.date_time ASC";

        return $this->connection->Execute($query, ["companyId" => $companyId]);
    }

    public function getInterviewsByCompany($companyId) {
        try {
            $query = "SELECT 
                        i.interviewId,
                        i.jobOfferId,
                        i.studentId,
                        i.date_time, 
                        i.location_or_link, 
                        i.status as interviewStatus,
                        s.firstName, 
                        s.lastName, 
                        u.email,
                        jo.title as jobTitle
                    FROM interviews i
                    INNER JOIN students s ON i.studentId = s.studentId
                    INNER JOIN users u ON s.userId = u.userId
                    INNER JOIN job_offers jo ON i.jobOfferId = jo.jobOfferId
                    WHERE jo.companyId = :companyId
                    ORDER BY i.date_time ASC"; // Ordenadas por la más cercana

            return $this->connection->Execute($query, ["companyId" => $companyId]);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getById($interviewId)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE interviewId = :interviewId";
            
            $parameters["interviewId"] = $interviewId;

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $interview = new \Models\Interview(); // Asegurate de que el namespace/modelo sea el correcto
                $interview->setInterviewId($row["interviewId"]);
                $interview->setStudentId($row["studentId"]);
                $interview->setJobOfferId($row["jobOfferId"]);
                $interview->setInterviewDate($row["date_time"]);
                $interview->setStatus($row["status"]);
                // Agregá aquí otros setters si tenés más columnas (ej. link virtual, notas, etc.)

                return $interview;
            }
            
            return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}