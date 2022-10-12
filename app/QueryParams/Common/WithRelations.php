<?php

namespace App\QueryParams\Common;

use App\QueryParams\QueryParam;
use Illuminate\Database\Eloquent\Builder;

class WithRelations extends QueryParam
{
    protected function isApplicable(): bool
    {
        return request()->filled('relations');
    }

    protected function applyParam(Builder $builder): Builder
    {
        return $builder->with(request()->input('relations'));
    }
}