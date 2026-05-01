<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;
use Models\Subject as Subject;

class SubjectDAO
{
    private $connection;
    private $tableName = "subjects";

    public function __construct($connection = null) {
            $this->connection = $connection ?? Connection::GetInstance();
        }

    public function getByCareer($careerId)
    {
        try {
            $subjectList = array();
            $query = "SELECT * FROM " . $this->tableName . " WHERE careerId = :careerId";
            $parameters["careerId"] = $careerId;

            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $subject = new Subject();
                    $subject->setSubjectId($row["subjectId"]);
                    $subject->setCareerId($row["careerId"]);
                    $subject->setAsignatura($row["asignatura"]);
                    $subject->setCursado($row["cursado"]);
                    $subject->setHsSemanales($row["hsSemanales"]);
                    $subject->setCargaHorariaTotal($row["cargaHorariaTotal"]);
                    $subject->setCreditos($row["creditos"]);
                    $subject->setActive($row["active"]);

                    array_push($subjectList, $subject);
                }
            }
            return $subjectList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getAll() {
        try {
            $subjectList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $subject = new Subject();
                $subject->setSubjectId($row["subjectId"]);
                $subject->setCareerId($row["careerId"]);
                $subject->setAsignatura($row["asignatura"]);
                $subject->setCursado($row["cursado"]);
                $subject->setHsSemanales($row["hsSemanales"]);
                $subject->setCargaHorariaTotal($row["cargaHorariaTotal"]);
                $subject->setCreditos($row["creditos"]);
                $subject->setActive($row["active"]);
                array_push($subjectList, $subject);
            }
            return $subjectList;
        } catch (\Exception $ex) { throw $ex; }
    }

    public function add(Subject $subject) {
        try {
            // Corregido: Agregamos 'active' a la lista de columnas
            $query = "INSERT INTO " . $this->tableName . " (careerId, asignatura, cursado, hsSemanales, cargaHorariaTotal, creditos, active) 
                    VALUES (:careerId, :asignatura, :cursado, :hsSemanales, :cargaHorariaTotal, :creditos, :active);";

            $parameters["careerId"] = $subject->getCareerId();
            $parameters["asignatura"] = $subject->getAsignatura();
            $parameters["cursado"] = $subject->getCursado();
            $parameters["hsSemanales"] = $subject->getHsSemanales();
            $parameters["cargaHorariaTotal"] = $subject->getCargaHorariaTotal();
            $parameters["creditos"] = $subject->getCreditos();
            $parameters["active"] = $subject->getActive() ? 1 : 0; // Casteo a int para la DB

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) { throw $ex; }
    }

    public function getApprovedByStudent($studentId) {
        try {
            $subjectList = array();
            // Usamos un JOIN para cruzar las tablas
            $query = "SELECT s.* FROM " . $this->tableName . " s 
                    INNER JOIN student_subjects ss ON s.subjectId = ss.subjectId 
                    WHERE ss.studentId = :studentId";
            
            $parameters["studentId"] = $studentId;

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $subject = new Subject();
                $subject->setSubjectId($row["subjectId"]);
                $subject->setCareerId($row["careerId"]);
                $subject->setAsignatura($row["asignatura"]);
                $subject->setCursado($row["cursado"]);
                $subject->setHsSemanales($row["hsSemanales"]);
                $subject->setCargaHorariaTotal($row["cargaHorariaTotal"]);
                $subject->setCreditos($row["creditos"]);
                $subject->setActive($row["active"]);
                array_push($subjectList, $subject);
            }
            return $subjectList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function addApprovedSubject($studentId, $subjectId)
    {
        try {
            $query = "INSERT INTO student_subjects (studentId, subjectId) VALUES (:studentId, :subjectId)";
            
            $parameters["studentId"] = $studentId;
            $parameters["subjectId"] = $subjectId;

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex; // El Controller atrapará si el alumno ya tiene esa materia (Duplicate entry)
        }
    }

    public function getById($subjectId)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE subjectId = :subjectId";
            $parameters["subjectId"] = $subjectId;

            $resultSet = $this->connection->Execute($query, $parameters);

            if (!empty($resultSet)) {
                $row = $resultSet[0];
                $subject = new Subject();
                $subject->setSubjectId($row["subjectId"]);
                $subject->setCareerId($row["careerId"]);
                $subject->setAsignatura($row["asignatura"]);
                $subject->setCursado($row["cursado"]);
                $subject->setHsSemanales($row["hsSemanales"]);
                $subject->setCargaHorariaTotal($row["cargaHorariaTotal"]);
                $subject->setCreditos($row["creditos"]);
                $subject->setActive($row["active"]);
                
                return $subject;
            }
            return null;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function update(Subject $subject) {
        try {
            $query = "UPDATE " . $this->tableName . " SET 
                    careerId = :careerId, 
                    asignatura = :asignatura, 
                    cursado = :cursado, 
                    hsSemanales = :hsSemanales, 
                    cargaHorariaTotal = :cargaHorariaTotal, 
                    creditos = :creditos 
                    WHERE subjectId = :subjectId";

            $parameters["careerId"] = $subject->getCareerId();
            $parameters["asignatura"] = $subject->getAsignatura();
            $parameters["cursado"] = $subject->getCursado();
            $parameters["hsSemanales"] = $subject->getHsSemanales();
            $parameters["cargaHorariaTotal"] = $subject->getCargaHorariaTotal();
            $parameters["creditos"] = $subject->getCreditos();
            $parameters["subjectId"] = $subject->getSubjectId();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) { throw $ex; }
    }

    public function delete($subjectId) {
        try {
            // Borrado lógico: cambiamos el estado a 0 (false)
            $query = "UPDATE " . $this->tableName . " SET active = 0 WHERE subjectId = :subjectId";
            
            $parameters["subjectId"] = $subjectId;

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function restore($subjectId) {
        try {
            $query = "UPDATE " . $this->tableName . " SET active = 1 WHERE subjectId = :subjectId";
            $parameters["subjectId"] = $subjectId;

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}