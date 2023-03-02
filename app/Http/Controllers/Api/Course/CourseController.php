<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Services\Course\CourseService;
use App\Http\Requests\Api\Course\StoreRequest;
use App\Http\Requests\Api\Group\UpdateRequest;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {
    }

    /**
     * Get all courses by user.
     */
    public function all(): EloquentCollection
    {
        return $this->courseService->all();
    }

    /**
     * Create new course in database with validated data.
     */
    public function store(StoreRequest $storeRequest): Course
    {
        $courseData = $storeRequest->validated();
        data_set($courseData, 'user_id', $storeRequest->user()->id);

        return $this->courseService->create($courseData);
    }

    /**
     * Update course in database with validated data.
     */
    public function update(Course $course, UpdateRequest $storeRequest): Course
    {
        return $this->courseService->update($course, $storeRequest->validated());
    }

    /**
     * Delete course by id.
     */
    public function delete(Course $course): bool
    {
        return $this->courseService->delete($course);
    }
}
