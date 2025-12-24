<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;

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
        if (Cache::has("user:{$id}")) {
            Cache::forget("user:{$id}");
        }

        return $this->userRepository->delete($id);
    }
}
