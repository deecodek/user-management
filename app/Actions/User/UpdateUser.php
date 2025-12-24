<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        DB::beginTransaction();

        try {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->userRepository->update($id, $data);

            Cache::forget("user:{$id}");
            Cache::put("user:{$id}", $user);

            Log::info('User updated successfully', ['user_id' => $id]);

            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('User update failed', [
                'user_id' => $id,
                'exception' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
