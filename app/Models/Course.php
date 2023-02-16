<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasUuid, HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'user_id'
    ];

    protected $hidden = [
        'id'
    ];

    /**
     * Group related to the course.
     *
     * @return HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    /**
     * Get user who created course.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
