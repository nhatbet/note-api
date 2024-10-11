<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\CommentRepository;
use App\Events\CommentUpdated;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentService
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getByArticle(Request $request)
    {
        $comments = $this->repository
            ->with('commentator')
            ->withCount('comments')
            ->where('commentable_id', $request->get('article_id'))
            ->where('commentable_type', Article::class)
            ->paginate(10);

        return $comments;
    }

    public function index(Request $request)
    {
        $comments = $this->repository
            ->with('commentator')
            ->withCount('comments')
            ->where('parent_id', $request->get('parent_id'))
            ->paginate(10);

        return $comments;
    }

    public function getCountByArticle(Request $request)
    {
        $count = $this->repository->where('commentable_id', $request->get('article_id'))->count();

        return $count;
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
