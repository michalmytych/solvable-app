<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CodeLanguageRepositoryInterface
{
    public function all(): Collection;
}