<?php

namespace App\Services\CodeExecutor;

use App\Exceptions\CurlError3Exception;
use App\Exceptions\ExternalServiceInitializationException;
use App\Models\Solution;
use App\Jobs\ExecuteSolutionTest;
use App\Jobs\FinishSolutionProcessing;
use App\Contracts\CodeExecutor\CodeExecutorServiceInterface;
use App\Support\ExternalCompiler\Client as ExternalCompilerClient;

class CodeExecutorService implements CodeExecutorServiceInterface
{
    public function __construct(private ExternalCompilerClient $externalCompilerClient)
    {
    }

    /**
     * Initialize service.
     */
    public function init(): self
    {
        $this->externalCompilerClient->init();

        return $this;
    }

    /**
     * Execute solution code.
     */
    public function executeSolution(Solution $solution): void
    {
        $tests = $solution->problem->tests;

        foreach ($tests as $test) {
            ExecuteSolutionTest::dispatch($test, $solution, auth()->user());
        }

        FinishSolutionProcessing::dispatch($solution);      // todo moze sprawdzic czy wszystkie joby ExecuteSolutionTest sie wykonaly
    }
}
