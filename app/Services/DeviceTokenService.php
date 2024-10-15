<?php

namespace App\Services;

use App\Models\DeviceToken;
use App\Repositories\DeviceTokenRepository;

class DeviceTokenService
{
    protected DeviceTokenRepository $repository;

    public function __construct(DeviceTokenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attrs): DeviceToken
    {
        $userId = data_get($attrs, 'user_id');

        /** @var ?DeviceToken $device */
        $this->delete($userId);
        $device = $this->repository->create($attrs);

        return $device;
    }

    public function delete(int $userId): void
    {
        /** @var ?DeviceToken $device */
        $device = $this->getByUserId($userId);
        if ($device) {
            $device->delete();
        }
    }

    public function getByUserId(int $userId): ?DeviceToken
    {
        $device = $this->repository
            ->where('user_id', $userId)
            ->first();

        return $device;
    }
    
}
