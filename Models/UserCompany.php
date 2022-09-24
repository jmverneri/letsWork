<?php 

namespace Models;

class UserCompany{

    private $userCompanyId;
    private $email;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $dni;
    private $password;

    public function __construct()
    {
        
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;

    }
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;

    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
 
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

 
    public function getUserCompanyId()
    {
        return $this->userCompanyId;
    }

 
    public function setUserCompanyId($userCompanyId)
    {
        $this->userCompanyId = $userCompanyId;

        return $this;
    }
}?>