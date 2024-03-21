<?php

namespace App\Repositories;

use App\Models\ArticleHistory;
use Prettus\Repository\Eloquent\BaseRepository;

class ArticleHistoryRepository extends BaseRepository
{
    function model(): string
    {
        return ArticleHistory::class;
    }
}
