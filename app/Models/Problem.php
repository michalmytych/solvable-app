<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasQueryParams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property CodeLanguage[]|Collection $codeLanguages
 * @property int $chars_limit
 * @property string $title
 * @property string $content
 * @property string $user_id
 */
class Problem extends Model
{
    use HasUuid, HasFactory, HasQueryParams;

    protected $fillable = [
        'title',
        'content',
        'chars_limit',
        'user_id',
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

    /**
     * Get user related to problem.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get groups to which problem is attached.
     *
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    protected static function queryParams(): array
    {
        // TODO: Implement queryParams() method.
        return [];
    }
}
