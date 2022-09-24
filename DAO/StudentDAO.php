<?php
    namespace DAO;

    use interfaces\Idaos as IDaos;
    use Models\Student as Student;
    use DAO\IStudentDAO as IStudentDAO;

    use DAO\Connection as Connection;
    use \PDOException as PDOException;


class StudentDAO implements IStudentDAO
    {
        private $connection;
        private $student;
        private $studentBD;
        private $studentList;

        public function __construct()
        {
            $this->student = new Student();
            $this->studentBD = new Student();
            $this->studentList = array();
        } 

        
        public function GetAll()
        {   
           $this->consumeFromApi();
           return $this->studentList;
            
        }

        private function consumeFromApi(){
            $this->studentList = array();

            $options = array(
                'http' => array(
                  'method'=>"GET",
                  'header'=>"x-api-key: " . API_KEY)
           );
    

            $context = stream_context_create($options);

            $response = file_get_contents(API_URL .'Student', false, $context);

           $arrayToDecode = json_decode($response, true);

            foreach($arrayToDecode as $value){
                
                $student = new Student();

                $student->setstudentId($value['studentId']);
                $student->setCareerId($value['careerId']);
                $student->setFirstName($value['firstName']);
                $student->setLastName($value['lastName']);
                $student->setDni($value['dni']);
                $student->setFileNumber($value['fileNumber']);
                $student->setGender($value['gender']);
                $student->setBirthDate($value['birthDate']);
                $student->setEmail($value['email']);
                $student->setPhoneNumber($value['phoneNumber']);
                $student->setActive($value['active']);

                array_push($this->studentList, $student);
            }

        }

        public function getStudentByMail($email)
        {
            $this->consumeFromApi();

            foreach ($this->studentList as $student) {
                if ($student->getEmail() == $email){
                    return $student;
                }
            }
                return null;

        }

        public function getStudentByMailNoApi($email)
        {
            $sql = "SELECT * FROM students WHERE email=:email";
            $parameters['email']=$email;           
            
            try{
                $this->connection = Connection::getInstance();
                $this->studentList =  $this->connection->execute($sql, $parameters);
            }catch(\PDOException $ex){
                throw $ex;
            }
            if (!empty($this->studentBD)) {
                return $this->retrieveOneStudent();
            } else {
                return $this->studentBD;
            }
        }

        public function getStudentById($StudentId)
        {
            $sql = "SELECT * FROM students WHERE studentId=:studentId";
            $parameters['email']=$StudentId;           
            
            try{
                $this->connection = Connection::getInstance();
                $this->studentBD =  $this->connection->execute($sql, $parameters);
                //var_dump($this->studentList);
                //die;
               
            }catch(\PDOException $ex){
                throw $ex;
            }
            if (!empty($this->studentBD)) {
                return $this->retrieveOneStudent();
            } else {
                return $this->studentBD;
            }
        }

       public function Add(Student $student)
        {
            
          $sql = "INSERT INTO students (firstName, lastName, dni, fileNumber, gender, birthDate, phoneNumber, active, password, careerId, email)
                     VALUES (:firstName, :lastName, :dni, :fileNumber, :gender, :birthDate, :phoneNumber, :active, :password, :careerId, :email);";
            $parameters["firstName"]=$student->getFirstName();
            $parameters['lastName']=$student->getLastName();
            $parameters['dni']=$student->getDni();
            $parameters['gender']=$student->getGender();
            $parameters['fileNumber']=$student->getFileNumber();
            $parameters['birthDate']=$student->getBirthDate();
            $parameters['phoneNumber']=$student->getPhoneNumber();
            $parameters['active']=true;
            $parameters['password']=$student->getPassword();
            $parameters['careerId']=$student->getCareerId();
            $parameters['email']=$student->getEmail();
            try {
                $this->connection= Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            } catch (\PDOException $ex) {
                throw $ex;
            }
        }
/*
        public function Delete($idToDelete){

            $sql = "DELETE FROM students WHERE studentId=:studentId";
            $parameters['studentId']=$idToDelete;
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }catch(\PDOException $exeption){
                throw $exeption;
            }

        }

        public function Update($student, $toFind){
            $sql = "UPDATE students set careerId=:careerId, firstName=:firstName, lastName=:lastName, dni=:dni, fileNumber=:fileNumber, 
                     gender=:gender, birthDate=:birthDate, email=:email, phoneNumber=:phoneNumber WHERE studentId= '$toFind';";

            $parameters["firstName"]=$student->getFirstName();
            $parameters['lastName']=$student->getLastName();
            $parameters['dni']=$student->getDni();
            $parameters['gender']=$student->getGender();
            $parameters['birthDate']=$student->getBirthDate();
            $parameters['phoneNumber']=$student->getPhoneNumber();
            $parameters['active']=$student->getActive();

            try{
                $this->connection=Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }catch(\PDOException $exeption){
                throw $exeption;
            }
                     
        }
*/
       public function getLoginStudent($email){
            $sql = "SELECT * FROM students WHERE email=:email";
            $parameters['email']=$email;
            try{
                $this->connection = Connection::getInstance();
                $this->studentBD= $this->connection->execute($sql, $parameters);
                
            }catch(\PDOException $exeption){
                throw $exeption;
            }

            if($this->studentBD != null){
                return $this->retrieveOneStudent();
                //var_dump($student);
                //die;
                //return $this->student;
            }else{
                return false;
            }

        }

        private function retrieveOneStudent()
    {
        foreach ($this->studentBD as $stud) {
            $loginStudent = new Student();
            $loginStudent->setStudentId($stud['studentId']);
            $loginStudent->setCareerId($stud['careerId']);
            $loginStudent->setFirstName($stud['firstName']);
            $loginStudent->setLastName(($stud['lastName']));
            $loginStudent->setDni($stud['dni']);
            $loginStudent->setFileNumber($stud['fileNumber']);
            $loginStudent->setGender($stud['gender']);
            $loginStudent->setBirthDate($stud['birthDate']);
            $loginStudent->setEmail($stud['email']);
            $loginStudent->setPhoneNumber($stud['phoneNumber']);
            $loginStudent->setPassword($stud['password']);
        }
        return $loginStudent;
    }

    

        /*
        private function mapear($studentList){

            $studentList=is_array($studentList)?$studentList:[];

            $studentArray=array_map(function($pos){
                $newStudent = new Student($pos['careerId'],$pos['firstName'],$pos['lastName'],$pos['dni'],$pos['fileNumber'],$pos['gender'],
                                        $pos['birthDate'],$pos['email'],$pos['phoneNumber'],$pos['password']);//crear student
                $newStudent->setstudentId($pos['studentId']);

                return $newStudent;
            }, $studentList);
            return count($studentArray)>=1? $studentArray:$studentArray['0'];
        }*/




       /* private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->studentList as $student)
            {
                $valuesArray["recordId"] = $student->getRecordId();
                $valuesArray["firstName"] = $student->getFirstName();
                $valuesArray["lastName"] = $student->getLastName();

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/students.json', $jsonContent);
        }*/

      /* private function RetrieveData()
        {
            $this->studentList = array();

            if(file_exists('Data/students.json'))
            {
                $jsonContent = file_get_contents('Data/students.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $student = new Student();
                    $student->setRecordId($valuesArray["recordId"]);
                    $student->setFirstName($valuesArray["firstName"]);
                    $student->setLastName($valuesArray["lastName"]);

                    array_push($this->studentList, $student);
                }
            }
        }*/
    }
?>