<?php

namespace App\Contracts\CodeExecutor;

use App\Models\Solution;

interface CodeExecutorServiceInterface
{
    public function init(): self;

    public function executeSolution(Solution $solution): void;
}
