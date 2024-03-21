<?php

namespace App\Services;

use App\Models\ArticleHistory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\ArticleHistoryRepository;

class ArticleHistoryService
{
    protected ArticleHistoryRepository $repository;

    public function __construct(ArticleHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attrs): ArticleHistory
    {
        $history = $this->repository->create($attrs);

        return $history;
    }
}
