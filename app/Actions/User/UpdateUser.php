<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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

        return $this->userRepository->update($id, $data);
    }
}
