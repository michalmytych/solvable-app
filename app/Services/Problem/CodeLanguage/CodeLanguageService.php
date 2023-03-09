<?php

namespace App\Services\Problem\CodeLanguage;

use Illuminate\Database\Eloquent\Collection;
use App\Contracts\CodeLanguageRepositoryInterface;

class CodeLanguageService
{
    public function __construct(private CodeLanguageRepositoryInterface $codeLanguageRepository) {}

    public function all(string $userId): Collection
    {
        // @todo userId
        return $this->codeLanguageRepository->all();
    }
}