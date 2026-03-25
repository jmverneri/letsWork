<?php
    namespace Models;

class Notification {
    private $notificationId;
    private $studentId;
    private $jobOfferId;
    private $message;
    private $isRead;
    private $createdAt;

    /**
     * Get the value of notificationId
     */ 
    public function getNotificationId() {
        return $this->notificationId;
    }

    /**
     * Set the value of notificationId
     */ 
    public function setNotificationId($notificationId) {
        $this->notificationId = $notificationId;
        return $this;
    }

    /**
     * Get the value of studentId
     */ 
    public function getStudentId() {
        return $this->studentId;
    }

    /**
     * Set the value of studentId
     */ 
    public function setStudentId($studentId) {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * Get the value of jobOfferId
     */ 
    public function getJobOfferId() {
        return $this->jobOfferId;
    }

    /**
     * Set the value of jobOfferId
     */ 
    public function setJobOfferId($jobOfferId) {
        $this->jobOfferId = $jobOfferId;
        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage() {
        return $this->message;
    }

    /**
     * Set the value of message
     */ 
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * Get the value of isRead
     */ 
    public function getIsRead() {
        return $this->isRead;
    }

    /**
     * Set the value of isRead
     */ 
    public function setIsRead($isRead) {
        $this->isRead = $isRead;
        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */ 
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }
}
?>