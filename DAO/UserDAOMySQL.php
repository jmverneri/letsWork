<?php
namespace DAO;

use \Exception;
use DAO\IUserDAO as IUserDAO;
use Models\User as User;
use DAO\Connection as Connection;

class UserDAOMySQL implements IUserDAO
{
    private $connection;
    private $tableName = "users";

    public function add(User $user)
    {
        try {
            $query = "INSERT INTO users (email, password, role, active) VALUES (:email, :password, :role, :active);";

            $parameters["email"] = $user->getEmail();
            $parameters["password"] = $user->getPassword();
            $parameters["role"] = $user->getRole();
            $parameters["active"] = $user->getActive() ? 1 : 0;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);

            // Esto es clave: le pedimos a la conexión el ID que acaba de crear
            return $this->connection->lastInsertId(); 
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // El "string" antes de $email y el ": ?User" al final son obligatorios
    public function getByEmail(string $email): ?User 
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
            $parameters["email"] = $email;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                return $this->map($resultSet[0]);
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getAll(): array
    {
        try {
            $userList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $userList[] = $this->map($row);
            }
            return $userList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function map($row)
    {
        $user = new User();
        $user->setUserId($row["userId"]);
        $user->setEmail($row["email"]);
        $user->setPassword($row["password"]);
        $user->setRole($row["role"]);
        $user->setActive($row["active"]);

        return $user;
    }

    public function getById(int $userId): ?User
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE userId = :userId";
            $parameters["userId"] = $userId;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                return $this->map($resultSet[0]);
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}