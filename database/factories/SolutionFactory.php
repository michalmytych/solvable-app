<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Problem;
use App\Models\Solution;
use App\Models\CodeLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolutionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solution::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'user_id' => User::first()->id,
            'problem_id' => Problem::first()->id,
            'code_language_id' => CodeLanguage::first()->id,
            'code' => $this->faker->sentence(),
            'score' => 10,
            'execution_time' => 300,
            'memory_used' => 400,
            'characters' => 30,
            'status' => 7,
            'created_at' => (string) now(),
            'updated_at' => (string) now()
        ];
    }
}
