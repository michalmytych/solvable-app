<?php

namespace App\Repositories;

use App\Models\CodeLanguage;
use App\DTOs\CodeLanguageDTO;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\CodeLanguageRepositoryInterface;

class CodeLanguageRepository implements CodeLanguageRepositoryInterface
{
    public function all(): DataCollectable
    {
        $codeLanguages = CodeLanguage::all();

        return CodeLanguageDTO::collection($codeLanguages);
    }
}