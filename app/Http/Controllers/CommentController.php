<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Services\CommentService;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function getByArticle(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->service->getByArticle($request)
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->service->index($request)
        ]);
    }

    public function getCountByArticle(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $this->service->getCountByArticle($request)
        ]);
    }

    public function createForArticle(StoreRequest $request, Article $article): JsonResponse
    {
        $comment = $this->service->createForModel($article, $request);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $comment
        ]);
    }

    public function update(UpdateRequest $request, Comment $comment): JsonResponse
    {
        $comment = $this->service->update($comment, $request->validated() + ['editor' => $request->user()]);

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
