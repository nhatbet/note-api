<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'name' . $i,
                'username' => 'user' . $i,
                'password' => bcrypt('123123'),
                'email' => 'email' . $i . '@gmail.com',
                'gender' => 1,
                'dob' => Carbon::now()->format('Y-m-d'),
            ]);
        }
    }
}
