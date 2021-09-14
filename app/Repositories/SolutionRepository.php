<?php

namespace App\Repositories;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\SolutionRepositoryInterface;

class SolutionRepository implements SolutionRepositoryInterface
{
    /**
     * Get all solutions for provided problem instance.
     *
     * @param Problem $problem
     * @return Collection
     */
    public function findByProblem(Problem $problem): Collection
    {
        return $problem->solutions;
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
