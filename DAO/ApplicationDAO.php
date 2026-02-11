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
            // Traemos datos de la oferta y el nombre de la empresa uniendo las tablas
            $query = "SELECT jo.*, a.applicationDate, c.name as companyName 
                    FROM " . $this->tableName . " a
                    INNER JOIN job_offers jo ON a.jobOfferId = jo.jobOfferId
                    INNER JOIN companies c ON jo.companyId = c.companyId
                    WHERE a.studentId = :studentId
                    ORDER BY a.applicationDate DESC"; // Lo más reciente primero

            $parameters["studentId"] = $studentId;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            return $resultSet; // Retornamos el array asociativo directamente para la vista
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}