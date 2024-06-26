<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Article;

class SelectionController extends Controller
{
    public function index(): JsonResponse
    {
        $selection['article_status'] = [
            [
                'label' => 'draft',
                'value' => Article::STATUS_DRAFT,
            ],
            [
                'label' => 'public',
                'value' => Article::STATUS_PUBLIC,
            ],
            [
                'label' => 'private',
                'value' => Article::STATUS_PRIVATE,
            ],
        ];

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $selection
        ]);
    }
}
