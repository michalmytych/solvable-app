<?php

namespace App\Http\Controllers\Api;

use App\Models\Problem;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\ProblemRepository;
use App\Http\Requests\Api\Problem\StoreRequest;
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
    public function allByUser(): EloquentCollection
    {
        return $this->problemRepository->allByUserId(Auth::id());
    }

    /**
     * Create new problem in database with validated data.
     * move to course controller and group controller
     *
     * @param StoreRequest $storeRequest
     * @return Problem
     */
    public function store(StoreRequest $storeRequest): Problem
    {
        return $this->problemRepository->store($storeRequest->validated());
    }
}
