<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lập trình', 
                'meta' => [
                    'color' => '#eb4034'
                ]
            ],
            [
                'name' => 'Tiếng Anh', 
                'meta' => [
                    'color' => '#2de33d'
                ]
            ],
            [
                'name' => 'Câu hỏi', 
                'meta' => [
                    'color' => '#2d97e3'
                ]
            ],
            [
                'name' => 'Chuyện trò', 
                'meta' => [
                    'color' => '#e3e02d'
                ]
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
