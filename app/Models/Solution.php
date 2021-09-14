<?php

namespace App\Models;

use App\Enums\SolutionStatusType;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Solution extends Model
{
    use HasUuid;

    protected $fillable = [
        'code',
        'score',
        'user_id',
        'execution_time',
        'code_language_id',
        'memory_used',
        'characters',
        'status'
    ];

    protected $casts = [
      'status' => SolutionStatusType::class
    ];

    /**
     * Problem to which solution is attached.
     *
     * @return BelongsTo
     */
    public function problem(): BelongsTo
    {
        return $this->belongsTo(Problem::class);
    }

    /**
     * Code language to which solution is related.
     *
     * @return HasOne
     */
    public function codeLanguage(): HasOne
    {
        return $this->hasOne(CodeLanguage::class, 'id', 'code_language_id');
    }

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
