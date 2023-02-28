<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface CodeLanguageRepositoryInterface
{
    public function all(): Collection;
}