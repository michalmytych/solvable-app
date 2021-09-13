<?php

namespace App\Contracts;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

interface SolutionRepositoryInterface
{
    public function findByProblemAndUser(Problem $problem, Authenticatable $user);

    public function update(Solution $solution, array $data): Solution;
}
