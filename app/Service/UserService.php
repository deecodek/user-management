<?php

declare(strict_types=1);

namespace App\Service;

use App\Actions\User\CreateUser;
use App\Actions\User\DeleteUser;
use App\Actions\User\GetUser;
use App\Actions\User\UpdateUser;
use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

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
        Log::info('Fetching all users');

        return $this->userRepository->getAll();
    }

    public function getUserById(int $id)
    {
        Log::info('Fetching user by id', ['user_id' => $id]);

        return $this->getUser->execute($id);
    }

    public function createUser(array $data)
    {
        Log::info('Creating user');

        return $this->createUser->execute($data);
    }

    public function updateUser(int $id, array $data)
    {
        Log::info('Updating user', ['user_id' => $id]);

        return $this->updateUser->execute($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        Log::info('Deleting user', ['user_id' => $id]);

        return $this->deleteUser->execute($id);
    }
}
