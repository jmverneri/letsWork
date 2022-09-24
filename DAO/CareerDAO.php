<?php

    namespace DAO;

    use Models\Career as Career;
    use DAO\ICareerDAO as ICareerDAO;
    use Models\Student as Student;

    class CareerDAO implements ICareerDAO{

        private $careerList = array();

        public function __construct(){
            
        }


        public function GetAll(){
            
            $sql = "SELECT * FROM careers WHERE active=:active";
            $parameters['active']=1;

            try {
                $this->connection = Connection::getInstance();
                $this->careerList = $this->connection->execute($sql,$parameters);
            } catch (\PDOException $exeption) {
                throw $exeption;
            }
    
            if (!empty($this->careerList)) {
                return $this->retrieveData();
            } else {
                return false;
            }

        }

        public function GetAllWhitInactives(){
            
            $sql = "SELECT * FROM careers";
            
            try {
                $this->connection = Connection::getInstance();
                $this->careerList = $this->connection->execute($sql);
            } catch (\PDOException $exeption) {
                throw $exeption;
            }
    
            if (!empty($this->careerList)) {
                return $this->retrieveData();
            } else {
                return false;
            }

        }

        public function Delete(Career $careerToDelete){

        }

        private function consumeFromApi(){
         
            $this->careerList = array();

            $options = array(
                'http' => array(
                'method'=>"GET",
                'header'=>"x-api-key: " . API_KEY)
            );

            $context = stream_context_create($options);

            $response = file_get_contents(API_URL .'Career', false, $context);

            $arrayToDecode = json_decode($response, true);
          
          foreach($arrayToDecode as $valuesArray){
            $career = new Career();
            $career->setCareerId($valuesArray['careerId']);
            $career->setDescription($valuesArray['description']);
            $career->setActive($valuesArray['active']);

            array_push($this->careerList, $career);

          }

        }

      public function GetAllActive(){
            $this->consumeFromApi();
            return array_filter(
                $this->careerList,
                fn($activeCareer) => $activeCareer->getActive() == true
             );

        }

        public function GetCareerById($careerId){
            //var_dump($careerId);
            //die;
              $sql = "SELECT * FROM careers WHERE careerId=".$careerId;
            //$parameters['careerId']=$careerId;

            try {
                $this->connection = Connection::getInstance();
                $this->careerList = $this->connection->execute($sql);
            } catch (\PDOException $exeption) {
                throw $exeption;
            }
           //var_dump($this->careerList);
            //die;
            if (!empty($this->careerList)) {
                return $this->retrieveOneCareerData();
            } else {
                return false;
            }
        }


        public function GetJobOffersByIdB($careerId){
            $this->consumeFromApi();

            foreach ($this->careerList as $career) {
                if ($career->getCareerId() == $careerId){
                    return $career;
                }
            }
            return null;
        }


    public function getCareerStudent(Student $student){
        $this->consumeFromApi();
            foreach($this->careerList as $career){
                if($student->getCareerId() == $career->getCareerId())
                return $career;
            }
        
    }

    

    private function retrieveData()
    {
        $listToReturn = array();

        foreach ($this->careerList as $values) {
            $career = new Career();
            $career->setCareerId($values['careerId']);
            $career->setDescription($values['description']);
            $career->setActive($values['active']);
                     
            array_push($listToReturn, $career);
        }
        return  $listToReturn;
    }

    
    private function retrieveOneCareerData()
    {
        foreach ($this->careerList as $values) {
            $career = new Career();
            $career->setCareerId($values['careerId']);
            $career->setDescription($values['description']);
            $career->setActive($values['active']);
        }
        return  $career;
    }



}


?> 