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
        Category::insert([
            [
                'name' => 'While this code',
                'meta' => "{\"color\":\"#eb4034\"}"
            ],
            [
                'name' => 'Quality of your ',
                'meta' => "{\"color\":\"#2de33d\"}"
            ],
            [
                'name' => 'He person asking n',
                'meta' => "{\"color\":\"#2d97e3\"}"
            ],
            [
                'name' => 'Con Stack Ov',
                'meta' => "{\"color\":\"#e3e02d\"}"
            ],
        ]);
    }
}
