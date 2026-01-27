<?php
        namespace Models;

        class JobOffer
        {
                private $jobOfferId;
                private $title;
                private $description;
                private $salary;
                private $startDate;
                private $deadline;
                private $status; // draft | published | closed

                private $companyId;
                private $careerId;
                private $jobPositionId;

                private ?string $careerName = null;
                private ?string $companyName = null;

                public function getJobOfferId()
                {
                        return $this->jobOfferId;
                }

                public function setJobOfferId($jobOfferId)
                {
                        $this->jobOfferId = $jobOfferId;
                        return $this;
                }

                public function getTitle()
                {
                        return $this->title;
                }

                public function setTitle($title)
                {
                        $this->title = $title;
                        return $this;
                }

                public function getDescription()
                {
                        return $this->description;
                }

                public function setDescription($description)
                {
                        $this->description = $description;
                        return $this;
                }

                public function getSalary()
                {
                        return $this->salary;
                }

                public function setSalary($salary)
                {
                        $this->salary = $salary;
                        return $this;
                }

                public function getStartDate()
                {
                        return $this->startDate;
                }

                public function setStartDate($startDate)
                {
                        $this->startDate = $startDate;
                        return $this;
                }

                public function getDeadline()
                {
                        return $this->deadline;
                }

                public function setDeadline($deadline)
                {
                        $this->deadline = $deadline;
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

                public function getCompanyId()
                {
                        return $this->companyId;
                }

                public function setCompanyId($companyId)
                {
                        $this->companyId = $companyId;
                        return $this;
                }

                public function getCareerId()
                {
                        return $this->careerId;
                }

                public function setCareerId($careerId)
                {
                        $this->careerId = $careerId;
                        return $this;
                }

                public function getJobPositionId()
                {
                        return $this->jobPositionId;
                }

                public function setJobPositionId($jobPositionId)
                {
                        $this->jobPositionId = $jobPositionId;
                        return $this;
                }

                public function setCareerName(?string $name): void
                {
                        $this->careerName = $name;
                }

                public function getCareerName(): string
                {
                        return $this->careerName ?? 'N/A';
                }

                public function setCompanyName(?string $name): void
                {
                        $this->companyName = $name;
                }

                public function getCompanyName(): string
                {
                        return $this->companyName ?? 'N/A';
                }
        }
?>