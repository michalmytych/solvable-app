<?php

namespace Database\Seeders;

use App\Models\CodeLanguage;
use App\Models\Problem;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Database\Seeder;

class SolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Solution::firstOrCreate(
            [
                'code' => '#include <iostream> int main() { int a, b; std::cin >> a; std::cin >> b; std::cout << a + b; return 0; }',
                'score' => 100,
                'execution_time' => 300,
                'memory_used' => 1200,
                'characters' => 73,
                'updated_at' => now(),
                'created_at' => now(),
                'user_id' => User::first()->id,
                'problem_id' => Problem::first()->id,
                'code_language_id' => CodeLanguage::first()->id
            ]
        );
    }
}
