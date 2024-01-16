<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\CommentRepository;

class CommentService
{
    public function createForModel(Model $model, $attrs): Comment
    {
        $comment = $model->comments()->create($attrs);

        return $comment;
    }

    public function update(Comment $comment, $attrs): Comment
    {
        /** @var CommentRepository $commentRepo */
        $commentRepo = app(CommentRepository::class);
        $comment = $commentRepo->update($attrs, $comment->getKey());

        return $comment;
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
