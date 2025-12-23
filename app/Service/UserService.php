<?php

namespace App\Service;
use App\UserRepositoryInterface;
use App\Actions\User\CreateUser;
use App\Actions\User\UpdateUser;
use App\Actions\User\DeleteUser;
use App\Actions\User\GetUser;

use Exception;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected CreateUser $createUser,
        protected UpdateUser $updateUser,
        protected GetUser $getUser,
        protected DeleteUser $deleteUser
    ) {
        //
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById(int $id)
    {
        return $this->getUser->execute($id);
    }

    public function createUser(array $data)
    {
        return $this->createUser->execute($data);
    }

    public function updateUser(int $id, array $data)
    {
        return $this->updateUser->execute($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->deleteUser->execute($id);
    }
}
