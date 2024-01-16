<?php

namespace App\Repositories;

use App\Models\Comment;
use Prettus\Repository\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository
{
    function model(): string
    {
        return Comment::class;
    }
}
