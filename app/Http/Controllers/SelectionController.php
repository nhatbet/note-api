<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Article;
use App\Models\Category;

class SelectionController extends Controller
{
    public function index(): JsonResponse
    {
        $selection['article_status'] = [
            [
                'label' => 'draft',
                'value' => Article::STATUS_DRAFT,
                'description' => 'Trang thai nhap',
            ],
            [
                'label' => 'public',
                'value' => Article::STATUS_PUBLIC,
                'description' => 'Trang thai cong bo',
            ],
            [
                'label' => 'private',
                'value' => Article::STATUS_PRIVATE,
                'description' => 'Trang thai rieng tu',
            ],
        ];

        $categories = Category::all();
        foreach ($categories as $key => $category) {
            $selection['categories'][] = [
                'label' => $category->name,
                'value' => $category->getKey(),
                'description' => null,
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $selection
        ]);
    }
}
