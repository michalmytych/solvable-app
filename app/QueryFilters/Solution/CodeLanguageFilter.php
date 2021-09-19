<?php

namespace App\QueryFilters\Solution;

use App\QueryFilters\QueryFilter;

class CodeLanguageFilter extends QueryFilter
{
    public function handle($builder, $next)
    {
        if (request()->has('code_language_id')) {
            $builder->where('code_language_id', request('code_language_id'));
        }

        $next($builder);
    }
}
