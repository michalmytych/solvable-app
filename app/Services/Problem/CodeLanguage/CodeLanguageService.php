<?php

namespace App\Services\Problem\CodeLanguage;

use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\CodeLanguageRepositoryInterface;

class CodeLanguageService
{
    public function __construct(private CodeLanguageRepositoryInterface $codeLanguageRepository) {}

    public function all(): Collection
    {
        return $this->codeLanguageRepository->all();
    }
}