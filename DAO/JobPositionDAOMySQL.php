<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use Models\JobPosition as JobPosition;

class JobPositionDAOMySQL
{
    private $connection;
    private $tableName = "job_positions";

    public function getAll()
    {
        try {
            $jobPositionList = array();
            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();
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

            $this->connection = Connection::GetInstance();
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
}