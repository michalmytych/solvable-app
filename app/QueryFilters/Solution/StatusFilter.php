<?php

namespace App\QueryFilters\Solution;

use App\QueryFilters\QueryFilter;

class StatusFilter extends QueryFilter
{
    public function handle($builder, $next)
    {
        if (request()->has('status')) {
            $builder->where('status', request('status'));
        }

        $next($builder);
    }
}
