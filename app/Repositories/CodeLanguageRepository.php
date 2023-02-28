<?php

namespace App\Repositories;

use App\Models\CodeLanguage;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\CodeLanguageRepositoryInterface;

class CodeLanguageRepository implements CodeLanguageRepositoryInterface
{
    public function all(): Collection
    {
        return CodeLanguage::all();
    }
}