<?php

namespace App\Jobs;

use Exception;
use App\Models\Test;
use App\Models\Solution;
use App\Models\Execution;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Response;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exceptions\CodeExecutor\ExternalCompilerRequestError;
use App\Support\ExternalCompiler\Client as ExternalCompilerClient;

class ExecuteSolutionTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Test $test;

    private Solution $solution;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Test $test, Solution $solution)
    {
        $this->test = $test;
        $this->solution = $solution;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(ExternalCompilerClient $externalCompilerClient)
    {
        $solution = $this->solution;

        $solution->loadMissing(['codeLanguage']);

        $codeToExecute = $solution->code;
        $solutionLanguage = $solution->codeLanguage->identifier;
        $solutionLanguageVersionIndex = $solution->codeLanguage->version;

        $responseData = $externalCompilerClient
            ->postCodeToExecute([
                'script' => $codeToExecute,
                'language' => $solutionLanguage,
                'versionIndex' => $solutionLanguageVersionIndex
            ]);

        if ((int) $responseData['statusCode'] !== Response::HTTP_OK) {
            throw new ExternalCompilerRequestError($responseData['error'], $responseData['statusCode']);
        }

        $testResult = [
            'output' => $responseData['output'],
            'execution_time' => $responseData['cpuTime'],
            'memory_used' => $responseData['memory'],
            'solution_id' => $solution->id
        ];

        $execution = $this->test
            ->executions()
            ->create($testResult);

        $execution = tap($execution)->update([
            'passed' => $this->checkIfExecutionPassedTest($execution)
        ]);

        // todo $this->broadcastingService->broadcastExecutionState($execution)
    }

    /**
     * Check if this code execution passed test.
     *
     * @param Execution $execution
     * @return bool
     */
    private function checkIfExecutionPassedTest(Execution $execution): bool
    {
        return collect([
            $this->isOutputValid($this->test->valid_output, $execution->output),
            $this->test->time_execution_limit >= $execution->execution_time,
            $this->test->memory_limit > $execution->memory_used,
        ])->every(fn ($result) => $result);
    }

    /**
     * Check if output of this code execution matched
     * valid output from related Problem entity.
     *
     * @param $validOutput
     * @param $executionOutput
     * @return bool
     */
    private function isOutputValid($validOutput, $executionOutput): bool
    {
        return (string)$validOutput === (string)$executionOutput;
    }
}
