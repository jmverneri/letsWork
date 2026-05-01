<?php
namespace Models;

class Interview {
    private $interviewId;
    private $studentId;
    private $jobOfferId;
    private $interviewDate;
    private $status;

    public function __construct($interviewId = null, $studentId = null, $jobOfferId = null, $interviewDate = null, $status = null) {
        $this->interviewId = $interviewId;
        $this->studentId = $studentId;
        $this->jobOfferId = $jobOfferId;
        $this->interviewDate = $interviewDate;
        $this->status = $status;
    }

    // Getters
    public function getInterviewId() { return $this->interviewId; }
    public function getStudentId() { return $this->studentId; }
    public function getJobOfferId() { return $this->jobOfferId; }
    public function getInterviewDate() { return $this->interviewDate; }
    public function getStatus() { return $this->status; }

    // Setters
    public function setInterviewId($interviewId) { $this->interviewId = $interviewId; }
    public function setStudentId($studentId) { $this->studentId = $studentId; }
    public function setJobOfferId($jobOfferId) { $this->jobOfferId = $jobOfferId; }
    public function setInterviewDate($interviewDate) { $this->interviewDate = $interviewDate; }
    public function setStatus($status) { $this->status = $status; }
}