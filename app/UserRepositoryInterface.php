<?php

declare(strict_types=1);

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?User;

    public function create(array $data): User;

    public function update(int $id, array $data): User;

    public function delete(int $id): bool;
}
