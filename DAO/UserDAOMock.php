<?php
namespace DAO;

use DAO\IUserDAO;
use Models\User;

class UserDAOMock implements IUserDAO
{
    private array $userList = [];

    public function __construct()
    {
        // Datos mock iniciales
        $user = new User();
        $user->setUserId(1)
             ->setEmail("admin@test.com")
             ->setPassword(password_hash("123", PASSWORD_DEFAULT))
             ->setRole(User::ROLE_ADMIN);

        $user1 = new User();
        $user1->setUserId(2)
             ->setEmail("juan@test.com")
             ->setPassword(password_hash("123", PASSWORD_DEFAULT))
             ->setRole(User::ROLE_STUDENT);

        $user2 = new User();
        $user2->setUserId(3)
             ->setEmail("ana@test.com")
             ->setPassword(password_hash("123", PASSWORD_DEFAULT))
             ->setRole(User::ROLE_STUDENT);

        $user3 = new User();
        $user3->setUserId(4)
             ->setEmail("company@test.com")
             ->setPassword(password_hash("123", PASSWORD_DEFAULT))
             ->setRole(User::ROLE_COMPANY);

        $user4 = new User();
        $user4->setUserId(5)
             ->setEmail("company1@test.com")
             ->setPassword(password_hash("123", PASSWORD_DEFAULT))
             ->setRole(User::ROLE_COMPANY);

        $this->userList[] = $user;
        $this->userList[] = $user1;
        $this->userList[] = $user2;
        $this->userList[] = $user3;
        $this->userList[] = $user4;
    }

    public function getAll(): array
    {
        return $this->userList;
    }

    public function getById(int $userId): ?User
    {
        foreach ($this->userList as $user) {
            if ($user->getUserId() === $userId) {
                return $user;
            }
        }
        return null;
    }

    public function getByEmail(string $email): ?User
    {
        foreach ($this->userList as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }

    public function add(User $user): void
    {
        // Simulamos autoincrement
        if ($user->getUserId() === null) {
            $user->setUserId(count($this->userList) + 1);
        }

        $this->userList[] = $user;
    }
}
