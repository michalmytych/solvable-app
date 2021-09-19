<?php

namespace Database\Factories;

use App\Models\CodeLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CodeLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'identifier' => $this->faker->uuid(),
            'version' => 0,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
