<?php

namespace App\Repositories;

use App\Models\Vote;
use Prettus\Repository\Eloquent\BaseRepository;

class VoteRepository extends BaseRepository
{
    function model(): string
    {
        return Vote::class;
    }
}
