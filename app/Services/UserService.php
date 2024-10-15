<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(int $id, array $attrs): User
    {
        $userUpdated = $this->repository->update($attrs, $id);

        return $userUpdated;
    }
    
    public function getList(int $number = 50, callable $callback): void
    {
        $this->repository
            ->select(['id', 'name', 'creator_id'])
            ->with(['deviceTokens'])
            ->chunkById($number, $callback);
    }
}
