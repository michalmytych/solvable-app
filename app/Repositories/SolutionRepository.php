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
     * @param array $params
     * @param Authenticatable $user
     * @return LengthAwarePaginator
     */
    public function all(array $params, Authenticatable $user): LengthAwarePaginator
    {
        $params = collect($params);

        $problemId = $params->get('problem_id');

        return Solution::query()
            ->where('user_id', $user->id)
            ->when(!empty($problemId), fn($builder) =>
                $builder->where('problem_id', $problemId)
            )
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
