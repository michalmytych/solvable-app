<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    /**
     * Get all courses related to user by user id.
     *
     * @param string $id
     * @return mixed
     */
    public function allByUserId(string $id)
    {
        return Course::where('user_id', $id);
    }

    /**
     * Store new course in database.
     *
     * @param array $data
     * @return Course
     */
    public function store(array $data): Course
    {
        return Course::create($data);
    }

    /**
     * Update course at database.
     *
     * @param Course $course
     * @param array $data
     * @return Course
     */
    public function update(Course $course, array $data): Course
    {
        return tap($course)->update($data);
    }

    /**
     * Delete course at database.
     *
     * @param Course $course
     * @return bool
     */
    public function delete(Course $course): bool
    {
        return $course->delete();
    }
}
