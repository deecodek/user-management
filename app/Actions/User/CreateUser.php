<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        DB::beginTransaction();

        try {
            $data['password'] = Hash::make($data['password']);

            $user = $this->userRepository->create($data);

            Cache::put("user:{$user->id}", $user);

            Log::info('User created successfully', ['user_id' => $user->id]);

            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('User creation failed', [
                'exception' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
