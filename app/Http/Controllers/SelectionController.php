<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Article;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use App\Models\Tag;

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

        $selection['genders'] = [
            [
                'label' => 'male',
                'value' => User::GENDER_MALE,
                'description' => 'Male',
            ],
            [
                'label' => 'female',
                'value' => User::GENDER_FEMALE,
                'description' => 'Female',
            ],
            [
                'label' => 'other',
                'value' => User::GENDER_OTHER,
                'description' => 'Other',
            ],
        ];

        $selection['report_categories'] = [
            [
                'label' => Report::TYPE_NAME_1,
                'value' => Report::TYPE_1,
                'description' => null,
            ],
            [
                'label' => Report::TYPE_NAME_2,
                'value' => Report::TYPE_2,
                'description' => null,
            ],
            [
                'label' => Report::TYPE_NAME_3,
                'value' => Report::TYPE_3,
                'description' => null,
            ],
            [
                'label' => Report::TYPE_NAME_4,
                'value' => Report::TYPE_4,
                'description' => null,
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

        $tags = Tag::all();
        foreach ($tags as $key => $tag) {
            $selection['tags'][] = [
                'label' => $tag->name,
                'value' => $tag->getKey(),
                'description' => $tag->description,
            ];
        }

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $selection
        ]);
    }
}
