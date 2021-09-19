<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    /**
     * The request.
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Load the request via dependency injection into the filter.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the filter and return the builder.
     *
     * @param Builder $builder
     * @param Closure $next
     * @return void
     */
    public abstract function handle(Builder $builder, Closure $next);
}
