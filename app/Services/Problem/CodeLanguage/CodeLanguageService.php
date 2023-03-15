<?php

namespace App\Services\Problem\CodeLanguage;

use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\CodeLanguageRepositoryInterface;

class CodeLanguageService
{
    public function __construct(private CodeLanguageRepositoryInterface $codeLanguageRepository) {}

    public function all(): DataCollectable
    {
        return $this->codeLanguageRepository->all();
    }
}