<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasUuid, HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_default',
        'user_id'
    ];

    protected $hidden = [
        'id'
    ];

    protected $casts = [
        'is_default' => 'bool'
    ];

    /**
     * Group related to the course.
     *
     * @return BelongsToMany
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'group_course');
    }

    /**
     * Return problems related to group.
     *
     * @return HasMany
     */
    public function problems(): HasMany
    {
        return $this->hasMany(Problem::class);
    }

    /**
     * Get user who created group.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
