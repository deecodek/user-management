<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        DB::beginTransaction();

        try {
            if (Cache::has("user:{$id}")) {
                Cache::forget("user:{$id}");
            }

            $deleted = $this->userRepository->delete($id);

            Log::info('User deleted successfully', ['user_id' => $id]);

            DB::commit();

            return $deleted;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('User deletion failed', [
                'user_id' => $id,
                'exception' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
