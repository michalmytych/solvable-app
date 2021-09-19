<?php

namespace App\Contracts;

use App\Models\Solution;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SolutionRepositoryInterface
{
    public function all(array $params, Authenticatable $user): LengthAwarePaginator;

    public function update(Solution $solution, array $data): Solution;
}
