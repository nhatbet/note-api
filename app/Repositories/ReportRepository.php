<?php

namespace App\Repositories;

use App\Models\Report;
use Prettus\Repository\Eloquent\BaseRepository;

class ReportRepository extends BaseRepository
{
    function model(): string
    {
        return Report::class;
    }
}
