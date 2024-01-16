<?php

namespace App\Repositories;

use App\Models\Article;
use Prettus\Repository\Eloquent\BaseRepository;

class ArticleRepository extends BaseRepository
{

    function model(): string
    {
        return Article::class;
    }
}
