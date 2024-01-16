<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    protected ArticleService $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $article = $this->service->store($request->validated() + ['author_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $article
        ]);
    }

    public function update(UpdateRequest $request, Article $article): JsonResponse
    {
        $article = $this->service->update($article, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $article
        ]);
    }

    public function destroy(Article $article): JsonResponse
    {
        $this->service->delete($article);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }
}
