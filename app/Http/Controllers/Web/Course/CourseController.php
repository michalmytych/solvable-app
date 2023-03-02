<?php

namespace App\Http\Controllers\Web\Course;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Course\CourseService;
use App\Http\Requests\Api\Course\StoreRequest;

class CourseController extends Controller
{
    public function __construct(private CourseService $courseService) {}

    public function index(): View
    {
        $courses = $this->courseService->all();
        return view('courses.index', compact('courses'));
    }

    public function show(string $id): View
    {
        $course = $this->courseService->find($id);
        return view('courses.show', compact('course'));
    }

    public function create(): View
    {
        return view('courses.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        sleep(5);
        $courseData = $request->validated();
        data_set($courseData, 'user_id', $request->user()->id);

        $this->courseService->create($courseData);
        return redirect()->to(route('course.index'));
    }

    public function edit(string $id): View
    {
        $course = $this->courseService->find($id);
        return view('courses.edit', compact('course'));
    }
}
