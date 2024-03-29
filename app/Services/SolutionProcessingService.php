<?php

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use App\Enums\SolutionStatusType;
use Illuminate\Validation\ValidationException;
use App\Services\CodeExecutor\CodeExecutorService;

class SolutionProcessingService
{
    private Solution $solution;

    private Problem $problem;

    private array $solutionData;

    public function __construct(
        private SolutionService           $solutionService,
        private CodeExecutorService       $codeExecutorService,
        private SolutionValidationService $solutionValidationService
    ) {
    }

    /**
     * Set problem for which solution is processed.
     */
    public function setProblem(Problem $problem): SolutionProcessingService
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Set data to create a Solution of.
     */
    public function setSolutionData(array $data): self
    {
        $this->solutionData = $this->decodeSolutionCodeFromBase($data);

        return $this;
    }

    /**
     * Commit new solution for problem.
     */
    public function commit(): SolutionProcessingService
    {
        $this->solution = $this->solutionService->createSolutionRecord(
            $this->problem,
            $this->solutionData
        );

        return $this
            ->validate()
            ->delegateExecution();
    }

    /**
     * Return currently processed solution model.
     */
    public function getProcessedSolution(): Solution
    {
        return $this->solution->refresh();
    }

    /**
     * Validate solution against custom business validation rules.
     * @throws ValidationException
     */
    private function validate(): self
    {
        $this
            ->solutionValidationService
            ->setSolution($this->solution)
            ->setProblem($this->problem)
            ->markReceived()
            ->validateCodeString($this->solutionData)
            ->validateCharsCount($this->solutionData)
            ->validateLanguageUsed($this->solutionData);

        $this->solutionData['status'] = SolutionStatusType::VALIDATED->value;

        $this->solutionService->updateSolution($this->solution, $this->solutionData);

        return $this;
    }

    /**
     * Delegate execution of problem tests to CodeExecutorService,
     * which can be used as abstraction / adapter for many
     * external code compilation & execution services.
     */
    private function delegateExecution(): self
    {
        $this->codeExecutorService
            ->init()
            ->executeSolution($this->solution);

        $this->solutionService->updateSolution(
            $this->solution,
            ['status' => SolutionStatusType::DELEGATED->value]
        );

        return $this;
    }

    /**
     * Decode stored solution code data from base 64 to string,
     * throw validation error if provided code data is invalid.
     */
    private function decodeSolutionCodeFromBase(array $data): array
    {
        $data['code'] = base64_decode($data['code']);

        return $data;
    }
}