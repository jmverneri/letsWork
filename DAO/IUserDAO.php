<?php
namespace DAO;

use Models\User;

interface IUserDAO
{
    public function getAll(): array;

    public function getById(int $userId): ?User;

    public function getByEmail(string $email): ?User;

    public function add(User $user): void;
}
