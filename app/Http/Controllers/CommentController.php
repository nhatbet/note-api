<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Services\CommentService;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    protected CommentService $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function createForArticle(StoreRequest $request, Article $article): JsonResponse
    {
        $comment = $this->service->createForModel($article, $request->validated() + ['commentator_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $comment
        ]);
    }

    public function update(UpdateRequest $request, Comment $comment): JsonResponse
    {
        $comment = $this->service->update($comment, $request->validated() + ['commentator_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $comment
        ]);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->service->delete($comment);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }
}
