<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    /**
     * Get all courses related to user by user id.
     */
    public function allByUserId(string $id)
    {
        return Course::where('user_id', $id);
    }

    /**
     * Store new course in database.
     */
    public function store(array $data): Course
    {
        return Course::create($data);
    }

    /**
     * Update course at database.
     */
    public function update(Course $course, array $data): Course
    {
        return tap($course)->update($data);
    }

    /**
     * Delete course at database.
     */
    public function delete(Course $course): bool
    {
        return $course->delete();
    }
}
