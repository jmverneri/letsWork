<?php
namespace DAO;

use \Exception;
use Models\User as User;
use DAO\Connection as Connection;

class UserDAOMySQL
{
    private $connection;
    private $tableName = "users";

    public function __construct($connection = null) {
            $this->connection = $connection ?? Connection::GetInstance();
        }

    public function getByEmail(string $email): ?User 
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
            $parameters["email"] = $email;

            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                return $this->map($resultSet[0]);
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getById(int $userId): ?User
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE userId = :userId";
            $parameters["userId"] = $userId;

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
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $userList[] = $this->map($row);
            }
            return $userList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Mapea el resultado de la DB a un objeto User
     */
    private function map($row)
    {
        $user = new User();
        $user->setUserId($row["userId"]);
        $user->setEmail($row["email"]);
        $user->setPassword($row["password"]);
        $user->setRole($row["role"]);
        $user->setActive((bool)$row["active"]);

        if(isset($row["mustChangePassword"])) {
            $user->setMustChangePassword((bool)$row["mustChangePassword"]);
        }

        return $user;
    }
    public function add(User $user)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (email, password, role, active) VALUES (:email, :password, :role, :active);";

            $parameters["email"] = $user->getEmail();
            $parameters["password"] = $user->getPassword();
            $parameters["role"] = $user->getRole();
            $parameters["active"] = $user->getActive() ? 1 : 0;

            // 1. Ejecutamos la inserción
            $this->connection->ExecuteNonQuery($query, $parameters);

            // 2. Obtenemos el ID usando Execute (que existe en tu Connection)
            // Esto evita el error de "getLastId() undefined"
            $queryId = "SELECT LAST_INSERT_ID() as id";
            $resultSet = $this->connection->Execute($queryId);

            // Retornamos el ID para que el Repository lo use (igual que en Student)
            return $resultSet[0]["id"];

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function update(User $user)
    {
        try {
            // Solo actualizamos el email y el estado (el password suele ir por otro lado)
            $query = "UPDATE " . $this->tableName . " SET 
                email = :email, 
                active = :active 
                WHERE userId = :userId;";

            $parameters["email"] = $user->getEmail();
            $parameters["active"] = $user->getActive() ? 1 : 0;
            $parameters["userId"] = $user->getUserId();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function delete(int $userId)
    {
        try {
            $query = "UPDATE " . $this->tableName . " 
                  SET active = 0 
                  WHERE userId = :userId AND role = 'admin'";
            $parameters["userId"] = $userId;

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function activate(int $userId)
    {
        try {
            $query = "UPDATE " . $this->tableName . " 
                    SET active = 1 
                    WHERE userId = :userId AND role = 'admin'";

            $parameters["userId"] = $userId;
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function UpdatePassword($email, $password) {
        $query = "UPDATE users SET password = :password, mustChangePassword = 1 WHERE email = :email";
        $parameters["email"] = $email;
        $parameters["password"] = $password;

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function UpdatePasswordAndClearFlag($email, $password)
    {
        $query = "UPDATE users SET password = :password, mustChangePassword = 0 WHERE email = :email";

        $parameters["password"] = $password;
        $parameters["email"] = $email;

        try {
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function setResetToken($email, $token, $expires)
    {
        try {
            $query = "UPDATE users SET reset_token = :token, token_expires = :expires WHERE email = :email";
            
            $parameters["token"] = $token;
            $parameters["expires"] = $expires;
            $parameters["email"] = $email;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getUserByToken($token)
    {
        try {
            // Buscamos el usuario donde el token coincida Y la fecha actual sea menor a la de expiración
            $query = "SELECT * FROM users WHERE reset_token = :token AND token_expires > NOW()";
            $parameters["token"] = $token;

            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                // Mapeás el resultado a tu objeto User (como ya hacés en el Login)
                return $this->map($resultSet[0]); 
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updatePasswordAndResetToken($userId, $password)
    {
        try {
            // Actualizamos la pass y limpiamos el token de una sola vez
            $query = "UPDATE " . $this->tableName . " 
                      SET password = :password, 
                          reset_token = NULL, 
                          token_expires = NULL 
                      WHERE userId = :userId";

            $parameters["password"] = $password;
            $parameters["userId"] = $userId;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}