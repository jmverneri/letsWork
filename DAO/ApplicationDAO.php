<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;

class ApplicationDAO {
    private $connection;
    private $tableName = "applications";

    /**
     * Registra una nueva postulación
     */
    public function add($studentId, $jobOfferId, $date) {
        try {
            $query = "INSERT INTO " . $this->tableName . " (studentId, jobOfferId, applicationDate) 
                      VALUES (:studentId, :jobOfferId, :applicationDate)";

            $parameters["studentId"] = $studentId;
            $parameters["jobOfferId"] = $jobOfferId;
            $parameters["applicationDate"] = $date;

            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Verifica si un estudiante ya aplicó a una oferta específica
     * Retorna true si ya existe el registro, false si no.
     */
    public function isStudentApplied($studentId, $jobOfferId) {
        try {
            $query = "SELECT studentId FROM " . $this->tableName . " 
                      WHERE studentId = :studentId AND jobOfferId = :jobOfferId";

            $parameters["studentId"] = $studentId;
            $parameters["jobOfferId"] = $jobOfferId;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            return !empty($resultSet); // Si el resultado no está vacío, es que ya aplicó
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Trae todos los IDs de ofertas a las que se postuló un alumno
     */
    public function getAppliedOfferIds($studentId) {
        try {
            $query = "SELECT jobOfferId FROM " . $this->tableName . " WHERE studentId = :studentId";
            $parameters["studentId"] = $studentId;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            // Devolvemos solo un array simple con los IDs para facilitar la búsqueda después
            return array_column($resultSet, 'jobOfferId');
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getApplicationsByStudent($studentId) {
        try {
            // Traemos el deadline y usamos CURDATE() para saber si ya expiró
            $query = "SELECT jo.title, jo.active as offerActive, jo.deadline, 
                            a.status as appStatus, a.applicationDate, c.name as companyName,
                            IF(jo.deadline >= CURDATE() AND jo.active = 1, 1, 0) as isRealActive
                    FROM applications a
                    INNER JOIN job_offers jo ON a.jobOfferId = jo.jobOfferId
                    INNER JOIN companies c ON jo.companyId = c.companyId
                    WHERE a.studentId = :studentId
                    ORDER BY a.applicationDate DESC";

            $this->connection = Connection::GetInstance();
            return $this->connection->Execute($query, ["studentId" => $studentId]);
        } catch (Exception $ex) { throw $ex; }
    }

    public function getApplicantsByOffer($jobOfferId) {
        try {
            // El a.* trae el 'status' de la tabla applications
            $query = "SELECT s.*, u.email, a.applicationDate, a.status 
                    FROM applications a
                    INNER JOIN students s ON a.studentId = s.studentId
                    INNER JOIN users u ON s.userId = u.userId
                    WHERE a.jobOfferId = :jobOfferId
                    ORDER BY s.lastName ASC";

            $parameters["jobOfferId"] = $jobOfferId;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            return $resultSet; 
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function UpdateStatus($studentId, $jobOfferId, $status)
    {
        try {
            $query = "UPDATE " . $this->tableName . " 
                    SET status = :status 
                    WHERE studentId = :studentId AND jobOfferId = :jobOfferId";

            $parameters["status"] = $status;
            $parameters["studentId"] = $studentId;
            $parameters["jobOfferId"] = $jobOfferId;

            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}