<?php


namespace Controllers;

use Models\UserCompany as UserCompany;
use DAO\UserCompanyDAO as UserCompanyDAO;
use DAO\CompanyDAO as CompanyDAO;
use Models\Company as Company;
use Utils\Utils;

class UserCompanyController
{

    private $userCompany;
    private $userCompanyDAO;

    public function __construct()
    {
        $this->userCompany = new UserCompany();
        $this->userCompanyDAO = new UserCompanyDAO();
    }

    public function userCompanyMenu(){
        require_once(USERCOMPANY_VIEWS . "menu-usercompany.php");
    }


    //Ver esta funcion porque tendria que traer los datos de la empresa
    public function userCompanyProfile(){

        
        require_once(USERCOMPANY_VIEWS . "usercompany-profile.php");
    }


    public function ShowUserCompanyRegistrationView()
    {

        require_once(USERCOMPANY_VIEWS . "usercompany-register.php");
    }

    public function ShowUserCompanyProfile($email)
    {
        $this->userCompany = $this->userCompanyDAO->getUserCompanyByEmail($email);
        require_once(USERCOMPANY_VIEWS . "usercompany-profile.php");
    }

    public function userCompanyRegistration($firstName, $lastName, $dni, $email, $phoneNumber, $password, $confirmPassword)
    {

        $userCompany = new UserCompany();
        if ($password == $confirmPassword) {
            $userCompany->setFirstName($firstName);
            $userCompany->setLastName($lastName);
            $userCompany->setDni($dni);
            $userCompany->setEmail($email);
            $userCompany->setPhoneNumber($phoneNumber);
            $userCompany->setPassword($password);

            $this->userCompanyDAO->AddUserCompany($userCompany);
            $this->ShowUserCompanyProfile($email);

        } else {
            echo "Confirmo mal el password";
            $this->ShowUserCompanyRegistrationView();
        }

    }
}
