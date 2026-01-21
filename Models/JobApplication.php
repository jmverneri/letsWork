<?php
        namespace Models;

        class JobApplication
        {
                private $id;
                private $studentId;
                private $jobOfferId;
                private $appliedAt;
                private $status; // applied | reviewed | accepted | rejected
                private $notes;

                const STATUS_APPLIED  = 'applied';
                const STATUS_ACCEPTED = 'accepted';
                const STATUS_REJECTED = 'rejected';

                public function getId()
                {
                        return $this->id;
                }

                public function setId($id)
                {
                        $this->id = $id;
                        return $this;
                }

                public function getStudentId()
                {
                        return $this->studentId;
                }

                public function setStudentId($studentId)
                {
                        $this->studentId = $studentId;
                        return $this;
                }

                public function getJobOfferId()
                {
                        return $this->jobOfferId;
                }

                public function setJobOfferId($jobOfferId)
                {
                        $this->jobOfferId = $jobOfferId;
                        return $this;
                }

                public function getAppliedAt()
                {
                        return $this->appliedAt;
                }

                public function setAppliedAt($appliedAt)
                {
                        $this->appliedAt = $appliedAt;
                        return $this;
                }

                public function getStatus()
                {
                        return $this->status;
                }

                public function setStatus($status)
                {
                        $this->status = $status;
                        return $this;
                }

                public function getNotes()
                {
                        return $this->notes;
                }

                public function setNotes($notes)
                {
                        $this->notes = $notes;
                        return $this;
                }
        }
?>