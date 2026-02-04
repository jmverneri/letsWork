<?php
namespace Repositories;

use DAO\CompanyDAOMySQL as CompanyDAO;
use DAO\UserDAOMySQL as UserDAO; // Usamos el DAO directamente
use Models\Company;
use Models\User;
use Exception;

class CompanyRepository 
{
    private $dao;
    private $userDAO;

    public function __construct() {
        $this->dao = new CompanyDAO();
        $this->userDAO = new UserDAO(); 
    }

    /**
     * IMPORTANTE: Este es el método que necesita el controlador para el email.
     * Asegurate que en tu UserDAOMySQL el método sea GetById o getById.
     */
    public function getUserById($userId) {
        return $this->userDAO->GetById($userId); 
    }

    public function createCompany($data) {
        try {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword(password_hash($data['cuit'], PASSWORD_DEFAULT));
            $user->setRole("company");
            $user->setActive(true);

            // Guardamos usando el DAO de usuario
            $userId = $this->userDAO->add($user);

            if($userId) {
                $company = new Company();
                $company->setUserId($userId);
                $company->setName($data['name']);
                $company->setCuit($data['cuit']);
                $company->setCity($data['city'] ?? null);
                $company->setDescription($data['description'] ?? null);
                $company->setPhoneNumber($data['phoneNumber'] ?? null);
                $company->setActive(true);

                $this->dao->add($company);
                return $company;
            }
            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateCompany(Company $company, $newEmail) 
    {
        try {
            // 1. Actualizamos la tabla 'companies'
            $this->dao->update($company);

            // 2. Actualizamos el email en la tabla 'users'
            $user = $this->userDAO->GetById($company->getUserId());
            
            if($user) {
                $user->setEmail($newEmail);
                $this->userDAO->update($user); 
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getByUserId($userId): ?Company {
        return $this->dao->getByUserId($userId);
    }

    public function getByCuit($cuit): ?Company {
        return $this->dao->getByCuit($cuit);
    }

    public function getAll(): array {
        return $this->dao->getAll();
    }

    public function getById($id): ?Company {
        return $this->dao->getById($id);
    }

    public function deleteLogic(Company $company)
    {
        try {
            // Marcamos como inactivo el objeto
            $company->setActive(false);
            
            // Actualizamos en la DB de empresas
            $this->dao->update($company);

            // Opcional: Desactivar también el usuario asociado
            $user = $this->userDAO->GetById($company->getUserId());
            if($user) {
                $user->setActive(false);
                $this->userDAO->update($user);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function reactivateLogic(Company $company)
    {
        try {
            $company->setActive(true);
            $this->dao->update($company);

            // Activamos también el acceso del usuario
            $user = $this->userDAO->GetById($company->getUserId());
            if($user) {
                $user->setActive(true);
                $this->userDAO->update($user);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}