<?php
namespace DAO;

use \Exception as Exception;
use DAO\Connection as Connection;

class StudentPreferenceDAO {
    private $connection;

    public function addPreference($studentId, $jobPositionId) {
        try {
            $query = "INSERT INTO student_preferences (studentId, jobPositionId) VALUES (:studentId, :jobPositionId)";
            
            $parameters = array(); 
            
            $parameters["studentId"] = $studentId;
            $parameters["jobPositionId"] = is_array($jobPositionId) ? $jobPositionId[0] : $jobPositionId;

            $this->connection = Connection::GetInstance();
            
            // 2. Ejecutar
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function clearPreferences($studentId) {
        $query = "DELETE FROM student_preferences WHERE studentId = :studentId";
        $parameters["studentId"] = $studentId;
        $this->connection = Connection::GetInstance();
        $this->connection->ExecuteNonQuery($query, $parameters);
    }

    public function getStudentIdsByPosition($jobPositionId) {
        try {   
            $query = "SELECT studentId FROM student_preferences WHERE jobPositionId = :jobPositionId";
            $parameters = array();
            $parameters["jobPositionId"] = $jobPositionId;
            $this->connection = Connection::GetInstance();
            return $this->connection->Execute($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}