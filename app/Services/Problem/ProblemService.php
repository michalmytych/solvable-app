<?php


namespace App\Services\Problem;


use Throwable;
use App\Models\Problem;
use App\DTOs\ProblemDTO;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\GroupRepositoryInterface;
use App\Contracts\Repositories\ProblemRepositoryInterface;

class ProblemService
{
    public function __construct(
        private ProblemRepositoryInterface $problemRepository,
        private GroupRepositoryInterface   $groupRepository
    ) {
    }

    /**
     * Get all problems for user.
     */
    public function allByUser(string $userId): DataCollectable
    {
        return $this->problemRepository->allByUser($userId);
    }

    /**
     * Create new problem with relations in transaction,
     * rollback on database error.
     */
    public function createWithRelations(ProblemDTO $problemDTO): ?Problem
    {
        $problem = null;

        DB::beginTransaction();

        try {
            $problem = $this->storeProblem($problemDTO);

            if ($problemDTO->group_id) {
                $this->addProblemToGroup($problemDTO->group_id, $problem);

            } else if ($problemDTO->course_id) {
                $this->addProblemToAllGroupsOfCourse($problemDTO->course_id, $problem);
            }

            $this->updateProblemTests($problem, $problemDTO->tests);

            $this->updateProblemCodeLanguages($problem, $problemDTO->code_languages_ids);

            DB::commit();
        } catch (Throwable) {
            DB::rollBack();
        }

        return $problem;
    }

    private function storeProblem(ProblemDTO $problemDTO): ProblemDTO
    {
        $data = $problemDTO->toArray();

        return $this
            ->problemRepository
            ->store(collect($data)
                ->forget([
                    'tests',
                    'group_id',
                    'course_id',
                    'code_languages_ids',
                ])
                ->toArray()
            );
    }

    private function addProblemToGroup(string $groupId, Problem $problem)
    {
        $group = $this->groupRepository->findById($groupId);
        $group->problems()->attach($problem);   // @todo
    }

    private function addProblemToAllGroupsOfCourse(string $courseId, Problem $problem)
    {
        $groupsOfCourse = $this->groupRepository->findByCourseId($courseId);

        $groupsOfCourse->map(       // @todo
            fn($group) => $group->problems()->attach($problem)
        );
    }

    private function updateProblemTests(Problem $problem, DataCollection $tests)
    {
        if (count($tests)) {
            $problem->tests()->createMany($tests->toArray());   // @todo
        }
    }

    private function updateProblemCodeLanguages(Problem $problem, array $codeLanguagesIds)
    {
        if (count($codeLanguagesIds)) {
            $problem->codeLanguages()->sync($codeLanguagesIds);     // $todo
        }
    }

    public function find(Problem|string $problem): ?Problem
    {
        if (is_string($problem)) {
            return $this->problemRepository->findById($problem);
        }

        return $problem;
    }
}
