<?php

namespace App\Repositories;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Contracts\SolutionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @return LengthAwarePaginator
     */
    public function findByProblemAndUserWithPagination(Problem $problem, Authenticatable $user): LengthAwarePaginator
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
            ->paginate(10);
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
