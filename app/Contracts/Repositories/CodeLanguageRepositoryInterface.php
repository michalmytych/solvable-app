<?php

namespace App\Contracts\Repositories;

use Spatie\LaravelData\Contracts\DataCollectable;

interface CodeLanguageRepositoryInterface
{
    public function all(): DataCollectable;
}