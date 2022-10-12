<?php

namespace App\Http\Controllers\Api\Problem\CodeLanguage;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Problem\CodeLanguage\CodeLanguageService;

class CodeLanguageController extends Controller
{
    public function __construct(private CodeLanguageService $codeLanguageService) {}

    public function all(): Collection
    {
        return $this->codeLanguageService->all();
    }
}