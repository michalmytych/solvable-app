<?php

namespace App\Http\Controllers\Api;

use App\Models\Problem;
use App\Services\SolutionService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SolutionRepository;
use App\Http\Requests\Api\Solution\CommitRequest;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class SolutionController extends Controller
{
    private SolutionRepository $solutionRepository;

    private SolutionService $solutionService;

    public function __construct(
        SolutionRepository $solutionRepository,
        SolutionService $solutionService
    )
    {
        $this->solutionRepository = $solutionRepository;
        $this->solutionService = $solutionService;
    }

    /**
     * Get all solutions for provided problem.
     *
     * @param Problem $problem
     * @return EloquentCollection
     */
    public function allByProblem(Problem $problem): EloquentCollection
    {
        return $this->solutionRepository
            ->allByProblem($problem);
    }

    /**
     * Commit a new solution for a problem.
     *
     * @param CommitRequest $commitRequest
     * @param Problem $problem
     * @return JsonResponse
     */
    public function commit(CommitRequest $commitRequest, Problem $problem): JsonResponse
    {
        $solutionData = $commitRequest->input('data');

        $solutionData['user_id'] = Auth::id();

        $this->solutionService
            ->setProblem($problem)
            ->setSolutionData($solutionData)
            ->validate()
            ->delegateExecution();

        return response()->json([
            'message' => 'solution.messages.processing'
        ], 202);
    }
}
