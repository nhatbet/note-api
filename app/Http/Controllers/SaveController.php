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

    public function saveArticle(Request $request, Article $article): JsonResponse
    {
        $this->service->save($request->user(),  $article);
 
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }

    public function unSaveArticle(Request $request, Article $article): JsonResponse
    {
        $this->service->unSave($request->user(),  $article);
 
        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }

    public function getByArticle(Request $request, Article $article): JsonResponse
    {
        $save = $this->service->getByModel($request->user(),  $article);
        $data = false;
            if ($save->isSaved()) {
            $data = true;
        }

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $data
        ]);
    }
}
