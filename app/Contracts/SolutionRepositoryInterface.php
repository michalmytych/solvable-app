<?php

namespace App\Contracts;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Database\Eloquent\Collection;

interface SolutionRepositoryInterface
{
    public function findByProblem(Problem $problem): Collection;

    public function update(Solution $solution, array $data): Solution;
}
