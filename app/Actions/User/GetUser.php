<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;

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
        if (Cache::has("user:{$id}")) {
            return Cache::get("user:{$id}");
        }

        $user = $this->userRepository->findById($id);

        Cache::put("user:{$id}", $user, now()->addMinutes(10));

        return $user;
    }
}
