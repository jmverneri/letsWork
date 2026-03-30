<?php
namespace Repositories;

use DAO\UserDAOMySQL;
use Models\User;

class UserRepository {
    private $dao;

    public function __construct() {
        $this->dao = new UserDAOMySQL();
    }

    public function add(User $user) {
        // Es vital que el DAO retorne el ID generado
        return $this->dao->add($user);
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function UpdatePassword($email, $newPassword) {
        $this->dao->UpdatePassword($email, $newPassword);
    }
    public function UpdatePasswordAndClearFlag($email, $hashedPassword)
    {
        try {
            $this->dao->UpdatePasswordAndClearFlag($email, $hashedPassword);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function GetById(int $userId): ?User {
        return $this->dao->getById($userId);
    }
}