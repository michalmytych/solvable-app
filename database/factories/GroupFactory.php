<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $course = Course::first();
        $name = $this->faker->sentence;
        $mainGroupOfCourseCode = 'main_group_for_course_' . $course->id;

        if (Group::firstWhere('code', $mainGroupOfCourseCode)) {
            $mainGroupOfCourseCode = $name . '_group_for_course_' . $course->id;
        }

        return [
            'name' => $name,
            'description' => $this->faker->realText(512),
            'code' => $mainGroupOfCourseCode,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
