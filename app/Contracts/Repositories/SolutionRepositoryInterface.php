<?php

namespace App\Contracts\Repositories;

use App\Models\Solution;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SolutionRepositoryInterface
{
    public function all(Authenticatable $user): LengthAwarePaginator;

    public function update(Solution $solution, array $data): Solution;
}
