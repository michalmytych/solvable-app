<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Services\Course\CourseService;
use App\Http\Requests\Api\Course\StoreRequest;
use App\Http\Requests\Api\Group\UpdateRequest;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CourseController extends Controller
{
    private CourseRepository $courseRepository;

    private CourseService $courseService;

    public function __construct(CourseRepository $courseRepository, CourseService $courseService)
    {
        $this->courseRepository = $courseRepository;
        $this->courseService = $courseService;
    }

    /**
     * Get all courses by user.
     *
     * @return EloquentCollection
     */
    public function all(): EloquentCollection
    {
        return $this->courseRepository->allByUserId(Auth::id());
    }

    /**
     * Create new course in database with validated data.
     *
     * @param StoreRequest $storeRequest
     * @return Course
     */
    public function store(StoreRequest $storeRequest): Course
    {
        $courseData = $storeRequest->validated();
        $courseData['user_id'] = Auth::id();

        return $this->courseService->create($courseData);
    }

    /**
     * Update course in database with validated data.
     *
     * @param Course $course
     * @param UpdateRequest $storeRequest
     * @return Course
     */
    public function update(Course $course, UpdateRequest $storeRequest): Course
    {
        return $this->courseRepository->update($course, $storeRequest->validated());
    }

    /**
     * Delete course by id.
     *
     * @param Course $course
     * @return bool
     */
    public function delete(Course $course): bool
    {
        return $this->courseRepository->delete($course);
    }
}
