<?php
    namespace DAO;

    use \Exception;
    use DAO\IStudentDAO as IStudentDAO;
    use Models\Student as Student;
    use DAO\Connection as Connection;

    class StudentDAOMySQL implements IStudentDAO
    {
        private $connection;
        private $tableName = "students";

        public function add(Student $student)
        {
            try {
                $query = "INSERT INTO " . $this->tableName . " 
                    (careerId, firstName, lastName, dni, fileNumber, gender, birthDate, phoneNumber, active, userId) 
                    VALUES (:careerId, :firstName, :lastName, :dni, :fileNumber, :gender, :birthDate, :phoneNumber, :active, :userId);";

                $parameters["careerId"] = $student->getCareerId();
                $parameters["firstName"] = $student->getFirstName();
                $parameters["lastName"] = $student->getLastName();
                $parameters["dni"] = $student->getDni();
                $parameters["fileNumber"] = $student->getFileNumber();
                $parameters["gender"] = $student->getGender();
                $parameters["birthDate"] = $student->getBirthDate();
                $parameters["phoneNumber"] = $student->getPhoneNumber();
                $parameters["active"] = $student->isActive() ? 1 : 0;
                $parameters["userId"] = $student->getUserId();

                $this->connection = Connection::GetInstance();

                return $this->connection->ExecuteNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getAll()
        {
            try {
                $studentList = array();
                $query = "SELECT * FROM " . $this->tableName;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                foreach ($resultSet as $row) {
                    $studentList[] = $this->map($row);
                }

                return $studentList;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getById($id)
        {
            try {
                $query = "SELECT * FROM " . $this->tableName . " WHERE studentId = :studentId";
                $parameters["studentId"] = $id;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);

                return (!empty($resultSet)) ? $this->map($resultSet[0]) : null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getByEmail($email)
        {
            try {
                $query = "SELECT * FROM " . $this->tableName . " WHERE email = :email";
                $parameters["email"] = $email;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);

                return (!empty($resultSet)) ? $this->map($resultSet[0]) : null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function getByUserId($userId) : ?\Models\Student
        {
            try {
                // Hacemos un INNER JOIN para traer el email que está en la tabla users
                $query = "SELECT s.*, u.email 
                FROM " . $this->tableName . " s
                INNER JOIN users u ON s.userId = u.userId
                WHERE s.userId = :userId";

                $parameters["userId"] = $userId;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query, $parameters);

                foreach ($resultSet as $row) {
                    $student = new \Models\Student();
                    $student->setStudentId($row["studentId"]);
                    $student->setFirstName($row["firstName"]);
                    $student->setLastName($row["lastName"]);
                    $student->setDni($row["dni"]);
                    $student->setFileNumber($row["fileNumber"]);
                    $student->setGender($row["gender"]);
                    $student->setBirthDate($row["birthDate"]);
                    $student->setPhoneNumber($row["phoneNumber"]);
                    $student->setActive($row["active"]);
                    $student->setUserId($row["userId"]);

                    $student->setCareerId($row["careerId"] ?? null);

                    return $student;
                }
                return null;
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        public function update(Student $student)
        {
            try {
                $query = "UPDATE " . $this->tableName . " SET 
                    careerId = :careerId, 
                    firstName = :firstName, 
                    lastName = :lastName, 
                    dni = :dni, 
                    fileNumber = :fileNumber, 
                    gender = :gender, 
                    birthDate = :birthDate, 
                    email = :email, 
                    phoneNumber = :phoneNumber, 
                    active = :active, 
                    userId = :userId 
                    WHERE studentId = :studentId;";

                $parameters["careerId"] = $student->getCareerId();
                $parameters["firstName"] = $student->getFirstName();
                $parameters["lastName"] = $student->getLastName();
                $parameters["dni"] = $student->getDni();
                $parameters["fileNumber"] = $student->getFileNumber();
                $parameters["gender"] = $student->getGender();
                $parameters["birthDate"] = $student->getBirthDate();
                $parameters["email"] = $student->getEmail();
                $parameters["phoneNumber"] = $student->getPhoneNumber();
                $parameters["active"] = $student->getActive() ? 1 : 0;
                $parameters["userId"] = $student->getUserId();
                $parameters["studentId"] = $student->getStudentId();

                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        private function map($row)
        {
            $student = new Student();
            $student->setStudentId($row["studentId"]);
            $student->setCareerId($row["careerId"]);
            $student->setFirstName($row["firstName"]);
            $student->setLastName($row["lastName"]);
            $student->setDni($row["dni"]);
            $student->setFileNumber($row["fileNumber"]);
            $student->setGender($row["gender"]);
            $student->setBirthDate($row["birthDate"]);
            $student->setPhoneNumber($row["phoneNumber"]);
            $student->setActive($row["active"]);
            $student->setUserId($row["userId"] ?? null);

            return $student;
        }
    }