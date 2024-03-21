<?php

namespace App\Repositories;

use App\Models\CommentHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class CommentHistoryRepository extends BaseRepository
{
    function model(): string
    {
        return CommentHistory::class;
    }
}
