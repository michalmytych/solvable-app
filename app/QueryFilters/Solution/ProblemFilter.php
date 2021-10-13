<?php

namespace App\QueryFilters\Solution;

use App\QueryFilters\QueryFilter;

class ProblemFilter extends QueryFilter
{
    public function handle($builder, $next)
    {
        if (request()->has('problem_id')) {
            $builder->where('problem_id', request('problem_id'));
        }

        $next($builder);
    }
}
