<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Problem extends Model
{
    use HasUuid;

    protected $fillable = [
        'title',
        'content'
    ];

    protected $hidden = [
        'id'
    ];

    /**
     * Solutions related to the problem.
     *
     * @return HasMany
     */
    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class);
    }

    /**
     * Tests related to the problem.
     *
     * @return HasMany
     */
    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    /**
     * Code languages related to the problem.
     *
     * @return BelongsToMany
     */
    public function codeLanguages(): BelongsToMany
    {
        return $this->belongsToMany(CodeLanguage::class);
    }
}
