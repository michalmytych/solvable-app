<?php

namespace App\Repositories;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Contracts\SolutionRepositoryInterface;

class SolutionRepository implements SolutionRepositoryInterface
{
    /**
     * Find solution by id.
     *
     * @param Solution $solution
     * @return Solution|null
     */
    public function find(Solution $solution)
    {
        return Solution::query()
            ->where('id', $solution->id)
            ->with('executions', fn($execution) => $execution->with('test'))
            ->first();
    }

    /**
     * Get all solutions for provided problem instance.
     *
     * @param Problem $problem
     * @param Authenticatable $user
     * @return Collection
     */
    public function findByProblemAndUser(Problem $problem, Authenticatable $user): Collection
    {
        return Solution::query()
            ->where('problem_id', $problem->id)
            ->where('user_id', $user->id)
            ->select([
                'id',
                'problem_id',
                'code_language_id',
                'status',
                'created_at',
                'updated_at'
            ])
            ->get();
    }

    /**
     * Update provided Solution database record with data.
     *
     * @param Solution $solution
     * @param array $data
     * @return Solution
     */
    public function update(Solution $solution, array $data): Solution
    {
        return tap($solution)->update($data);
    }
}
