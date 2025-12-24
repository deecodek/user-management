<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class CreateUser
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        //
    }

    public function execute(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        Cache::put("user:{$user->id}", $user);

        return $user;
    }
}
