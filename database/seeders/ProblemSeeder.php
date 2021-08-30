<?php

namespace Database\Seeders;

use App\Models\Problem;
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
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
