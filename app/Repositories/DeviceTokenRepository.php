<?php

namespace App\Repositories;

use App\Models\DeviceToken;
use Prettus\Repository\Eloquent\BaseRepository;

class DeviceTokenRepository extends BaseRepository
{
    function model(): string
    {
        return DeviceToken::class;
    }
}
