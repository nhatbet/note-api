<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 99; $i++) {
            Article::create([
                'title' => 'title ' . $i,
                'content' => 'content ' . $i,
                'author_id' => 1,
                'status' => 2,
                'category_id' => 1,
            ]);
        }
    }
}
