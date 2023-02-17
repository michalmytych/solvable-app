<?php

namespace App\Http\Controllers\Api\Solution;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\SolutionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\SolutionResource;
use App\Services\SolutionProcessingService;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ProcessedSolutionResource;
use App\Http\Requests\Api\Solution\CommitRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SolutionController extends Controller
{
    public function __construct(
        private SolutionService           $solutionService,
        private SolutionProcessingService $solutionProcessingService
    ) {
    }

    /**
     * Get all solutions for authenticated user.
     */
    public function all(Request $request): LengthAwarePaginator
    {
        return $this->solutionService->all($request->user());
    }

    /**
     * Find solution by id.
     */
    public function find(Solution $solution): SolutionResource
    {
        return new SolutionResource($this->solutionService->find($solution));
    }

    /**
     * Commit a new solution for a problem.
     */
    public function commit(CommitRequest $commitRequest, Problem $problem): JsonResponse
    {
        $solutionData = $commitRequest->input('data');

        try {
            $solution = $this
                ->solutionProcessingService
                ->setProblem($problem)
                ->setSolutionData($solutionData)
                ->commit()
                ->getProcessedSolution();

        } catch (ValidationException $validationException) {
            $solution = $this
                ->solutionProcessingService
                ->getProcessedSolution();

            return response()->json([
                'message' => $validationException->getMessage(),
                'errors'  => $validationException->errors(),
                'data'    => new ProcessedSolutionResource($solution),
            ], 422);
        }

        return response()->json([
            'message' => 'messages.solution-processing',
            'data'    => new ProcessedSolutionResource($solution),
        ], 202);
    }
}
