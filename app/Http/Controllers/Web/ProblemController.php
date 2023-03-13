<?php

namespace App\Http\Controllers\Web;

use App\DTOs\ProblemDTO;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Course\GroupService;
use App\Services\Course\CourseService;
use App\Services\Problem\ProblemService;
use App\Http\Requests\Web\Problem\StoreRequest;
use App\Services\Problem\CodeLanguage\CodeLanguageService;

class ProblemController extends Controller
{
    public function __construct(
        private ProblemService      $problemService,
        private CourseService       $courseService,
        private GroupService        $groupService,
        private CodeLanguageService $codeLanguageService
    ) {
    }

    public function index(Request $request): View
    {
        $problems = $this->problemService->allByUser($request->user()->id);

        return view('problems.index', compact('problems'));
    }

    public function show(string $id): View
    {
        $problem = $this->problemService->find($id);

        return view('problems.show', compact('problem'));
    }

    public function create(Request $request): View
    {
        $userId = $request->user()->id;

        return view('problems.create', [
            'courses'       => $this->courseService->allByUser($userId),
            'groups'        => $this->groupService->allByUser($userId),
            'codeLanguages' => $this->codeLanguageService->all(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $problemDTO = ProblemDTO::fromRequest($request);

        $this->problemService->createWithRelations($problemDTO);

        return redirect()->to(route('problem.index'));
    }
}
