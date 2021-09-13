<?php

namespace App\Contracts;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SolutionRepositoryInterface
{
    public function findByProblemAndUserWithPagination(Problem $problem, Authenticatable $user): LengthAwarePaginator;

    public function update(Solution $solution, array $data): Solution;
}
