<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Tag 1',
                'meta' => [
                    'icon' => '🪄'
                ]
            ],
            [
                'name' => 'Tag 2',
                'meta' => [
                    'icon' => '🤖'
                ]
            ],
            [
                'name' => 'Tag 3',
                'meta' => [
                    'icon' => '🤗'
                ]
            ],
            [
                'name' => 'Tag 4',
                'meta' => [
                    'icon' => '😲'
                ]
            ],
            [
                'name' => 'Tag 5',
                'meta' => [
                    'icon' => '📏'
                ]
            ],
            [
                'name' => 'Tag 6',
                'meta' => [
                    'icon' => '🧬'
                ]
            ],
            [
                'name' => 'Tag 7',
                'meta' => [
                    'icon' => '📈'
                ]
            ],
        ];

        foreach ($tags as $key => $tag) {
            Tag::create($tag);
        }
    }
}
