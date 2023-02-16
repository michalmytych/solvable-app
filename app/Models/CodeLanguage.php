<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CodeLanguage extends Model
{
    use HasUuid, HasFactory;

    protected $fillable = [
        'name',
        'identifier',
        'version'
    ];

    /**
     * Related problems.
     *
     * @return BelongsToMany
     */
    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(Problem::class);
    }
}

