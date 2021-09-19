<?php

namespace App\Traits;

use Illuminate\Pipeline\Pipeline;

trait HasQueryFilters
{
    /**
     * Use in Model extending classes.
     *
     * @param $builder
     */
    public function scopeWithQueryFilters($builder)
    {
        app(Pipeline::class)
            ->send($builder)
            ->through(
                $this->getFilters()
            )
            ->thenReturn();
    }
}
