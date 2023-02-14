<?php

namespace App\Http\Controllers\Api\Problem;

use App\Models\Problem;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\ProblemRepository;
use App\Http\Resources\ProblemResource;
use App\Services\Problem\ProblemService;
use App\Http\Requests\Api\Problem\CreateRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProblemController extends Controller
{
    public function __construct(private ProblemRepository $problemRepository)
    {
    }

    /**
     * Get all problems for user.
     */
    public function all(): LengthAwarePaginator
    {
        return $this->problemRepository->all(Auth::user());
    }

    /**
     * Find problem.
     */
    public function find(Problem $problem): Problem
    {
        return $problem;
    }

    /**
     * Create new problem with relations,
     * or return error message on fail.
     */
    public function store(CreateRequest $createRequest, ProblemService $problemService): ProblemResource
    {
        $problem = $problemService->createWithRelations($createRequest);

        return new ProblemResource($problem);
    }
}
