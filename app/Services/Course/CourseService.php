<?php

namespace App\Services\Course;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CourseService
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }

    /**
     * Get all courses by user.
     */
    public function all(): EloquentCollection
    {
        return Course::all(); // @todo
        //return $this->courseRepository->allByUserId(Auth::id());
    }

    /**
     * Create new course and add default group to it.
     */
    public function create(array $data): Course
    {
        $course = $this->courseRepository->store($data);
        $this->createDefaultGroupAtCourse($course);

        return $course;
    }

    /**
     * Update course in database with validated data.
     */
    public function update(Course $course, array $data): Course
    {
        return $this->courseRepository->update($course, $data);
    }

    /**
     * Delete course by id.
     */
    public function delete(Course $course): bool
    {
        return $this->courseRepository->delete($course);
    }

    /**
     * Add default group to newly created course.
     */
    private function createDefaultGroupAtCourse(Course $course): void
    {
        $course
            ->groups()
            ->create([      // todo moze logike tworzenia default gropy przeniesc do group service?
                'name'        => 'course.default-group-name',
                'code'        => Str::slug('default.' . $course->name),
                'description' => 'course.default-group-description.{' . $course->id . '}',
                'user_id'     => $course->user_id,
                'is_default'  => true,
            ]);
    }
}
