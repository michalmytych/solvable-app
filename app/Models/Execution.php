<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Execution extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'output',
        'execution_time',
        'solution_id',
        'memory_used',
        'passed',
        'status_code',
        'error'
    ];

    /**
     * Solution to which execution is related.
     *
     * @return BelongsTo
     */
    public function solution(): BelongsTo
    {
        return $this->belongsTo(Solution::class);
    }

    /**
     * Test to which execution is related.
     *
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
