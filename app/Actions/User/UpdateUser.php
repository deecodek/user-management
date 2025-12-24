<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UpdateUser
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        //
    }

    public function execute(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->userRepository->update($id, $data);

        Cache::forget("user:{$id}");
        Cache::put("user:{$id}", $user);

        return $user;
    }
}
