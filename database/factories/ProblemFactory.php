<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Problem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Problem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->realText(256),
            'chars_limit' => 1028,
            'user_id' => User::first()->id,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
