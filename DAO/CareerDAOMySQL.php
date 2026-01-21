<?php
namespace DAO;

use Models\Career;
use DAO\Connection;
use PDOException;

class CareerDAOMySQL implements ICareerDAO
{
    private $connection;

    public function getAll(): array
    {
        $sql = "SELECT * FROM careers";
        $careerList = [];

        try {
            $this->connection = Connection::getInstance();
            $result = $this->connection->execute($sql);

            foreach ($result as $row) {
                $career = (new Career())
                    ->setCareerId($row['career_id'])
                    ->setDescription($row['description'])
                    ->setActive($row['active']);

                $careerList[] = $career;
            }
        } catch (PDOException $ex) {
            throw $ex;
        }

        return $careerList;
    }

    public function getById(int $careerId): ?Career
    {
        $sql = "SELECT * FROM careers WHERE career_id = :id";

        try {
            $this->connection = Connection::getInstance();
            $result = $this->connection->execute($sql, ['id' => $careerId]);

            if (!empty($result)) {
                $row = $result[0];

                return (new Career())
                    ->setCareerId($row['career_id'])
                    ->setDescription($row['description'])
                    ->setActive($row['active']);
            }
        } catch (PDOException $ex) {
            throw $ex;
        }

        return null;
    }

    public function add(Career $career): bool
    {
        $sql = "INSERT INTO careers (description, active) VALUES (:description, :active)";

        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($sql, [
                'description' => $career->getDescription(),
                'active'      => $career->getActive()
            ]);
            return true;
        } catch (PDOException $ex) {
            throw $ex;
        }
    }
}
