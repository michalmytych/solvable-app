<?php


namespace App\Services\Problem;


use App\Http\Requests\Api\Problem\CreateRequest;
use App\Models\Problem;
use App\Repositories\GroupRepository;
use App\Repositories\ProblemRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProblemService
{
    public function __construct(
        private ProblemRepository $problemRepository,
        private GroupRepository   $groupRepository
    )
    {
    }

    /**
     * Create new problem with relations in transaction,
     * rollback on database error.
     *
     * @param CreateRequest $createRequest
     * @return Problem|null
     */
    public function createWithRelations(CreateRequest $createRequest): ?Problem
    {
        $problemData = collect($createRequest->input())
            ->put('user_id', Auth::id());

        $tests = collect($problemData->get('tests'));
        $codeLanguagesIds = collect($problemData->get('code_languages_ids'));

        $groupId = $problemData->get('group_id');
        $courseId = $problemData->get('course_id');

        $problem = null;

        DB::beginTransaction();

        try {
            $problem = $this->storeProblem($problemData);

            if ($groupId) {
                $this->addProblemToGroup($groupId, $problem);

            } else if ($courseId) {
                $this->addProblemToAllGroupsOfCourse($courseId, $problem);
            }

            $this->updateProblemTests($problem, $tests);

            $this->updateProblemCodeLanguages($problem, $codeLanguagesIds);

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
        }

        return $problem;
    }

    private function storeProblem(Collection $problemData): Problem
    {
        return $this->problemRepository->store(
            $problemData
                ->forget([
                    'tests',
                    'group_id',
                    'course_id',
                    'code_languages_ids'
                ])
                ->toArray()
        );
    }

    private function addProblemToGroup($groupId, Problem $problem)
    {
        $group = $this->groupRepository->findById($groupId);
        $group->problems()->attach($problem);
    }

    private function addProblemToAllGroupsOfCourse($courseId, Problem $problem)
    {
        $groupsOfCourse = $this->groupRepository->findByCourseId($courseId);

        $groupsOfCourse->map(
            fn($group) => $group->problems()->attach($problem)
        );
    }

    private function updateProblemTests(Problem $problem, Collection $tests)
    {
        if ($tests->isNotEmpty()) {
            $problem->tests()->createMany($tests);
        }
    }

    private function updateProblemCodeLanguages(Problem $problem, Collection $codeLanguagesIds)
    {
        if ($codeLanguagesIds->isNotEmpty()) {
            $problem->codeLanguages()->sync($codeLanguagesIds);
        }
    }
}
