<?php

namespace Controllers;

    use Models\User as User;
    use Controllers\StudentController as StudentController;
    use Models\Student as Student;
    use DAO\StudentDAO as StudentDAO;
    use DAO\CareerDAO as CareerDAO;
    use Models\Career as Career;
    use Models\UserCompany as UserCompany;
    use DAO\UserCompanyDAO as UserCompanyDAO;

class HomeController

{

        private $studentDAO;
        private $student;
        private $careerDAO;
        private $career;
        private $userCompany;
        private $userCompanyDAO;

        public function __construct()
        {
            $this->studentDAO =new StudentDAO;    
            $this->student = new Student();
             $this->careerDAO = new CareerDAO();
             $this->career = new Career();
             $this->userCompany = new UserCompany();
             $this->userCompanyDAO = new UserCompanyDAO();
        }



    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "login.php");
    }

    public function menuAdmin()
    {

        require_once(ADMIN_VIEWS . "menu-admin.php");
    }

    public function menuStudent()
     {

        require_once(STUDENT_VIEWS . "menu-student.php");
        }
   
        public function login($email, $password){
            $this->student = $this->studentDAO->getLoginStudent($email);
            $this->userCompany = $this->userCompanyDAO->getUserCompanyByEmail($email);
            if(($email == 'user@hot.com') && ($password == 'C1234har')){

                $user = new User($email);
                $user= new User($password);
                $_SESSION['admin'] = $user;
                require_once(ADMIN_VIEWS."menu-admin.php");
            } else if($this->student !=null){
                //var_dump($this->student);
                //die;
                if(($this->student->getEmail() == $email) && ($password == $this->student->getPassword())){
                    $this->career = $this->careerDAO->GetCareerById($this->student->getCareerId());
                    $_SESSION['student'] = $this->student;
                    require_once(STUDENT_VIEWS."student-profile.php");
                } 
            }else if($this->userCompany != null){
                    if(($this->userCompany->getEmail() == $email) && ($password == $this->userCompany->getPassword())){
                    
                    $_SESSION['userCompany'] = $this->userCompany;
                    require_once(USERCOMPANY_VIEWS."usercompany-profile.php");
                } 

            }else{
                $invalidEmail = true;
                require_once(VIEWS_PATH ."login.php");
            }
        }
    

    public function RedirectAdm()
    {
        require_once(VIEWS_PATH . "admin-view.php");
    }

    public function Logout()
    {
        session_destroy();

        $this->Index();
    }
}
