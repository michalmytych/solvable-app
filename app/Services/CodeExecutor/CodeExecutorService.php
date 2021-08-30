<?php

namespace App\Services\CodeExecutor;

use App\Models\Solution;
use App\Jobs\ExecuteSolutionTest;
use App\Jobs\FinishSolutionProcessing;
use App\Contracts\CodeExecutor\CodeExecutorServiceInterface;
use App\Support\ExternalCompiler\Client as ExternalCompilerClient;

class CodeExecutorService implements CodeExecutorServiceInterface
{
    private ExternalCompilerClient $externalCompilerClient;

    public function __construct(ExternalCompilerClient $externalCompilerClient)
    {
        $this->externalCompilerClient = $externalCompilerClient;
    }

    public function init(): self
    {
        $this->externalCompilerClient->init();

        return $this;
    }

    public function executeSolution(Solution $solution): void
    {
        $tests = $solution->problem->tests;

        foreach ($tests as $test) {
            ExecuteSolutionTest::dispatch($test, $solution);
        }

        FinishSolutionProcessing::dispatch($solution);      // todo moze sprawdzic czy wszystkie joby ExecuteSolutionTest sie wykonaly
    }
}
