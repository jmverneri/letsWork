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

    /*public function UpdatePassword($email, $newPassword) {
        $this->dao->UpdatePassword($email, $newPassword);
    }*/
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

    /**
     * Guarda el token de reseteo y su expiración para un usuario
     */
    public function setResetToken($email, $token, $expires)
    {
        try {
            $this->dao->setResetToken($email, $token, $expires);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Busca un usuario por su token de reseteo, validando que no haya expirado
     */
    public function getUserByToken($token)
    {
        try {
            return $this->dao->getUserByToken($token);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Actualiza la contraseña real del usuario y limpia el token para que no se use de nuevo
     */
    public function updatePassword($userId, $newPassword)
    {
        try {
            // Acá podrías hashear la contraseña antes de mandarla al DAO si no lo hacés ahí
            // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->dao->updatePassword($userId, $newPassword);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function updatePasswordAndResetToken($userId, $hashedPassword)
    {
        try {
            // Llamamos al DAO para que haga el UPDATE y setee el token en NULL
            $this->dao->updatePasswordAndResetToken($userId, $hashedPassword);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function updateEmail($userId, $newEmail)
    {
        try {
            $this->dao->updateEmail($userId, $newEmail);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }
}