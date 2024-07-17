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
            ],
            [
                'name' => 'Quality of your ', 
            ],
            [
                'name' => 'He person asking n', 
            ],
            [
                'name' => 'Con Stack Ov', 
            ],
        ]);
    }
}
