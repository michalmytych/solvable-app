<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Problem\CreateRequest;
use App\Http\Requests\Api\Solution\CommitRequest;
use App\Http\Resources\ProblemResource;
use App\Http\Resources\SolutionResource;
use App\Models\Problem;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProblemRepository;
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
    public function findByUser(): EloquentCollection
    {
        return $this->problemRepository->findByUser(Auth::id());
    }

    /**
     * Create new problem.
     *
     * @param CreateRequest $createRequest
     * @return ProblemResource
     */
    public function createWithRelations(CreateRequest $createRequest): ProblemResource
    {
        $problemData = collect($createRequest->input());     // todo - change to validated()
        $problemData['user_id'] = Auth::id();

        $tests = collect($problemData->get('tests'));
        $codeLanguagesIds = collect($problemData->get('code_languages_ids'));

        $problemData = $problemData->forget('tests');

        $problem = $this->problemRepository->store($problemData->toArray());

        if ($tests->isNotEmpty()) {
            $problem->tests()->createMany($tests);
        }

        if ($codeLanguagesIds->isNotEmpty()) {
            $problem->codeLanguages()->sync($codeLanguagesIds);
        }

        return new ProblemResource($problem);
    }
}
