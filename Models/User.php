<?php 

namespace Models;

class User{

    private $email;
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
}?>