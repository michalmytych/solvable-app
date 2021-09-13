<?php

namespace App\Http\Controllers\Api;

use App\Models\Problem;
use App\Models\Solution;
use App\Services\SolutionService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SolutionResource;
use App\Repositories\SolutionRepository;
use App\Http\Requests\Api\Solution\CommitRequest;

class SolutionController extends Controller
{
    private SolutionRepository $solutionRepository;

    private SolutionService $solutionService;

    public function __construct(
        SolutionRepository $solutionRepository,
        SolutionService    $solutionService
    )
    {
        $this->solutionRepository = $solutionRepository;
        $this->solutionService = $solutionService;
    }

    /**
     * Find solution by id.
     *
     * @param Solution $solution
     * @return SolutionResource
     */
    public function find(Solution $solution): SolutionResource
    {
        return new SolutionResource($this->solutionRepository->find($solution));
    }

    /**
     * Get all solutions for provided problem.
     *
     * @param Problem $problem
     * @return array
     */
    public function findByProblemAndUser(Problem $problem): array
    {
        return [
            'solutions' => $this->solutionRepository
                ->findByProblemAndUser($problem, Auth::user())
        ];
    }

    /**
     * Commit a new solution for a problem.
     *
     * @param CommitRequest $commitRequest
     * @param Problem $problem
     * @return SolutionResource
     */
    public function commit(CommitRequest $commitRequest, Problem $problem): SolutionResource
    {
        $solutionData = $commitRequest->input('data');

        $solutionData['user_id'] = Auth::id();

        $solution = $this->solutionService
            ->setProblem($problem)
            ->setSolutionData($solutionData)
            ->validate()
            ->delegateExecution()
            ->getProcessedSolution();

        return new SolutionResource($solution);
    }
}
