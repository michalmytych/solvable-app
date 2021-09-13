<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model
{
    use HasUuid;

    protected $fillable = [
        'input',
        'valid_outputs',
        'time_limit',
        'memory_limit'
    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'valid_outputs' => 'json'
    ];

    /**
     * Executions of this test.
     *
     * @return HasMany
     */
    public function executions(): HasMany
    {
        return $this->hasMany(Execution::class);
    }
}
