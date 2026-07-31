<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use Models\JobPosition as JobPosition;

class JobPositionDAOMySQL
{
    private $connection;
    private $tableName = "job_positions";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    public function getAll()
    {
        try {
            $jobPositionList = array();
            $query = "SELECT * FROM " . $this->tableName ;

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $jobPosition = new JobPosition();
                $jobPosition->setJobPositionId($row["jobPositionId"]);
                $jobPosition->setCareerId($row["careerId"]);
                $jobPosition->setDescription($row["description"]);

                array_push($jobPositionList, $jobPosition);
            }

            return $jobPositionList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE jobPositionId = :id";
            $parameters["id"] = $id;

            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                $row = $resultSet[0];
                $jobPosition = new JobPosition();
                $jobPosition->setJobPositionId($row["jobPositionId"]);
                $jobPosition->setCareerId($row["careerId"]);
                $jobPosition->setDescription($row["description"]);
                return $jobPosition;
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function add(JobPosition $jobPosition)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (careerId, description) 
                      VALUES (:careerId, :description);";

            $parameters["careerId"] = $jobPosition->getCareerId();
            $parameters["description"] = $jobPosition->getDescription();

            $this->connection->ExecuteNonQuery($query, $parameters);

            // Retornamos el ID por si lo necesitás para algo después de insertar
            return $this->connection->lastInsertId();
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update(JobPosition $jobPosition)
    {
        try {
            // Preparamos la consulta SQL
            $query = "UPDATE " . $this->tableName . " 
                      SET careerId = :careerId, 
                          description = :description 
                      WHERE jobPositionId = :jobPositionId";

            // Mapeamos los valores del objeto a los parámetros
            $parameters["careerId"] = $jobPosition->getCareerId();
            $parameters["description"] = $jobPosition->getDescription();
            $parameters["jobPositionId"] = $jobPosition->getJobPositionId();
            
            // Ejecutamos la sentencia (ExecuteNonQuery para UPDATE/INSERT/DELETE)
            $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            // En lugar de borrar, seteamos active en 0
            $query = "UPDATE " . $this->tableName . " 
                      SET active = 0 
                      WHERE jobPositionId = :id";
            
            $parameters["id"] = $id;

            $this->connection->ExecuteNonQuery($query, $parameters);
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Busca todas las posiciones que pertenecen a una carrera específica
     */
    public function getByCareerId($careerId)
    {
        try {
            $jobPositionList = array();
            
            // Filtramos por careerId y que estén activas (borrado lógico)
            $query = "SELECT * FROM " . $this->tableName . " 
                      WHERE careerId = :careerId AND active = 1";

            $parameters["careerId"] = $careerId;

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $jobPosition = new JobPosition();
                $jobPosition->setJobPositionId($row["jobPositionId"]);
                $jobPosition->setCareerId($row["careerId"]);
                $jobPosition->setDescription($row["description"]);

                array_push($jobPositionList, $jobPosition);
            }

            return $jobPositionList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}