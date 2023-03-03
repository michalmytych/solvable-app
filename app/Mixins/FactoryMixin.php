<?php

namespace App\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
class FactoryMixin
{
    public function firstOrCreate(): Closure
    {
        return function (?array $attributes = null): Model {
            $model = $this->model::first();

            if ($attributes) {
                $model = $this->model::firstWhere($attributes)
                    ?? $this->model::factory()->create($attributes);
            }

            return $model ?? $this->model::factory()->create();
        };
    }
}