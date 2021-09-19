<?php

namespace App\Http\Controllers\Api\Problem;

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
     * Get all problems by user.
     *
     * @return EloquentCollection
     */
    public function all(): EloquentCollection
    {
        return $this->problemRepository->all(Auth::id());
    }

    /**
     * Create new problem with relations,
     * or return error message on fail.
     *
     * @param CreateRequest $createRequest
     * @param ProblemService $problemService
     * @return ProblemResource|JsonResponse
     */
    public function store(CreateRequest $createRequest, ProblemService $problemService)
    {
        $problem = $problemService->createWithRelations($createRequest);

        return $problem
            ? new ProblemResource($problem)
            : response()->json([
                'message' => 'errors.error-while-creating'
            ], 500);
    }
}
