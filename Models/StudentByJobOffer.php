<?php

    namespace Models;

    class StudentByJobOffer{
        private $studentByJobOfferId;
        private $jobOfferId;
        private $studentId;

        public function __construct()
        {
                
        }

        /**
         * Get the value of studentByJobOfferId
         */ 
        public function getStudentByJobOfferId()
        {
                return $this->studentByJobOfferId;
        }

        /**
         * Set the value of studentByJobOfferId
         *
         * @return  self
         */ 
        public function setStudentByJobOfferId($studentByJobOfferId)
        {
                $this->studentByJobOfferId = $studentByJobOfferId;

                return $this;
        }

        /**
         * Get the value of jobOfferId
         */ 
        public function getJobOfferId()
        {
                return $this->jobOfferId;
        }

        /**
         * Set the value of jobOfferId
         *
         * @return  self
         */ 
        public function setJobOfferId($jobOfferId)
        {
                $this->jobOfferId = $jobOfferId;

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
    }

?>