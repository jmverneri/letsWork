<?php
    namespace Models;

    class JobPosition
    {
       private $jobPositionId;
       private $careerId;
       private $description;

       public function __construct()
       {
           
       }

       public function setDescription($description){
            $this->description = $description;
       }

       public function getDescription(){
           return $this->description;
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