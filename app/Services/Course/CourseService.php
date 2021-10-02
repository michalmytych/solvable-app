<?php

namespace App\Services\Course;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Repositories\CourseRepository;

class CourseService
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }

    /**
     * Create new course and add default group to it.
     *
     * @param array $data
     * @return Course
     */
    public function create(array $data): Course
    {
        $course = $this->courseRepository->store($data);
        $this->createDefaultGroupAtCourse($course);

        return $course;
    }

    /**
     * Add default group to newly created course.
     *
     * @param Course $course
     */
    private function createDefaultGroupAtCourse(Course $course): void
    {
        $course
            ->groups()
            ->create([      // todo moze logike tworzenia default gropy przeniesc do group service?
                'name' => 'course.default-group-name',
                'code' => Str::slug('default.' . $course->name),
                'description' => 'course.default-group-description.{' . $course->id . '}',
                'user_id' => $course->user_id,
                'is_default' => true
            ]);
    }
}
