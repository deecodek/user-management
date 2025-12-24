<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        DB::beginTransaction();

        try {
            if (Cache::has("user:{$id}")) {
                $user = Cache::get("user:{$id}");

                Log::info('User fetched from cache', ['user_id' => $id]);

                DB::commit();

                return $user;
            }

            $user = $this->userRepository->findById($id);

            Cache::put("user:{$id}", $user, now()->addMinutes(10));

            Log::info('User fetched from database and cached', ['user_id' => $id]);

            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('User fetch failed', [
                'user_id' => $id,
                'exception' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
