<?php

namespace App\Traits;

use Illuminate\Pipeline\Pipeline;

trait HasQueryFilters
{
    /**
     * Use in Model extending classes.
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
