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

    public function __construct()
    {
        $this->connection = Connection::GetInstance();
    }

    /**
     * Inserta un usuario y retorna el ID generado por la base de datos
     */
    public function getAndSyncByEmail($email) {
        // 1. Buscamos localmente
        $student = $this->userDAO->getByEmail($email);

        if (!$student) {
            // 2. Buscamos en la API de Python
            $data = $this->api->getByEmail($email);

            if ($data) {
                // --- PASO A: Crear el Objeto User y guardarlo ---
                $user = new \Models\User();
                $user->setEmail($data['email']);
                $user->setPassword(password_hash($data['dni'], PASSWORD_DEFAULT));
                $user->setRole("student");
                $user->setActive(true);

                // Guardamos el usuario y obtenemos su ID automático
                $userId = $this->userDAO->add($user); 

                // --- PASO B: Crear el Objeto Student ---
                $newStudent = new \Models\Student();
                $newStudent->setUserId($userId); // El cruce de tablas
                $newStudent->setFirstName($data['firstName']);
                $newStudent->setLastName($data['lastName']);
                $newStudent->setDni($data['dni']);
                $newStudent->setFileNumber($data['fileNumber']);
                $newStudent->setGender($data['gender']);
                $newStudent->setBirthDate($data['birthDate']);
                $newStudent->setPhoneNumber($data['phoneNumber']);
                $newStudent->setCareerId($data['careerId']);
                $newStudent->setActive(true);

                // --- PASO C: Guardar el Student en MySQL ---
                $this->db->add($newStudent);

                $student = $newStudent;
            }
        }
        return $student;
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
}