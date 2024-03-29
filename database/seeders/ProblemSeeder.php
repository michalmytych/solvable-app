<?php

namespace Database\Seeders;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Problem::firstOrCreate(
            [
                'title' => 'Adding integers in C++',
                'content' => 'Write a C++ program to read two integers from std-in, sum them and print output to std-out.',
                'chars_limit' => 1028,
                'user_id' => User::first()->id,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Problem::firstOrCreate(
            [
                'title' => 'Adding integers in PHP',
                'content' => 'Write a PHP script to read two integers from std-in, sum them and print output to std-out.',
                'chars_limit' => 1028,
                'user_id' => User::first()->id,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
