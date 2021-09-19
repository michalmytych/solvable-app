<?php

namespace App\Http\Controllers\Api\Problem;

use App\Models\Problem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\ProblemRepository;
use App\Http\Resources\ProblemResource;
use App\Services\Problem\ProblemService;
use App\Http\Requests\Api\Problem\CreateRequest;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ProblemController extends Controller
{
    private ProblemRepository $problemRepository;

    public function __construct(ProblemRepository $problemRepository)
    {
        $this->problemRepository = $problemRepository;
    }

    /**
     * Get all problems for user.
     *
     * @return LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator
    {
        return $this->problemRepository->all(Auth::user());
    }

    /**
     * Find problem.
     *
     * @param Problem $problem
     * @return Problem
     */
    public function find(Problem $problem): Problem
    {
        return $problem;
    }

    /**
     * Create new problem with relations,
     * or return error message on fail.
     *
     * @param CreateRequest $createRequest
     * @param ProblemService $problemService
     * @return ProblemResource
     */
    public function store(CreateRequest $createRequest, ProblemService $problemService)
    {
        $problem = $problemService->createWithRelations($createRequest);

        return new ProblemResource($problem);
    }
}
