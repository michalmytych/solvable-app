<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Services\Problem\ProblemService;
use App\Http\Requests\Api\Problem\StoreRequest;

class ProblemController extends Controller
{
    public function __construct(private ProblemService $problemService) {}

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
        return view('problems.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->problemService->createWithRelations($request->validated());
        return redirect()->to(route('problem.index'));
    }
}
