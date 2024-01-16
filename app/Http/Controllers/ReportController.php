<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Services\ReportService;
use App\Http\Requests\Report\StoreRequest;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    protected ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function createForComment(StoreRequest $request, Comment $comment): JsonResponse
    {
        $report = $this->service->createForModel($comment, $request->validated() + ['reporter_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $report
        ]);
    }

    public function createForArticle(StoreRequest $request, Article $article): JsonResponse
    {
        $report = $this->service->createForModel($article, $request->validated() + ['reporter_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $report
        ]);
    }
}
