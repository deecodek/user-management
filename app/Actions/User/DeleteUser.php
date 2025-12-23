<?php

namespace App\Actions\User;
use App\UserRepositoryInterface;
class DeleteUser
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected UserRepositoryInterface $userRepository) 
    {
        //
    }
    public function execute(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
