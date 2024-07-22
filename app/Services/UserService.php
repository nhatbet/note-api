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
}
