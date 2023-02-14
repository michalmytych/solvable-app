<?php

namespace App\Repositories;

use App\Models\Solution;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Contracts\SolutionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SolutionRepository implements SolutionRepositoryInterface
{
    /**
     * Find solution by id.
     */
    public function find(Solution $solution): ?Solution
    {
        return Solution::query()
            ->withQueryParams()
            ->where('id', $solution->id)
            ->with('executions', fn($execution) => $execution->with('test'))
            ->first();
    }

    /**
     * Get all solutions for provided problem instance.
     */
    public function all(Authenticatable $user): LengthAwarePaginator
    {
        return Solution::query()
            ->where('user_id', $user->id)
            ->withQueryParams()
            ->withQueryFilters()
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
     */
    public function update(Solution $solution, array $data): Solution
    {
        return tap($solution)->update($data);
    }
}
