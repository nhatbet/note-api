<?php

namespace App\Repositories;

use App\Models\Tag;
use Prettus\Repository\Eloquent\BaseRepository;

class TagRepository extends BaseRepository
{
    function model(): string
    {
        return Tag::class;
    }
}
