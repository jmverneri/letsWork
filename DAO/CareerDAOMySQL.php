<?php
namespace DAO;

use \Exception as Exception;
use Models\Career as Career;
use DAO\Connection as Connection;

class CareerDAOMySQL {
    private $connection;
    private $tableName = "careers";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    public function getById($careerId) {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE careerId = :careerId";
            $parameters["careerId"] = $careerId;

            $resultSet = $this->connection->Execute($query, $parameters);

            if($resultSet) {
                $row = $resultSet[0];
                $career = new Career();
                $career->setCareerId($row["careerId"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);
                return $career;
            }
            return null;
        } catch (Exception $ex) { throw $ex; }
    }

    // Método para INSERTAR una carrera nueva
    public function add(Career $career) {
        try {
            $query = "INSERT INTO " . $this->tableName . " (careerId, description, active) 
                      VALUES (:careerId, :description, :active);";

            $parameters["careerId"] = $career->getCareerId();
            $parameters["description"] = $career->getDescription();
            $parameters["active"] = $career->getActive() ? 1 : 0;

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) { throw $ex; }
    }

    // Método para ACTUALIZAR una carrera existente (sin pisar el campo 'active')
    public function update(Career $career) {
        try {
            $query = "UPDATE " . $this->tableName . " 
                      SET description = :description, active = :active 
                      WHERE careerId = :careerId;";

            $parameters["description"] = $career->getDescription();
            $parameters["active"] = $career->getActive() ? 1 : 0;
            $parameters["careerId"] = $career->getCareerId();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) { throw $ex; }
    }

    public function getAll()
    {
        $careerList = array();
        $query = "SELECT * FROM " . $this->tableName . " ORDER BY description ASC";

        try {
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $career = new Career();
                $career->setCareerId($row["careerId"]);
                $career->setDescription($row["description"]);
                $career->setActive($row["active"]);
                
                array_push($careerList, $career);
            }
            return $careerList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}