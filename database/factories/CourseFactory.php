<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $courseId = Str::uuid();
        $courseName = $this->faker->sentence;

        return [
            'id' => $courseId,
            'name' => $courseName,
            'description' => $this->faker->realText(512),
            'slug' => Str::slug($courseName) . '_' . $courseId,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
