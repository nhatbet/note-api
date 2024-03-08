<?php

namespace App\Repositories;

use App\Models\Save;
use Prettus\Repository\Eloquent\BaseRepository;

class SaveRepository extends BaseRepository
{
    function model(): string
    {
        return Save::class;
    }
}
