<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\CommentRepository;
use App\Events\CommentUpdated;

class CommentService
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createForModel(Model $model, $attrs): Comment
    {
        $comment = $model->comments()->create($attrs);

        return $comment;
    }

    public function update(Comment $comment, $attrs): Comment
    {
        $oldComment = clone $comment;
        $comment = $this->repository->update($attrs, $comment->getKey());

        CommentUpdated::dispatch($oldComment, $comment, $attrs['editor']);

        return $comment;
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
