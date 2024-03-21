<?php

namespace App\Services;

use App\Models\CommentHistory;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\CommentHistoryRepository;

class CommentHistoryService
{
    protected CommentHistoryRepository $repository;

    public function __construct(CommentHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attrs): CommentHistory
    {
        $history = $this->repository->create($attrs);

        return $history;
    }
}
