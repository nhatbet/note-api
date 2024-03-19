<?php

namespace App\Repositories;

use App\Models\Device;
use Prettus\Repository\Eloquent\BaseRepository;

class DeviceRepository extends BaseRepository
{
    function model(): string
    {
        return Device::class;
    }
}
