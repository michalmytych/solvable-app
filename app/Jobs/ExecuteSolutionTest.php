<?php

namespace App\Jobs;

use Exception;
use App\Models\Test;
use App\Models\Solution;
use App\Models\Execution;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Websockets\BroadcastingService;
use App\Exceptions\CodeExecutor\ExternalCompilerRequestException;
use App\Support\ExternalCompiler\Client as ExternalCompilerClient;

class ExecuteSolutionTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Test     $test,
        private Solution $solution
    )
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(
        ExternalCompilerClient $externalCompilerClient,
        BroadcastingService    $broadcastingService
    )
    {
        $solution = $this->solution;

        $solution->loadMissing(['codeLanguage']);

        $codeToExecute = $solution->code;
        $solutionLanguage = $solution->codeLanguage->identifier;
        $solutionLanguageVersionIndex = $solution->codeLanguage->version;

        $response = $externalCompilerClient
            ->postCodeToExecute([
                'script' => $codeToExecute,
                'language' => $solutionLanguage,
                'versionIndex' => $solutionLanguageVersionIndex
            ]);

        $responseData = collect(json_decode($response->getBody(), true));

        if ((int)$responseData['statusCode'] !== Response::HTTP_OK) {
            throw new ExternalCompilerRequestException($responseData['error'], $responseData['statusCode']);
        }

        $responseData = $this->prepareExternalServiceResponseData($responseData);

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

        $broadcastingService->broadcastExecutionState($execution);
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
        ])->every(fn($result) => $result);
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

    /**
     * Validate if data returned by external service is valid
     * for database insertion, if it isn't - prepare it.
     *
     * @param Collection $responseData
     * @return array
     */
    private function prepareExternalServiceResponseData(Collection $responseData): array
    {
        $outputLimit = config('services.external-compiler-client.max-chars-in-external-compiler-output') ?? 1028;

        if (strlen($responseData['output']) > (int)$outputLimit) {
            // For some reason substr() works better here than
            // Str::limit() which gives different outputs some time (?)
            $responseData['output'] = substr($responseData['output'], 0, $outputLimit);
        }

        return $responseData->toArray();
    }
}
