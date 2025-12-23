<?php

namespace App\Actions\User;
use App\UserRepositoryInterface;
class GetUser
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected UserRepositoryInterface $userRepository) 
    {
        //
    }

    public function execute(int $id)
    {
        return $this->userRepository->findById($id);
    }
}
