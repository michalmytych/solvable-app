<?php

namespace Database\Seeders;

use App\Models\Problem;
use App\Models\Solution;
use App\Models\Test;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Test::firstOrCreate([
            'input' => '2\n1',
            'valid_outputs' => json_encode([3]),
            'time_limit' => 400,
            'memory_limit' => 100,
            'problem_id' => Problem::first()->id
        ]);

        Test::firstOrCreate([
            'input' => '4\n6',
            'valid_outputs' => json_encode([10]),
            'time_limit' => 400,
            'memory_limit' => 100,
            'problem_id' => Problem::first()->id
        ]);

        Test::firstOrCreate([
            'input' => '289\n1',
            'valid_outputs' => json_encode([290]),
            'time_limit' => 23,
            'memory_limit' => 123,
            'problem_id' => Problem::first()->id
        ]);
    }
}
