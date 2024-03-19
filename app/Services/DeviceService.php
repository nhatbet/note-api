<?php

namespace App\Services;

use App\Models\Device;
use App\Repositories\DeviceRepository;

class DeviceService
{
    protected DeviceRepository $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attrs): Device
    {
        $name = data_get($attrs, 'name');
        $userId = data_get($attrs, 'user_id');

        /** @var ?Device $device */
        $this->deleteByName($name, $userId);
        $device = $this->repository->create($attrs);

        return $device;
    }

    public function deleteByName(string $name, int $userId): void
    {
        /** @var ?Device $device */
        $device = $this->getByName($name, $userId);
        if ($device) {
            $device->delete();
        }
    }

    protected function getByName(string $name, int $userId): ?Device
    {
        $device = $this->repository->where('name', $name)
            ->where('user_id', $userId)
            ->first();

        return $device;
    }
    
}
