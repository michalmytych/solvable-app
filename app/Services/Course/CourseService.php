<?php

namespace App\Services\Course;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Repositories\CourseRepository;

class CourseService
{
    public function __construct(private CourseRepository $courseRepository) { }

    /**
     * Get all courses by user.
     */
    public function all()
    {
        return Course::latest()->paginate(); // @todo
        //return $this->courseRepository->allByUserId(Auth::id());
    }

    public function find(string $id): ?Course
    {
        // @todo - to repository
        return Course::with('groups')->findOrFail($id);
    }

    /**
     * Create new course and add default group to it.
     */
    public function create(array $data): Course
    {
        $name = data_get($data, 'name');
        data_set($data, 'slug', Str::slug($name));

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
        // @todo move to GroupService? move to repository
        $course
            ->groups()
            ->create([
                'name'        => 'Default group for course ' . $course->name,
                'code'        => Str::slug('default-' . $course->name),
                'description' => 'Default course group.',
                'user_id'     => $course->user_id,
                'is_default'  => true,
            ]);
    }
}
