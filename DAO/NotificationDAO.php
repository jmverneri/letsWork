<?php
namespace DAO;

use DAO\Connection as Connection;
use Models\Notification;

class NotificationDAO {
    private $connection;
    private $tableName = "notifications";

    public function __construct($connection = null) {
        $this->connection = $connection ?? Connection::GetInstance();
    }

    public function create($studentId, $jobOfferId, $message) {
        $query = "INSERT INTO notifications (studentId, jobOfferId, message) VALUES (:studentId, :jobOfferId, :message)";
        $parameters["studentId"] = $studentId;
        $parameters["jobOfferId"] = $jobOfferId;
        $parameters["message"] = $message;
        $this->connection->ExecuteNonQuery($query, $parameters);
    }

    public function getByStudent($studentId) {
        $query = "SELECT * FROM notifications WHERE studentId = :studentId ORDER BY created_at DESC";
        $parameters["studentId"] = $studentId;
        return $this->connection->Execute($query, $parameters);
    }

    public function getUnreadByStudent($studentId) {
        $notificationList = array();    
        try {
            $query = "SELECT * FROM " . $this->tableName . " 
                      WHERE studentId = :studentId 
                      AND is_read = 0 
                      ORDER BY created_at DESC";

            $parameters["studentId"] = $studentId;

            $resultSet = $this->connection->Execute($query, $parameters);

            if(!empty($resultSet) && is_array($resultSet)) {
                foreach ($resultSet as $row) {
                    $notification = new Notification();
                    $notification->setNotificationId($row["notificationId"]);
                    $notification->setStudentId($row["studentId"]);
                    $notification->setJobOfferId($row["jobOfferId"]);
                    $notification->setMessage($row["message"]);
                    $notification->setIsRead($row["is_read"]);

                array_push($notificationList, $notification);
                }
            }

            return $notificationList;

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function markAsRead($studentId, $jobOfferId)
    {
        try {
            $query = "UPDATE " . $this->tableName . " 
                  SET is_read = 1 
                  WHERE studentId = :studentId AND jobOfferId = :jobOfferId AND is_read = 0";
            
            $parameters["studentId"] = $studentId;
            $parameters["jobOfferId"] = $jobOfferId;

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function getAllByStudent($studentId) {
        $notificationList = array();    
        try {
            // Aquí NO filtramos por is_read = 0, traemos TODO
            $query = "SELECT * FROM " . $this->tableName . " 
                    WHERE studentId = :studentId 
                    ORDER BY notificationId DESC"; 

            $parameters["studentId"] = $studentId;
            $resultSet = $this->connection->Execute($query, $parameters);

            if(!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    $notification = new \Models\Notification();
                    $notification->setNotificationId($row["notificationId"]);
                    $notification->setStudentId($row["studentId"]);
                    $notification->setJobOfferId($row["jobOfferId"]);
                    $notification->setMessage($row["message"]);
                    $notification->setIsRead($row["is_read"]);
                    array_push($notificationList, $notification);
                }
            }
            return $notificationList;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}