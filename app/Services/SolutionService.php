<?php /** @noinspection PhpFieldAssignmentTypeMismatchInspection */

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use App\Enums\SolutionStatusType;
use App\Repositories\SolutionRepository;
use Illuminate\Validation\ValidationException;
use App\Contracts\CodeExecutor\CodeExecutorServiceInterface;

class SolutionService
{
    private Solution $solution;

    private Problem $problem;

    private array $solutionData;

    public function __construct(
        private SolutionRepository           $solutionRepository,
        private SolutionValidationService    $solutionValidationService,
        private CodeExecutorServiceInterface $codeExecutorService
    )
    {
    }

    /**
     * Set problem for which solution is processed.
     *
     * @param Problem $problem
     * @return $this
     */
    public function setProblem(Problem $problem): SolutionService
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Set data to create a Solution of.
     *
     * @param array $data
     * @return $this
     */
    public function setSolutionData(array $data): self
    {
        $this->solutionData = $this->decodeSolutionCodeFromBase($data);

        return $this;
    }

    /**
     * Commit new solution for problem.
     *
     * @throws ValidationException
     */
    public function commit(): SolutionService
    {
        return $this
            ->validate()
            ->delegateExecution();
    }

    /**
     * Return currently processed solution model.
     *
     * @return Solution
     */
    public function getProcessedSolution(): Solution
    {
        return $this->solution;
    }

    /**
     * Validate solution against custom business validation rules.
     *
     * @return $this
     * @throws ValidationException
     */
    private function validate(): self
    {
        try {
            $this->solutionValidationService->validateCodeString($this->solutionData);

        } catch (ValidationException $validationException) {
            $this->solutionData['status'] = SolutionStatusType::MALFORMED_UTF8_CODE_STRING;
            $this->solutionData['code'] = 'data-placeholder.solution-code-data-was-malformed';

            $this->storeSolution();

            throw $validationException;
        }

        $this->storeSolution();

        $this->solutionValidationService
            ->setSolution($this->solution)
            ->setProblem($this->problem)
            ->validateCharsCount()
            ->validateLanguageUsed();

        $this->updateSolution(['status' => SolutionStatusType::VALIDATED]);

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

        $this->updateSolution(['status' => SolutionStatusType::DELEGATED]);

        return $this;
    }

    /**
     * Store solution record in the database.
     */
    private function storeSolution(): void
    {
        $this->solution = $this->problem
            ->solutions()
            ->create($this->solutionData);
    }

    /**
     * Decode stored solution code data from base 64 to string,
     * throw validation error if provided code data is invalid.
     *
     * @param array $data
     * @return array
     */
    private function decodeSolutionCodeFromBase(array $data): array
    {
        $data['code'] = base64_decode($data['code']);

        return $data;
    }

    /**
     * Update solution database record using concrete repository.
     *
     * @param array $data
     */
    private function updateSolution(array $data): void
    {
        $this->solution = $this->solutionRepository->update($this->solution, $data);
    }
}
