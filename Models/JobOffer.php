<?php
    namespace Models;
        use Models\JobPosition as JobPosition;
    class JobOffer{
        private $jobOfferId;
        private $name;
        private $startDay;
        private $deadLine;
        private $active;
        private $description;
        private $salary;
        private $companyId;
        private $studentId;
        private $careerId;
        private $jobPositionId;
        
        public function __construct()
        {
                
        }
            

        /**
         * Get the value of jobOfferId
         */ 
        public function getJobOfferId()
        {
                return $this->jobOfferId;
        }

        public function setJobOfferId($jobOfferId)
        {
                $this->jobOfferId = $jobOfferId;

                return $this;
        }

        /**
         * Get the value of startDay
         */ 
        public function getStartDay()
        {
                return $this->startDay;
        }

        /**
         * Set the value of startDay
         *
         * @return  self
         */ 
        public function setStartDay($startDay)
        {
                $this->startDay = $startDay;

                return $this;
        }

        /**
         * Get the value of deadLine
         */ 
        public function getDeadLine()
        {
                return $this->deadLine;
        }

        /**
         * Set the value of deadLine
         *
         * @return  self
         */ 
        public function setDeadLine($deadLine)
        {
                $this->deadLine = $deadLine;

                return $this;
        }

        /**
         * Get the value of active
         */ 
        public function getActive()
        {
                return $this->active;
        }

        /**
         * Set the value of active
         *
         * @return  self
         */ 
        public function setActive($active)
        {
                $this->active = $active;

                return $this;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of salary
         */ 
        public function getSalary()
        {
                return $this->salary;
        }

        /**
         * Set the value of salary
         *
         * @return  self
         */ 
        public function setSalary($salary)
        {
                $this->salary = $salary;

                return $this;
        }

        /**
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

        /**
         * Set the value of name
         *
         * @return  self
         */ 
        public function setName($name)
        {
                $this->name = $name;

                return $this;
        }
   

        /**
         * Get the value of companyId
         */ 
        public function getCompanyId()
        {
                return $this->companyId;
        }

        /**
         * Set the value of companyId
         *
         * @return  self
         */ 
        public function setCompanyId($companyId)
        {
                $this->companyId = $companyId;

                return $this;
        }

        /**
         * Get the value of studentId
         */ 
        public function getStudentId()
        {
                return $this->studentId;
        }

        /**
         * Set the value of studentId
         *
         * @return  self
         */ 
        public function setStudentId($studentId)
        {
                $this->studentId = $studentId;

                return $this;
        }

        /**
         * Get the value of careerId
         */ 
        public function getCareerId()
        {
                return $this->careerId;
        }

        /**
         * Set the value of careerId
         *
         * @return  self
         */ 
        public function setCareerId($careerId)
        {
                $this->careerId = $careerId;

                return $this;
        }

        /**
         * Get the value of jobPositionId
         */ 
        public function getJobPositionId()
        {
                return $this->jobPositionId;
        }

        /**
         * Set the value of jobPositionId
         *
         * @return  self
         */ 
        public function setJobPositionId($jobPositionId)
        {
                $this->jobPositionId = $jobPositionId;

                return $this;
        }
}
?>