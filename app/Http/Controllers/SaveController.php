<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Save;
use App\Services\SaveService;
use Illuminate\Http\JsonResponse;

class SaveController extends Controller
{
    protected SaveService $service;

    public function __construct(SaveService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $saves = $this->service->index($request);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $saves
        ]);
    }

    public function createForArticle(Request $request, Article $article): JsonResponse
    {
        $save = $this->service->findSave($request->user(),  $article);
        if (is_null($save)) {
            $save = $this->service->save($article);
        }

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $save
        ]);
    }

    public function destroy(Save $save): JsonResponse
    {
        $this->service->unSave($save);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }
}
