<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Course\GroupService;
use App\Services\Course\CourseService;
use App\Services\Problem\ProblemService;
use App\Http\Requests\Web\Problem\StoreRequest;

class ProblemController extends Controller
{
    public function __construct(
        private ProblemService $problemService,
        private CourseService  $courseService,
        private GroupService   $groupService
    )
    {
    }

    public function index(Request $request): View
    {
        $problems = $this->problemService->all($request->user());
        return view('problems.index', compact('problems'));
    }

    public function show(string $id): View
    {
        $problem = $this->problemService->find($id);
        return view('problems.show', compact('problem'));
    }

    public function create(): View
    {
        $courses = $this->courseService->allByUser();
        $groups  = $this->groupService->allByUser();

        return view('problems.create', [
            'courses' => $courses,
            'groups'  => $groups,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        dd($request->validated());
        $this->problemService->createWithRelations($request->validated());
        return redirect()->to(route('problem.index'));
    }
}
